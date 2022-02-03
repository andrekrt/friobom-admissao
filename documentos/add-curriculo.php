<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==2 ){

    $idUsuario = $_SESSION['idUsuario'];
    $data = date("Y-m-d H:i:s");
    $nome = filter_input(INPUT_POST, 'nome' );
    $funcao = filter_input(INPUT_POST, 'funcao');
    $rota = filter_input(INPUT_POST, 'rota');
    $documentosNome = "Anexos";
    $situacao = 'Em Análise';
    $anexoDocumentos = $_FILES['curriculo'];

    $sql = $db->prepare("INSERT INTO documentos_admissao (data_envio, nome_contratado, funcao, rota, documentos, situacao, usuarios_idusuarios) VALUES (:dataEnvio, :nome, :funcao, :rota, :documentos, :situacao, :usuario)");
    $sql->bindValue(':dataEnvio', $data);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':rota', $rota);
    $sql->bindValue(':documentos', $documentosNome);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':usuario', $idUsuario);

    if($sql->execute()){
        $ultimoId = $db->lastInsertId();
        $diretorioPrincipal = "uploads/".$ultimoId;
        mkdir($diretorioPrincipal,0755);
        $destinoDocumentos = $diretorioPrincipal."/". $anexoDocumentos['name'];
        move_uploaded_file($anexoDocumentos['tmp_name'],$destinoDocumentos);

        echo "<script>alert('Curriculo Enviada!');</script>";
        echo "<script>window.location.href='form-curriculo.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>