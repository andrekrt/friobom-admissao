<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==2 || $_SESSION['tipoUsuario']==99) ){

    $idDocumentacao = filter_input(INPUT_POST, 'id');

    $nome = filter_input(INPUT_POST, 'nome' );
    $funcao = filter_input(INPUT_POST, 'funcao');
    $rota = filter_input(INPUT_POST, 'rota');
    $situacao = filter_input(INPUT_POST, 'situacao');
    $obs = filter_input(INPUT_POST, 'obs');

    $db->beginTransaction();

    try{
        $sql = $db->prepare("UPDATE documentos_admissao SET nome_contratado = :nome, funcao = :funcao, rota = :rota, situacao = :situacao, obs = :obs WHERE iddocumentos_admissao = :idDocumentos ");
        $sql->bindValue(':idDocumentos', $idDocumentacao);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':rota', $rota);
        $sql->bindValue(':situacao', $situacao);
        $sql->bindValue(':obs', $obs);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Curriculo Atualizado com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Curriculo!';
        $_SESSION['icon']='error';
    }  

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: documentos.php");
exit(); 
?>