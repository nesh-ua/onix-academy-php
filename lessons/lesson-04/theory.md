# ООП (Часть 2).

## Область видимости

Область видимости свойства, метода или константы (начиная c PHP 7.1.0) может быть определена путём использования следующих ключевых слов в объявлении: public, protected или private. Доступ к свойствам и методам класса, объявленным как public (общедоступный), разрешён отовсюду. Модификатор protected (защищённый) разрешает доступ самому классу, наследующим его классам и родительским классам. Модификатор private (закрытый) ограничивает область видимости так, что только класс, где объявлен сам элемент, имеет к нему доступ.

```php 
<?php
    class MyClass
    {
        // константы
        public const PUBLIC = 'Public'; // будет доступ отовсюду
        public const PROTECTED = 'Protected'; // будет доступ с этого же класса и с класов наследников и родителей
        public const PRIVATE = 'Private'; // будет доступ только с этого же класса
    
        // свойства
        public $public = 'Public'; // будет доступ отовсюду
        protected $protected = 'Protected'; // будет доступ с этого же класса и с класов наследников и родителей
        private $private = 'Private'; // будет доступ только с этого же класса
    
        // методы
        public function public() // будет доступ отовсюду
        {
        }
    
        protected function protected() // будет доступ с этого же класса и с класов наследников и родителей
        {
        }
    
        private function private() // будет доступ только с этого же класса
        {
        }
    }
?>
```

## Наследование
Наследование — это хорошо зарекомендовавший себя принцип программирования, и PHP использует этот принцип в своей объектной модели. Этот принцип повлияет на то, как многие классы и объекты связаны друг с другом.

Например, при расширении класса дочерний класс наследует все общедоступные и защищённые методы, свойства и константы родительского класса. До тех пор пока эти методы не будут переопределены, они будут сохранять свою исходную функциональность.

Это полезно для определения и абстрагирования функциональности и позволяет реализовать дополнительную функциональность в похожих объектах без необходимости реализовывать всю общую функциональность.


```php 
<?php
    class Foo
    {
        public int $prop;
    
        public function printItem($string)
        {
            echo 'Foo: ' . $string . PHP_EOL;
        }
    
        public function printPHP()
        {
            echo 'PHP просто супер.' . PHP_EOL;
        }
    }
    
    class Bar extends Foo
    {
        // Нельзя: read-write -> readonly, это вызовет ошибку
        public readonly int $prop;
    
        // переопределяем функциию с класса родителя.
        // Видимость методов, свойств и констант можно ослабить, например, защищённый метод может быть помечен как общедоступный
        // но нельзя ограничить видимость, например, нельзя пометить общедоступное свойство как закрытое
        public function printItem($string)
        {
            // вызываем функцию с parent класа
            parent::printItem($string);
            $this->printPHP();
            echo 'Bar: ' . $string . PHP_EOL;
        }
    }
    
    $foo = new Foo();
    $bar = new Bar();
    $foo->printItem('baz'); // Выведет: 'Foo: baz'
    $foo->printPHP();       // Выведет: 'PHP просто супер'
    $bar->printItem('baz'); // Выведет: 'Foo: baz' и 'PHP просто супер' и 'Bar: baz'
    $bar->printPHP();       // Выведет: 'PHP просто супер'

?>
```

## Ключевое слово final

PHP предоставляет ключевое слово final, разместив которое перед объявлениями методов или констант класса, можно предотвратить их переопределение в дочерних классах. Если же сам класс определяется с этим ключевым словом, то он не сможет быть унаследован.

```php 
<?php 
    // этот клас нельзя расширить
    final class BaseClass 
    {
        // эту константу нельзя переопределить
        final public const X = "foo";
        
        public function test() 
        {
            echo "Вызван метод BaseClass::test()\n";
        }
        // этот метод нельзя переопределить в дочерних класах
        final public function moreTesting() 
        {
            echo "Вызван метод BaseClass::moreTesting()\n";
        }
    }
?>
```

## Абстрактные классы
PHP поддерживает определение абстрактных классов и методов. На основе абстрактного класса нельзя создавать объекты, и любой класс, содержащий хотя бы один абстрактный метод, должен быть определён как абстрактный. Методы, объявленные абстрактными, несут, по существу, лишь описательный смысл и не могут включать реализацию.

При наследовании от абстрактного класса, все методы, помеченные абстрактными в родительском классе, должны быть определены в дочернем классе и следовать обычным правилам наследования и совместимости сигнатуры.

```php 
<?php
    // нельзя создавать объект абстрактного класса
    abstract class AbstractClass
    {
        // Данные методы должны быть определены в дочернем классе
        abstract protected function getValue();
        abstract protected function prefixValue($prefix);
    
        // Общий метод
        public function printOut() {
            print $this->getValue() . "\n";
        }
    }
?>

```

