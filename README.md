# Dframe/myMail

Moduł mail do frameworka Dframe 

### Użycie
```php
# config/myMail.php
<?php 
return array(
	'Hosts' => array('example@mail'), // Specify main and backup SMTP servers
	'SMTPAuth' => true,					// Enable SMTP authentication
	'Username' => 'Username@mail',	// SMTP username
	'Password' => '',				// SMTP password
	'SMTPSecure' => 'tls',				// Enable TLS encryption, `ssl` also accepted
	'Port' => 587,						// Port

	'setMailTemplateDir' => './View/templates/mail',
	'smartyHtmlExtension' => '.html.php',              // Default '.html.php'
	'smartyTxtExtension' => '.txt.php',    //Default '.txt.php'
	'fileExtension' => '.html.php',

	'senderName' => PROJECT_NAME, //Name of default sender
	'senderMail' => 'senderMail@mail' //Default sender's address
?>
```

```php
<?php
use \Dframe\myMail;
use \Dframe\Config;
$view = $this->loadView('index');
$myMail = new myMail($config = Config::load('myMail')); // Załadowanie Configu

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
 
 $myMail->SMTPDebug  = 2; // enables SMTP debug information (for testing)
                        // 1 = errors and messages
                        // 2 = messages only
		       
$addAddress = array('mail' => $_POST['email'], 'name' => $userResult['firstname']); // Adresy na jakie ma wysłać
$view->assign('name', $userResult['firstname']); // Podmiana z templatki wartości
$body = $view->fetchMail('reset'); // Templatka Maila
$mail->send($addAddress, 'Test Mail', $body);
````


Stalone example#1 php
```php
use \Dframe\myMail\MyMail;
require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 
$myMail = new \MyMail($config); // Załadowanie Configu
$addAddress = array('mail' => 'adres@email', 'name' => 'titleFrom'); // Adresy na jakie ma wysłać
$mail->send($addAddress, 'Test Mail', $body);
````


Stalone example#2 php
```php

<?php
use Dframe\myMail\myMail

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once 'config/config.php'; 

$mail = new myMail(); // Załadowanie Configu
$mail->mailObject->isSMTP();
$mail->mailObject->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//$mail->SMTPDebug  = 2; // enables SMTP debug information (for testing)
                       // 1 = errors and messages
                       // 2 = messages only
$mail->mailObject->SMTPSecure = false;

$addAddress = array('mail' => 'adres@email', 'name' => 'titleFrom'); // Adresy na jakie ma wysłać
s
try {
	$mail->send($addAddress, 'Test Mail', $body);

} catch (Exception $e) {
	echo $e->getMessage();
	
}
```