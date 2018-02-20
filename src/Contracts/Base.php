<?php

namespace App\Contracts;

class Base
{
/*	public function __set($property, $value)
	{
		if(property_exists($this, $property)) {
	    $this->$property = $value;
	  	}
	}

	public function __get($property)
	{
		if(property_exists($this, $property)) {
	    return $this->$property;
	  	}
	}
	public function __unset($name)
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }*/

    public static function create(array $array)
    {
    	$class = get_called_class();


    	$data = new $class;

		foreach ($array as $key => $value)
		{
		    $data->$key = $value;
		}

		return $data;

    }

    public function toArray()
    {
    	return (array)$this;
    }

}

class A extends Base
{
    public function setSlugAttribute($value) {
         $this->slug = strtolower($value);
    }
}

class B extends Base
{
    protected $appends = [
        'full_name',
    ];

    protected $hidden = [
        'slug',
    ];

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }
}

$data = A::create(["id"=>"5", "slug"=>"TEST"]);
/*var_dump($data->toArray());*/
/*var_dump($data instanceof A);*/
