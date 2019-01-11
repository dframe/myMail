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
        if ((!isset($config['hosts']) or empty($config['hosts'])) or
            (!isset($config['smtpAuth']) or empty($config['smtpAuth'])) or
            (!isset($config['username']) or empty($config['username'])) or
            !isset($config['password']) or
            (!isset($config['smtpSecure']) or empty($config['smtpSecure'])) or
            (!isset($config['port']) or empty($config['port'])) or
            (!isset($config['senderEmail']) or empty($config['senderEmail'])) or
            (!isset($config['senderName']) or empty($config['senderName']))

        ) {
            throw new InvalidArgumentException('Required params (hosts, smtpAuth, username, password, smtpSecure, port, senderMail, senderName)');
        }

        if (!is_bool($config['smtpAuth'])) {
            throw new InvalidArgumentException('SMTPAuth must be type Boolean (true/false)');
        }

        $this->config = $config;
        $this->mail = new PHPMailer;
        $this->mail->CharSet = $config['CharSet'] ?? 'UTF-8';
        $this->mail->Host = is_array($this->config['hosts']) ? implode(';',
            $this->config['hosts']) : $this->config['hosts'];
        $this->mail->SMTPAuth = $this->config['smtpAuth'];
        $this->mail->Username = $this->config['username'];
        $this->mail->Password = $this->config['password'];
        $this->mail->SMTPSecure = $this->config['smtpSecure'];
        $this->mail->Port = $this->config['port'];

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
            $sender['mail'] ?? $this->config['senderEmail'],
            $sender['name'] ?? $this->config['senderName']);

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
