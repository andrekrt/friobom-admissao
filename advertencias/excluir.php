<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99) ){

    $idAdvertencia = filter_input(INPUT_GET, 'id');
    

   $db->beginTransaction();

   try{
    $sql = $db->prepare("DELETE FROM advertencias WHERE idadvertencia = :idadvertencia");
    $sql->bindValue(':idadvertencia', $idAdvertencia);
    $sql->execute();

    $db->commit();

    $_SESSION['msg'] = 'Advertência Excluída com Sucesso!';
    $_SESSION['icon']='success';

   }catch(Exception $e){
    $db->rollBack();
    $_SESSION['msg'] = 'Erro ao Excluir Advertência!';
    $_SESSION['icon']='error';
   }    

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: advertencias.php");
exit(); 
?>