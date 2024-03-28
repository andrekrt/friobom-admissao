<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==2 || $_SESSION['tipoUsuario']==99) ){

    $nome = filter_input(INPUT_POST, 'nome' );
    $funcao = filter_input(INPUT_POST, 'funcao');
    $rota = filter_input(INPUT_POST, 'rota');
    $situacao = 'Documentação em Análise';
    $anexoDocumentos = $_FILES['documentos'];
    $idDocumento = filter_input(INPUT_POST, 'idDocumento');

    // echo "$nome<br>$funcao<br>$rota<br>$situacao<br>$idDocumento";
    // print_r($anexoDocumentos);


    $sql = $db->prepare("UPDATE documentos_admissao SET nome_contratado = :nome, funcao = :funcao, rota=:rota, situacao=:situacao WHERE iddocumentos_admissao = :idDocumento");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':rota', $rota);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':idDocumento', $idDocumento);

    if($sql->execute()){
        $diretorioPrincipal = "uploads/".$idDocumento;
        for($i=0;$i<count($anexoDocumentos['name']);$i++){
            $destinoDocumentos = $diretorioPrincipal."/". $anexoDocumentos['name'][$i];
            move_uploaded_file($anexoDocumentos['tmp_name'][$i],$destinoDocumentos);
        }
        echo "<script>alert('Documentação Enviada!');</script>";
        echo "<script>window.location.href='documentos.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }



}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>