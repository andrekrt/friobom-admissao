<?php

session_start();
require("../conexao.php");
require_once("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1 ){

    $idEntrada = filter_input(INPUT_POST, 'idEntrada');
    $nf = filter_input(INPUT_POST, 'nf');
    $material = filter_input(INPUT_POST, 'material');
    $vlUnit = filter_input(INPUT_POST, 'vlUnit');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $vlTotal = $vlUnit*$qtd;
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');
    
    $consultaMaterial = $db->prepare("SELECT material FROM estoque_entradas WHERE idestoque_entradas = :idEntrada");
    $consultaMaterial->bindValue(':idEntrada', $idEntrada);
    $consultaMaterial->execute();
    $material = $consultaMaterial->fetch();
    $material = $material['material'];

    $atualiza = $db->prepare("UPDATE estoque_entradas SET nf = :nf, material = :material, valor_unit = :vlUnit, qtd = :qtd, valor_total = :vlTotal, fornecedores_idfornecedores = :fornecedor WHERE idestoque_entradas = :idEntrada");
    $atualiza->bindValue(':nf', $nf);
    $atualiza->bindValue(':material', $material);
    $atualiza->bindValue(':vlUnit', $vlUnit);
    $atualiza->bindValue(':qtd', $qtd);
    $atualiza->bindValue(':vlTotal', $vlTotal);
    $atualiza->bindValue(':fornecedor', $fornecedor);
    $atualiza->bindValue(':idEntrada', $idEntrada);

    if($atualiza->execute()){
        if(atualizaEstoque($material)){
            echo "<script> alert('Atualizado com Sucesso!')</script>";
            echo "<script> window.location.href='entradas.php' </script>";
        }
        
    }else{
        print_r($atualiza->errorInfo());
    }

}else{

}

?>