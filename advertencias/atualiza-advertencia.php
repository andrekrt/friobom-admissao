<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 ){

    $idAdvertencia = filter_input(INPUT_POST, 'idadvertencia');
    $usuario = $_SESSION['idUsuario'];
    $nomeFuncionario = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $dataOcorrencia = filter_input(INPUT_POST, 'dataOcorrencia');
    $assunto = filter_input(INPUT_POST, 'assunto');
    $motivo = nl2br(filter_input(INPUT_POST, 'motivo'));
    $diasSuspenso = filter_input(INPUT_POST, 'diasSuspenso')?filter_input(INPUT_POST, 'diasSuspenso'):0;
    $dataRetorno = filter_input(INPUT_POST, 'dataRetorno')?filter_input(INPUT_POST, 'dataRetorno'):"1900-01-01";

    // echo "$nomeFuncionario<br>$funcao<br>$dataOcorrencia<br>$assunto<br>$motivo<br>$diasSuspenso<br>$dataRetorno";

    /*echo "$nomeFuncionario<br>$funcao<br>$admissao<br>$demissao<br>$valorFormt<br><br>";
    echo "$material<br>$contraCheque<br>$xeroxCtps<br>$devolucaoCtps<br>$valeTransporte<br>$planoSaude<br>$contratoExperiencia<br>$livroAssinado<br>$valorDescontado<br>$verificado1221<br>$semCarteira<br>$recibos<br>$exames<br>$cartaDemissao<br>$motivoSaida<br>$ponto<br>$ferias<br>$chip<br>$assinado1221<br>$planoCancelado<br>$desativado";*/

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

    if($sql->execute()){
        echo "<script>alert('Advertência Atualizada!');</script>";
        echo "<script>window.location.href='advertencias.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>