<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
 
require_once('php-libs/Database.class.php');
 
$dbHost = 'localhost:3306';
$dbUser = 'user';
$dbPassword = 'pw';

#world
$dbName = 'world';
$world = new Database($dbHost, $dbUser, $dbPassword, $dbName);

#website
$dbName = 'website';
$website = new Database($dbHost, $dbUser, $dbPassword, $dbName);

#character
$dbName = 'characters';
$character = new Database($dbHost, $dbUser, $dbPassword, $dbName);
