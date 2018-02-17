<?php 

class  extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'message');
		$this->assertResponseOk();
	}

	public function testShow()
	{
		$this->call('GET', 'message/1');
		$this->assertResponseOk();
	}

	public function testCreate()
	{
		$this->call('GET', 'message/create');
		$this->assertResponseOk();
	}

	public function testEdit()
	{
		$this->call('GET', 'message/1/edit');
		$this->assertResponseOk();
	}
}
