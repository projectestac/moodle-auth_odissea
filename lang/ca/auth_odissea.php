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
 * Strings for component 'auth_odissea', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   auth_odissea
 * @author    Salva Valldeoriola <svallde2@xtec.cat>
 * @author    Isabel Oussedik
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['auth_odisseadescription'] = 'Aquest mètode proporciona autenticació contra un servidor LDAP extern.
                                      Si el nom d\'usuari/ària i la contrasenya són vàlids, Moodle crea una entrada per
                                      a l\'usuari/ària nou a la seva base de dades. Aquest mòdul llegeix atributs de
                                      l\'usuari/ària LDAP, omple els camps corresponents de Moodle i modifica el nom
                                      d\'usuari/ària pel NIF o equivalent.
                                      En connexions successives només es comproven el nom d\'usuari/ària i la contrasenya.
                                      Els codi de centre (del tipus a80xxxxx, b7xxxxxx, etc.) no poden entrar.';
$string['pluginname'] = 'Odissea';
$string['auth_odissea_nif_attribute'] = 'Opcional: substitueix l\'atribut utilitzat pel NIF o equivalent dels usuaris. Generalment \'nif\'.';
$string['auth_odissea_nif_attribute_key'] = 'NIF';

$string['auth_xtec_server_settings'] = 'Paràmetres del servidor LDAP-XTEC';
$string['auth_gicar_server_settings'] = 'Paràmetres del servidor LDAP-GICAR';

$string['auth_odissea_no_schoolcode'] = 'Els codis de centre no es poden utilitzar per entrar';
$string['auth_odissea_passwordnotempty'] = 'La contrasenya no pot estar buida';


$string['auth_odissea_no_schoolcode'] = 'Els codis de l\'escola no es poden utilitzar per iniciar la sessió';
$string['auth_odissea_passwordnotempty'] = 'La contrasenya no pot estar buida';

$string['auth_odissea_auth_user_create_key'] = 'Crear usuaris de manera externa';
$string['auth_odissea_bind_dn'] = 'Per utilitzar l\'usuari vinculat per cercar usuaris, especifiqueu-lo aquí. Ha de ser similar a \'cn=ldapuser,ou=public,o=org\'';
$string['auth_odissea_bind_dn_key'] = 'Nom distingit';
$string['auth_odissea_bind_pw'] = 'Contrasenya per vincular l\'usuari.';
$string['auth_odissea_bind_pw_key'] = 'Contrasenya';
$string['auth_odissea_bind_settings'] = 'Configuració de vinculació';
$string['auth_odissea_contexts'] = 'Llista de contextos on es troben els usuaris. Separeu els diferents contextos amb \';\'. Per exemple: \'ou=users,o=org; ou=others,o=org\'';
$string['auth_odissea_contexts_key'] = 'Contextos';
$string['auth_odisseadescription'] = 'Aquest mètode proporciona autenticació contra un servidor LDAP extern.
                                  Si el nom d\'usuari i la contrasenya són vàlids, Moodle crea una nova entrada
                                  d\'usuari a la seva base de dades. Aquest mòdul pot llegir els atributs de l\'usuari de LDAP i omplir prèviament
                                  els camps requerits a Moodle.  En el següent inici de sessió només es comprovarà
                                  el nom d\'usuari i la contrasenya.';
$string['auth_odisseaextrafields'] = 'Aquests camps són opcionals. Podeu escollir omplir prèviament alguns camps d\'usuari de Moodle amb informació dels <b>camps de LDAP</b> que especifiqueu aquí. <p>Si deixeu aquests camps buits, no es transferirà res de LDAP i s\'utilitzaran els valors predeterminats de Moodle.</p><p>En qualsevol cas, l\'usuari podrà editar tots aquests camps després d\'iniciar la sessió.</p>';
$string['auth_odissea_host_url'] = 'Especifiqueu l\'amfitrió LDAP en forma d\'URL com \'ldap://ldap.myorg.com/\' o \'ldaps://ldap.myorg.com/\'. Separeu els múltiples servidors amb \';\' per aconseguir suport per error de commutació.';
$string['auth_odissea_host_url_key'] = 'URL amfitrió';
$string['auth_odissea_ldap_encoding'] = 'Especifiqueu la codificació utiitzada pel servidor LDAP. Probablement utf-8, MS AD v2 utilitza la codificació per defecte de la plataforma com ara cp1252, cp1250, etc.';
$string['auth_odissea_ldap_encoding_key'] = 'Codificació LDAP';
$string['auth_odissea_noextension'] = '<em>El mòdul PHP LDAP sembla que no està present. Si voleu utilitzar aquest complement d\'autenticació, assegureu-vos que està instal·lat i habilitat.</em>';
$string['auth_odissea_no_mbstring'] = 'Necessiteu l\'extensió mbstring per crear usuaris al Directory Actiu.';
$string['auth_odisseanotinstalled'] = 'No podeu iniciar sessió amb LDAP. El mòdul PHP LDAP no està instal·lat.';
$string['auth_odissea_rolecontext'] = '{$a->localname} context';
$string['auth_odissea_rolecontext_help'] = 'Context LDAP utilitzat per seleccionar per al mapatge de <i>{$a->localname}</i>. Separeu els múltiples grups amb \';\'. Generalment serà similar a  "cn={$a->shortname},ou=staff,o=myorg".';
$string['auth_odissea_user_attribute'] = 'Opcional: Invalida l\'atribut utilitzat per nomenar / buscar usuaris. Generalment \'cn\'.';
$string['auth_odissea_user_attribute_key'] = 'Atribut de l\'usuari';
$string['auth_odissea_user_settings'] = 'Configuració de cerca d\'usuaris';
$string['auth_odissea_version'] = 'La versió del protocol de LDAP que utilitza el vostre servidor.';
$string['auth_odissea_version_key'] = 'Versió';

$string['cannotmaprole'] = 'El rol "{$a->rolename}" no es pot mapar perquè el nom curt "{$a->shortname}" és massa llarg i/o conté guions. Per permetre el mapatge, el nom curt ha de ser reduït al màxim de {$a->charlimit} caracters i s\'han d\'eliminar els guions. <a href="{$a->link}">Edita el rol</a>';
$string['pagesize'] = 'Assegureu-vos que aquest valor és més petit que el límit de la mida del conjunt de resultats del servidor LDAP (el màxim nombre d\'entrades que es poden retornar en una consulta única)';
$string['pluginname'] = 'Odissea';
$string['systemrolemapping'] = 'Mapatge dels rols de sistema';
$string['start_tls'] = 'Utilitzeu el servei LDAP habitual (port 389) amb encriptació TLS';
$string['start_tls_key'] = 'Utilitzeu TLS';

// Deprecated since Moodle 3.4.
$string['privacy:metadata'] = 'El connector d\'autenticació del servidor LDAP no emmagatzema cap dada personal.';
