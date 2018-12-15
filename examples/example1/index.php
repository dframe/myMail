<?php

use Dframe\MyMail\MyMail;

require_once __DIR__ . '/../vendor/autoload.php';
$config = include_once 'config/config.php';

$mail = new MyMail($config); // Załadowanie Configu
$mail->mailObject->isSMTP();
$mail->mailObject->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ]
];
//$mail->SMTPDebug  = 2; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
$mail->mailObject->SMTPSecure = false;

$addAddress = ['mail' => 'adres@email', 'name' => 'Title From']; // Adresy na jakie ma wysłać

try {
    $mail->send($addAddress, 'Test Mail', 'Hello Word!');
} catch (Exception $e) {
    echo $e->getMessage();
}
