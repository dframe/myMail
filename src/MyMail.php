<?php
namespace Dframe\MyMail;

use PHPMailer\PHPMailer;
use Dframe\Config;


/**
 * Biblioteka obslugi maili dla Dframe
 */
class MyMail
{

    public $addAttachment = array();
    //protected $config;

    public function __construct($config = null)
    {
        $this->config = $config;

        if (is_null($this->config)) {
            $this->config = Config::load('myMail')->get();
        }

        $this->mailObject = new \PHPMailer;
        $this->mailObject->CharSet = 'UTF-8';
        $this->mailObject->Host = implode(';', $this->config['Hosts']);
        $this->mailObject->SMTPAuth = $this->config['SMTPAuth'];
        $this->mailObject->Username = $this->config['Username'];
        $this->mailObject->Password = $this->config['Password'];
        $this->mailObject->SMTPSecure = $this->config['SMTPSecure'];
        $this->mailObject->Port = $this->config['Port'];
        return $this->mailObject;

    }

    public function addAttachment($addAttachment)
    {
        $this->addAttachment[] = $addAttachment;
        return $this;
    }

    public function send($Recipient = array(), $Subject, $Body, $Sender = '')
    {

        $this->mailObject->ClearAddresses();  // each AddAddress add to list
        $this->mailObject->ClearCCs();
        $this->mailObject->ClearBCCs();


        if ($Sender != '') {
            $this->mailObject->setFrom($Sender['address'], $Sender['name']);
        } else {
            $this->mailObject->setFrom($this->config['senderMail'], $this->config['senderName']);
        }


        $this->mailObject->Subject = $Subject;

        $Recipient['mail'] = $Recipient['mail'];
        $domain = explode('@', $Recipient['mail']);
        if (!filter_var($Recipient['mail'], FILTER_VALIDATE_EMAIL) AND $domain[1] != 'localhost') {
            throw new \Exception("Mailer Error: Invalid email format.");
        }

        $this->mailObject->addAddress($Recipient['mail'], $Recipient['name']);     // Add a recipient

        if (!empty($this->addAttachment)) {
            foreach ($addAttachment as $key => $attachment) {
                $this->mailObject->addAttachment = $attachment;
            }
        }
        $this->mailObject->msgHTML($Body);

        if (!$this->mailObject->send()) {
            throw new \Exception("Mailer Error: " . $this->mailObject->ErrorInfo);
        }

        $this->addAttachment = null;
        return true;
    }


}
