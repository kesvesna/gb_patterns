<?php

//Команда: вы — разработчик продукта Macrosoft World. Это текстовый редактор с
//возможностями копирования, вырезания и вставки текста (пока только это). Необходимо
//реализовать механизм по логированию этих операций и возможностью отмены и возврата
//действий. Т. е., в ходе работы программы вы открываете текстовый файл .txt, выделяете
//участок кода (два значения: начало и конец) и выбираете, что с этим кодом делать

interface ITextCopy
{
    public function copy(string $filename, int $textBegin, int $textEnd);
}

interface ITextCut
{
    public function cut(string $filename, int $textBegin, int $textEnd);
}

interface ITextInsert
{
    public function insert(string $filename, int $textBegin, int $textEnd);
}

interface ITextDelete
{
    public function delete(string $filename, int $textBegin, int $textEnd);
}

class TextCopy implements ITextCopy
{

    public function __construct(public string $filename, public int $textBegin, public int $textEnd)
    {
    }

    public function copy(string $filename, int $textBegin, int $textEnd)
    {
        echo 'Копируем текст';
    }

}

class TextCut implements ITextCut
{
    public function __construct(public string $filename, public int $textBegin, public int $textEnd)
    {
    }

    public function cut(string $filename, int $textBegin, int $textEnd)
    {
        echo 'Вырезаем текст';
    }

}

class TextInsert implements ITextInsert
{
    public function __construct(public string $filename, public int $textBegin, public int $textEnd)
    {
    }

    public function insert(string $filename, int $textBegin, int $textEnd)
    {
        echo 'Вставляем текст';
    }

}

class TextDelete implements ITextDelete
{
    public function __construct(public string $filename, public int $textBegin, public int $textEnd)
    {
    }

    public function delete(string $filename, int $textBegin, int $textEnd)
    {
        echo 'Удаляем текст';
    }

}

interface ICommand
{
    public function execute();
    public function undo();
    public function redo();
}

class TextCopyDistributor implements ICommand
{
    private $textCopy;

    public function __construct(ITextCopy $textCopy)
    {
        $this->textCopy = $textCopy;
    }
    public function execute()
    {
        echo 'Некоторая бизнес-логика';
        $this->textCopy->copy($this->textCopy->filename, $this->textCopy->textBegin, $this->textCopy->textEnd);
    }

    public function undo()
    {

    }

    public function redo()
    {

    }

}

class TextCutDistributor implements ICommand
{
    private $textCut;

    public function __construct(ITextCut $textCut)
    {
        $this->textCut = $textCut;
    }
    public function execute()
    {
        echo 'Некоторая бизнес-логика';
        $this->textCut->cut($this->textCut->filename, $this->textCut->textBegin, $this->textCut->textEnd);
    }

    public function undo()
    {

    }

    public function redo()
    {

    }

}

class TextInsertDistributor implements ICommand
{
    private $textInsert;

    public function __construct(ITextInsert $textInsert)
    {
        $this->textInsert = $textInsert;
    }
    public function execute()
    {
        echo 'Некоторая бизнес-логика';
        $this->textInsert->insert($this->textInsert->filename, $this->textInsert->textBegin, $this->textInsert->textEnd);
    }

    public function undo()
    {

    }

    public function redo()
    {

    }

}

class TextDeleteDistributor implements ICommand
{
    private $textDelete;

    public function __construct(ITextDelete $textDelete)
    {
        $this->textDelete = $textDelete;
    }
    public function execute()
    {
        echo 'Некоторая бизнес-логика';
        $this->textDelete->delete($this->textDelete->filename, $this->textDelete->textBegin, $this->textDelete->textEnd);
    }

    public function undo()
    {

    }

    public function redo()
    {

    }

}

interface ILog
{
    public function add(ICommand $command);

    public function remove(ICommand $command);
}

class Log implements ILog
{

    public function __construct(private string $filename)
    {

    }

    public function add(ICommand $command)
    {

    }

    public function remove(ICommand $command)
    {

    }
}


class RemoteControl
{
    public function submit(ICommand $command, ILog $log)
    {
        echo 'Некоторая бизнес-логика';
        $command->execute();
        $log->add($command);
        echo 'Некоторая бизнес-логика';
    }

    public function undo(ICommand $command, ILog $log)
    {
        echo 'Некоторая бизнес-логика';
        $command->execute();
        $log->remove($command);
        echo 'Некоторая бизнес-логика';
    }

    public function redo(ICommand $command, ILog $log)
    {
        echo 'Некоторая бизнес-логика';
        $command->execute();
        $log->add($command);
        echo 'Некоторая бизнес-логика';
    }

}

function testCommand()
{
    $textCopy = new TextCopy('textFile.txt', 40000, 40005);
    $copyDistributor = new TextCopyDistributor($textCopy);

    $textCut = new TextCut('textFile.txt', 32000, 32008);
    $cutDistributor = new TextCutDistributor($textCut);

    $textInsert = new TextInsert('textFile.txt', 31000, 31012);
    $insertDistributor = new TextInsertDistributor($textInsert);

    $textDelete = new TextDelete('textFile.txt', 31000, 31012);
    $deleteDistributor = new TextDeleteDistributor($textDelete);

    $log = new Log('logFile.txt');
    $remote = new RemoteControl();

    $remote->submit($copyDistributor, $log);
    $remote->redo($copyDistributor, $log);
    $remote->undo($copyDistributor, $log);
    $remote->submit($cutDistributor, $log);
    $remote->submit($insertDistributor, $log);
    $remote->submit($deleteDistributor, $log);
    $remote->undo($deleteDistributor, $log);
}
