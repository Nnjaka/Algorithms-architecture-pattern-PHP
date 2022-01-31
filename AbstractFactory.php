<?php

abstract class AbstractFactory
{
    abstract public function getDBConnection(): DBConnection;

    abstract public function getDBRecord(): DBRecord;

    abstract public function getDBQueryBuilder(): DBQueryBuilder;
}
