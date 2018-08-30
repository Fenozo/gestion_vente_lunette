<?php
namespace AppBundle\Engine;
use PDO;
class DB {
    private $host           = 'localhost';
    private $username       = 'root';
    private $password       = '';
    private $database_name  = 'database_name';
    private $db;

    public function __construct(
        $host     = null,
        $username = null,
        $password = null,
        $database_name = null
    )
    {
        if($host != null) {
            $this->host             =   $host;
            $this->username         =   $username;
            $this->password         =   $password;
            $this->database_name    =   $database_name;
        }
        try {
        $this->db = new PDO(
            'mysql:host='.$this->host.
            ';dbname='.$this->database_name,
            $this->username,
            $this->password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
        ));
        }   catch(\PDOException $e) {
            die('<h1 style="text-align:center;color:red;"> Impossible de se connecter à la base de données </h1>');
        }
    }

    public function query($sql,$data = array(), $one = false) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        $response =  $req->fetchAll();
        if($one == true) {
            $response = $response[0];
        } 
        return $response;
    }

}