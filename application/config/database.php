<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | DATABASE CONNECTIVITY SETTINGS
  | -------------------------------------------------------------------
  | This file will contain the settings needed to access your database.
  |
  | For complete instructions please consult the 'Database Connection'
  | page of the User Guide.
  |
  | -------------------------------------------------------------------
  | EXPLANATION OF VARIABLES
  | -------------------------------------------------------------------
  |
  |	['hostname'] The hostname of your database server.
  |	['username'] The username used to connect to the database
  |	['password'] The password used to connect to the database
  |	['database'] The name of the database you want to connect to
  |	['dbdriver'] The database type. ie: mysql.  Currently supported:
  mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
  |	['dbprefix'] You can add an optional prefix, which will be added
  |				 to the table name when using the  Active Record class
  |	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
  |	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
  |	['cache_on'] TRUE/FALSE - Enables/disables query caching
  |	['cachedir'] The path to the folder where cache files should be stored
  |	['char_set'] The character set used in communicating with the database
  |	['dbcollat'] The character collation used in communicating with the database
  |	['swap_pre'] A default table prefix that should be swapped with the dbprefix
  |	['autoinit'] Whether or not to automatically initialize the database.
  |	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
  |							- good for ensuring strict SQL while developing
  |
  | The $active_group variable lets you choose which connection group to
  | make active.  By default there is only one group (the 'default' group).
  |
  | The $active_record variables lets you determine whether or not to load
  | the active record class
 */

if (LOCAL) {
    $active_group = "local";
} else {
    if (HOMOLOG) {
        $active_group = "homologacao";
    } else {
        $active_group = "default";
    }
}

if (HOMOLOG) {
    $active_group = "homologacao";
}

$active_record = TRUE;

//$active_group = "default";

$db['local']['hostname'] = "localhost";
$db['local']['username'] = "root";
$db['local']['password'] = "";
$db['local']['database'] = "gerenciacliente";
$db['local']['dbdriver'] = "mysql";
$db['local']['dbprefix'] = "";
$db['local']['pconnect'] = TRUE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = "";
$db['local']['char_set'] = "utf8";
$db['local']['dbcollat'] = "utf8_general_ci";

$db['homologacao']['hostname'] = "localhost";
$db['homologacao']['username'] = "root";
$db['homologacao']['password'] = "";
$db['homologacao']['database'] = "gerenciacliente";
$db['homologacao']['dbdriver'] = "mysql";
$db['homologacao']['dbprefix'] = "";
$db['homologacao']['pconnect'] = FALSE;
$db['homologacao']['db_debug'] = TRUE;
$db['homologacao']['cache_on'] = FALSE;
$db['homologacao']['cachedir'] = "";
$db['homologacao']['char_set'] = "utf8";
$db['homologacao']['dbcollat'] = "utf8_general_ci";

$db['default']['hostname'] = "www.rogeriomaster.com";
$db['default']['username'] = "rogeriom_gercli";
$db['default']['password'] = "rogerio5362";
$db['default']['database'] = "rogeriom_gerenciacliente";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
