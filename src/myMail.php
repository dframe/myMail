<?php
namespace Dframe\myMail;
use \PHPMailer\PHPMailer;

/**
* Biblioteka obslugi maili dla Dframe
*/
class myMail
{
	
	public $addAttachment = array();
	protected $config;

	public function __construct(array $config){
		$this->config = $config;
		

        $this->mailObject = new \PHPMailer;
        $this->mailObject->isSMTP();      
		$this->mailObject->Host = implode(';', $this->config['Hosts']);
		$this->mailObject->SMTPAuth = $this->config['SMTPAuth'];
		$this->mailObject->Username = $this->config['Username'];
		$this->mailObject->Password = $this->config['Password'];
		$this->mailObject->SMTPSecure = $this->config['STMPSecure'];
		$this->mailObject->Port = $this->config['Port'];

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

		if($Sender != '')
			$this->mailObject->setFrom($Sender['address'], $Sender['name']);
		else
			$this->mailObject->setFrom($this->config['senderMail'], $this->config['senderName']);
		
        
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