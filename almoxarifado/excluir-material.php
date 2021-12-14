<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1){

    $id = filter_input(INPUT_GET, 'idMaterial');
    $delete = $db->prepare("DELETE FROM estoque_material WHERE idmaterial_estoque = :idMaterial ");
    $delete->bindValue(':idMaterial', $id);

    if($delete->execute()){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='estoque.php' </script>";
    }else{
        print_r($db->errorInfo());
    }

}else{
    echo "Erro";
}

?>