<?php

// Найти и указать в проекте Front Controller и расписать классы, которые с ним
// взаимодействуют


// В этом проекте FrontController файл index.php  в папке web
// Взаимодействует с классами:
// Request - создает экземпляр класса Request
// ContainerBuilder - создает контейнер для хранения данных
// Registry - добавляет контейнер в регистр
// Kernel - ядро приложения


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$request = Request::createFromGlobals();
$containerBuilder = new ContainerBuilder();

Framework\Registry::addContainer($containerBuilder);

$response = (new Kernel($containerBuilder))->handle($request);
$response->send();
