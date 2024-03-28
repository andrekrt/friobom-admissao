<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99) ){

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
        $sql = $db->prepare("INSERT INTO advertencias (funcionario, funcao, data_ocorrencia, assunto, dias_suspencao, data_retorno, motivo, usuario) VALUES (:funcionario, :funcao, :dataOcorrencia, :assunto, :diasSuspenso, :dataRetorno, :motivo, :usuario)");
        $sql->bindValue(':funcionario', $nomeFuncionario);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':dataOcorrencia', $dataOcorrencia);
        $sql->bindValue(':assunto', $assunto);
        $sql->bindValue(':diasSuspenso', $diasSuspenso);
        $sql->bindValue(':dataRetorno', $dataRetorno);
        $sql->bindValue(':motivo', $motivo);
        $sql->bindValue(':usuario', $usuario);
        $sql->execute();
        
        $db->commit();

        $_SESSION['msg'] = 'Advertência Lançada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Lançar Advertência!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: form-advertencia.php");
exit(); 
?>