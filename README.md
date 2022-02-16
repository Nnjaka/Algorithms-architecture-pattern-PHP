Урок 8. Массивы и структуры данных. Оценка сложности алгоритма

1. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов.
2. Определить сложность следующих алгоритмов:
поиск элемента массива с известным индексом,
дублирование массива через foreach,
рекурсивная функция нахождения факториала числа. 
3. Определить сложность следующих алгоритмов. Сколько произойдет итераций? 
1) 
$n = 100; 
$array[]= [];
for ($i = 0; $i < $n; $i++) 
{
    for ($j = 1; $j < $n; $j *= 2) 
    {
        $array[$i][$j]= true;
    } 
}

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
4. * Простые делители числа 13195 — 5, 7, 13 и 29. Каков самый большой делитель числа 600851475143, являющийся простым числом?