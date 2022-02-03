<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==2 ){

    $idDocumentacao = filter_input(INPUT_POST, 'id');

    $nome = filter_input(INPUT_POST, 'nome' );
    $funcao = filter_input(INPUT_POST, 'funcao');
    $rota = filter_input(INPUT_POST, 'rota');
    $situacao = filter_input(INPUT_POST, 'situacao');
    $obs = filter_input(INPUT_POST, 'obs');

    //echo "$nome<br>$funcao<br>$rota<br>$situacao<br>$obs<br>";

    $sql = $db->prepare("UPDATE documentos_admissao SET nome_contratado = :nome, funcao = :funcao, rota = :rota, situacao = :situacao, obs = :obs WHERE iddocumentos_admissao = :idDocumentos ");
    $sql->bindValue(':idDocumentos', $idDocumentacao);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':rota', $rota);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':obs', $obs);

    if($sql->execute()){

        // $diretorioPrincipal = "uploads/".$idDocumentacao;

        // for($i=0;$i<count($documentosAnexos['name']);$i++){
        //     $destino = $diretorioPrincipal."/". $documentosAnexos['name'][$i];
        //     move_uploaded_file($documentosAnexos['tmp_name'][$i],$destino);
        // }

        echo "<script>alert('Atualizado!');</script>";
        echo "<script>window.location.href='documentos.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }



}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>