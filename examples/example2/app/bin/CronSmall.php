<?php

use Dframe\Router\Response;

set_time_limit(0);
ini_set('max_execution_time', 0);
date_default_timezone_set('Europe/Warsaw');
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../web/config.php';
/**
 * Self Aonymous Cron class
 */
return (new class() extends \Dframe\Cron\Task {
    /**
     * @return Response
     */
    public function init()
    {
        $lockTime = $this->lockTime('Mail', 59);
        if ($lockTime) {
            /**
             * Your Code
             */
            $MailModel = $this->loadModel('Mail');
            $MailModel->sendMails();

            return Response::renderJSON(['code' => 200, 'message' => 'Cron Complete']);
        }
        return Response::renderJSON(['code' => 403, 'message' => 'Cron in Lock'])->status(403);
    }
}
)->init()->display();
