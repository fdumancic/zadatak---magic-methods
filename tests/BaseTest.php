<?php

use App\Contracts\A;
use App\Contracts\B;
use App\Contracts\Base;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
	public function testDataisCreated()
	{
		$data = array();
		$data = Base::create(["id"=>"5", "slug"=>"TEST"]);
		$this->assertEquals($data->slug, 'TEST');
	}

	public function testGetClassA()
	{
		$data = array();
		$data = A::create(["id"=>"5", "slug"=>"TEST"]);
		$a = (object) $data;
		$this->assertEquals(get_class($a), 'App\Contracts\A');
	}
}
