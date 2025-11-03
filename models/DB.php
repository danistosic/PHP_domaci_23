<?php

class DB {

    public $connection;

    public function __construct() {
        $this->connection = mysqli_connect(hostname: "localhost", username: "root", password: "", database: "php23");
    }
}

