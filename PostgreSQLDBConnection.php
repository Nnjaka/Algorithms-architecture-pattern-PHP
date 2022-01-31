<?php

class PostgreSQLDBConnection implements DBConnection
{
    public function getConnection()
    {
        return "DB PostgreSQL connected";
    }
}
