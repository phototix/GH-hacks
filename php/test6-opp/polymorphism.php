<?php  
class Shape {
    public function area() {
        // Default implementation
    }
}

class Rectangle extends Shape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function area() {
        return $this->width * $this->height;
    }
}

class Circle extends Shape {
    private $radius;

    public function __construct($radius) {
        $this->radius = $radius;
    }

    public function area() {
        return pi() * $this->radius * $this->radius;
    }
}

$shapes = [
    new Rectangle(5, 10),
    new Circle(3)
];

foreach ($shapes as $shape) {
    echo "Area: " . $shape->area() . "<br>";
}
?>