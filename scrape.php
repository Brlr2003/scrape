<?php
$url = $_POST['url'];
include 'vendor/autoload.php';
use Goutte/Client;
use Goutte\Client;

$client = new Client();

$crawler = $client->