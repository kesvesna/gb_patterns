<?php

// Реализовать удаление элемента массива по его значению. Обратите внимание на возможные
//дубликаты!

$arr = [6,9,5,67,21,2,5,5];

echo 'Before remove number ' . PHP_EOL;
print_r($arr);
echo PHP_EOL;

$remove_num = 5;
sort($arr);

for($i = 0; $i < count($arr); $i++)
{
    if($arr[$i] === $remove_num || $arr[$i+1] === $remove_num){
        unset($arr[$i]);
    }
}

echo 'After remove number ' . PHP_EOL;
print_r($arr);
echo PHP_EOL;