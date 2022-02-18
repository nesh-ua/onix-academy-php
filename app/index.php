<?php

class Food {}

class AnimalFood extends Food {}

abstract class Animal
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function eat(AnimalFood $food)
    {
        echo $this->name . " ест " . get_class($food);
    }
}

class Dog extends Animal
{
    public function speak()
    {
        echo $this->name . " лает";
    }

    public function eat(Food $food) {
        echo $this->name . " ест " . get_class($food);
    }
}

class Cat extends Animal
{
    public function speak()
    {
        echo $this->name . " мяукает";
    }
}


interface AnimalShelter
{
    public function adopt(string $name): Animal;
}

class CatShelter implements AnimalShelter
{
    public function adopt(string $name): Cat // Возвращаем класс Cat вместо Animal
    {
        return new Cat($name);
    }
}

class DogShelter implements AnimalShelter
{
    public function adopt(string $name): Dog // Возвращаем класс Dog вместо Animal
    {
        return new Dog($name);
    }
}

$kitty = (new CatShelter)->adopt("Рыжик");
$catFood = new AnimalFood();
$kitty->eat($catFood);
echo "\n";

$doggy = (new DogShelter)->adopt("Бобик");
$banana = new Food();
$doggy->eat($banana);