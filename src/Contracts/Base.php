<?php

namespace App\Contracts;

class Base
{
	protected $data = [];

	protected $hidden = ['slug'];

	protected $appends = ['full_name'];

    protected $fillable = ['first_name', 'last_name'];

    protected $guarded = ['id'];

	public function __construct(array $arguments = [])
	{
		$this->data = $arguments;
	}

    /**
     * Magic method __callStatic()
     *
     * @param string $name
     * @param array $arguments
     * @return object
     */
	public static function __callStatic($name, $arguments)
    {
    	$class_name = get_called_class();
	    $class = new $class_name;
	    return call_user_func_array(array($class, $name), $arguments);
    }

    /**
     * Magic method __call()
     *
     * @param string $name
     * @param array $arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
    	if($name == 'create'){
    		return call_user_func_array(array($this, $name), $arguments);
    	}
    }

    /**
     * Creates instance of current class
     *
     * @param array $arguments
     * @return object
     */
    protected function create(array $arguments)
    {
    	$new_class = get_class($this);
    	$model = new $new_class($arguments);
    	return $model;
    }

    /**
     * Returns array with appended and without hidden elements
     *
     * @return array
     */
    public function toArray()
    {
    	$new_array = (array)$this->data;
    	$hidden_array = $this->hidden;
        $to_merge = [];

        foreach ($this->appends as $key => $value) {
            $function_name = 'get'.ucfirst($value).'Attribute';
            if(method_exists($this, $function_name)) {
                $to_merge[$value] = call_user_func(array($this, $function_name));
            }
        }

    	$appended_array = array_merge($new_array, $to_merge);

        $filtered_array = array_filter($appended_array, function ($key) use ($hidden_array) {
            return !in_array($key, $hidden_array);
            }, ARRAY_FILTER_USE_KEY);
        return $filtered_array;

    }

    /**
     * Magic method __set()
     *
     * @param string $name
     * @param string $value
     * @return object
     */
    public function __set($name, $value)
    {
    	$function_name = 'set'.ucfirst($name).'Attribute';
    	if(method_exists($this, $function_name)) {
	    	return call_user_func(array($this, $function_name), $value);
    	}

        if(in_array($name, $this->fillable) && (!in_array($name, $this->guarded))){
            $this->data[$name] = $value;
        }
    }

    /**
     * Magic method __get()
     *
     * @param string $name
     * @return object
     */
    public function __get($name)
    {
    	$function_name = 'get'.ucfirst($name).'Attribute';
    	if(method_exists($this, $function_name)) {
	    	return call_user_func(array($this, $function_name), $this->data[$name]);
    	}
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    /**
     * Returns string with full name
     *
     * @return string
     */
    public function getFull_nameAttribute()
    {
  		return $this->first_name . ' ' . $this->last_name;
	}
}

$a = new Base(["id" => "1", "slug" => "aaabbbccc", "first_name" => "John", "last_name" => "Doe"]);
$b = $a->toArray();
$a->test = 'aaaaa';
$c = $a->test;

print_r($c);