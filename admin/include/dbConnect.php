<?php
set_time_limit(0);
$server = 0;
$db_host        = 'localhost';
$db_user        = 'root';
$db_pass        = '';
$db_database    = 'yuva_aqua';
if ($server == 1) {
    $db_host        = 'localhost';
    $db_user        = 'ewolweDefault';
    $db_pass        = 'bwa@R3Vl[UVQ';
    $db_database    = 'ap_yuva_aqua';
}
$db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_database, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
