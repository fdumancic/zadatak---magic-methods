<?php

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

	public function testCreateMethodShoudReturnNewObject()
	{
		$class_1 = new A();

		$class_2 = $class_1->create(['id' => 2]);

		$this->assertInstanceOf(A::class, $class_2);

		$this->assertNotSame($class_1->id, $class_2->id);
	}

	public function testAccessor()
	{
        // Create a prophecy for the Observer class.
        $observer = $this->prophesize(A::class);

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->getNameAttribute()->shouldBeCalled();

        $model = $observer->reveal();

        $model->name;
	}
}


class A extends Base
{
	public function getNameAttribute()
	{
		//
	}
}