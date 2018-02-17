<?php 

class  extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', 'communication');
		$this->assertResponseOk();
	}

	public function testShow()
	{
		$this->call('GET', 'communication/1');
		$this->assertResponseOk();
	}

	public function testCreate()
	{
		$this->call('GET', 'communication/create');
		$this->assertResponseOk();
	}

	public function testEdit()
	{
		$this->call('GET', 'communication/1/edit');
		$this->assertResponseOk();
	}
}
