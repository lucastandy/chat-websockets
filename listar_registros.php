<?php

// Incluir o arquivo com conexão com banco de dados
include_once './conexao.php';

// Quantidade de registros que deve ser retornado
$limit = 10;


// Iniciar a partir do registro
$offset = filter_input(INPUT_GET,"offset",FILTER_SANITIZE_NUMBER_INT);

// Recuperar os registros do banco de dados
$query_mensagens = "SELECT msg.id, msg.mensagem, msg.usuario_id, usr.nome FROM mensagens AS msg INNER JOIN usuarios AS usr ON usr.id = msg.usuario_id ORDER BY msg.id DESC LIMIT :limit OFFSET :offset";

// Preparando a QUERY recuperar as mensagens
$result_mensagens = $conn->prepare($query_mensagens);

// Substituir os links da QUERY pelos valores
$result_mensagens->bindParam(':limit',$limit,PDO::PARAM_INT);
$result_mensagens->bindParam(':offset',$offset,PDO::PARAM_INT);

// Executa a QUERY recuperar as mensagens
$result_mensagens->execute();

// Recuperar a quantidade de registros retornando do banco de dados
$qtd_mansagens = $result_mensagens->rowCount();

// Recuperar quantidade total de registros na tabela
$query_total_mensagens = "SELECT COUNT(id) AS total_registros FROM mensagens";

// Preparando a QUERY recuperar as mensagens
$result_total_mensagens = $conn->prepare($query_total_mensagens);

// Executar a QUERY recuperar as mensagens
$result_total_mensagens->execute();

// Ler o total de registro
$row_total_mensagem = $result_total_mensagens->fetch(PDO::FETCH_ASSOC);

// Acessa o IF quando encontrar registro no banco de dados
if(($result_mensagens) and ($result_mensagens->rowCount() != 0)){
    // Variável responsável em receber os dados
    $dados = "";

    // Ler as mensagens retornada do banco de dados
    $dados =  $result_mensagens->fetchAll(PDO::FETCH_ASSOC);

    // Criar o array de retorno
    $retorno = ['status' => true, 'dados' => $dados, 'qtd_mensagens' => $qtd_mansagens, 'total_mensagem' => $row_total_mensagem['total_registros']];

}else{
    // Quando não encontrar os dados, criar o array de retorno
    $retorno = ['status' => false, 'msg' => 'Isso é tudo. Você viu todas as mensagens'];
}

// Retornar objeto de dados para o JavaScript
echo json_encode($retorno);