<?php

namespace App\Contracts;


class Base
{
	protected $data = [];

	public function __construct(array $arguments = [])
	{
		$this->data = $arguments;
	}


	public static function __callStatic($name, $arguments)
    {
    	$class_name = get_called_class();
	    $class = new $class_name;

	    return call_user_func_array(array($class, $name), $arguments);

    }

    public function __call($name, $arguments)
    {
    	if($name == 'create'){
    		return call_user_func_array(array($this, $name), $arguments);
    	}
    }

    protected function create(array $arguments)
    {
    	$new_class = get_class($this);
    	$model = new $new_class($arguments);
    	return $model;

    }

    public function toArray()
    {
    	return (array)$this;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
    	$f = 'get'.ucfirst($name).'Attribute';
    	if(method_exists($this, $f)) {
	    	return call_user_func(array($this, $f));;
    	}

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

}




/*
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
*/



//$a->bla = '3';
/*var_dump($data);
die();
*/
