<?php

namespace Controller;

use Dframe\Controller;

/**
 * Project Name
 * Copyright (c) Firstname Lastname
 *
 * @license http://yourLicenceUrl/ (Licence Name)
 */


/**
 * Here is a description of what this file is for.
 *
 * @author First Name <adres@email>
 */
class MailController extends Controller
{
    /**
     * initial function call working like __construct
     */
    public function init()
    {
        /** @var \Model\MailModel $MailModel */
        $MailModel = $this->loadModel('Mail');

        $MailModel->addToBuffer(['name' => 'FirstName', 'mail' => 'example@youremail.com'], 'Title', 'Body');
        $execute = $MailModel->execute();
    }
}
