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
        if ($results = $this->connection->query($query)) {
            return $results instanceof mysqli_result
                ?  $results->fetch_all(MYSQLI_ASSOC)
                : $results
            ;
        }

        return null;
    }
}
