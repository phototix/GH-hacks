<?php  
class Person {
    public $name;
    public $age;

    public function sayHello() {
        echo "Hello, my name is " . $this->name;
    }
}
?>