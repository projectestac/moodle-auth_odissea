<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin settings and defaults.
 *
 * @package auth_odissea
 * @copyright  2018 Salva Valldeoriola <svallde2@xtec.cat>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    if (!function_exists('ldap_connect')) {
        $settings->add(new admin_setting_heading('auth_odissea_noextension', '',
                get_string('auth_odissea_noextension', 'auth_odissea')));
    } else {

        require_once($CFG->dirroot.'/auth/odissea/classes/admin_setting_special_lowercase_configtext.php');
        require_once($CFG->dirroot.'/auth/odissea/classes/admin_setting_special_contexts_configtext.php');

        // We need to use some of the Moodle LDAP constants / functions to create the list of options.
        require_once($CFG->dirroot.'/auth/odissea/auth.php');

        // Introductory explanation.
        $settings->add(new admin_setting_heading('auth_odissea/pluginname', '',
                new lang_string('auth_odisseadescription', 'auth_odissea')));

        // LDAP-XTEC server settings.
        $settings->add(new admin_setting_heading('auth_odissea/ldapserversettings',
                new lang_string('auth_xtec_server_settings', 'auth_odissea'), ''));

        // Host.
        $settings->add(new admin_setting_configtext('auth_odissea/host_url',
                get_string('auth_odissea_host_url_key', 'auth_odissea'),
                get_string('auth_odissea_host_url', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // Version.
        $versions = array();
        $versions[2] = '2';
        $versions[3] = '3';
        $settings->add(new admin_setting_configselect('auth_odissea/ldap_version',
                new lang_string('auth_odissea_version_key', 'auth_odissea'),
                new lang_string('auth_odissea_version', 'auth_odissea'), 3, $versions));

        // Start TLS.
        $yesno = array(
                new lang_string('no'),
                new lang_string('yes'),
        );
        $settings->add(new admin_setting_configselect('auth_odissea/start_tls',
                new lang_string('start_tls_key', 'auth_odissea'),
                new lang_string('start_tls', 'auth_odissea'), 0 , $yesno));


        // Encoding.
        $settings->add(new admin_setting_configtext('auth_odissea/ldapencoding',
                get_string('auth_odissea_ldap_encoding_key', 'auth_odissea'),
                get_string('auth_odissea_ldap_encoding', 'auth_odissea'), 'utf-8', PARAM_RAW_TRIMMED));

        // Bind settings.
        $settings->add(new admin_setting_heading('auth_odissea/ldapbindsettings',
                new lang_string('auth_odissea_bind_settings', 'auth_odissea'), ''));

        // User ID.
        $settings->add(new admin_setting_configtext('auth_odissea/bind_dn',
                get_string('auth_odissea_bind_dn_key', 'auth_odissea'),
                get_string('auth_odissea_bind_dn', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // Password.
        $settings->add(new admin_setting_configpasswordunmask('auth_odissea/bind_pw',
                get_string('auth_odissea_bind_pw_key', 'auth_odissea'),
                get_string('auth_odissea_bind_pw', 'auth_odissea'), ''));

        // User Lookup settings.
        $settings->add(new admin_setting_heading('auth_odissea/ldapuserlookup',
                new lang_string('auth_odissea_user_settings', 'auth_odissea'), ''));

        // Contexts.
        $settings->add(new auth_odissea_admin_setting_special_contexts_configtext('auth_odissea/contexts',
                get_string('auth_odissea_contexts_key', 'auth_odissea'),
                get_string('auth_odissea_contexts', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // User attribute.
        $settings->add(new auth_odissea_admin_setting_special_lowercase_configtext('auth_odissea/user_attribute',
                get_string('auth_odissea_user_attribute_key', 'auth_odissea'),
                get_string('auth_odissea_user_attribute', 'auth_odissea'), '', PARAM_RAW));

        // NIF.
        $settings->add(new auth_odissea_admin_setting_special_lowercase_configtext('auth_odissea/nif_attribute',
                get_string('auth_odissea_nif_attribute_key', 'auth_odissea'),
                get_string('auth_odissea_nif_attribute', 'auth_odissea'), '', PARAM_URL));



        // GICAR server settings.
        $settings->add(new admin_setting_heading('auth_odissea/gicarserversettings',
                new lang_string('auth_gicar_server_settings', 'auth_odissea'), ''));


        // Host.
        $settings->add(new admin_setting_configtext('auth_odissea/gicar_host_url',
                get_string('auth_odissea_host_url_key', 'auth_odissea'),
                get_string('auth_odissea_host_url', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // Version.
        $versions = array();
        $versions[2] = '2';
        $versions[3] = '3';
        $settings->add(new admin_setting_configselect('auth_odissea/gicar_ldap_version',
                new lang_string('auth_odissea_version_key', 'auth_odissea'),
                new lang_string('auth_odissea_version', 'auth_odissea'), 3, $versions));

        // Start TLS.
        $yesno = array(
                new lang_string('no'),
                new lang_string('yes'),
        );
        $settings->add(new admin_setting_configselect('auth_odissea/gicar_start_tls',
                new lang_string('start_tls_key', 'auth_odissea'),
                new lang_string('start_tls', 'auth_odissea'), 0 , $yesno));


        // Encoding.
        $settings->add(new admin_setting_configtext('auth_odissea/gicar_ldapencoding',
                get_string('auth_odissea_ldap_encoding_key', 'auth_odissea'),
                get_string('auth_odissea_ldap_encoding', 'auth_odissea'), 'utf-8', PARAM_RAW_TRIMMED));

        // Bind settings.
        $settings->add(new admin_setting_heading('auth_odissea/gicar_ldapbindsettings',
                new lang_string('auth_odissea_bind_settings', 'auth_odissea'), ''));

        // User ID.
        $settings->add(new admin_setting_configtext('auth_odissea/gicar_bind_dn',
                get_string('auth_odissea_bind_dn_key', 'auth_odissea'),
                get_string('auth_odissea_bind_dn', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // Password.
        $settings->add(new admin_setting_configpasswordunmask('auth_odissea/gicar_bind_pw',
                get_string('auth_odissea_bind_pw_key', 'auth_odissea'),
                get_string('auth_odissea_bind_pw', 'auth_odissea'), ''));

        // User Lookup settings.
        $settings->add(new admin_setting_heading('auth_odissea/gicar_ldapuserlookup',
                new lang_string('auth_odissea_user_settings', 'auth_odissea'), ''));

        // Contexts.
        $settings->add(new auth_odissea_admin_setting_special_contexts_configtext('auth_odissea/gicar_contexts',
                get_string('auth_odissea_contexts_key', 'auth_odissea'),
                get_string('auth_odissea_contexts', 'auth_odissea'), '', PARAM_RAW_TRIMMED));

        // User attribute.
        $settings->add(new auth_odissea_admin_setting_special_lowercase_configtext('auth_odissea/gicar_user_attribute',
                get_string('auth_odissea_user_attribute_key', 'auth_odissea'),
                get_string('auth_odissea_user_attribute', 'auth_odissea'), '', PARAM_RAW));

        // NIF.
        $settings->add(new auth_odissea_admin_setting_special_lowercase_configtext('auth_odissea/gicar_nif_attribute',
                get_string('auth_odissea_nif_attribute_key', 'auth_odissea'),
                get_string('auth_odissea_nif_attribute', 'auth_odissea'), '', PARAM_URL));


        // System roles mapping header.
        $settings->add(new admin_setting_heading('auth_odissea/systemrolemapping',
                new lang_string('systemrolemapping', 'auth_odissea'), ''));

        // Create system role mapping field for each assignable system role.
        $roles = get_odissea_assignable_role_names();
        foreach ($roles as $role) {
            // Before we can add this setting we need to check a few things.
            // A) It does not exceed 100 characters otherwise it will break the DB as the 'name' field
            //    in the 'config_plugins' table is a varchar(100).
            // B) The setting name does not contain hyphens. If it does then it will fail the check
            //    in parse_setting_name() and everything will explode. Role short names are validated
            //    against PARAM_ALPHANUMEXT which is similar to the regex used in parse_setting_name()
            //    except it also allows hyphens.
            // Instead of shortening the name and removing/replacing the hyphens we are showing a warning.
            // If we were to manipulate the setting name by removing the hyphens we may get conflicts, eg
            // 'thisisashortname' and 'this-is-a-short-name'. The same applies for shortening the setting name.
            if (core_text::strlen($role['settingname']) > 100 || !preg_match('/^[a-zA-Z0-9_]+$/', $role['settingname'])) {
                $url = new moodle_url('/admin/roles/define.php', array('action' => 'edit', 'roleid' => $role['id']));
                $a = (object)['rolename' => $role['localname'], 'shortname' => $role['shortname'], 'charlimit' => 93,
                        'link' => $url->out()];
                $settings->add(new admin_setting_heading('auth_odissea/role_not_mapped_' . sha1($role['settingname']), '',
                        get_string('cannotmaprole', 'auth_odissea', $a)));
            } else {
                $settings->add(new admin_setting_configtext('auth_odissea/' . $role['settingname'],
                        get_string('auth_odissea_rolecontext', 'auth_odissea', $role),
                        get_string('auth_odissea_rolecontext_help', 'auth_odissea', $role), '', PARAM_RAW_TRIMMED));
            }
        }

        // User Account Sync.
        $settings->add(new admin_setting_heading('auth_odissea/syncusers',
                new lang_string('auth_sync_script', 'auth'), ''));
    }

    // Display locking / mapping of profile fields.
    $authplugin = get_auth_plugin('ldap');
    $help  = get_string('auth_odisseaextrafields', 'auth_odissea');
    $help .= get_string('auth_updatelocal_expl', 'auth');
    $help .= get_string('auth_fieldlock_expl', 'auth');
    $help .= get_string('auth_updateremote_expl', 'auth');
    $help .= '<hr />';
    $help .= get_string('auth_updateremote_ldap', 'auth');
    display_auth_lock_options($settings, $authplugin->authtype, $authplugin->userfields,
            $help, true, true, $authplugin->get_custom_user_profile_fields());
}
