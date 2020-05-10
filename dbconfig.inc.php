<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
 
require_once('php-libs/Database.class.php');
 
$wowHost = 'localhost:3306';
$wowUser = 'user';
$wowPassword = 'pw';

$webHost = 'localhost:3306';
$webUser = 'user';
$webPassword = 'pw';

#world
$dbName = 'world';
$world = new Database($wowHost, $wowUser, $wowPassword, $dbName);

#website
$dbName = 'website';
$website = new Database($webHost, $webUser, $webPassword, $dbName);

#character
$dbName = 'characters';
$character = new Database($wowHost, $wowUser, $wowPassword, $dbName);
