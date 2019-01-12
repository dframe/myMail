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
    'senderName' => 'Sender Name',

    /**
     * Default sender's address
     */
    'senderEmail' => 'senderMail@mail'
];
