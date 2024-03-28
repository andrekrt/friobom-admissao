<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99) ){
    $idUsuario = filter_input(INPUT_GET, 'idUsuario');

    $db->beginTransaction();

    try{
        $delete = $db->prepare("DELETE FROM usuarios WHERE idusuarios = :idusuario ");
        $delete->bindValue(':idusuario', $idUsuario);
        $delete->execute();

        $db->commit();

        $_SESSION['msg'] = 'Usuário Excluído com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Excluir Usuário!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: usuarios.php");
exit(); 
?>