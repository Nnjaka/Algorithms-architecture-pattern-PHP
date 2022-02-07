<?php

/**
 * Создаем Контекст и описываем его методы
 */
class Context
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {

        $this->strategy = $strategy;
    }

    public function setStrategy(Strategy $strategy)
    {

        $this->strategy = $strategy;
    }

    public function implementationStrategy(): void
    {
        echo "Payment..\n";
        $result = $this->strategy->makePayment();
    }
}

/**
 * Создаем нтерфейс Стратегии с общим для всех частных стратегий методом
 */
interface Strategy
{
    public function makePayment(): void;
}

/**
 * Конкретные Стратегии оплаты
 */
class Qiwi implements Strategy
{
    public function makePayment(): void
    {
        echo "Payment via Qiwi";
    }
}

class Yandex implements Strategy
{
    public function makePayment(): void
    {
        echo "Payment via Yandex";
    }
}
class WebMoney implements Strategy
{
    public function makePayment(): void
    {
        echo "Payment via WebMoney";
    }
}

/**
 * Клиентский код
 */
$context = new Context(new Qiwi());
echo "Payment strategy via Qiwi.\n";
$context->implementationStrategy();

echo "\n";

echo "Change of payment strategy - via Yandex.\n";
$context->setStrategy(new Yandex());
$context->implementationStrategy();

echo "\n";

echo "Change of payment strategy - via WebMoney.\n";
$context->setStrategy(new WebMoney());
$context->implementationStrategy();
