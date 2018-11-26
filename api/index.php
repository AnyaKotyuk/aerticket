<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://ak-site.xyz:8029/");
header("Access-Control-Allow-Credentials: true");

include 'DB.php';
include 'Flight.php';

$flight = new Flight($_POST['searchQuery']);

$action = $_GET['r'];
switch ($action) {
    case 'search':
        $flight->search();
        break;
    default:
        $flight->setErrorStatus();
        echo 'Wrong request';
}
