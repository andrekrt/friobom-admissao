<?php

require("../conexao.php");

function atualizaEstoque($idMaterial){
    require("../conexao.php");

    $qtdEntradas = $db->prepare("SELECT SUM(qtd) as entradas FROM estoque_entradas WHERE material = :idMaterial");
    $qtdEntradas->bindValue(':idMaterial', $idMaterial);
    $qtdEntradas->execute();
    $qtdEntradas = $qtdEntradas->fetch();
    $qtdEntradas = $qtdEntradas['entradas']?$qtdEntradas['entradas']:0;

    $qtdSaida = $db->prepare("SELECT SUM(qtd) as saidas FROM estoque_saidas WHERE material = :idMaterial");
    $qtdSaida->bindValue(':idMaterial', $idMaterial);
    $qtdSaida->execute();
    $qtdSaida = $qtdSaida->fetch();
    $qtdSaida = $qtdSaida['saidas']?$qtdSaida['saidas']:0;

    $totalEstoque = $qtdEntradas-$qtdSaida;

    $vlTotal = $db->prepare("SELECT SUM(valor_total) as vlTotal FROM estoque_entradas WHERE material = :idMaterial");
    $vlTotal->bindValue(':idMaterial', $idMaterial);
    $vlTotal->execute();
    $vlTotal = $vlTotal->fetch();
    $vlTotal = $vlTotal['vlTotal']?$vlTotal['vlTotal']:0;
    
    $atualiza = $db->prepare("UPDATE estoque_material SET total_entrada = :entradas, total_saida = :saidas, total_estoque = :estoque, valor_comprado = :vlTotal WHERE idmaterial_estoque = :idMaterial");
    $atualiza->bindValue(':entradas', $qtdEntradas);
    $atualiza->bindValue(':saidas', $qtdSaida);
    $atualiza->bindValue(':estoque', $totalEstoque);
    $atualiza->bindValue(':vlTotal', $vlTotal);
    $atualiza->bindValue(':idMaterial', $idMaterial);

    if($atualiza->execute()){
        return true;
    }else{
        return print_r($atualiza->errorInfo());
    }
   
}


?>