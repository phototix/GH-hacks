<?php  
abstract class Animal {
    abstract public function makeSound();
}

class Dog extends Animal {
    public function makeSound() {
        echo "Woof!";
    }
}

$dog = new Dog();
$dog->makeSound();
?>