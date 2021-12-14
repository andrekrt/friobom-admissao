<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1){

    $id = filter_input(INPUT_GET, 'idEntrada');
    $consultaMaterial = $db->prepare("SELECT material FROM estoque_entradas WHERE idestoque_entradas = :idEntrada");
    $consultaMaterial->bindValue(':idEntrada', $id);
    $consultaMaterial->execute();
    $material = $consultaMaterial->fetch();
    $material = $material['material'];

    $delete = $db->prepare("DELETE FROM estoque_entradas WHERE idestoque_entradas = :idEntrada ");
    $delete->bindValue(':idEntrada', $id);

    if($delete->execute()){
        if(atualizaEstoque($material)){
            echo "<script> alert('Excluído com Sucesso!')</script>";
            echo "<script> window.location.href='entradas.php' </script>";
        }
        
    }else{
        print_r($db->errorInfo());
    }

}else{
    echo "Erro";
}

?>