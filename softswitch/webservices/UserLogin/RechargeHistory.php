<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 3/22/2015
 * Time: 6:23 PM
 */

$data=array();
$i=0;$j=0;
$data[$i][$j++]= '1';
$data[$i][$j++]= '2';
$data[$i][$j++]= '3';
$data[$i][$j++]= '4';
$data[$i][$j++]= '5';
$data[$i][$j++]= '6';

echo json_encode($data);