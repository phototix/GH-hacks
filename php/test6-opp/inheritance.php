<?php  
class Animal {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function eat() {
        echo $this->name . " is eating.";
    }
}

class Cat extends Animal {
    public function meow() {
        echo "Meow!";
    }
}

$cat = new Cat("Whiskers");
$cat->eat();
$cat->meow();
?>