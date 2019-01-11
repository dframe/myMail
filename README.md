# Dframe/MyMail

[![Build Status](https://travis-ci.org/dframe/myMail.svg?branch=master)](https://travis-ci.org/dframe/myMail) [![Latest Stable Version](https://poser.pugx.org/dframe/myMail/v/stable)](https://packagist.org/packages/dframe/myMail) [![Latest Unstable Version](https://poser.pugx.org/dframe/myMail/v/unstable)](https://packagist.org/packages/dframe/myMail) [![License](https://poser.pugx.org/dframe/myMail/license)](https://packagist.org/packages/dframe/myMail)

Simple mail wrapper using phpmailer 

### Użycie
#### config/myMail.php

```php
<?php

return [
    /**
     * Specify main and backup SMTP servers
     */
    'hosts' => ['primaryHostName.tld', 'backupHostName.tld'],

    /**
     * Enable SMTP authentication
     */
    'smtpAuth' => true,

    /**
     * SMTP username
     */
    'username' => 'Username@mail',

    /**
     * SMTP password
     */
    'password' => '',

    /**
     * Enable TLS encryption, `ssl` also accepted
     */
    'smtpSecure' => 'tls',

    /**
     * Port
     */
    'port' => 587,

    /**
     * Name of default sender
     */
    'senderName' => PROJECT_NAME,

    /**
     * Default sender's address
     */
    'senderEmail' => 'senderMail@mail'
];

```

```php
<?php

use Dframe\MyMail\MyMail;
use Dframe\Config;
$view = $this->loadView('index');
$MyMail = new MyMail($config = Config::load('myMail')->get()); // Load Configu

/* 
 * If you have problem with ssl in php 5.6 add
 *       $MyMail->SMTPOptions = [
 *           'ssl' => [
 *               'verify_peer' => false,
 *               'verify_peer_name' => false,
 *               'allow_self_signed' => true
 *           ]
 *       ];
 */
 
 $MyMail->SMTPDebug  = 2; // Enables SMTP debug information (for testing)
                          // 1 = errors and messages
                          // 2 = messages only
		       
$addAddress = ['mail' => $_POST['email'], 'name' => $_POST['firstname']];    // Addresses to send
$view->assign('name', $_POST['firstname']);                                       // Assign template values
$body = $view->fetch('reset');                                                    // Template mail
$MyMail->send($addAddress, 'Test Mail', $body);
````


Stalone example#1 php

```php
use \Dframe\MyMail\MyMail;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 
$MyMail = new MyMail($config);                                       // Load Config
$addAddress = ['mail' => 'adres@email', 'name' => 'Title From']; // Addresses to send
$MyMail->send($addAddress, 'Test Mail', $body);
````


Standalone example#2 php

```php
<?php

use Dframe\MyMail\MyMail;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 

$MyMail = new MyMail($config); // Załadowanie Configu
$MyMail->mail->isSMTP();
$MyMail->mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//$MyMail->SMTPDebug  = 2; // Enables SMTP debug information (for testing)
                         // 1 = errors and messages
                         // 2 = messages only
$MyMail->mail->SMTPSecure = false;

$addAddress = ['mail' => 'adres@email', 'name' => 'titleFrom']; // Addresses to send

try {
    $MyMail->send($addAddress, 'Test Mail', 'Hello Word!');

} catch (Exception $e) {
    echo $e->getMessage();
	
}
```
