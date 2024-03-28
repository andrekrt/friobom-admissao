<?php

session_start();
require("../conexao.php");
require("funcoes.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99) ){

    $idMaterial = filter_input(INPUT_POST, 'idMaterial');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $medida = filter_input(INPUT_POST, 'medida');
    $grupo = filter_input(INPUT_POST, 'grupo');
    $estoqueMinimo = filter_input(INPUT_POST, 'estoqueMinimo');

    $db->beginTransaction();

    try{
        $atualiza = $db->prepare("UPDATE estoque_material SET descricao_material = :descricao, un_medida = :medida, grupo_material = :grupo, estoque_minimo = :estoqueMinimo WHERE idmaterial_estoque = :idMaterial");
        $atualiza->bindValue(':descricao', $descricao);
        $atualiza->bindValue(':medida', $medida);
        $atualiza->bindValue(':grupo', $grupo);
        $atualiza->bindValue(':estoqueMinimo', $estoqueMinimo);
        $atualiza->bindValue(':idMaterial', $idMaterial);
        $atualiza->execute();
        
        $db->commit();

        $_SESSION['msg'] = 'Material Atualizado com Sucesso!';
        $_SESSION['icon']='success';
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Material!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
echo atualizaEstoque($idMaterial);
header("Location: estoque.php");
exit(); 
?>