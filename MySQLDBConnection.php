<?php

class MySQLDBConnection implements DBConnection
{
    public function getConnection()
    {
        return "DB MySQL connected";
    }
}
