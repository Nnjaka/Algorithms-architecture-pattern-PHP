<?php

class OracleFactory extends AbstractFactory
{
    public function getDBConnection(): DBConnection
    {
        return new OracleDBConnection();
    }

    public function getDBRecord(): DBRecord
    {
        return new OracleDBRecord();
    }

    public function getDBQueryBuilder(): DBQueryBuilder
    {
        return new OracleDBQueryBuilder();
    }
}
