<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2) ){

    $idautorizacao = filter_input(INPUT_POST, 'id');
    $nome = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $valor = filter_input(INPUT_POST, 'valor');
    $obs = filter_input(INPUT_POST, 'obs');
    
    $db->beginTransaction();
    
    try{

        $sql = $db->prepare("UPDATE autorizacoes SET nome = :nome, funcao = :funcao, valor = :valor, obs = :obs WHERE idautorizacao = :id");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':id', $idautorizacao);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Autorização Atualizada com Sucesso!';
        $_SESSION['icon']='success';
    }catch(PDOException $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Autorização!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: autorizacoes.php");
exit(); 
?>