<?php

session_start();

include_once("utils.php");
include_once("audit.php");
include_once("global_config.php");
error_reporting(0);
$dbtype = 'mysql';
$UserID = 'root';
$Password = 'nopass';
$Server = 'localhost';
$Database = 'softswitch';

$salt = 'DjhG83b0QyJfIxfs2gsVoUubWwVniR2G0FgaC9ny';
$temp_dbtype = '';
$temp_UserID = '';
$temp_Password = '';
$temp_Server = '';
$temp_Database = '';
?>