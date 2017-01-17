<?php
use \Dframe\MyMail;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 

$myMail = new \MyMail(); // Załadowanie Configu
$addAddress = array('mail' => 'adres@email', 'name' => 'titleFrom'); // Adresy na jakie ma wysłać
$mail->send($addAddress, 'Test Mail', $body);

