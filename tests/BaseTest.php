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

		$val = 25;
        // Create a prophecy for the Observer class.
        $observer = $this->prophesize(A::class);

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->getNameAttribute($val)->shouldBeCalled();

        $model = $observer->reveal();

        $model->name = $val;

        $model->name;


/*        // Create a prophecy for the Observer class.
        $observer = $this->prophesize(A::class);

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->getNameAttribute(null)->shouldBeCalled();

        $model = $observer->reveal();

        $model->name;
        */
	}

	/* mutators - seter */

	public function testMutator()
	{

		$val = 25;

        $observer = $this->prophesize(B::class);

        $observer->setNameAttribute($val)->shouldBeCalled();

        $model = $observer->reveal();

        $model->name = $val;

        $model->name;

	}


}


class A extends Base
{
	public function getNameAttribute($val)
	{
		//
	}
}

class B extends Base
{
	public function setNameAttribute($val)
	{
		//
	}
}