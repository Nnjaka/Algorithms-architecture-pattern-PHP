<?php

class PostgreSQLFactory extends AbstractFactory
{
    public function getDBConnection(): DBConnection
    {
        return new PostgreSQLDBConnection();
    }

    public function getDBRecord(): DBRecord
    {
        return new PostgreSQLDBRecord();
    }

    public function getDBQueryBuilder(): DBQueryBuilder
    {
        return new PostgreSQLDBQueryBuilder();
    }
}
