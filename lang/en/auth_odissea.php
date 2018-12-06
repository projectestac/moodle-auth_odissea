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
 * Strings for component 'auth_odissea', language 'en', branch 'MOODLE_34_STABLE'
 *
 * @package   auth_odissea
 * @author    Salva Valldeoriola <svallde2@xtec.cat>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['auth_odisseadescription'] = 'This method provides authentication against an external LDAP server.
                                  If the given username and password are valid, Moodle creates a new user
                                  entry in its database. This module can read user attributes from LDAP, prefill
                                  wanted fields in Moodle and change username for NIF or equivalent.
                                  For following logins, only the username and password are checked.
                                  School codes (like a80xxxxx, b7xxxxxx, etc.) cannot log in.';
$string['pluginname'] = 'Odissea';
$string['auth_odissea_nif_attribute'] = 'Optional: Overrides the attribute used for identity number of users (NIF or equivalent). Usually \'nif\'.';
$string['auth_odissea_nif_attribute_key'] = 'NIF';

$string['auth_xtec_server_settings'] = 'LDAP-XTEC server settings';
$string['auth_gicar_server_settings'] = 'LDAP-GICAR server settings';

$string['auth_odissea_no_schoolcode'] = 'School codes cannot be used to log in';
$string['auth_odissea_passwordnotempty'] = 'Password cannot be empty';

$string['auth_odissea_auth_user_create_key'] = 'Create users externally';
$string['auth_odissea_bind_dn'] = 'If you want to use bind-user to search users, specify it here. Something like \'cn=ldapuser,ou=public,o=org\'';
$string['auth_odissea_bind_dn_key'] = 'Distinguished name';
$string['auth_odissea_bind_pw'] = 'Password for bind-user.';
$string['auth_odissea_bind_pw_key'] = 'Password';
$string['auth_odissea_bind_settings'] = 'Bind settings';
$string['auth_odissea_contexts'] = 'List of contexts where users are located. Separate different contexts with \';\'. For example: \'ou=users,o=org; ou=others,o=org\'';
$string['auth_odissea_contexts_key'] = 'Contexts';
$string['auth_odisseadescription'] = 'This method provides authentication against an external LDAP server.
                                  If the given username and password are valid, Moodle creates a new user
                                  entry in its database. This module can read user attributes from LDAP and prefill
                                  wanted fields in Moodle.  For following logins only the username and
                                  password are checked.';
$string['auth_odisseaextrafields'] = 'These fields are optional.  You can choose to pre-fill some Moodle user fields with information from the <b>LDAP fields</b> that you specify here. <p>If you leave these fields blank, then nothing will be transferred from LDAP and Moodle defaults will be used instead.</p><p>In either case, the user will be able to edit all of these fields after they log in.</p>';
$string['auth_odissea_host_url'] = 'Specify LDAP host in URL-form like \'ldap://ldap.myorg.com/\' or \'ldaps://ldap.myorg.com/\'. Separate multiple servers with \';\' to get failover support.';
$string['auth_odissea_host_url_key'] = 'Host URL';
$string['auth_odissea_ldap_encoding'] = 'Specify encoding used by LDAP server. Most probably utf-8, MS AD v2 uses default platform encoding such as cp1252, cp1250, etc.';
$string['auth_odissea_ldap_encoding_key'] = 'LDAP encoding';
$string['auth_odissea_noextension'] = '<em>The PHP LDAP module does not seem to be present. Please ensure it is installed and enabled if you want to use this authentication plugin.</em>';
$string['auth_odissea_no_mbstring'] = 'You need the mbstring extension to create users in Active Directory.';
$string['auth_odisseanotinstalled'] = 'Cannot use LDAP authentication. The PHP LDAP module is not installed.';
$string['auth_odissea_rolecontext'] = '{$a->localname} context';
$string['auth_odissea_rolecontext_help'] = 'LDAP context used to select for <i>{$a->localname}</i> mapping. Separate multiple groups with \';\'. Usually something like "cn={$a->shortname},ou=staff,o=myorg".';
$string['auth_odissea_user_attribute'] = 'Optional: Overrides the attribute used to name/search users. Usually \'cn\'.';
$string['auth_odissea_user_attribute_key'] = 'User attribute';
$string['auth_odissea_user_settings'] = 'User lookup settings';
$string['auth_odissea_version'] = 'The version of the LDAP protocol your server is using.';
$string['auth_odissea_version_key'] = 'Version';

$string['cannotmaprole'] = 'The role "{$a->rolename}" cannot be mapped because its short name "{$a->shortname}" is too long and/or contains hyphens. To allow it to be mapped, the short name needs to be reduced to a maximum of {$a->charlimit} characters and any hyphens removed. <a href="{$a->link}">Edit the role</a>';
$string['pagesize'] = 'Make sure this value is smaller than your LDAP server result set size limit (the maximum number of entries that can be returned in a single query)';
$string['pluginname'] = 'Odissea';
$string['systemrolemapping'] = 'System role mapping';
$string['start_tls'] = 'Use regular LDAP service (port 389) with TLS encryption';
$string['start_tls_key'] = 'Use TLS';

// Deprecated since Moodle 3.4.
$string['privacy:metadata'] = 'The LDAP server authentication plugin does not store any personal data.';
