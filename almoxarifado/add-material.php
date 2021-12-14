<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1 ){

    $idUsuario = $_SESSION['idUsuario'];
    $descricao = filter_input(INPUT_POST, 'descricao');
    $medida = filter_input(INPUT_POST, 'medida');
    $grupo = filter_input(INPUT_POST, 'grupo');
    $estoqueMinimo = str_replace(",", ".", filter_input(INPUT_POST, 'estoqueMinimo'));
    $dataCadastro = date('Y-m-d');

    $verificaMaterial = $db->prepare("SELECT * FROM estoque_material WHERE descricao_material = :descricao");
    $verificaMaterial->bindValue(':descricao', $descricao);
    $verificaMaterial->execute();
    if($verificaMaterial->rowCount()>0){

        echo "<script>alert('Esse Material já está cadastrada no Estoque!');</script>";
        echo "<script>window.location.href='estoque.php'</script>";

    }else{

        $inserir = $db->prepare("INSERT INTO estoque_material (descricao_material, un_medida, grupo_material, estoque_minimo, data_cadastro, usuarios_idusuarios) VALUES (:descricao, :medida, :grupo, :estoqueMinimo, :dataCadastro, :idUsuario)");
        $inserir->bindValue(':descricao', $descricao);
        $inserir->bindValue(':medida', $medida);
        $inserir->bindValue(':grupo', $grupo);
        $inserir->bindValue(':estoqueMinimo', $estoqueMinimo);
        $inserir->bindValue(':dataCadastro', $dataCadastro);
        $inserir->bindValue(':idUsuario', $idUsuario);

        if($inserir->execute()){
            echo "<script>alert('Material Cadastrado com Sucesso!');</script>";
            echo "<script>window.location.href='estoque.php'</script>";
        }else{
            print_r($inserir->errorInfo());
        }

    }

    

}

?>