<?php
class Database
{
    function connect()
    {
        $DB = "cpanel";
        $USER = "root";
        $PASS = "";
        $HOST = "localhost";
        try {
            return new PDO(
                'mysql:host=' . $HOST . ";dbname=" . $DB,
                $USER,
                $PASS,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $ex) {
            die($ex);
            return null;
        }
    }
}
