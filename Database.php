<?php

class Database{
    public $pdo; //mainīgais ārpus metodem lai būt izmantojms visās metodēs
    
    // Konstruktors - izpildās vienu reizi, kad objekts izpildās 
    public function __construct($config){ // atsevišķa metode lai savienotos ar datu bāzi 
        // Data Source Name
        $dsn = "mysql:" . http_build_query($config,"",";");
        // PDO -PHP Data Object
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); //nodrošina assoc masīvu
    }
    public function query($sql){

        // 1. sagatavot vaicājumu (statement)
        $statement = $this->pdo->prepare($sql); // pievieno this lai saprastu kurš mainīgais tiek izmnatots
        // 2.Izpildit statement
        $statement->execute();
        return $statement;
    }
}
?>