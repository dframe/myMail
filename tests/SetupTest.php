<?php
namespace Dframe\MyMail\tests;

use Dframe\MyMail\MyMail;
use Dframe\Config;

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') and class_exists('\PHPUnit_Framework_TestCase')) {
	class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class SetupTest extends \PHPUnit\Framework\TestCase
{

	public function mail()
	{
		$myMail = new MyMail(array(
			'Hosts' => array('localhost.localdomain'),      // Specify main and backup SMTP servers
			'SMTPAuth' => true,                    // Enable SMTP authentication
			'Username' => 'Username@mail',         // SMTP username
			'Password' => '',                      // SMTP password
			'SMTPSecure' => 'tls',                 // Enable TLS encryption, `ssl` also accepted
			'Port' => 587,                         // Port

			'setMailTemplateDir' => dirname(__DIR__) . '/tests/templates/',
			'smartyHtmlExtension' => '.html.php',              // Default '.html.php'
			'smartyTxtExtension' => '.txt.php',                // Default '.txt.php'
			'fileExtension' => '.html.php',

			'senderName' => 'example',      // Name of default sender
			'senderMail' => 'senderMail@mail'  // Default sender's address
		)); // Load Configu

		return $myMail;
	}

	public function testSetUp()
	{
		$this->assertInstanceOf(\Dframe\MyMail\MyMail::class, $this->mail());
	}

	public function testSend()
	{
		$addAddress = array('mail' => 'root@localhost.localdomain', 'name' => 'titleFrom'); // Addresses to send
		$this->assertTrue($this->mail()->send($addAddress, 'Title', 'Body'));
	}

	public function testInvalidEmail()
	{
		$addAddress = array('mail' => 'NotEmail', 'name' => 'titleFrom'); // Addresses to send
		$this->expectException($this->mail()->send($addAddress, 'Title', 'Body'));
	}
}
