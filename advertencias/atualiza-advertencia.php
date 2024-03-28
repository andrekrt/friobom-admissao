<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99) ){

    $idAdvertencia = filter_input(INPUT_POST, 'idadvertencia');
    $usuario = $_SESSION['idUsuario'];
    $nomeFuncionario = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $dataOcorrencia = filter_input(INPUT_POST, 'dataOcorrencia');
    $assunto = filter_input(INPUT_POST, 'assunto');
    $motivo = nl2br(filter_input(INPUT_POST, 'motivo'));
    $diasSuspenso = filter_input(INPUT_POST, 'diasSuspenso')?filter_input(INPUT_POST, 'diasSuspenso'):0;
    $dataRetorno = filter_input(INPUT_POST, 'dataRetorno')?filter_input(INPUT_POST, 'dataRetorno'):"1900-01-01";

    $db->beginTransaction();

    try{
        $sql = $db->prepare("UPDATE advertencias SET funcionario = :funcionario, funcao = :funcao, data_ocorrencia = :dataOcorrencia, assunto = :assunto, dias_suspencao = :diasSuspensao, data_retorno = :dataRetorno, motivo = :motivo, usuario = :usuario WHERE idadvertencia = :idadvertencia");
        $sql->bindValue(':funcionario', $nomeFuncionario);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':dataOcorrencia', $dataOcorrencia);
        $sql->bindValue(':assunto', $assunto);
        $sql->bindValue(':diasSuspensao', $diasSuspenso);
        $sql->bindValue(':dataRetorno', $dataRetorno);
        $sql->bindValue(':motivo', $motivo);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':idadvertencia', $idAdvertencia);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Advertência Atualizada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Advertência!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: advertencias.php");
exit(); 
?>