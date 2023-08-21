<?php

namespace Api\Websocket;

use PDO;
use PDOException;

class DbConnection
{

    /** @var string $host Recebe o host da constante HOST*/
    private $host = "localhost";
    
    /** @var string $host Recebe o usuário da constante USER*/
    private $user = "root";

    /** @var string $pass Recebe a senha da constante PASS*/
    private $pass = "";

    /** @var string $dbName Recebe a base de dados da constante DBNAME*/
    private $dbname = "celke_web_socket";

    /** @var int|string $port Recebe a porta da constante PORT*/
    private $port = "3306";

    /** @var object $connect Recebe a conexão com o banco de dados*/
    private $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não realizando a conexão corretamente, para o processamento da página e apresenta a mensagem de erro, com o e-mail de contato com o banco de dados
     * @return object retorna a conexão com o banco de dados
     */

     public function getConnection(){
        
        try{
            // Conexão sem a porta
            $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=".$this->dbname, $this->user, $this->pass);

            return $this->connect;
        }catch(PDOException $err){
            die("Erro: Conexão com banco de dados não realizado com sucesso!");
        }
     }
     
}

