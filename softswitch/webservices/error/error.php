<?php

/**
 * Created by PhpStorm.
 * User: Mazhar
 * Date: 10/25/2014
 * Time: 5:59 PM
 */
if (isset($_REQUEST['error'])) {

    $error = $_REQUEST['error'];

    $user_name = isset($_REQUEST['user_ame']) ? $_REQUEST['user_ame'] : "";
    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";

    errorHandling($error, $user_name, $user_id);
}

function errorHandling($e, $user_name = "", $user_id = "")
{
    $content = "Message: $user_name has faced this error and his User ID is $user_id  on " . date("l jS \of F Y h:i:s A") . "  $e \n";

    $myFile = "log/error/errorLog.txt";
    $fh = fopen($myFile, 'a+') or die("can't open file");

    fwrite($fh, $content);
    fclose($fh);
}

/*
 *
 */