## Интерфейсы объектов

Интерфейсы объектов позволяют создавать код, который указывает, какие методы должен реализовать класс, без необходимости определять, как именно они должны быть реализованы. Интерфейсы разделяют пространство имён с классами и трейтами, поэтому они не могут называться одинаково.

Интерфейсы объявляются так же, как и обычные классы, но с использованием ключевого слова interface вместо class. Тела методов интерфейсов должны быть пустыми.

Все методы, определённые в интерфейсах, должны быть общедоступными, что следует из самой природы интерфейса.

На практике интерфейсы используются в двух взаимодополняющих случаях:
- Чтобы позволить разработчикам создавать объекты разных классов, которые могут использоваться взаимозаменяемо, поскольку они реализуют один и тот же интерфейс или интерфейсы. Типичный пример - несколько служб доступа к базе данных, несколько платёжных шлюзов или разных стратегий кеширования. Различные реализации могут быть заменены без каких-либо изменений в коде, который их использует.
- Чтобы разрешить функции или методу принимать и оперировать параметром, который соответствует интерфейсу, не заботясь о том, что ещё может делать объект или как он реализован. Эти интерфейсы часто называют Iterable, Cacheable, Renderable и так далее, чтобы описать их поведение.

```php
<?php
    // Объявим интерфейс 'StorageInterface'
    interface StorageInterface
    {
        // Интерфейсы могут содержать константы
        const B = 'Константа интерфейса';
        
        public function getData(string $table): string;
    }
    
    interface StorageNameInterface
    {
        public function getStorageName(): string;
    }
    
    class Db implements StorageInterface, StorageNameInterface
    {
        public function getData(string $table): string
        {
            return 'реализация выборки с б.д.';
        }
        
        public function getStorageName(): string
        {
            return 'db';
        }
    }
    
    class File implements StorageInterface
    {
        public function getData(string $table): string
        {
            return 'реализация выборки с файла';
        }
    }
    
    
    function printData(StorageInterface $storage)
    {
        var_dump($storage->getData('test'));
    }
    
    printData(new File());
    printData(new Db()); 
?>
```

Наследование интерфейсов

```php 
<?php 
    interface A
    {
        public function foo();
    }
    
    interface B
    {
        public function bar();
    }
    
    // Наследование интерфейсов
    interface C extends A
    {
        public function baz();
    }
    
    // Множественное наследование интерфейсов
    interface C extends A, B
    {
        public function baz();
    }
?>
```

## Трейты
PHP реализует метод для повторного использования кода под названием трейт (trait).

Трейт - это механизм обеспечения повторного использования кода в языках с поддержкой только одиночного наследования, таких как PHP. Трейт предназначен для уменьшения некоторых ограничений одиночного наследования, позволяя разработчику повторно использовать наборы методов свободно, в нескольких независимых классах и реализованных с использованием разных архитектур построения классов. Семантика комбинации трейтов и классов определена таким образом, чтобы снизить уровень сложности, а также избежать типичных проблем, связанных с множественным наследованием и смешиванием (mixins).

Трейт очень похож на класс, но предназначен для группирования функционала хорошо структурированным и последовательным образом. Невозможно создать самостоятельный экземпляр трейта. Это дополнение к обычному наследованию и позволяет сделать горизонтальную композицию поведения, то есть применение членов класса без необходимости наследования.

### Использование трейтов
```php
<?php
    class Base {
        public function sayHello() {
            echo 'Hello ';
        }
    }
    
    trait SayWorld {
        public function sayHello() {
            parent::sayHello();
            echo 'World!';
        }
    }
    
    class MyHelloWorld extends Base {
        use SayWorld;
    }
    
    class MyHelloWorld2 extends Base {
        use SayWorld;
        
        public function sayHello() {
            echo 'Hello from MyHelloWorld2';
        }
    }
    
    //Порядок приоритета следующий: члены из текущего класса переопределяют методы в трейте, которые в свою очередь переопределяют унаследованные методы.
    (new MyHelloWorld())->sayHello();    
    (new MyHelloWorld2())->sayHello();
?>
```

### Пример использования нескольких трейтов
В класс можно добавить несколько трейтов, перечислив их в директиве use через запятую.
```php 
<?php 
    trait Hello {
        public function sayHello() {
            echo 'Hello ';
        }
    }
    
    trait World {
        public function sayWorld() {
            echo 'World';
        }
    }
    
    class MyHelloWorld {
        use Hello, World;
        public function sayExclamationMark() {
            echo '!';
        }
    }
    
    $o = new MyHelloWorld();
    $o->sayHello();
    $o->sayWorld();
    $o->sayExclamationMark();
?>
```

### Разрешение конфликтов
Если два трейта добавляют метод с одним и тем же именем, это приводит к фатальной ошибке в случае, если конфликт явно не разрешён.

