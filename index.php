<?php


//Реализовать на PHP пример Декоратора, позволяющий отправлять уведомления
//несколькими различными способами.


interface ISender
{
    public function sender(): string;
}

class NoSender implements ISender
{
    private $text;
    public function __construct(string $text)
    {
        $this->text = $text;
    }
    public function sender(): string
    {
        return $this->text;
    }
}

abstract class Decorator implements ISender
{
    protected $content = null;
    public function __construct(ISender $content)
    {
        $this->content = $content;
    }
}

class SmsSender extends Decorator
{
    public function sender(): string
    {
        $sms = $this->content->sender();
        return $sms;
    }
}

class EmailSender extends Decorator
{
    public function sender(): string
    {
        $email = $this->content->sender();
        return $email;
    }
}

class CnSender extends Decorator
{
    public function sender(): string
    {
        $cn = $this->content->sender();
        return $cn;
    }
}

function testDecorator(string $text)
{
    $sender =
        new CnSender(
            new SmsSender(
                new EmailSender(
                    new NoSender($text)
                )
            )
        );
    $sender->sender();
}

testDecorator('Test text');


//=====================================================================

//  Реализовать паттерн Адаптер для связи внешней библиотеки (классы SquareAreaLib и
//  CircleAreaLib) вычисления площади квадрата (getSquareArea) и площади круга
//  (getCircleArea) с интерфейсами ISquare и ICircle имеющегося кода. Примеры классов даны
//  ниже. Причём во внешней библиотеке используются для расчётов формулы нахождения через
//  диагонали фигур, а в интерфейсах квадрата и круга — формулы, принимающие значения
//  одной стороны и длины окружности соответственно.

class SquareAreaLib
{
    public function getSquareArea(int $diagonal)
    {
        $area = ($diagonal**2)/2;
        return $area;
    }
}
class CircleAreaLib
{
    public function getCircleArea(int $diagonal)
    {
        $area = (M_PI * $diagonal**2)/4;
        return $area;
    }
}

interface ISquare
{
    function squareArea(int $sideSquare);
}

interface ICircle
{
    function circleArea(int $circumference);
}

class AreaAdaptor implements ICircle, ISquare
{
    protected $squareArea;
    protected $circleArea;

    function __construct()
    {
        $this->circleArea = new CircleAreaLib();
        $this->squareArea = new SquareAreaLib();
    }

    function squareArea(int $sideSquare)
    {
        return $this->squareArea->getSquareArea(sqrt(2) * $sideSquare);
    }

    function circleArea(int $circumference)
    {
        return $this->circleArea->getCircleArea($circumference/M_PI);
    }
}

$areaAdaptor = new AreaAdaptor();
$squareArea = $areaAdaptor->squareArea(5);
$circleArea = $areaAdaptor->circleArea(20);

echo "Square area = " . $squareArea . '<br>';
echo "Circle area = " . $circleArea;


