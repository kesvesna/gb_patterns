////////
1. Антипаттерн Синглтон

В вводном курсе PHP использовалась нижеследующая функция для получения соединения с базой данных.
При вызове этой функции из разных контроллеров, получалось много соединений с одной и той же базой.

function getDb()
{

    $db = @mysqli_connect(HOST, USER, PASS, DB) or die("Could not connect: " . mysqli_connect_error());

    return $db;
}

Далее был использован следующий вариант, для контроля за количеством соединений,
своего рода синглтон.

function getDb()
{
    static $db = null;
        if (is_null($db)) {
            $db = @mysqli_connect(HOST, USER, PASS, DB) or die("Could not connect: " . mysqli_connect_error());
        }
    return $db;
}


Следующим шагом было исользование специально созданного для этой цели трэйта TSingletone.php
Он использовался в классе DbWithSingletone.php


2. Антипаттерн Coding by Exception

В папке controllers практически во всех контроллерах в методах есть проверки на ошибки try/catch,
можно было избежать этого просто добавив в файл index.php следующий код:

try {
    App::call()->run($config);
} catch (PDOException $e) {
    var_dump($e);
} catch (Exception $e) {
    echo $e->getMessage();
}
