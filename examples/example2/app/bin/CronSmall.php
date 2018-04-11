<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
date_default_timezone_set('Europe/Warsaw');

require_once dirname(__DIR__).'/../vendor/autoload.php';
require_once dirname(__DIR__).'/../app/Bootstrap.php';
$bootstrap = new Bootstrap();

class CronSmall extends \Dframe\Controller
{
    
    public function init()
    {
        $this->dirLog = dirname(__DIR__).'/../web/cache/logs/cronSmall.txt';
  
        if(file_exists($this->dirLog) AND filemtime($this->dirLog)+59 > time()) { 
            echo filemtime($this->dirLog)."\n\r";
            echo time()."\n\r";
            die('Time Limit. Max 59 request on seconds.');
        } 

        $this->mailCron();
    }

    private function mailCron()
    {
        echo '#Updating mailCron'."\n\r";
        $mailModel = $this->loadModel('Mail');
        $mailModel->sendMails();
    }

}

$cron = new CronSmall($bootstrap);
$cron->init();
echo 'Ok';