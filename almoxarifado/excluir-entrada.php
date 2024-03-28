<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99)){

    $id = filter_input(INPUT_GET, 'idEntrada');

    echo $id;

    $db->beginTransaction();

    try{

        $consultaMaterial = $db->prepare("SELECT material FROM estoque_entradas WHERE idestoque_entradas = :idEntrada");
        $consultaMaterial->bindValue(':idEntrada', $id);
        $consultaMaterial->execute();
        $material = $consultaMaterial->fetch();
        $material = $material['material'];

        $delete = $db->prepare("DELETE FROM estoque_entradas WHERE idestoque_entradas = :idEntrada ");
        $delete->bindValue(':idEntrada', $id);
        $delete->execute();

        $db->commit();

        $_SESSION['msg'] = 'Entrada Excluida com Sucesso!';
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