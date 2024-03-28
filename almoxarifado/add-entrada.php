<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99)){

    $idUsuario = $_SESSION['idUsuario'];
    $dataEntrada = date('Y-m-d');
    $nf = filter_input(INPUT_POST, 'nf');
    $material = filter_input(INPUT_POST, 'material');
    $vlUnd = str_replace(",", ".", filter_input(INPUT_POST, 'valor'));
    $qtd = str_replace(",", ".", filter_input(INPUT_POST, 'qtd'));
    $vlTotal = $vlUnd*$qtd;
    $fornecedor = filter_input(INPUT_POST,'fornecedor');

    $db->beginTransaction();

    try{
        $inserir = $db->prepare("INSERT INTO estoque_entradas (data_entrada, nf, material, valor_unit, qtd, valor_total, fornecedores_idfornecedores, usuarios_idusuarios) VALUES (:dataEntrada, :nf, :material, :vlUnd, :qtd, :vlTotal, :fornecedor, :idUsuario)");
        $inserir->bindValue(':dataEntrada', $dataEntrada);
        $inserir->bindValue(':nf', $nf);
        $inserir->bindValue(':material', $material);
        $inserir->bindValue(':vlUnd', $vlUnd);
        $inserir->bindValue(':qtd', $qtd);
        $inserir->bindValue(':vlTotal', $vlTotal);
        $inserir->bindValue(':fornecedor', $fornecedor);
        $inserir->bindValue(':idUsuario', $idUsuario);
        $inserir->execute(); 

        $db->commit();

        $_SESSION['msg'] = 'Entrada Lançada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Lançar Entrada!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
atualizaEstoque($material);
header("Location: entradas.php");
exit(); 
?>