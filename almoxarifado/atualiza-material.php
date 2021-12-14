<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1 ){

    $idMaterial = filter_input(INPUT_POST, 'idMaterial');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $medida = filter_input(INPUT_POST, 'medida');
    $grupo = filter_input(INPUT_POST, 'grupo');
    $estoqueMinimo = filter_input(INPUT_POST, 'estoqueMinimo');

    $atualiza = $db->prepare("UPDATE estoque_material SET descricao_material = :descricao, un_medida = :medida, grupo_material = :grupo, estoque_minimo = :estoqueMinimo WHERE idmaterial_estoque = :idMaterial");
    $atualiza->bindValue(':descricao', $descricao);
    $atualiza->bindValue(':medida', $medida);
    $atualiza->bindValue(':grupo', $grupo);
    $atualiza->bindValue(':estoqueMinimo', $estoqueMinimo);
    $atualiza->bindValue(':idMaterial', $idMaterial);

    if($atualiza->execute()){
        if(atualizaEstoque($idMaterial)){
            echo "<script> alert('Atualizado com Sucesso!')</script>";
            echo "<script> window.location.href='estoque.php' </script>";
        }
       
    }else{
        print_r($atualiza->errorInfo());
    }

}else{

}

?>