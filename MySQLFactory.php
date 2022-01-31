<?php

class MySQLFactory extends AbstractFactory
{
    public function getDBConnection(): DBConnection
    {
        return new MySQLDBConnection();
    }

    public function getDBRecord(): DBRecord
    {
        return new MySQLDBRecord();
    }

    public function getDBQueryBuilder(): DBQueryBuilder
    {
        return new MySQLDBQueryBuilder();
    }
}
