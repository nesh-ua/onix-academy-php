# ООП (Часть 1).

## Классы и объекты

```php 
<?php
    // определяем класс
    class SimpleClass
    {
        // объявление свойства
        public string $var = 'значение по умолчанию';
    
        // объявление метода
        public function displayVar(): void
        {
            echo $this->var;
        }
    }
    
    // создаём объект класса
    $object = new SimpleClass();
    
    // доступ к свойству
    var_dump($object->var);
    // вызов метода
    $object->displayVar();
    
    // Использование анонимного класса
    $object2 = new class {
        public function log(string $msg)
        {
            echo $msg;
        }
    };
    
    
    // проверяем является ли объект объектом класса SimpleClass
    var_dump($object instanceof SimpleClass); // bool(true)
    
    // Доступ к свойствам/методам только что созданного объекта
    (new SimpleClass())->displayVar();
    
    
    // полное имя класса ClassName
    var_dump(SimpleClass::class);
    // полное имя класса ClassName
    var_dump($object::class);
    
    //Методы и свойства Nullsafe. Начиная с PHP 8.0.0
    $object?->var // если $object будет null то и var будет null. Если написать через -> будет ошибка
?>
```
[Функции работы с классами и объектами](https://www.php.net/manual/ru/ref.classobj.php) 

## Свойства, Константы, Методы класса

```php 
<?php
    class SimpleClass
    {
        // объявление свойства
        public string $var = 'значение по умолчанию';
    
        //Начиная с PHP 8.1.0, предотвращает изменение свойства после инициализации.
        //у readonly-свойства Test::$prop не может быть значения по умолчанию
        public readonly string $var2;
    
        // Объявление и использование константы
        public const CONSTANT = 'значение константы';
        private const CONSTANT2 = 'значение константы2';
    
    
        /**
         * @param string $var2
         */
        public function __construct(string $var2) {
            // Правильная инициализация.
            $this->var2 = $var2;
        }
    
        // объявление метода
        public function displayVar(): void
        {
            //обращение к свойствам
            echo $this->var;
        }
    
        function showConstant() {
            echo  self::CONSTANT . "\n";
        }
    
        function showConstant2() {
            echo  self::CONSTANT2 . "\n";
        }
    }
    
    $object = new SimpleClass('test');
    // меняем значения свойства
    $object->var = 'новое значение по умолчанию';
    echo $object->var . "\n";
    
    // приведёт к исключению Error
    //$object->var2 = 'новое значение по умолчанию';
    
    // выведет константу через метод класса
    $object->showConstant();
    // выведет то же самое. Вам не нужно создавать объект класса что б использовать константы
    echo SimpleClass::CONSTANT . "\n";
    // но если сильно хочется то можно :)
    echo $object::CONSTANT . "\n";
    
    $object->showConstant2();
    // вызовет ошибку, так как нет доступа
    // echo $object::CONSTANT2 . "\n";
?>
```

## Ключевое слово Static
Объявление свойств и методов класса статическими позволяет обращаться к ним без создания экземпляра класса. К ним также можно получить доступ статически в созданном экземпляре объекта класса.

```php 
<?php
    class Foo {
        public static $my_static = 'foo';
        public $not_static = '1';

        public static function aStaticMethod() {
            echo self::$my_static . "\n";
        }

        public function notStaticMethod() {
            echo self::$my_static . "\n";
        }
    }

    Foo::aStaticMethod();
    echo Foo::$my_static . "\n";
    // приведёт к ошибке
    //Foo::$not_static;
    //Foo::notStaticMethod();

    (new Foo())->notStaticMethod();
```

## Объекты и ссылки

```php 
<?php
    class A
    {
        public $foo = 1;
    }

    $a = new A;
    $b = $a;     // $a и $b - копии одного идентификатора
    // ($a) = ($b) = <id>
    $b->foo = 2;
    echo $a->foo."\n"; // выведет 2


    $c = new A;
    $d = &$c;    // $c и $d - ссылки
    // ($c,$d) = <id>

    $d->foo = 2;
    echo $c->foo."\n"; // выведет 2


    $e = new A;

    function foo($obj) {
        // ($obj) = ($e) = <id>
        $obj->foo = 2;
    }

    foo($e);
    echo $e->foo."\n"; // выведет 2

?>
```

## Магические методы
Магические методы - это специальные методы, которые переопределяют действие PHP по умолчанию, когда над объектом выполняются определённые действия.

Следующие названия методов считаются магическими: 

### [__construct()](https://www.php.net/manual/ru/language.oop5.decon.php#object.construct), [__destruct()](https://www.php.net/manual/ru/language.oop5.decon.php#object.destruct),

PHP позволяет объявлять методы-конструкторы. Классы, в которых объявлен метод-конструктор, будут вызывать этот метод при каждом создании нового объекта, так что это может оказаться полезным, например, для инициализации какого-либо состояния объекта перед его использованием.

Если у класса нет конструктора, или его конструктор не имеет обязательных параметров, скобки после имени класса можно не писать.

PHP предоставляет концепцию деструктора, аналогичную с той, которая применяется в других ОО-языках, таких, как C++. Деструктор будет вызван при освобождении всех ссылок на определённый объект или при завершении скрипта (порядок выполнения деструкторов не гарантируется).

```php 
<?php
    class Point
    {
        public int $x;
        public int $y;

        /**
         * @param int $x
         * @param int $y
         */
        public function __construct(int $x, int $y = 0)
        {
            $this->x = $x;
            $this->y = $y;
        }
    }

    // Использование определения свойств в конструкторе
    class Point2
    {
        /**
         * @param int $x
         * @param int $y
         */
        public function __construct(public int $x, public int $y = 0)
        {
        }
    }

    // создаём объект класса
    $p1 = new Point(4, 5); // второй параметр не обязательный, так как есть занчени по умолчанию
    // Вызываем с именованными параметрами (начиная с PHP 8.0):
    $p3 = new Point(y: 5, x: 4);

    // Использование статических методов для создания объектов
    class Product
    {
        private function __construct(public ?int $id = null, public ?string $name = null)
        {
        }

        public static function fromData(array $data): static
        {
            return new static(...$data);
        }
    }

    // создать объект такого класса можно только через метод Product::fromData()
    $p2 = Product::fromData([1, 'name']);
    echo $p2->name . "\n"; // выведет name

    // деструктор

    class MyDestructableClass
    {
        public function __construct() {
            print "Конструктор\n";
        }

        public function __destruct() {
            print "Уничтожается " . __CLASS__  . "\n";
        }
    }

    $obj = new MyDestructableClass();
```

### [__sleep()](https://www.php.net/manual/ru/language.oop5.magic.php#object.sleep), [__wakeup()](https://www.php.net/manual/ru/language.oop5.magic.php#object.wakeup)
Функция serialize() проверяет, присутствует ли в классе метод с магическим именем __sleep(). Если это так, то этот метод выполняется до любой операции сериализации. Он может очистить объект и должен возвращать массив с именами всех переменных этого объекта, которые должны быть сериализованы. Если метод ничего не возвращает, то сериализуется null и выдаётся предупреждение E_NOTICE.

С другой стороны, функция unserialize() проверяет наличие метода с магическим именем __wakeup(). Если она имеется, эта функция может восстанавливать любые ресурсы, которые может иметь объект.
Функции __sleep()/wakeup() работают только если в классе нет функции __serialize()/__unserialize()

```php 
<?php 
    class Sum
    {
        private int $sum = 0;
    
        public function __construct(
            private int $test,
            private int $test2,
            private int $test3 = 3
        ) {
            $this->calc();
        }
    
        private function calc()
        {
            $this->sum = $this->test + $this->test2 + $this->test3;
        }
    
    
        public function __sleep()
        {
            echo "__sleep\n";
            return ['test', 'test2', 'test3'];
        }
    
        public function __wakeup()
        {
            echo "__wakeup\n";
            $this->calc();
        }
    }
    
    $object = new Sum(1, 2, 3);
    $serialized = serialize($object);
    echo $serialized . "\n"; 
    $unserialized = unserialize($serialized);
    var_dump($unserialized);
?>
```

### [__serialize()](https://www.php.net/manual/ru/language.oop5.magic.php#object.serialize), [__unserialize()](https://www.php.net/manual/ru/language.oop5.magic.php#object.unserialize)
Функция serialize() проверяет, есть ли в классе функция с магическим именем __serialize(). Если да, функция выполняется перед любой сериализацией. Она должна создать и вернуть ассоциативный массив пар ключ/значение, которые представляют сериализованную форму объекта. Если массив не возвращён, будет выдано TypeError.

И наоборот, unserialize() проверяет наличие магической функции __unserialize(). Если функция присутствует, ей будет передан восстановленный массив, который был возвращён из __serialize(). Затем он может восстановить свойства объекта из этого массива соответствующим образом.
```php 
<?php 
    class Sum
    {
        private int $sum = 0;
    
        public function __construct(
            private int $test,
            private int $test2,
            private int $test3 = 3
        ) {
            $this->calc();
        }
    
        private function calc()
        {
            $this->sum = $this->test + $this->test2 + $this->test3;
        }
    
    
        public function __serialize(): array
        {
            echo "__serialize\n";
            return [
                'test' => $this->test,
                'test2' => $this->test2,
                'test3' => $this->test3
            ];
        }
    
        public function __unserialize(array $data): void
        {
            echo "__unserialize\n";
            $this->test = $data['test'];
            $this->test2 = $data['test2'];
            $this->test3 = $data['test3'];
    
            $this->calc();
        }
    }
    
    $object = new Sum(1, 2, 3);
    $serialized = serialize($object);
    echo $serialized . "\n";
    $unserialized = unserialize($serialized);
    var_dump($unserialized);
?>
```

### [__call()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.call), [__callStatic()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.callstatic),
__call() запускается при вызове недоступных методов в контексте объект.
__callStatic() запускается при вызове недоступных методов в статическом контексте.
```php 
<?php 
    class MethodTest 
    {
        public function __call($name, $arguments) {
            // Замечание: значение $name регистрозависимо.
            echo "Вызов метода '$name' "
                . implode(', ', $arguments). "\n";
        }
    
        public static function __callStatic($name, $arguments) {
            // Замечание: значение $name регистрозависимо.
            echo "Вызов статического метода '$name' "
                . implode(', ', $arguments). "\n";
        }
    }

    MethodTest::test();
    (new MethodTest)->test();
?>
```
### [__get()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.get), [__set()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.set), [__isset()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.isset), [__unset()](https://www.php.net/manual/ru/language.oop5.overloading.php#object.unset)
Метод __set() будет выполнен при записи данных в недоступные (защищённые или приватные) или несуществующие свойства.

Метод __get() будет выполнен при чтении данных из недоступных (защищённых или приватных) или несуществующих свойств.

Метод __isset() будет выполнен при использовании isset() или empty() на недоступных (защищённых или приватных) или несуществующих свойствах.

Метод __unset() будет выполнен при вызове unset() на недоступном (защищённом или приватном) или несуществующем свойстве.

```php
<?php
    class Test
    {
        private $data = [];
    
        public function __get($name)
        {
            echo "__get called \n";
            return $this->data[$name] ?? null;
        }
    
        public function __set($name, $value)
        {
            echo "__set called \n";
            $this->data[$name] = $value;
        }
    
        public function __isset($name)
        {
            echo "__isset called \n";
            return isset($this->data[$name]);
        }
    
        public function __unset($name)
        {
            echo "__unset called \n";
            unset($this->data[$name]);
        }
    
    
        public function printData() {
            var_dump($this->data);
        }
    }
    
    $object = new Test();
    $object->test = 'test';
    $object->printData();
    echo $object->test . "\n";
    if (isset($object->test)) {
        unset($object->test);
    }
    $object->printData();
?>
```
### [__invoke()](https://www.php.net/manual/ru/language.oop5.magic.php#object.invoke),
Метод __invoke() вызывается, когда скрипт пытается выполнить объект как функцию.

```php 
<?php
    class CallableClass
    {
        public function __invoke($x)
        {
            var_dump($x);
        }
    }
    $obj = new CallableClass;
    $obj(5);
    var_dump(is_callable($obj));
?>
```
### [__toString()](https://www.php.net/manual/ru/language.oop5.magic.php#object.tostring),
Метод __toString() позволяет классу решать, как он должен реагировать при преобразовании в строку. Например, что вывести при выполнении echo $obj;.
```php 
<?php
    // Объявление простого класса
    class TestClass
    {
        public $foo;
    
        public function __construct($foo)
        {
            $this->foo = $foo;
        }
    
        public function __toString()
        {
            return $this->foo;
        }
    }
    
    $class = new TestClass('Привет');
    echo $class;
?>
```

### [__clone()](https://www.php.net/manual/ru/language.oop5.cloning.php#object.clone)

После завершения клонирования, если метод __clone() определён, то будет вызван метод __clone() вновь созданного объекта для возможного изменения всех необходимых свойств.

```php 
<?php
    class Test
    {
        public int $test;
    
        public function __construct() {
            $this->test = 1;
        }
    
        public function __clone() {
            $this->test = 2;
        }
    }
    
    $obj = new Test();
    $obj2 = clone $obj;
    echo $obj->test . "\n"; // выведет 1
    echo $obj2->test . "\n"; // выведет 2
?>
```

### [__debugInfo()](https://www.php.net/manual/ru/language.oop5.magic.php#object.debuginfo)
Этот метод вызывается функцией var_dump(), когда необходимо вывести список свойств объекта. Если этот метод не определён, тогда будут выведены все свойства объекта c модификаторами public, protected и private.

```php 
<?php 
    class C {
        private $prop;
    
        public function __construct($val) {
            $this->prop = $val;
        }
    
        public function __debugInfo() {
            return [
                'propSquared' => $this->prop ** 2,
            ];
        }
    }
    
    var_dump(new C(42));
?>
```

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


## Автоматическая загрузка классов

Большинство разработчиков объектно-ориентированных приложений используют такое соглашение именования файлов, в котором каждый класс хранится в отдельно созданном для него файле. Одна из самых больших неприятностей - необходимость писать в начале каждого скрипта длинный список подгружаемых файлов (по одному для каждого класса).

Функция spl_autoload_register() позволяет зарегистрировать необходимое количество автозагрузчиков для автоматической загрузки классов и интерфейсов, если они в настоящее время не определены. Регистрируя автозагрузчики, PHP получает последний шанс для интерпретатора загрузить класс прежде, чем он закончит выполнение скрипта с ошибкой.

```php 
<?php

    spl_autoload_register(function ($className) {
        $file = __DIR__ . '\\' . $className . '.php';
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        if (file_exists($file)) {
            include $file;
        }
    });
    
    (new MyClass())->test();
?>
```
