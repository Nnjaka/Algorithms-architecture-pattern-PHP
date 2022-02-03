<?php

/**
 * Внешняя библиотека
 */
class CircleAreaLib
{
    public function getCircleArea(int $diagonal)
    {
        $area = (M_PI * $diagonal ** 2) / 4;

        return $area;
    }
}

class SquareAreaLib
{
    public function getSquareArea(int $diagonal)
    {
        $area = ($diagonal ** 2) / 2;

        return $area;
    }
}

/**
 * Адаптер для расчета площади круга
 */
interface ICircle
{
    function circleArea(int $circumference);
}

class CircleAdapter implements ICircle
{
    private $adaptee;

    public function __construct(CircleAreaLib $adaptee)
    {

        $this->adaptee = $adaptee;
    }

    public function circleArea(int $circumference)
    {
        $diagonal = $circumference / pi();
        return $this->adaptee->getCircleArea($diagonal);
    }
}


/**
 * Адаптер для расчета плозади квадрата
 */
interface ISquare
{
    function squareArea(int $sideSquare);
}

class SquareAdapter implements ISquare
{
    private $adaptee;

    public function __construct(SquareAreaLib $adaptee)
    {

        $this->adaptee = $adaptee;
    }

    public function squareArea(int $sideSquare)
    {
        $diagonal = sqrt($sideSquare * 2);
        return $this->adaptee->getSquareArea($diagonal);
    }
}

/**
 * Клиентский код
 */
function clientCodeCircle(ICircle $circle, int $circumference)
{
    echo $circle->circleArea($circumference);
}

function clientCodeSquare(ISquare $square, int $sideSquare)
{
    echo $square->squareArea($sideSquare);
}


$circumference = 20;
$adaptee = new CircleAreaLib();
$adapter = new CircleAdapter($adaptee);
clientCodeCircle($adapter, $circumference);

$sideSquare = 20;
$adaptee = new SquareAreaLib();
$adapter = new SquareAdapter($adaptee);
clientCodeSquare($adapter, $sideSquare);
