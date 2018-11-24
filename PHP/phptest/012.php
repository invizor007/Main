<?php

class A
{
	public $X=0;
	
	public function __construct()
    {
        echo "ClassA constructor<br>";
		$this->X = 1;
    }
	
	public function foo()
	{
		echo $this->X."<br>";
		
		if (isset($this)) 
		{
			echo '$this is defined (';
			echo get_class($this);
			echo ")<br>";
		}
		else 
		{
			echo '$this is not defined<br>';
		}
	}
	
	static function bar()
	{
		echo "bar<br>";
	}
}
        
        

class B extends A
{
	public function __construct()
    {
        echo "ClassB constructor<br>";
		$this->X = 2;
    }	
	
	public function foo2()
	{
		A::foo();
	}
	
	static function bar2()
	{
		A::bar();
	}	
}


$a=new A();
$a->foo();
A::bar();

echo "<br>";

$b=new B();
$b->foo2();
B::bar2();
?>

