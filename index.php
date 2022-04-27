<?php

class Application {

    protected $connection;
    protected $record;
    protected $builder;

    public function __construct(ServiceFactoryInterface $serviceFactory){
        $this->connection = $serviceFactory->createConnection();
        $this->record = $serviceFactory->createRecord();
        $this->builder = $serviceFactory->createBuilder();
    }

}

interface ConnectionInterface {};
interface RecordInterface {};
interface BuilderInterface {};

class MySQLConnection implements ConnectionInterface {}
class PostgreSQLConnection implements ConnectionInterface {}
class OracleConnection implements ConnectionInterface {}

class MySQLRecord implements RecordInterface {}
class PostgreSQLRecord implements RecordInterface {}
class OracleRecord implements RecordInterface {}

class MySQLBuilder implements BuilderInterface {}
class PostgreSQLBuilder implements BuilderInterface {}
class OracleBuilder implements BuilderInterface {}

interface ServiceFactoryInterface {

    public function createConnection(): ConnectionInterface;
    public function createRecord(): RecordInterface;
    public function createBuilder(): BuilderInterface;

}


class MySQLServiceFactory implements ServiceFactoryInterface {

    public function createConnection(): ConnectionInterface
    {
        return new MySQLConnection();
    }

    public function createRecord(): RecordInterface
    {
        return new MySQLRecord();
    }

    public function createBuilder(): BuilderInterface
    {
        return new MySQLBuilder();
    }
}

class PostgreSQLServiceFactory implements ServiceFactoryInterface {

    public function createConnection(): ConnectionInterface
    {
        return new PostgreSQLConnection();
    }

    public function createRecord(): RecordInterface
    {
        return new PostgreSQLRecord();
    }

    public function createBuilder(): BuilderInterface
    {
        return new PostgreSQLBuilder();
    }
}

class OracleServiceFactory implements ServiceFactoryInterface {

    public function createConnection(): ConnectionInterface
    {
        return new OracleConnection();
    }

    public function createRecord(): RecordInterface
    {
        return new OracleRecord();
    }

    public function createBuilder(): BuilderInterface
    {
        return new OracleBuilder();
    }
}

$applicationMySQL = new Application(new MySQLServiceFactory());
$applicationPostgreSQL = new Application(new PostgreSQLServiceFactory());
$applicationOracle = new Application(new OracleServiceFactory());

//var_dump($applicationMySQL);
//echo '<br>';
//var_dump($applicationPostgreSQL);
//echo '<br>';
//var_dump($applicationOracle);
