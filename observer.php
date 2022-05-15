<?php

//Наблюдатель: есть сайт HandHunter.gb. На нем работники могут подыскать себе вакансию
//РНР-программиста. Необходимо реализовать классы искателей с их именем, почтой и стажем
//работы. Также реализовать возможность в любой момент встать на биржу вакансий
//(подписаться на уведомления), либо же, напротив, выйти из гонки за местом. Таким образом,
//как только появится новая вакансия программиста, все жаждущие автоматически получат
//уведомления на почту (можно реализовать условно).

function subscribe($user)
{

}

interface Observer
{
    public function handle();
}

class Subscriber implements Observer
{

    public function handle()
    {
        subscribe($user);
    }
}



class ApplicantManager
{
    /**
     * @var Observer[]
     */
    protected  array $observers = [];
    protected string $email;
    protected string $name;
    protected float $experience;

    public function checkNewVacancy($user)
    {
        $this->notify();
    }

    public function attachObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function detachObserver()
    {
        array_pop($this->observers);
    }

    protected function notify()
    {
        foreach($this->observers as $observer)
        {
            $observer->handle();
        }
    }

}

$manager = new ApplicantManager();
$manager->attachObserver(new Subscriber());