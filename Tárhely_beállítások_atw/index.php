<?php session_start();?>
<?php
//alkalmaz�s gy�k�r k�nyvt�ra a szerveren

define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']."/www/");

//URL c�m az alkalmaz�s gy�ker�hez
define('SITE_ROOT', 'https://sz95789.hosting.atw.co.hu/');

// a router.php vez�rl� bet�lt�se
require_once(SERVER_ROOT . 'controllers/' . 'router.php');

?>
