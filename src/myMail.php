<?php
namespace Dframe\myMail;
use \PHPMailer\PHPMailer;
use \Dframe\Config;


/**
* Biblioteka obslugi maili dla Dframe
*/
class myMail
{
	
	public $addAttachment = array();
	//protected $config;

	public function __construct(){
		$this->config = Config::load('myMail')->get();

        $this->mailObject = new \PHPMailer;
        $this->mailObject->CharSet = 'UTF-8';
        $this->mailObject->isSMTP();      
		$this->mailObject->Host = implode(';', $this->config['Hosts']);
		$this->mailObject->SMTPAuth = $this->config['SMTPAuth'];
		$this->mailObject->Username = $this->config['Username'];
		$this->mailObject->Password = $this->config['Password'];
		$this->mailObject->SMTPSecure = $this->config['SMTPSecure'];
		$this->mailObject->Port = $this->config['Port'];
		return $this->mailObject;

	}

	public function addAttachment($addAttachment){
		$this->addAttachment[] = $addAttachment;
		return $this;
	}

	public function send($Recipient = array(), $Subject, $Body, $Sender = ''){

		$this->mailObject->ClearAddresses();  // each AddAddress add to list
		$this->mailObject->ClearCCs();
		$this->mailObject->ClearBCCs();


		if($Sender != '')
			$this->mailObject->setFrom($Sender['address'], $Sender['name']);
		else
			$this->mailObject->setFrom($this->config['senderMail'], $this->config['senderName']);
		
        
        $this->mailObject->Subject = $Subject;
        $this->mailObject->addAddress($Recipient['mail'], $Recipient['name']);     // Add a recipient

        if(!empty($this->addAttachment))
        	foreach ($addAttachment as $key => $Attachment) {
        		 $this->mailObject->addAttachment = $Attachment;
        	}
        $this->mailObject->msgHTML($Body);

    	if (!$this->mailObject->send()) {
		    throw new \Exception("Mailer Error: " . $this->mailObject->ErrorInfo);
		    return false;
		}

		$this->addAttachment = null;
		return true;
	}


}