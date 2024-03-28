<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99)){

    $id = filter_input(INPUT_GET, 'idMaterial');

    $db->beginTransaction();

    try{
        $delete = $db->prepare("DELETE FROM estoque_material WHERE idmaterial_estoque = :idMaterial ");
        $delete->bindValue(':idMaterial', $id);
        $delete->execute();

        $db->commit();

        $_SESSION['msg'] = 'Material Excluído com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Material!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: estoque.php");
exit();
?>