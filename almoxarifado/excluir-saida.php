<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99)){

    $id = filter_input(INPUT_GET, 'idSaida');

    $db->beginTransaction();

    try{
        $consultaMaterial = $db->prepare("SELECT material FROM estoque_saidas WHERE idestoque_saidas = :idSaida");
        $consultaMaterial->bindValue(':idSaida', $id);
        $consultaMaterial->execute();
        $material = $consultaMaterial->fetch();
        $material = $material['material'];

        $delete = $db->prepare("DELETE FROM estoque_saidas WHERE idestoque_saidas = :idSaida ");
        $delete->bindValue(':idSaida', $id);
        $delete->execute();

        $db->commit();

        $_SESSION['msg'] = 'Saída Excluída com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Saída!';
        $_SESSION['icon']='error';
    }    

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}

atualizaEstoque($material);
header("Location: saidas.php");
exit(); 
?>