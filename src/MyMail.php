<?php
/**
 * DframeFramework
 * Copyright (c) Sławomir Kaleta.
 *
 * @license https://github.com/dframe/dframe/blob/master/LICENCE (MIT)
 */

namespace Dframe\MyMail;

use Exception;
use InvalidArgumentException;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * MyMail Class
 *
 */
class MyMail
{
    /**
     * @var array
     */
    public $addAttachment = [];

    /**
     * @var array
     */
    public $config;

    /**
     * @var PHPMailer
     */
    public $mail;

    /**
     * @var PHPMailer
     */
    public $mailObject;

    /**
     * MyMail constructor.
     *
     * @param array $config
     *
     * @throws Exception
     */
    public function __construct(array $config)
    {
        if ((!isset($config['Hosts']) or empty($config['Hosts'])) or
            (!isset($config['SMTPAuth']) or empty($config['SMTPAuth'])) or
            (!isset($config['Username']) or empty($config['Username'])) or
            !isset($config['Password']) or
            (!isset($config['SMTPSecure']) or empty($config['SMTPSecure'])) or
            (!isset($config['Port']) or empty($config['Port'])) or
            (!isset($config['SenderEmail']) or empty($config['SenderEmail'])) or
            (!isset($config['SenderName']) or empty($config['SenderName']))

        ) {
            throw new InvalidArgumentException('Required params (Hosts, SMTPAuth, Username, Password, SMTPSecure, Port, SenderMail, SenderName)');
        }

        if (!is_bool($config['SMTPAuth'])) {
            throw new InvalidArgumentException('SMTPAuth must be type Boolean (true/false)');
        }

        $this->config = $config;
        $this->mail = new PHPMailer;
        $this->mail->CharSet = $config['CharSet'] ?? 'UTF-8';
        $this->mail->Host = is_array($this->config['Hosts']) ? implode(';',
            $this->config['Hosts']) : $this->config['Hosts'];
        $this->mail->SMTPAuth = $this->config['SMTPAuth'];
        $this->mail->Username = $this->config['Username'];
        $this->mail->Password = $this->config['Password'];
        $this->mail->SMTPSecure = $this->config['SMTPSecure'];
        $this->mail->Port = $this->config['Port'];

        /**
         * Backward compatibility
         */
        $this->mailObject = $this->mail;
    }

    /**
     * @param array $addAttachment
     *
     * @return self
     */
    public function addAttachment(array $addAttachment): self
    {
        if (!isset($addAttachment['path']) or empty($addAttachment['path'])) {
            throw new InvalidArgumentException('Attachment must have param path');
        }

        $this->addAttachment[] = $addAttachment;
        return $this;
    }

    /**
     * @param array  $recipient
     * @param string $subject
     * @param string $body
     * @param array  $sender
     *
     * @return bool
     * @throws Exception
     */
    public function send(array $recipient, string $subject, string $body, array $sender = []): bool
    {
        $this->mail->ClearAddresses();  // each AddAddress add to list
        $this->mail->ClearCCs();
        $this->mail->ClearBCCs();

        $this->mail->setFrom(
            $sender['mail'] ?? $this->config['SenderEmail'],
            $sender['name'] ?? $this->config['SenderName']);

        $this->mail->Subject = $subject;

        /**
         * Mail Validation
         */
        if (!PHPMailer::validateAddress($recipient['mail'])) {
            throw new Exception("Mailer Error: Invalid email format.");
        }

        $this->mail->addAddress($recipient['mail'], $recipient['name'] ?? '');     // Add a recipient

        if (!empty($this->addAttachment)) {
            foreach ($this->addAttachment as $key => $attachment) {
                $this->mail->addAttachment(
                    $attachment['path'], $attachment['name'] ?? '',
                    $attachment['encoding'] ?? $this->mail::ENCODING_BASE64,
                    $attachment['type'] ?? '',
                    $attachment['disposition'] ?? 'attachment');
            }
        }

        $this->mail->msgHTML($body);

        if (!$this->mail->send()) {
            throw new Exception('Mailer Error: ' . $this->mail->ErrorInfo);
        }

        $this->addAttachment = null;
        return true;
    }
}
