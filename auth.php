<?php

/**
 * Authentication Plugin: Odissea Authentication
 * Authentication for Odissea Moodle. Let authenticate users against XTEC's LDAP,
 * using the identity card like username. In the future will also let connect to GICAR.
 *
 * @package auth_odissea
 * @author Sara Arjona
 * @author Salva Valldeoriola <svallde2@xtec.cat>
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

// Allows us to retrieve a diagnostic message in case of LDAP operation error.
if (!defined('LDAP_OPT_DIAGNOSTIC_MESSAGE')) {
    define('LDAP_OPT_DIAGNOSTIC_MESSAGE', 0x0032);
}

require_once($CFG->libdir . '/authlib.php');
require_once($CFG->libdir . '/ldaplib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/auth/odissea/locallib.php');

/**
 * Odissea authentication plugin.
 */
class auth_plugin_odissea extends auth_plugin_base {

    /**
     * Init plugin config from database settings depending on the plugin auth type.
     */
    private function init_plugin($authtype) {
        $this->pluginconfig = 'auth_'.$authtype;
        $this->config = get_config($this->pluginconfig);
        if (empty($this->config->ldapencoding)) {
            $this->config->ldapencoding = 'utf-8';
        }
        if (empty($this->config->user_type)) {
            $this->config->user_type = 'default';
        }

        $ldap_usertypes = ldap_supported_usertypes();
        $this->config->user_type_name = $ldap_usertypes[$this->config->user_type];
        unset($ldap_usertypes);

        $default = ldap_getdefaults();

        // Use defaults if values not given.
        foreach ($default as $key => $value) {
            // Watch out - 0, false are correct values too.
            if (!isset($this->config->{$key}) or $this->config->{$key} == '') {
                $this->config->{$key} = $value[$this->config->user_type];
            }
        }

        // Hack prefix to objectclass.
        $this->config->objectclass = ldap_normalise_objectclass($this->config->objectclass);
    }

