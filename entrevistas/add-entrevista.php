<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99) ){

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
        $sql = $db->prepare("INSERT INTO entrevistas (nome_candidato, vaga, processo, referencia, entrevistado, passou, obs, usuario) VALUES(:nome, :vaga, :processo, :referencia, :entrevistado, :passou, :obs, :usuario)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':vaga', $vaga);
        $sql->bindValue(':processo', $processo);
        $sql->bindValue(':referencia', $referencia);
        $sql->bindValue(':entrevistado', $entrevistou);
        $sql->bindValue(':passou', $teste);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':usuario', $usuario);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Entrevista Registrada com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Registrar Entrevista!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location:entrevistas.php");
exit(); 
?>