<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "celke_web_socket";
$port = 3306;

try{
    // Conexão sem a porta
    $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
}catch(PDOException $err){
    echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado ".$err->getMessage();
}