<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2) ){

    $idautorizacao = filter_input(INPUT_GET, 'id');

    $db->beginTransaction();

    try{
        

        $sql = $db->prepare("DELETE FROM autorizacoes WHERE idautorizacao = :id");
        $sql->bindValue(':id', $idautorizacao);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Autorização Excluída com Sucesso!';
        $_SESSION['icon']='success';

    }catch(PDOException $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Autorização!';
        $_SESSION['icon']='error';
    }


}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: autorizacoes.php");
exit(); 
?>