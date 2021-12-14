<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1){

    $id = filter_input(INPUT_GET, 'idForn');
    $delete = $db->prepare("DELETE FROM fornecedores WHERE idfornecedores = :idForn ");
    $delete->bindValue(':idForn', $id);

    if($delete->execute()){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='fornecedores.php' </script>";
    }else{
        print_r($db->errorInfo());
    }

}else{
    echo "Erro";
}

?>