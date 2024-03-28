<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99)){

    $id = filter_input(INPUT_GET, 'idForn');

    $db->beginTransaction();

    try{
        $delete = $db->prepare("DELETE FROM fornecedores WHERE idfornecedores = :idForn ");
        $delete->bindValue(':idForn', $id);
        $delete->execute();

        $db->commit();

        $_SESSION['msg'] = 'Fornecedor Excluído com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Fornecedor!';
        $_SESSION['icon']='error';
    }    

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: fornecedores.php");
exit(); 
?>