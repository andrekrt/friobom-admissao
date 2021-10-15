<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1 ){

    $idUsuario = filter_input(INPUT_POST, 'idusuarios');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $senha = password_hash(filter_input(INPUT_POST, 'senha'),PASSWORD_DEFAULT);

    $atualiza = $db->prepare("UPDATE usuarios SET tipo_usuario_idtipo_usuario = :tipo, senha = :senha WHERE idusuarios = :idusuarios ");
    $atualiza->bindValue(':tipo', $tipo);
    $atualiza->bindValue(':senha', $senha);
    $atualiza->bindValue(':idusuarios', $idUsuario);

    if($atualiza->execute()){
        echo "<script> alert('Atualizado com Sucesso!')</script>";
        echo "<script> window.location.href='usuarios.php' </script>";
    }else{
        print_r($atualiza->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
    echo "<script> window.location.href='usuarios.php' </script>";
}

?>