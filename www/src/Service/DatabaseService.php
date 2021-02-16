<?php

namespace Service;

use mysqli;
use mysqli_result;

class DatabaseService
{

    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli(getenv('DB_SERVER'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));

        if ($this->connection->connect_error) {
            die('Error ' . $this->connection->connect_errno . ': ' . $this->connection->connect_error);
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    public function query($query)
    {
        $results = $this->connection->query($query);

        if ($results === true || (!empty($results) && ($results instanceof mysqli_result))) {
            return $results instanceof mysqli_result
                ? $results->fetch_all(MYSQLI_ASSOC)
                : true
            ;
        }

        return false;
    }
}
