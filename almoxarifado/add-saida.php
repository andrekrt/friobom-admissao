<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1 ){

    $idUsuario = $_SESSION['idUsuario'];
    $dataSaida = date('Y-m-d');
    $material = filter_input(INPUT_POST, 'material');
    $qtd = str_replace(",", ".", filter_input(INPUT_POST, 'qtd'));
    $solicitante = filter_input(INPUT_POST,'solic');
    $obs = filter_input(INPUT_POST,'obs');

    $consultaEstoque = $db->prepare("SELECT total_estoque FROM estoque_material WHERE idmaterial_estoque = :idMaterial");
    $consultaEstoque->bindValue(':idMaterial', $material);
    $consultaEstoque->execute();
    $qtdEstoque = $consultaEstoque->fetch();

    if($qtd<=$qtdEstoque['total_estoque']){

        $inserir = $db->prepare("INSERT INTO estoque_saidas (data_saida, qtd, material, solicitante, obs, usuarios_idusuarios) VALUES (:dataSaida, :qtd, :material, :solicitante, :obs, :idUsuario)");
        $inserir->bindValue(':dataSaida', $dataSaida);
        $inserir->bindValue(':qtd', $qtd);
        $inserir->bindValue(':material', $material);
        $inserir->bindValue(':solicitante', $solicitante);
        $inserir->bindValue(':obs', $obs);
        $inserir->bindValue(':idUsuario', $idUsuario);

        if($inserir->execute()){
            if(atualizaEstoque($material)){
                echo "<script>alert('Saída Registrada!');</script>";
                echo "<script>window.location.href='saidas.php'</script>";
            }
            
        }else{
            print_r($inserir->errorInfo());
        }

    }else{
        echo "<script>alert('Quantidade Acima do Estoque Disponível!');</script>";
        echo "<script>window.location.href='saidas.php'</script>";
    }

    

}

?>