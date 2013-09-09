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
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['auth_odisseadescription'] = 'Aquest mètode proporciona autenticació contra un servidor LDAP extern.
                                      Si el nom d\'usuari/ària i la contrasenya són vàlids, Moodle crea una entrada per
                                      a l\'usuari/ària nou a la seva base de dades. Aquest mòdul llegeix atributs de
                                      l\'usuari/ària LDAP, omple els camps corresponents de Moodle i modifica el nom
                                      d\'usuari/ària pel NIF o equivalent. 
                                      En connexions successives només es comproven el nom d\'usuari/ària i la contrasenya.';
$string['pluginname'] = 'Odissea';
$string['auth_odissea_nif_attribute'] = 'Opcional: substitueix l\'atribut utilitzat pel NIF o equivalent dels usuaris. Generalment \'nif\'.';
$string['auth_odissea_nif_attribute_key'] = 'NIF';
