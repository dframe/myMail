<?php
use PHPUnit_Framework_Constraint_IsType as PHPUnit_IsType;


// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') AND class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class SetupTest extends \PHPUnit\Framework\TestCase {


	public function setUp(){
    //ToDo
	}

	public function testToDo(){
		
	}
}
