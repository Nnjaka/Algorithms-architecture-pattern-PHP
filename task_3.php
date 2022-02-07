<?php

/**
 * Создаем интерфейс команды
 */
interface Command
{
    public function execute(): void;
}

/**
 * Создаем команду для вставки текста
 */
class InsertText implements Command
{
    public $name = "Insert";

    public $text;

    public function __construct(string $text)
    {

        $this->text = $text;
    }

    public function execute(): void
    {
        echo "Insert text - " . $this->text . "\n";
    }
}

/**
 * Создаем команду для копирования текста
 */
class CopyText implements Command
{
    public $name = "Copy";

    public $text;

    public function __construct(string $text)
    {

        $this->text = $text;
    }

    public function execute(): void
    {
        echo "Copy text - " . $this->text . "\n";
    }
}

/**
 * Создаем команду для вырезания текста
 */
class CutText implements Command
{
    public $name = "Cut";

    public $text;

    public function __construct(string $text)
    {

        $this->text = $text;
    }

    public function execute(): void
    {

        echo "Cut text - " . $this->text . "\n";
    }
}

/**
 * Создаем класс для вызова определенной команды
 */
class TextEdit
{
    private $loggingData = [];

    public function handle(Command $command)
    {
        $command->execute();
        $loggingData[$command->name] = $command->text;
        echo "Command " . $command->name . " successfully completed.\n";
        var_dump($loggingData);
    }
}

/**
 * Клиентский код.
 */
$cutText = new CutText('aaa');
$copyText = new CopyText(('bbb'));
$insertText = new InsertText('ccc');

$textEdit = new TextEdit();
$textEdit->handle($cutText);
$textEdit->handle($copyText);
$textEdit->handle($insertText);
