##php 

class {{ $test or ''}} extends \TestCase
{
	public function testIndex()
	{
		$this->call('GET', '{{ $model or '' }}');
		$this->assertResponseOk();
	}

	public function testShow()
	{
		$this->call('GET', '{{ $model or '' }}/1');
		$this->assertResponseOk();
	}

	public function testCreate()
	{
		$this->call('GET', '{{ $model or '' }}/create');
		$this->assertResponseOk();
	}

	public function testEdit()
	{
		$this->call('GET', '{{ $model or '' }}/1/edit');
		$this->assertResponseOk();
	}
}
