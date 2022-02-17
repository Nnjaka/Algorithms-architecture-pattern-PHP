<?php
/* 1. Создать массив на миллион элементов и отсортировать его различными способами. Сравнить скорости.*/

//Создание массива
$arr = [];
for ($i = 0; $i < 10; $i++) {
    $arr[$i] = rand(1, 10);
}

//Сортировка пузырьком
function bubbleSort($arr)
{
    $stepsBubble = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $count = count($arr);
        for ($j = $i + 1; $j < $count; $j++) {
            if ($arr[$i] > $arr[$j]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $temp;
            }
            $stepsBubble++;
        }
    }
    echo 'Количество шагов при сортировке пузырьком - ' . $stepsBubble . PHP_EOL;
    return $arr;
}

//Шейкерная сортировка
function shakerSort($arr)
{
    $count = count($arr);
    $left = 0;
    $right = $count - 1;
    $stepsShaker = 0;
    do {
        for ($i = $left; $i < $right; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                list($arr[$i], $arr[$i + 1]) = array($arr[$i + 1], $arr[$i]);
            }
            $stepsShaker++;
        }
        $right -= 1;
        for ($i = $right; $i > $left; $i--) {
            if ($arr[$i] < $arr[$i - 1]) {
                list($arr[$i], $arr[$i - 1]) = array($arr[$i - 1], $arr[$i]);
            }
            $stepsShaker++;
        }
        $left += 1;
    } while ($left <= $right);
    echo 'Количество шагов при шейкерной сортировке - ' . $stepsShaker . PHP_EOL;
}


//Быстрая сортировка
$stepsQuick = 0;
function quickSort($arr)
{
    $count = count($arr);
    if ($count <= 1) {
        return $arr;
    }

    $firstValue = $arr[0];
    $leftArray = array();
    $rightArray = array();

    for ($i = 1; $i < $count; $i++) {
        if ($arr[$i] <= $firstValue) {
            $leftArray[] = $arr[$i];
        } else {
            $rightArray[] = $arr[$i];
        }
        global $stepsQuick;
        $stepsQuick++;
        echo 'Шаг - ' . $stepsQuick . PHP_EOL;
    }

    $leftArray = quickSort($leftArray);
    $rightArray = quickSort($rightArray);

    return array_merge($leftArray, array($firstValue), $rightArray);
}

//Проверка результатов
$start_time_bubble = microtime(true);
bubbleSort($arr);
$end_time_bubble = microtime(true);
echo 'Время выполнения при сортировке пузырьком - ' . $end_time_bubble - $start_time_bubble . PHP_EOL;

$start_time_shaker = microtime(true);
shakerSort($arr);
$end_time_shaker = microtime(true);
echo 'Время выполнения при шейкерной сортировке - ' . $end_time_shaker - $start_time_shaker . PHP_EOL;

$start_time_quick = microtime(true);
quickSort($arr);
$end_time_quick = microtime(true);
echo 'Время выполнения при быстрой сортировке - ' . $end_time_quick - $start_time_quick . PHP_EOL;


/* 2. Реализовать удаление элемента массива по его значению. Обратите внимание на возможные дубликаты!*/
$arr = [];
for ($i = 0; $i < 100; $i++) {
    $arr[$i] = rand(1, 10);
}

function removeArrayElement($arr, $num)
{
    foreach ($arr as $key => $value) {
        if ($value == $num) {
            unset($arr[$key]);
        }
    }
    return $arr;
}

//Проверка
var_dump(removeArrayElement($arr, 1));


/* 3. Подсчитать практически количество шагов при поиске описанными в методичке алгоритмами. */

// Данное задание реализовано в задании №1
