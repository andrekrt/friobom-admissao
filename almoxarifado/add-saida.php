<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99)){

    $idUsuario = $_SESSION['idUsuario'];
    $dataSaida = date('Y-m-d');
    $material = filter_input(INPUT_POST, 'material');
    $qtd = str_replace(",", ".", filter_input(INPUT_POST, 'qtd'));
    $solicitante = filter_input(INPUT_POST,'solic');
    $obs = filter_input(INPUT_POST,'obs');

    $db->beginTransaction();

    try{
        $consultaEstoque = $db->prepare("SELECT total_estoque FROM estoque_material WHERE idmaterial_estoque = :idMaterial");
        $consultaEstoque->bindValue(':idMaterial', $material);
        $consultaEstoque->execute();
        $qtdEstoque = $consultaEstoque->fetch();

        if($qtd>$qtdEstoque['total_estoque']){

            $_SESSION['msg'] = 'Quantidade Acima do Estoque Disponível!';
            $_SESSION['icon']='warning';
            header("Location: saidas.php");
            exit();    

        }

        $inserir = $db->prepare("INSERT INTO estoque_saidas (data_saida, qtd, material, solicitante, obs, usuarios_idusuarios) VALUES (:dataSaida, :qtd, :material, :solicitante, :obs, :idUsuario)");
        $inserir->bindValue(':dataSaida', $dataSaida);
        $inserir->bindValue(':qtd', $qtd);
        $inserir->bindValue(':material', $material);
        $inserir->bindValue(':solicitante', $solicitante);
        $inserir->bindValue(':obs', $obs);
        $inserir->bindValue(':idUsuario', $idUsuario);
        $inserir->execute();

        $db->commit();

        $_SESSION['msg'] = 'Saída Registrada com Sucesso!';
        $_SESSION['icon']='success';
    
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Registrar Saída!';
        $_SESSION['icon']='error';
    }
}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
atualizaEstoque($material);
header("Location: saidas.php");
exit(); 
?>