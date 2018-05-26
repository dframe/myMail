<?php
$autoloader = include dirname(__DIR__) . '/vendor/autoload.php';
$autoloader->addPsr4('Dframe\\MyMail\\tests\\', __DIR__);

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') and class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}