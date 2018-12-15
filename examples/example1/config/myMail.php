<?php

return [
    'Hosts' => ['example@mail'],      // Specify main and backup SMTP servers
    'SMTPAuth' => true,                    // Enable SMTP authentication
    'Username' => 'Username@mail',         // SMTP username
    'Password' => '',                      // SMTP password
    'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
    'Port' => 587,                         // Port

    'setMailTemplateDir' => APP_DIR . 'View/templates/mail',
    'smartyHtmlExtension' => '.html.php',              // Default '.html.php'
    'smartyTxtExtension' => '.txt.php',                // Default '.txt.php'
    'fileExtension' => '.html.php',

    'SenderName' => PROJECT_NAME,      // Name of default sender
    'senderEmail' => 'senderMail@mail'  // Default sender's address
];
