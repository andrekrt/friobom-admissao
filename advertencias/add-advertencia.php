<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 ){

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

    $sql = $db->prepare("INSERT INTO advertencias (funcionario, funcao, data_ocorrencia, assunto, dias_suspencao, data_retorno, motivo, usuario) VALUES (:funcionario, :funcao, :dataOcorrencia, :assunto, :diasSuspenso, :dataRetorno, :motivo, :usuario)");
    $sql->bindValue(':funcionario', $nomeFuncionario);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':dataOcorrencia', $dataOcorrencia);
    $sql->bindValue(':assunto', $assunto);
    $sql->bindValue(':diasSuspenso', $diasSuspenso);
    $sql->bindValue(':dataRetorno', $dataRetorno);
    $sql->bindValue(':motivo', $motivo);
    $sql->bindValue(':usuario', $usuario);

    if($sql->execute()){
        echo "<script>alert('Advertência Lançada!');</script>";
        echo "<script>window.location.href='form-advertencia.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>