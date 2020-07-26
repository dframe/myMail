<?php

namespace Dframe\MyMail\Tests;

use Dframe\MyMail\MyMail;
use Exception;
use PHPUnit\Framework\TestCase;

class SetupTest extends TestCase
{
    public function testSetUp()
    {
        $this->assertInstanceOf(MyMail::class, $this->mail());
    }

    public function mail()
    {
        $MyMail = new MyMail([
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
            'senderName' => 'example',

            /**
             * Default sender's address
             */
            'senderEmail' => 'root@localhost.localdomain'
        ]); // Load Config

        return $MyMail;
    }

    public function testSend()
    {
        $addAddress = ['mail' => 'root@localhost.localdomain', 'name' => 'titleFrom']; // Addresses to send
        $this->assertTrue($this->mail()->send($addAddress, 'Title', 'Body'));
    }

    public function testInvalidEmail()
    {
        $addAddress = ['mail' => 'NotEmail', 'name' => 'titleFrom']; // Addresses to send

        try {
            $this->mail()->send($addAddress, 'Title', 'Body');
        } catch (Exception $e) {
            $this->assertEquals('Mailer Error: Invalid email format.', $e->getMessage());
        }
    }
}
