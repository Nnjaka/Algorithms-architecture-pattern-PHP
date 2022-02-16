<?php

/* 1. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов.
*/

$path = dirname(__DIR__);
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);

foreach ($dir as $item) {
    $deep = ($dir->getDepth()) + 1;
    echo $deep . " " . $item . PHP_EOL;
}


/* 2. Определить сложность следующих алгоритмов:
- поиск элемента массива с известным индексом - O(1);
- дублирование массива через foreach - O(n);
- рекурсивная функция нахождения факториала числа - O(n).
*/


/*3. Определить сложность следующих алгоритмов. Сколько произойдет итераций? 
1) ``` 
$n = 100; 
$array[]= [];
for ($i = 0; $i < $n; $i++) 
{
    for ($j = 1; $j < $n; $j *= 2) 
    {
        $array[$i][$j]= true;
    } 
}

Cложность алгоритмa - O(n^2)
Количество итераций - 700 

2)
$n = 100;
$array[] = [];
for ($i = 0; $i < $n; $i += 2) 
{
    for ($j = $i; $j < $n; $j++) 
    {
        $array[$i][$j]= true;
    } 
}

Cложность алгоритмa - O(n^2)
Количество итераций - 2550 
*/


/*4. * Простые делители числа 13195 — 5, 7, 13 и 29. Каков самый большой делитель числа 600851475143, являющийся простым числом?*/
function getPrimeNumber($number)
{
    $i = 2;
    while ($i * $i < $number) {
        while ($number % $i == 0) {
            $number = $number / $i;
        }
        $i = $i + 1;
    }
    return $number;
}
echo getPrimeNumber(600851475143);