    /**
     * Constructor with initialisation.
     */
    public function __construct() {
        $this->authtype = 'odissea';
        $this->roleauth = 'auth_odissea';
        $this->errorlogtag = '[AUTH ODISSEA] ';
        $this->init_plugin($this->authtype);

        $this->ldapconns = 0;
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since Moodle 3.1
     */
    public function auth_plugin_ldap() {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct();
    }

    /**
     * Returns true if the username and password works or doesn't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username (without system magic quotes)
     * @param string $password The password (without system magic quotes)
     *
     * @return bool Authentication success or failure.
     */
    public function user_login($username, $password) {
        // Don't allow access to school codes.
        $pattern = '/^[abce]\d{7}$/'; // Matches a1234567.
        if (preg_match($pattern, $username)) {
            print_error('auth_odissea_no_schoolcode', 'auth_odissea');
            return false;
        }

        if (!function_exists('ldap_bind')) {
            print_error('auth_odisseanotinstalled', 'auth_odissea');
            return false;
        }

        if (!$username or !$password) {  // Don't allow blank usernames or passwords.
            return false;
        }

        // Trying to find specified user in LDAP-XTEC and LDAP-GICAR.
        list($ldapconnection, $ldapuserdn) = $this->get_userdn($username, $password);

        // Try to bind with current username and password.
        $ldaplogin = @ldap_bind($ldapconnection, $ldapuserdn, $password);
        $this->ldap_close();
        if ($ldaplogin) {
            return true;
        }
        return false;
    }

    /**
     *
     * @param string $username
     * @param type $password
     * @return array($ldapconnection, $userdn, $nif_attribute) or FALSE if the user is not found
     */
    public function get_userdn($username, $password = false) {
        // Hack to solve the lack of password on get_userinfo.
        global $auth_odissea_pass;
        if ($password) {
            $auth_odissea_pass = $password;
        } else {
            $password = $auth_odissea_pass;
        }

        $ldapconnection = $this->get_xtecconnection($username, $password);
        $user_dn = $this->ldap_find_userdn($ldapconnection, $username);

        if (!$user_dn) {
            // If user_dn is empty, user does not exist so it's needed to search in GICAR-LDAP.
            $this->ldap_close();
            $ldapconnection = $this->get_gicarconnection();
            if (!$ldapconnection) {
                $this->ldap_close();
                return false;
            }

            $ldap_result = ldap_search($ldapconnection, $this->config->gicar_contexts,
                    '(' . $this->config->gicar_nif_attribute . '=' . $username . ')',
                    array($this->config->gicar_user_attribute));
            $gicar_entry = ldap_first_entry($ldapconnection, $ldap_result);
            if ($gicar_entry) {
                if ($gicar_id_array = ldap_get_values($ldapconnection, $gicar_entry, $this->config->gicar_user_attribute)) {
                    $gicar_id = $gicar_id_array[0];
                    $user_dn = $this->ldap_find_userdn($ldapconnection, $gicar_id, $this->config->gicar_contexts,
                            $this->config->gicar_user_attribute);
                }
            }
            if (!$user_dn) {
                // If user_dn is empty, user does not exist.
                $this->ldap_close();
                return false;
            }
            $nif_attribute = $this->config->gicar_nif_attribute;

        } else {
            $nif_attribute = $this->config->nif_attribute;
        }
        return array($ldapconnection, $user_dn, $nif_attribute);
    }

    /**
     * Get ldapconnection using specified username and password as bind settings
     * @return resource LDAP-XTEC connection
     */
    public function get_xtecconnection($username, $password) {
        $bind_dn = $this->config->user_attribute . '=' . $username . ',' . $this->config->bind_dn;
        $ldapconnection = $this->ldap_connect($this->config->host_url, $this->config->ldap_version, $bind_dn, $password);

        return $ldapconnection;
    }

    /**
     * Get ldapconnection using GICAR bind settings
     * @return resource LDAP-GICAR connection
     */
    public function get_gicarconnection() {
        return $this->ldap_connect($this->config->gicar_host_url,
                $this->config->gicar_ldap_version,
                $this->config->gicar_bind_dn,
                $this->config->gicar_bind_pw);
    }

    /**
     * Reads user information from external authentication server and returns it in array()
     * Function should return all information available.
     *
     * @param string $username username
     *
     * @return mixed array with no magic quotes or false on error
     */
    public function get_userinfo($username, $notused = false) {
        // Trying to find specified user in LDAP-XTEC and LDAP-GICAR.
        list($ldapconnection, $ldapuserdn, $nif_attribute) = $this->get_userdn($username);
        $search_attribs = array();
        $attrmap = $this->odissea_attributes($nif_attribute);
        foreach ($attrmap as $key => $values) {
            if (!is_array($values)) {
                $values = array($values);
            }
            foreach ($values as $value) {
                if (!in_array($value, $search_attribs)) {
                    array_push($search_attribs, $value);
                }
            }
        }

        if (!$user_info_result = ldap_read($ldapconnection, $ldapuserdn, '(objectClass=*)', $search_attribs)) {
            $this->ldap_close();
            return false; // Error.
        }

        $user_entry = ldap_get_entries_moodle($ldapconnection, $user_info_result);
        if (empty($user_entry)) {
            $this->ldap_close();
            return false; // Entry not found.
        }

        $result = array();
        foreach ($attrmap as $key => $values) {
            if (!is_array($values)) {
                $values = array($values);
            }
            $ldapval = null;
            foreach ($values as $value) {
                $entry = array_change_key_case($user_entry[0], CASE_LOWER);
                if (($value == 'dn') || ($value == 'distinguishedname')) {
                    $result[$key] = $ldapuserdn;
                    continue;
                }
                if (!array_key_exists($value, $entry)) {
                    continue; // Wrong data mapping.
                }
                if (is_array($entry[$value])) {
                    if ($value == $this->config->nif_attribute || $value == $this->config->gicar_nif_attribute) {
                        $entry[$value][0] = str_replace(' ', '', $entry[$value][0]);
                    }
                    $newval = core_text::convert($entry[$value][0], $this->config->ldapencoding, 'utf-8');
                } else {
                    if ($value == $this->config->nif_attribute || $value == $this->config->gicar_nif_attribute) {
                        $entry[$value] = str_replace(' ', '', $entry[$value]);
                    }
                    $newval = core_text::convert($entry[$value], $this->config->ldapencoding, 'utf-8');
                }
                if (!empty($newval)) { // Favour ldap entries that are set.
                    $ldapval = $newval;
                }
            }
            if (!is_null($ldapval)) {
                $result[$key] = $ldapval;
            }
        }

        $this->ldap_close();
        return $result;
    }

    public function prevent_local_passwords() {
        return true;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    public function is_internal() {
        return false;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    public function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    public function change_password_url() {
        return null;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    public function can_reset_password() {
        return false;
    }

    /**
     * Connect to the LDAP server, using the plugin configured
     * settings. It's actually a wrapper around ldap_connect_moodle()
     *
     * @param type $host_url
     * @param type $ldapversion
     * @param type $binddn
     * @param type $bindpwd
     * @return resource A valid LDAP connection (or dies if it can't connect)
     */
    public function ldap_connect($hosturl, $ldapversion, $binddn, $bindpwd) {
        // Cache ldap connections. They are expensive to set up
        // and can drain the TCP/IP ressources on the server if we
        // are syncing a lot of users (as we try to open a new connection
        // to get the user details). This is the least invasive way
        // to reuse existing connections without greater code surgery.
        if (!empty($this->ldapconnection)) {
            $this->ldapconns++;
            return $this->ldapconnection;
        }

        if ($ldapconnection = ldap_connect_moodle($hosturl, $ldapversion, $this->config->user_type,
                $binddn, $bindpwd, $this->config->opt_deref, $debuginfo)) {
            $this->ldapconns = 1;
            $this->ldapconnection = $ldapconnection;
            return $ldapconnection;
        }
    }

    /**
     * Disconnects from a LDAP server
     *
     * @param force boolean Forces closing the real connection to the LDAP server, ignoring any
     *                      cached connections. This is needed when we've used paged results
     *                      and want to use normal results again.
     */
    public function ldap_close($force = false) {
        $this->ldapconns--;
        if (($this->ldapconns == 0) || ($force)) {
            $this->ldapconns = 0;
            @ldap_close($this->ldapconnection);
            unset($this->ldapconnection);
        }
    }

    /**
     * Search specified contexts for username and return the user dn
     * like: cn=username,ou=suborg,o=org. It's actually a wrapper
     * around ldap_find_userdn().
     *
     * @param resource $ldapconnection a valid LDAP connection
     * @param string $extusername the username to search (in external LDAP encoding, no db slashes)
     * @param boolean $contexts
     * @param boolean $userattribute
     * @return mixed the user dn (external LDAP encoding) or false
     */
    public function ldap_find_userdn($ldapconnection, $extusername, $contexts = false, $userattribute = false) {
        if (empty($contexts)) {
            $contexts = $this->config->contexts;
        }
        $ldapcontexts = explode(';', $contexts);
        if (!empty($this->config->create_context)) {
            array_push($ldapcontexts, $this->config->create_context);
        }
        if (empty($userattribute)) {
            $userattribute = $this->config->user_attribute;
        }
        return ldap_find_userdn($ldapconnection, $extusername, $ldapcontexts, $this->config->objectclass,
                $userattribute, $this->config->search_sub);
    }

    /**
     * Returns user attribute mappings between moodle and LDAP
     *
     * @return array nifattribute
     */
    public function odissea_attributes($nifattribute) {
        $moodleattributes = array();
        foreach ($this->userfields as $field) {
            if (!empty($this->config->{"field_map_$field"})) {
                $moodleattributes[$field] = core_text::strtolower(trim($this->config->{"field_map_$field"}));
                if (preg_match('/,/', $moodleattributes[$field])) {
                    $moodleattributes[$field] = explode(',', $moodleattributes[$field]); // Split ?.
                }
            }
        }
        $moodleattributes['username'] = core_text::strtolower(trim($nifattribute));
        return $moodleattributes;
    }

}
