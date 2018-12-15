<?php

namespace Dframe\MyMail\Tests;

use Dframe\MyMail\MyMail;
use PHPUnit\Framework\TestCase;

class SetupTest extends TestCase
{
    public function testSetUp()
    {
        $this->assertInstanceOf(\Dframe\MyMail\MyMail::class, $this->mail());
    }

    public function mail()
    {
        $MyMail = new MyMail([
            'Hosts' => ['localhost.localdomain'],      // Specify main and backup SMTP servers
            'SMTPAuth' => true,                    // Enable SMTP authentication
            'Username' => 'Username@mail',         // SMTP username
            'Password' => '',                      // SMTP password
            'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
            'Port' => 587,                         // Port

            'SenderName' => 'example',      // Name of default sender
            'SenderEmail' => 'root@localhost.localdomain'  // Default sender's address
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
        } catch (\Exception $e) {
            $this->assertEquals('Mailer Error: Invalid email format.', $e->getMessage());
        }
    }
}
