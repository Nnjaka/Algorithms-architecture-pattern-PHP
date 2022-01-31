<?php

function clientCode(AbstractFactory $factory)
{
    $connection = $factory->getDBConnection();
    $record = $factory->getDBRecord();
    $queryBuilder = $factory->getDBQueryBuilder();
}

clientCode(new MySQLFactory());
clientCode(new PostgreSQLFactory());
clientCode(new OracleFactory());
