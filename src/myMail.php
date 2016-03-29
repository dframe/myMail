<?php
namespace Dframe\myMail;
use \PHPMailer\PHPMailer;

/**
* Biblioteka obslugi maili
*/
class myMail
{
	
	public $addAttachment = array();
	public $mailConfig;

	public function __construct(){
		$this->mailConfig = \Dframe\Core\Config::load('mail');

        $this->mailObject = new \PHPMailer;
        $this->mailObject->isSMTP();      
		$this->mailObject->Host = implode(';', $this->mailConfig->get('Hosts'));
		$this->mailObject->SMTPAuth = $this->mailConfig->get('SMTPAuth');
		$this->mailObject->Username = $this->mailConfig->get('Username');
		$this->mailObject->Password = $this->mailConfig->get('Password');
		$this->mailObject->SMTPSecure = $this->mailConfig->get('STMPSecure');
		$this->mailObject->Port = $this->mailConfig->get('Port');

	}

	public function addAttachment($addAttachment){
		$this->addAttachment[] = $addAttachment;
		return $this;
	}

	public function send($addAddress = array(), $Subject, $Body, $Sender = ''){
		$addAddress = array(array('mail' => '', 'name' => '')); //BLOKADA PRZYPADKOWEJ WYSYLKI MAILI TESTOWYCH POZA SYSTEM
		if(!isset($this->counter)){
			$this->counter = 0;
		}

		if($this->counter++ > 20){
			return;
		}
		//BLOKADA ANTYSPAMOWA, TYMCZASOWA

		if($Sender != ''){
			$this->mailObject->setFrom($Sender['address'], $Sender['name']);
		}
		else{
			$this->mailObject->setFrom($this->mailConfig->get('senderMail'), $this->mailConfig->get('senderName'));
		}
        
        foreach ($addAddress as $key => $Address) {
        	 $this->mailObject->addAddress($Address['mail'], $Address['name']);     // Add a recipient
        }

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