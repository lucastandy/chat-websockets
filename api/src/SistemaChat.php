<?php

namespace Api\Websocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class SistemaChat implements MessageComponentInterface{
    
    protected $cliente;

    public function __construct(){
        // Iniciar o objetos que deve aramazernar os clientes conectados
        $this->cliente = new \SplObjectStorage;
    }

    // Abrir conexão para o novo cliente
    public function onOpen(ConnectionInterface $conn){
        // Adicionar o cliente na lista
        $this->cliente->attach($conn);

        //echo "Nova conexão: {$conn->resourceId}.\n\n";
    }

    // Enviar mensagens para os usuários conectados
    public function onMessage(ConnectionInterface $from, $msg){
        // Percorrer a lista de usuários conectados
        foreach($this->cliente as $cliente){

            // Não enviar a mensagem para o usuário que enviou a mensagem
            if($from !== $cliente){
                // Enviar a mensagens para os usuários
                $cliente->send($msg);
            }   
        }
        
        // Chamar a função salvar a mensagem no banco de dados
        $this->salvarMensagemNoBancoDeDados($msg);
        //echo "Usuário {$from->resourceId} enviou uma mensagem. \n\n";
    }

    // Desconectar o cliente do websocket
    public function onClose(ConnectionInterface $conn)
    {
        // Fechar a conexão e retirar o cliente da lista
        $this->cliente->detach($conn);

        //echo "Usuário {$conn->resourceId} desconectou. \n\n";
        
    }

    // Função que será chamada caso ocorra algum erro no websocket
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        // Fechar conexão do cliente
        $conn->close();

        //echo "Ocorreu um erro: {$e->getMessage()} \n\n";
        
    }

    // Função para salvar a mensagem no banco de dados
    private function salvarMensagemNoBancoDeDados($mansagem){
        
        // Recuperando a conexão com banco de dados
        $dbConnection = new DbConnection();
        $conn = $dbConnection->getConnection();

        // Salvar a mensagem no banco de dados
        $queryMensagem = "INSERT INTO mensagens (mensagem, usuario_id) VALUES (:mensagem, :usuario_id)";

        // Preparar a QUERY
        $addMensagem = $conn->prepare($queryMensagem);

        // Decodifica a string JSON em um array associativo
        $mensagemArray = json_decode($mansagem, true);
        $addMensagem->bindParam(':mensagem', $mensagemArray['mensagem']);
        $addMensagem->bindParam(':usuario_id', $mensagemArray['usuario_id']);

        $addMensagem->execute();
    }

}