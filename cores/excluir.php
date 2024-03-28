<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2) ){

    $id = filter_input(INPUT_GET, 'id');

    $db->beginTransaction();

    try{
        $sql = $db->prepare("DELETE FROM cores WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Core Excluído com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(PDOException $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Core!';
        $_SESSION['icon']='error';
        echo $e;
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: listar.php");
exit(); 
?>