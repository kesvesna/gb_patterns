<?php

// Подсчитать практически количество шагов при поиске описанными в методичке алгоритмами.

// Количество элементов массива 10
/*

Linear Search :
Searching number = 397
Iteration counter = 1

Бинарный поиск :
Searching number = 397
Iteration counter = 3

Интерполяционный поиск :
Searching number = 397
Iteration counter = 1

Количество элементов массива 100

Linear Search :
Searching number = 1422
Iteration counter = 48

Бинарный поиск :
Searching number = 1422
Iteration counter = 6

Интерполяционный поиск :
Searching number = 1422
Iteration counter = 1

Количество элементов массива 1 000

Linear Search :
Searching number = 793
Iteration counter = 287

Бинарный поиск :
Searching number = 793
Iteration counter = 10

Интерполяционный поиск :
Searching number = 793
Iteration counter = 5

Количество элементов массива 10 000

Linear Search :
Searching number = 11170
Iteration counter = 3729

Бинарный поиск :
Searching number = 11170
Iteration counter = 14

Интерполяционный поиск :
Searching number = 11170
Iteration counter = 3

Количество элементов массива 100 000

Linear Search :
Searching number = 263815
Iteration counter = 87788

Бинарный поиск :
Searching number = 263815
Iteration counter = 15

Интерполяционный поиск :
Searching number = 263815
Iteration counter = 5


Количество элементов массива 1 000 000

Linear Search :
Searching number = 2773426
Iteration counter = 924422

Бинарный поиск :
Searching number = 2773426
Iteration counter = 16

Интерполяционный поиск :
Searching number = 2773426
Iteration counter = 4

*/

// Линейный поиск

function LinearSearch($myArray, $num)
{
    $count = count($myArray);
    $iteration_counter = 0;
    for ($i = 0; $i < $count; $i++) {
        $iteration_counter++;
        if ($myArray[$i] == $num)
        {
            echo 'Linear Search : ' . PHP_EOL;
            echo 'Searching number = ' . $num . PHP_EOL;
            echo 'Iteration counter = ' . $iteration_counter . PHP_EOL;
            return $i;
        }
        elseif ($myArray[$i] > $num) return null;
    }
    return null;
}

// Бинарный поиск

function binarySearch($myArray, $num)
{
//определяем границы массива
    $left = 0;
    $right = count($myArray) - 1;
    $iteration_counter = 0;
    while ($left <= $right) {
        $iteration_counter++;
//находим центральный элемент с округлением индекса в меньшую сторону
        $middle = floor(($right + $left) / 2);
//если центральный элемент и есть искомый
        if ($myArray[$middle] == $num) {
            echo 'Бинарный поиск : ' . PHP_EOL;
            echo 'Searching number = ' . $num . PHP_EOL;
            echo 'Iteration counter = ' . $iteration_counter . PHP_EOL;
            return $middle;
        } elseif ($myArray[$middle] > $num) {
//сдвигаем границы массива до диапазона от left до middle-1
            $right = $middle - 1;
        } elseif ($myArray[$middle] < $num) {
            $left = $middle + 1;
        }
    }
    return null;
}


// Интерполяционный поиск

function InterpolationSearch($myArray, $num)
{
    $start = 0;
    $last = count($myArray) - 1;
    $iteration_counter = 0;
    while (($start <= $last) && ($num >= $myArray[$start])
        && ($num <= $myArray[$last])) {
        $iteration_counter++;
        $pos = floor($start + (
                (($last - $start) / ($myArray[$last] - $myArray[$start]))
                * ($num - $myArray[$start])
            ));
        if ($myArray[$pos] == $num) {
            echo 'Интерполяционный поиск : ' . PHP_EOL;
            echo 'Searching number = ' . $num . PHP_EOL;
            echo 'Iteration counter = ' . $iteration_counter . PHP_EOL;
            return $pos;
        }
        if ($myArray[$pos] < $num) {
            $start = $pos + 1;
        } else {
            $last = $pos - 1;
        }
    }
    return null;
}

include 'randArray.php';

function getArr(): array
{
    return _randArray(1000000);
}

$arr = getArr();
$num = $arr[5]; // search random number from array
sort($arr);

$result = LinearSearch($arr, $num);

echo PHP_EOL;

$result = binarySearch($arr, $num);

echo PHP_EOL;

$result = InterpolationSearch($arr, $num);





