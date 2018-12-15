Config file.

before 
```php
<?php
return array(
    'Hosts' => ['example@mail'],      // Specify main and backup SMTP servers
    'SMTPAuth' => true,                    // Enable SMTP authentication
    'Username' => 'Username@mail',         // SMTP username
    'Password' => '',                      // SMTP password
    'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
    'Port' => 587,                         // Port

    'senderName' => APP_NAME,      // Name of default sender
    'senderMail' => 'senderMail@mail'  // Default sender's address
);
```

After

```php
<?php
return array(
    'Hosts' => ['example@mail'],      // Specify main and backup SMTP servers
    'SMTPAuth' => true,                    // Enable SMTP authentication
    'Username' => 'Username@mail',         // SMTP username
    'Password' => '',                      // SMTP password
    'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
    'Port' => 587,                         // Port

    'SenderName' => APP_NAME,      // Name of default sender
    'SenderEmail' => 'senderMail@mail'  // Default sender's address
);
```



Class Call

before 
```php
<?php
$MyMail = new MyMail(); // Load Configu
$MyMail->mailObject->isSMTP();
$MyMail->mailObject->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
```


After 
```php
<?php
$MyMail = new MyMail($config); // Load Configu
$MyMail->mail->isSMTP();
$MyMail->mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
```
