<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1 ){
    $idUsuario = filter_input(INPUT_GET, 'idUsuario');

    $delete = $db->prepare("DELETE FROM usuarios WHERE idusuarios = :idusuario ");
    $delete->bindValue(':idusuario', $idUsuario);

    if($delete->execute()){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='usuarios.php' </script>";
    }else{
        print_r($delete->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
        echo "<script> window.location.href='usuarios.php' </script>";
}

?>