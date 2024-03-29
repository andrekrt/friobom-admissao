<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99) ){

    $id = filter_input(INPUT_POST,'id');
    $nome = filter_input(INPUT_POST, 'nome' );
    $vaga = filter_input(INPUT_POST, 'vaga');
    $processo = filter_input(INPUT_POST, 'processo');
    $referencia = filter_input(INPUT_POST, 'referencia');
    $entrevistou = filter_input(INPUT_POST, 'entrevistou');
    $teste = filter_input(INPUT_POST, 'teste');
    $obs = filter_input(INPUT_POST, 'obs');
    $usuario = $_SESSION['idUsuario'];

    $db->beginTransaction();

    try{
        $sql = $db->prepare("UPDATE entrevistas SET nome_candidato = :nome, vaga = :vaga, processo = :processo, referencia = :referencia, entrevistado = :entrevistado, passou = :passou, obs = :obs, usuario=:usuario WHERE id = :id");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':vaga', $vaga);
        $sql->bindValue(':processo', $processo);
        $sql->bindValue(':referencia', $referencia);
        $sql->bindValue(':entrevistado', $entrevistou);
        $sql->bindValue(':passou', $teste);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':id', $id);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Entrevista Atualizada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Entrevista!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location:entrevistas.php");
exit(); 
?>