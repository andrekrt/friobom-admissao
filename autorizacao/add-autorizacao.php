<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2) ){

    $idUsuario = $_SESSION['idUsuario'];
    $data = date("Y-m-d");
    $nome = filter_input(INPUT_POST, 'nome' );
    $funcao = filter_input(INPUT_POST, 'funcao');
    $valor = filter_input(INPUT_POST, 'valor');
    $obs = filter_input(INPUT_POST, 'obs');

    try{
        $db->beginTransaction();

        $sql = $db->prepare("INSERT INTO autorizacoes (nome, funcao, data_atual, valor, obs, usuario) VALUES (:nome, :funcao, :dataAtual, :valor, :obs, :usuario)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':dataAtual', $data);
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':usuario', $idUsuario);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Autorização Lançada com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(PDOException $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Lançar Autorização!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: form-autorizacao.php");
exit(); 
?>