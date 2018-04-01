<?php 
session_start();
require_once "vendor/autoload.php";
require_once "resources/library/doctrine/bootstrap.php";

$rooter = new rooter\Rooter( $entityManager );