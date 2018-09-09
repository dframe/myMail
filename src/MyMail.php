<?php

namespace Dframe\MyMail;

use Dframe\Config;

/**
 * Biblioteka obslugi maili dla Dframe
 *
 */
class MyMail
{
    /**
     * @var array
     */
    public $addAttachment = [];

    /**
     * @var mixed|null
     */
    public $config;

    /**
     * @var \PHPMailer
     */
    public $mailObject;

    /**
     * MyMail constructor.
     *
     * @param array|null $config
     */
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

    /**
     * @param $addAttachment
     *
     * @return $this
     */
    public function addAttachment($addAttachment)
    {
        $this->addAttachment[] = $addAttachment;
        return $this;
    }

    /**
     * @param array  $Recipient
     * @param        $Subject
     * @param        $Body
     * @param string $Sender
     *
     * @return bool
     */
    public function send($Recipient, $Subject, $Body, $Sender = null)
    {
        $this->mailObject->ClearAddresses();  // each AddAddress add to list
        $this->mailObject->ClearCCs();
        $this->mailObject->ClearBCCs();


        if (is_null($Sender)) {
            $this->mailObject->setFrom($Sender['address'], $Sender['name']);
        } else {
            $this->mailObject->setFrom($this->config['senderMail'], $this->config['senderName']);
        }


        $this->mailObject->Subject = $Subject;

        if (!filter_var($Recipient['mail'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Mailer Error: Invalid email format.");
        }

        $this->mailObject->addAddress($Recipient['mail'], $Recipient['name']);     // Add a recipient

        if (!empty($this->addAttachment)) {
            foreach ($this->addAttachment as $key => $attachment) {
                $this->mailObject->addAttachment($attachment);
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
