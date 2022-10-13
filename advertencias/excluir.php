<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 ){

    $idAdvertencia = filter_input(INPUT_GET, 'id');
    

    // echo "$nomeFuncionario<br>$funcao<br>$dataOcorrencia<br>$assunto<br>$motivo<br>$diasSuspenso<br>$dataRetorno";

    /*echo "$nomeFuncionario<br>$funcao<br>$admissao<br>$demissao<br>$valorFormt<br><br>";
    echo "$material<br>$contraCheque<br>$xeroxCtps<br>$devolucaoCtps<br>$valeTransporte<br>$planoSaude<br>$contratoExperiencia<br>$livroAssinado<br>$valorDescontado<br>$verificado1221<br>$semCarteira<br>$recibos<br>$exames<br>$cartaDemissao<br>$motivoSaida<br>$ponto<br>$ferias<br>$chip<br>$assinado1221<br>$planoCancelado<br>$desativado";*/

    $sql = $db->prepare("DELETE FROM advertencias WHERE idadvertencia = :idadvertencia");
    $sql->bindValue(':idadvertencia', $idAdvertencia);

    if($sql->execute()){
        echo "<script>alert('Advertência Excluída!');</script>";
        echo "<script>window.location.href='advertencias.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>