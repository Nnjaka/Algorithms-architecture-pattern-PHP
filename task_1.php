<?php

use Subject as GlobalSubject;

/**
 * Объявляем издателя и прописываем у него методы, которые присоединяет, удаляет, а также уведомляет всех подписанных наблюдателей
 */
class Subject implements \SplSubject
{
    public $state;

    public $minWorkExperience;

    private $subscribers;

    public function __construct()
    {

        $this->subscribers = new \SplObjectStorage();
    }

    /**
     * Добавление наблюдателя
     */
    public function attach(\SplObserver $subscribers): void
    {

        echo "You are subscribed.\n";
        $this->subscribers->attach($subscribers);
    }

    /**
     * Удаление наблюдателя
     */
    public function detach(\SplObserver $subscribers): void
    {

        $this->subscribers->detach($subscribers);
        echo "You have been unsubscribed.\n";
    }

    /**
     * Уведомление наблюдателей
     */
    public function notify(): void
    {

        echo "Subject: Notifying subscribers\n";
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($this);
        }
    }

    /**
     * Бизнес логика: появление новой вакансии и уведомление наблюдателей
     */
    public function updateNoticeBoard($vacancy, $minWorkExperience): void
    {

        //echo "Notice board update.\n";
        $this->state = $vacancy;
        $this->minWorkExperience = $minWorkExperience;


        echo "New vacancy for {$this->state}, minimal work experience - {$this->minWorkExperience}\n";
        $this->notify();
    }
}

/**
 * Создаем класс PHP разработчика 
 */
class PHPDeveloper implements \SplObserver
{
    private $email;

    private $name;

    private $workExperience;

    public function __construct($email, $name, $workExperience)
    {
        $this->email = $email;
        $this->name = $name;
        $this->workExperience = $workExperience;
    }

    public function update(\SplSubject $subject): void
    {

        if ($subject->state == "PHP Developer" && $subject->minWorkExperience < $this->workExperience) {
            echo "Good day, " . $this->name . ". A new vacancy PHP Developer has been sent to your email - " . $this->email . " \n";
        }
    }
}

/**
 * Создаем класс Java разработчика 
 */
class JavaDeveloper implements \SplObserver
{
    public function __construct($email, $name, $workExperience)
    {
        $this->email = $email;
        $this->name = $name;
        $this->workExperience = $workExperience;
    }

    public function update(\SplSubject $subject): void
    {

        if ($subject->state === "Java Developer" && $subject->minWorkExperience < $this->workExperience) {
            echo "Good day, " . $this->name . ". A new vacancy Java Developer has been sent to your email - " . $this->email . " \n";
        }
    }
}

/**
 * Клиентский код.
 */
$subject = new Subject();
$developerPHP = new PHPDeveloper('11@ya.ru', 'Ivan', 5);
$subject->attach($developerPHP);

$developerJava = new JavaDeveloper('22@ya.ru', 'Oleg', 3);
$subject->attach($developerJava);

$subject->updateNoticeBoard("PHP Developer", 1);
$subject->updateNoticeBoard("Java Developer", 1);

$subject->detach($developerPHP);
$subject->updateNoticeBoard("PHP Developer", 1);
