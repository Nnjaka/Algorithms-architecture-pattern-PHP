<?php

class Main
{
    // массив объектов дерева
    var $arrayNode = array();

    // вычисление значения выражения
    public function calc()
    {
        foreach ($this->arrayNode as $node) {
            if (!$node->parent) {
                return $node->calc();
            }
        }
    }

    // реализация строительства дерева классов
    public function builder($exeption)
    {
        // массив объектов дерева
        $arrayNode = [];

        // составляем массив лексем
        function parse($exeption)
        {
            $arrayLexem = str_split($exeption);
            echo print_r($arrayLexem);

            return $arrayLexem;
        }

        // создание одного объекта (узла)
        function objBuilder($point)
        {
            static $arNumNode = array(
                "addition" => 1,
                "subtraction" => 1,
                "exponentiation" => 1,
                "multiplication" => 1,
                "division" => 1,
                "number" => 1,
                "constant" => 1
            );

            switch ($point) {

                case "+":
                    $name = "Plus" . $arNumNode["addition"];
                    $node = new Plus($name);
                    ++$arNumNode["addition"];
                    break;

                case "-":
                    $name = "Minus" . $arNumNode["subtraction"];
                    $node = new Minus($name);
                    ++$arNumNode["subtraction"];
                    break;

                case "*":
                    $name = "Multiply" . $arNumNode["multiplication"];
                    $node = new Multiply($name);
                    ++$arNumNode["multiplication"];
                    break;

                case "/":
                    $name = "Fission" . $arNumNode["division"];
                    $node = new Fission($name);
                    ++$arNumNode["division"];
                    break;

                case "^":
                    $name = "Exponent" . $arNumNode["exponentiation"];
                    $node = new Exponent($name);
                    ++$arNumNode["exponentiation"];
                    break;

                default:
                    $name = "Variable" . $arNumNode["number"];
                    $node = new Variable($name);
                    $node->var = $point;
                    ++$arNumNode["number"];
            }
            return $node;
        }

        // строительство тройки объектов дерева
        function trioBuilder($arrayLexem, $leftLexem, $rightLexem, $inflectionPoint, $leftInflectionPoint, $rightInflectionPoint, $topObject)
        {

            // вершина тройки
            if (!$topObject) {
                $topTrio = objBuilder($inflectionPoint);
                $topTrio->lec = $arrayLexem;
                var_dump($topTrio->lec);
            } else {
                $topTrio = $topObject;
            }

            // левая ветвь тройки
            $leftTrio = objBuilder($leftInflectionPoint);
            $leftTrio->lec = $leftLexem;

            // правая ветвь тройки
            $rightTrio = objBuilder($rightInflectionPoint);
            $rightTrio->lec = $rightLexem;

            // формирование тройки из объектов
            $topTrio->childrenLeft = $leftTrio;
            $topTrio->childrenRight = $rightTrio;
            $leftTrio->parent = $topTrio;
            $rightTrio->parent = $topTrio;
            if (!$topObject) {
                $trio = array($topTrio, $leftTrio, $rightTrio);
                return $trio;
            } else {
                $duo = array($leftTrio, $rightTrio);
                return $duo;
            }
        }

        // проверка на полное построение дерева
        function stopBuild($arrayNode)
        {
            foreach ($arrayNode as $node) {
                if ($node->lec[1] && !$node->childrenLeft && !$node->childrenRight) {
                    var_dump($node->lec[1]);
                    return FALSE;
                }
            }
            return TRUE;
        }

        // поиск вершины для следующей тройки
        function searchObj($arrayNode)
        {
            foreach ($arrayNode as $node) {
                if ($node->lec[1] && !$node->childrenLeft && !$node->childrenRight) {
                    return $node;
                }
            }
        }

        // определение точки перегиба выражения
        function inflectionPoint($lexems)
        {
            $infl = 0;
            $max = 0;
            static $br = 0;
            static $priority = [
                "+" => 3,
                "-" => 3,
                "*" => 2,
                "/" => 2,
                "^" => 1
            ];

            foreach ($lexems as $key => $value) {
                if (preg_match("/^[\d.]/", $value)) {
                    continue;
                }
                if ($value == "(") {
                    ++$br;
                    continue;
                }
                if ($value == ")") {
                    --$br;
                    continue;
                }
                if ($priority[$value] - 3 * $br >= $max) {
                    $max = $priority[$value] - 3 * $br;
                    $infl = $key;
                }
            }
            return $infl;
        }

        $arrayLexem = parse($exeption);

        // первая тройка дерева
        $positionPoint = inflectionPoint($arrayLexem);
        $inflectionPoint = $arrayLexem[$positionPoint];
        $leftLexem = array_slice($arrayLexem, 0, $positionPoint);
        if ($leftLexem[0] == "(" && $leftLexem[count($leftLexem) - 1] == ")") {
            array_shift($leftLexem);
            array_pop($leftLexem);
        }
        $rightLexem = array_slice($arrayLexem, $positionPoint + 1);
        if ($rightLexem[0] == "(" && $rightLexem[count($rightLexem) - 1] == ")") {
            array_shift($rightLexem);
            array_pop($rightLexem);
        }
        $leftPositionPoint = inflectionPoint($leftLexem);
        $leftInflectionPoint = $leftLexem[$leftPositionPoint];
        $rightPositionPoint = inflectionPoint($rightLexem);
        $rightInflectionPoint = $rightLexem[$rightPositionPoint];
        $trio = trioBuilder($arrayLexem, $leftLexem, $rightLexem, $inflectionPoint, $leftInflectionPoint, $rightInflectionPoint, NULL);
        $arrayNode = $trio;

        // все последующие тройки дерева
        while (!stopBuild($arrayNode)) {
            $topTrio = searchObj($arrayNode);
            $arrayLexem = $topTrio->lec;
            $positionPoint = inflectionPoint($arrayLexem);
            $leftLexem = array_slice($arrayLexem, 0, $positionPoint);
            if ($leftLexem[0] == "(" && $leftLexem[count($leftLexem) - 1] == ")") {
                array_shift($leftLexem);
                array_pop($leftLexem);
            }
            $rightLexem = array_slice($arrayLexem, $positionPoint + 1);
            if ($rightLexem[0] == "(" && $rightLexem[count($rightLexem) - 1] == ")") {
                array_shift($rightLexem);
                array_pop($rightLexem);
            }
            $leftPositionPoint = inflectionPoint($leftLexem);
            $leftInflectionPoint = $leftLexem[$leftPositionPoint];
            $rightPositionPoint = inflectionPoint($rightLexem);
            $rightInflectionPoint = $rightLexem[$rightPositionPoint];
            $duo = trioBuilder(NULL, $leftLexem, $rightLexem, NULL, $leftInflectionPoint, $rightInflectionPoint, $topTrio);
            $arNode = array_merge($arrayNode, $duo);
        }
        $this->arrayNode = $arrayNode;
    }
}

abstract class Term
{

    public $name;
    public $childrenLeft;
    public $childrenRight;
    public $parent;
    public $lec;
    public $const;
    public $var;

    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract function calc();
}

class Plus extends Term
{
    public function calc()
    {
        return $this->childrenLeft->calc() + $this->childrenRight->calc();
    }
}

class Minus extends Term
{
    public function calc()
    {
        return $this->childrenLeft->calc() - $this->childrenRight->calc();
    }
}

class Multiply extends Term
{
    public function calc()
    {
        return $this->childrenLeft->calc() * $this->childrenRight->calc();
    }
}

class Fission extends Term
{
    public function calc()
    {
        return $this->childrenLeft->calc() / $this->childrenRight->calc();
    }
}

class Exponent extends Term
{
    public function calc()
    {
        return pow($this->childrenLeft->calc(), $this->childrenRight->calc());
    }
}

class Variable extends Term
{
    public function calc()
    {
        return $this->var;
    }
}

// задаем исходное математическое выражение
$str = "(2+5)*6";

// строим дерево
$parse = new Main();
$parse->builder($str);

// рассчет выражения
echo $str . " = " . $parse->calc() . PHP_EOL;
