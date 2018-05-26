# Dframe/MyMail

Moduł mail do frameworka Dframe 

### Użycie
#### config/myMail.php

```php
<?php
return array(
    'Hosts' => array('example@mail'),      // Specify main and backup SMTP servers
    'SMTPAuth' => true,                    // Enable SMTP authentication
    'Username' => 'Username@mail',         // SMTP username
    'Password' => '',                      // SMTP password
    'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
    'Port' => 587,                         // Port

    'setMailTemplateDir' => APP_DIR . 'View/templates/mail',
    'smartyHtmlExtension' => '.html.php',              // Default '.html.php'
    'smartyTxtExtension' => '.txt.php',                // Default '.txt.php'
    'fileExtension' => '.html.php',

    'senderName' => PROJECT_NAME,      // Name of default sender
    'senderMail' => 'senderMail@mail'  // Default sender's address
);

```

```php
<?php

use Dframe\MyMail\MyMail;
use Dframe\Config;
$view = $this->loadView('index');
$myMail = new MyMail($config = Config::load('myMail')); // Load Configu

/* 
 * If you have problem with ssl in php 5.6 add
 *       $myMail->SMTPOptions = array(
 *           'ssl' => array(
 *               'verify_peer' => false,
 *               'verify_peer_name' => false,
 *               'allow_self_signed' => true
 *           )
 *       );
 */
 
 $myMail->SMTPDebug  = 2; // Enables SMTP debug information (for testing)
                          // 1 = errors and messages
                          // 2 = messages only
		       
$addAddress = array('mail' => $_POST['email'], 'name' => $_POST['firstname']);    // Addresses to send
$view->assign('name', $_POST['firstname']);                                       // Assign template values
$body = $view->fetch('reset');                                                    // Template mail
$mail->send($addAddress, 'Test Mail', $body);
````


Stalone example#1 php

```php
use \Dframe\MyMail\MyMail;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 
$myMail = new MyMail($config);                                       // Load Config
$addAddress = array('mail' => 'adres@email', 'name' => 'titleFrom'); // Addresses to send
$mail->send($addAddress, 'Test Mail', $body);
````


Stalone example#2 php

```php
<?php

use Dframe\MyMail\MyMail

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 

$mail = new MyMail(); // Załadowanie Configu
$mail->mailObject->isSMTP();
$mail->mailObject->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//$mail->SMTPDebug  = 2; // Enables SMTP debug information (for testing)
                         // 1 = errors and messages
                         // 2 = messages only
$mail->mailObject->SMTPSecure = false;

$addAddress = array('mail' => 'adres@email', 'name' => 'titleFrom'); // Addresses to send

try {
    $mail->send($addAddress, 'Test Mail', $body);

} catch (Exception $e) {
    echo $e->getMessage();
	
}
```
