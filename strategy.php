<?php

//Стратегия: есть интернет-магазин по продаже носков. Необходимо реализовать возможность
//оплаты различными способами (Qiwi, Яндекс, WebMoney). Разница лишь в обработке запроса
//на оплату и получение ответа от платёжной системы. В интерфейсе функции оплаты
//достаточно общей суммы товара и номера телефона.


interface IPayment
{
    public function payment(float $summ, string $phone);
}

class QiwiPayment implements IPayment
{
    public function payment(float $summ, string $phone)
    {
        echo 'Логика оплаты Qiwi и получение ответа';
    }
}

class YandexPayment implements IPayment
{
    public function payment(float $summ, string $phone)
    {
        echo 'Логика оплаты Yandex и получение ответа';
    }
}

class WebMoneyPayment implements IPayment
{
    public function payment(float $summ, string $phone)
    {
        echo 'Логика оплаты WebMoney и получение ответа';
    }
}

class Socks
{
    public function buy(IPayment $payment, float $summ, string $phone)
    {
        return $payment->payment($summ, $phone);
    }
}

function testStrategy(float $summ, string $phone)
{
    $socks = new Socks();

    // оплата по киви
    $purchase = $socks->buy(new QiwiPayment(), $summ, $phone);

    // оплата по яндексу
    $purchase = $socks->buy(new YandexPayment(), $summ, $phone);

    // оплата по вебмани
    $purchase = $socks->buy(new WebMoneyPayment(), $summ, $phone);
}

