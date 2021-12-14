<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1){

    $id = filter_input(INPUT_GET, 'idSaida');
    $consultaMaterial = $db->prepare("SELECT material FROM estoque_saidas WHERE idestoque_saidas = :idSaida");
    $consultaMaterial->bindValue(':idSaida', $id);
    $consultaMaterial->execute();
    $material = $consultaMaterial->fetch();
    $material = $material['material'];

    $delete = $db->prepare("DELETE FROM estoque_saidas WHERE idestoque_saidas = :idSaida ");
    $delete->bindValue(':idSaida', $id);

    if($delete->execute()){
        if(atualizaEstoque($material)){
            echo "<script> alert('Excluído com Sucesso!')</script>";
            echo "<script> window.location.href='saidas.php' </script>";
        }
        
    }else{
        print_r($db->errorInfo());
    }

}else{
    echo "Erro";
}

?>