Для разрешения конфликтов именования между трейтами, используемыми в одном и том же классе, необходимо использовать оператор insteadof для того, чтобы точно выбрать один из конфликтующих методов.

Так как предыдущий оператор позволяет только исключать методы, оператор as может быть использован для включения одного из конфликтующих методов под другим именем. Обратите внимание, что оператор as не переименовывает метод и не влияет на какой-либо другой метод.
```php 
<?php
    trait A {
        public function smallTalk() {
            echo 'a';
        }
        public function bigTalk() {
            echo 'A';
        }
    }
    
    trait B {
        public function smallTalk() {
            echo 'b';
        }
        public function bigTalk() {
            echo 'B';
        }
    }
    
    class Talker {
        use A, B {
            B::smallTalk insteadof A;
            A::bigTalk insteadof B;
        }
    }
    
    class Aliased_Talker {
        use A, B {
            B::smallTalk insteadof A;
            A::bigTalk insteadof B;
            B::bigTalk as talk;
        }
    }
?>
```

## Изменение видимости метода
Используя синтаксис оператора as, можно также изменить видимость метода в использующем трейт классе.
```php 
<?php
    trait HelloWorld {
        public function sayHello() {
            echo 'Hello World!';
        }
    }
    
    // Изменение видимости метода sayHello
    class MyClass1 {
        use HelloWorld { sayHello as protected; }
    }
    
    // Создание псевдонима метода с изменённой видимостью
    // видимость sayHello не изменилась
    class MyClass2 {
        use HelloWorld { sayHello as private myPrivateHello; }
    }
?>
```

### Трейты, состоящие из трейтов
Трейты могут использоваться как в классах, так и в других трейтах. Используя один или более трейтов в определении другого трейта, он может частично или полностью состоять из членов, определённых в этих трейтах.
```php 
<?php
    trait Hello {
        public function sayHello() {
            echo 'Hello ';
        }
    }
    
    trait World {
        public function sayWorld() {
            echo 'World!';
        }
    }
    
    trait HelloWorld {
        use Hello, World;
    }
    
    class MyHelloWorld {
        use HelloWorld;
    }
    
    $o = new MyHelloWorld();
    $o->sayHello();
    $o->sayWorld();
?>
```

### Абстрактные члены трейтов
Трейты поддерживают использование абстрактных методов для того, чтобы установить требования к использующему классу. Поддерживаются общедоступные, защищённые и закрытые методы. До PHP 8.0.0 поддерживались только общедоступные и защищённые абстрактные методы.
```php 
<?php
    trait Hello {
        public function sayHelloWorld() {
            echo 'Hello'.$this->getWorld();
        }
        abstract public function getWorld();
    }
    
    class MyHelloWorld {
        private $world;
        use Hello;
        public function getWorld() {
            return $this->world;
        }
        public function setWorld($val) {
            $this->world = $val;
        }
    }
?>
```

### Статические члены трейта

В трейтах можно определять статические переменные, статические методы и статические свойства.

```php
<?php
    trait Counter {
        public static $static = 'foo';
        
        public function inc() 
        {
            static $c = 0;
            $c = $c + 1;
            echo "$c\n";
        }
        
        public static function doSomething() 
        {
            return 'Что-либо делаем';
        }
    }
    
    class C1 {
        use Counter;
    }
    
    class C2 {
        use Counter;
    }
    
    $o = new C1(); $o->inc(); // echo 1
    $p = new C2(); $p->inc(); // echo 1
    
    echo C1::doSomething();
    echo C1::$static;
?>
```


### Определение свойств
Если трейт определяет свойство, то класс не может определить свойство с таким же именем, кроме случаев полного совпадения (те же начальное значение и модификатор видимости), иначе будет сгенерирована фатальная ошибка.
```php 
<?php
    trait PropertiesTrait {
        public $same = true;
        public $different = false;
    }
    
    class PropertiesExample {
        use PropertiesTrait;
        
        public $same = true;
        public $different = true; // Фатальная ошибка
    }
?>
```

## Ковариантность и контравариантность
Ковариантность позволяет дочернему методу возвращать более конкретный тип, чем тип возвращаемого значения его родительского метода. 
Контравариантность позволяет типу параметра в дочернем методе быть менее специфичным, чем в родительском.

```php 
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
    $kitty->speak();
    echo "\n";

    $doggy = (new DogShelter)->adopt("Бобик");
    $doggy->speak();
    
    
    $kitty = (new CatShelter)->adopt("Рыжик");
    $catFood = new AnimalFood();
    $kitty->eat($catFood);
    echo "\n";
    
    $doggy = (new DogShelter)->adopt("Бобик");
    $banana = new Food();
    $doggy->eat($banana);
?>
```