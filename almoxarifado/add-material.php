<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99)){

    $idUsuario = $_SESSION['idUsuario'];
    $descricao = filter_input(INPUT_POST, 'descricao');
    $medida = filter_input(INPUT_POST, 'medida');
    $grupo = filter_input(INPUT_POST, 'grupo');
    $estoqueMinimo = str_replace(",", ".", filter_input(INPUT_POST, 'estoqueMinimo'));
    $dataCadastro = date('Y-m-d');

    $db->beginTransaction();

    try{
        $verificaMaterial = $db->prepare("SELECT * FROM estoque_material WHERE descricao_material = :descricao");
        $verificaMaterial->bindValue(':descricao', $descricao);
        $verificaMaterial->execute();
        if($verificaMaterial->rowCount()>0){

            $_SESSION['msg'] = 'Esse Material já está cadastrado no Estoque!';
            $_SESSION['icon']='warning';
            header("Location: estoque.php");
            exit();    
        }
    
        $inserir = $db->prepare("INSERT INTO estoque_material (descricao_material, un_medida, grupo_material, estoque_minimo, data_cadastro, usuarios_idusuarios) VALUES (:descricao, :medida, :grupo, :estoqueMinimo, :dataCadastro, :idUsuario)");
        $inserir->bindValue(':descricao', $descricao);
        $inserir->bindValue(':medida', $medida);
        $inserir->bindValue(':grupo', $grupo);
        $inserir->bindValue(':estoqueMinimo', $estoqueMinimo);
        $inserir->bindValue(':dataCadastro', $dataCadastro);
        $inserir->bindValue(':idUsuario', $idUsuario);
        $inserir->execute();

        $db->commit();

        $_SESSION['msg'] = 'Material Cadastrado com Sucesso!';
        $_SESSION['icon']='success';
    
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Cadastrar Material!';
        $_SESSION['icon']='error';
    }    
}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: estoque.php");
exit(); 
?>