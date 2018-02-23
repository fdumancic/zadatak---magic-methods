<?php

namespace App\Contracts;


class Base
{
	protected $data = [];

	protected $hidden = ['slug', 'id'];

	protected $appends = ['full_name'];

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
    	/*$new_array = (array)$this->data;
    	$hidden_array = (array)$this->hidden;

    	foreach ($hidden_array as $key => $value) {
    		if(array_key_exists($value, $new_array)) {
    			unset($new_array[$value]);
    		}
    	}
    	return $new_array;*/
//-------------------
    	/*$new_array = (array)$this->data;
    	$hidden_array = (array)$this->hidden;

    	$filltered = array_diff_key($new_array, array_flip($hidden_array));

    	return $filltered;*/
//-------------------
    	$new_array = (array)$this->data;
    	$hidden_array = $this->hidden;
    	$appends_array = $this->appends;

    	$filtered_array = array_filter($new_array, function ($key) use ($hidden_array) {
    		return !in_array($key, $hidden_array);
    		}, ARRAY_FILTER_USE_KEY);
    	return $filtered_array;

    	$appended_array = $filtered_array;

    }

    public function __set($name, $value)
    {
    	$f = 'set'.ucfirst($name).'Attribute';
    	if(method_exists($this, $f)) {
	    	return call_user_func(array($this, $f), $value);
    	}
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
    	$f = 'get'.ucfirst($name).'Attribute';
    	if(method_exists($this, $f)) {
	    	return call_user_func(array($this, $f), $this->data[$name]);
    	}
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }
    public function getFullNameAttribute()
    {
  		return $this->first_name . ' ' . $this->last_name;
	}
}

$a = new Base(["id" => "1", "slug" => "test", "first_name" => "John", "last_name" => "Doe"]);
$b = $a->toArray();

print_r($b);