<?php
namespace Controller;

/**
 * Project Name
 * Copyright (c) Firstname Lastname
 *
 * @license http://yourLicenceUrl/ (Licence Name)
 */

use Dframe\Config;
use Dframe\Router\Response;

/**
 * Here is a description of what this file is for.
 *
 * @author First Name <adres@email>
 */

class MailController extends \Controller\Controller
{
    /** 
     * initial function call working like __construct
     */
    public function init()
    {
        $mailModel = $this->loadModel('Mail');
        $mailModel->addToBuffer(array('name' => 'FirstName', 'mail' => 'example@youremail.com'), 'Title', 'Body');
        $execute = $mailModel->execute();
    }
}
                    