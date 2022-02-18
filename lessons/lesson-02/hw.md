- Создать в репозитории дерикторию lesson-01
- Код каждого задания должен храниться в своём файле. Пример: task-1.php 
- Задания можно выполнять прямо на [codewars](https://www.codewars.com) так как там уже реализованы тесты
- После реализации перенести код в репозиторий

## [Задание №1 - Clock](https://www.codewars.com/kata/55f9bca8ecaa9eac7100004a/train/php)
Часы показывают h часов, m минут и s секунд после полуночи.
Ваша задача — написать функцию, которая возвращает время с полуночи в миллисекундах.

``` 
h = 0
m = 1
s = 1

result = 61000
```

## [Задание №2 - Counting Duplicates](https://www.codewars.com/kata/54bf1c2cd5b56cc47f0007a1/train/php)
Напишите функцию, которая будет возвращать количество различных буквенных символов и цифр, не зависящих от регистра,  встречаются во входной строке более одного раза. Можно предположить, что входная строка содержит только буквы (как прописные, так и строчные) и числовые цифры.

```
"abcde" -> 0 # no characters repeats more than once
"aabbcde" -> 2 # 'a' and 'b'
"aabBcde" -> 2 # 'a' occurs twice and 'b' twice (`b` and `B`)
"indivisibility" -> 1 # 'i' occurs six times
"Indivisibilities" -> 2 # 'i' occurs seven times and 's' occurs twice
"aA11" -> 2 # 'a' and '1'
"ABBA" -> 2 # 'A' and 'B' each occur twice
```

## [Задание №3 - Create Phone Number](https://www.codewars.com/kata/525f50e3b73515a6db000b83/train/php)
Напишите функцию, которая принимает массив из 10 целых чисел (от 0 до 9), которая возвращает строку этих чисел в виде номера телефона.
```
createPhoneNumber([1,2,3,4,5,6,7,8,9,0]); // => returns "(123) 456-7890"
```

Возвращаемый формат должен быть правильным, чтобы выполнить эту задачу. Не забудьте пробел после закрывающей скобки!


## [Задание №4 - Count of languages](https://www.codewars.com/kata/5828713ed04efde70e000346/train/php)

Вам будет предоставлен ассоциативные массивы, представляющий данные о разработчиках, которые подписались на участие в следующей встрече программистов, которую вы организуете.
Ваша задача — вернуть объект (ассоциативный массив в PHP, таблицу в COBOL), который включает количество языков программирования, представленных на встрече.
Например, учитывая следующий входной массив:

```php
<?php 
    $list1 = [
      [
        "first_name" => "Noah",
        "last_name" => "M.",
        "country" => "Switzerland",
        "continent" => "Europe",
        "age" => 19,
        "language" => "C"
      ],
      [
        "first_name" => "Anna",
        "last_name" => "R.",
        "country" => "Liechtenstein",
        "continent" => "Europe",
        "age" => 52,
        "language" => "JavaScript"
      ],
      [
        "first_name" => "Ramon",
        "last_name" => "R.",
        "country" => "Paraguay",
        "continent" => "Americas",
        "age" => 29,
        "language" => "Ruby"
      ],
      [
        "first_name" => "George",
        "last_name" => "B.",
        "country" => "England",
        "continent" => "Europe",
        "age" => 81,
        "language" => "C"
      ]
    ];
?>
```

Ваша функция должна возвращать следующий ассоциативный массив:
```php
<?php 
    [
        "C" => 2,
        "JavaScript" => 1,
        "Ruby" => 1
    ]
?>
```

## [Задание №5 - Who likes it?](https://www.codewars.com/kata/5266876b8f4bf2da9b000362/train/php)
Вы, наверное, знаете систему «лайков» из Facebook и других страниц. Люди могут «лайкать» сообщения в блогах, изображения или другие элементы. Мы хотим создать текст, который должен отображаться рядом с таким элементом.

Реализуйте функцию, которая принимает массив, содержащий имена людей, которым понравился элемент. Он должен возвращать отображаемый текст, как показано в примерах:

```
[]                                -->  "no one likes this"
["Peter"]                         -->  "Peter likes this"
["Jacob", "Alex"]                 -->  "Jacob and Alex like this"
["Max", "John", "Mark"]           -->  "Max, John and Mark like this"
["Alex", "Jacob", "Mark", "Max"]  -->  "Alex, Jacob and 2 others like this"
```
Примечание: Для 4 и более имен число в строке «и еще 2» просто увеличивается.