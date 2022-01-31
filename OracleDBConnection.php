<?php

class OracleDBConnection implements DBConnection
{
    public function getConnection()
    {
        return "DB Oracle connected";
    }
}
