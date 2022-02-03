<?php

/**
 * Базовый интерфейс 
 */
interface Notifier
{
    public function sendMessage(): string;
}

/**
 * По-умолчанию - оправка уведомлений по электронной почте
 */
class EmailNotifier implements Notifier
{
    public function sendMessage(): string
    {

        return "Send by Email";
    }
}

/**
 * Базовый класс Декоратора 
 */
class Decorator implements Notifier
{
    /**
     * @var Notifier
     */
    protected $notifire;

    public function __construct(Notifier $notifire)
    {

        $this->notifire = $notifire;
    }

    public function sendMessage(): string
    {

        return $this->notifire->sendMessage();
    }
}

/**
 * Конкретный Декораторы для отправки SMS-уведомлений
 */
class SMSNotifier extends Decorator
{
    public function sendMessage(): string
    {

        return "Send by SMS and " . parent::sendMessage();
    }
}

/**
 * Конкретный Декораторы для отправки уведомлений через Telegram
 */
class TelegramNotifier extends Decorator
{
    public function sendMessage(): string
    {

        return "Send by Telegram and " . parent::sendMessage();
    }
}

/**
 * Конкретный Декораторы для отправки уведомлений через Telegram
 */
class WhatsAppNotifier extends Decorator
{
    public function sendMessage(): string
    {

        return "Send by WhatsApp and " . parent::sendMessage();
    }
}

/**
 * Клиентский код работает со всеми объектами, используя интерфейс Компонента.
 * Таким образом, он остаётся независимым от конкретных классов компонентов, с
 * которыми работает.
 */
function clientCode(Notifier $notifier)
{

    // ...

    echo "RESULT: " . $notifier->sendMessage();

    // ...
}


$simple = new EmailNotifier();
clientCode($simple);


$SMSDecorator = new SMSNotifier($simple);
$TelegramDecorator = new TelegramNotifier($SMSDecorator);
$WhatsAppDecorator = new WhatsAppNotifier($TelegramDecorator);
clientCode($WhatsAppDecorator);
