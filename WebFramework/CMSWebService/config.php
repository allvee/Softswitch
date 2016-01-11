<?php

include_once "utils.php";
error_reporting(0);
mysql_connect("localhost", "root", "nopass") or die(mysql_error());
mysql_select_db("ocmportal_cms") or die(mysql_error());
