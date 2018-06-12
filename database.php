<?php

class database{
    private $conn;
    function __construct(){
        $this -> conn = new mysqli('localhost', 'uy18clic_root', 'j2UN9{6yI37^', 'uy18clic_root_db');
    }
    public function run_query($sql_stmt){
        return $this -> conn -> query($sql_stmt);
    }
}

