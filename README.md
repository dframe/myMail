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
use \Dframe\MyMail;
$view = $this->loadView('index');
$myMail = new \MyMail($config = \Dframe\Core\Config::load('myMail')); // Załadowanie Configu

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
$addAddress[] = array('mail' => $_POST['email'], 'name' => $userResult['firstname']); // Adresy na jakie ma wysłać
$view->assign('name', $userResult['firstname']); // Podmiana z templatki wartości
$body = $view->fetchMail('reset'); // Templatka Maila
$mail->send($addAddress, 'Test Mail', $body);
?>
````
