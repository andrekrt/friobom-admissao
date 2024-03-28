<?php

session_start();
require("../conexao.php");
require_once("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99) ){

    $idEntrada = filter_input(INPUT_POST, 'idEntrada');
    $nf = filter_input(INPUT_POST, 'nf');
    $material = filter_input(INPUT_POST, 'material');
    $vlUnit = filter_input(INPUT_POST, 'vlUnit');
    $qtd = filter_input(INPUT_POST, 'qtd');
    $vlTotal = $vlUnit*$qtd;
    $fornecedor = filter_input(INPUT_POST, 'fornecedor');

    $db->beginTransaction();

    try{
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
        $atualiza->execute();

        $db->commit();

        $_SESSION['msg'] = 'Entrada Atualizada com Sucesso!';
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