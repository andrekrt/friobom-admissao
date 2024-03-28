<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99) ){

    $idUsuario = filter_input(INPUT_POST, 'idusuarios');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $senha = password_hash(filter_input(INPUT_POST, 'senha'),PASSWORD_DEFAULT);

    $db->beginTransaction();

    try{
        $atualiza = $db->prepare("UPDATE usuarios SET tipo_usuario_idtipo_usuario = :tipo, senha = :senha WHERE idusuarios = :idusuarios ");
        $atualiza->bindValue(':tipo', $tipo);
        $atualiza->bindValue(':senha', $senha);
        $atualiza->bindValue(':idusuarios', $idUsuario);
        $atualiza->execute();

        $db->commit();

        $_SESSION['msg'] = 'Usuário Atualizado com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Usuário!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: usuarios.php");
exit(); 
?>