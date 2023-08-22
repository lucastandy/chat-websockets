<?php

session_start();

unset($_SESSION['usuario_id'], $_SESSION['nome']);
$_SESSION['msg'] = "<p class='alert-sucesso'>Deslogado com sucesso!</p>";

header("Location: index.php");