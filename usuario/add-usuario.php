<?php

session_start();
require("../conexao.php");

if( isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99) ){

    $idUsuario = $_SESSION['idUsuario'];

    $cpf = filter_input(INPUT_POST, 'cpf');
    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $senha = password_hash(filter_input(INPUT_POST, 'senha'), PASSWORD_DEFAULT);
    $tipo = filter_input(INPUT_POST, 'tipo');

    $db->beginTransaction();

    try{
        $consulta = $db->prepare("SELECT * FROM usuarios WHERE cpf = :cpf OR email = :email");
        $consulta->bindValue(':cpf', $cpf);
        $consulta->bindValue(':email', $email);
        $consulta->execute();

        if($consulta->rowCount()>0){

            $_SESSION['msg'] = 'E-mail ou CPF já cadastrado!';
            $_SESSION['icon']='warning';
            header("Location: form-usuario.php");
            exit();  

        }
        $sql= $db->prepare("INSERT INTO usuarios (cpf, nome_usuario, email, senha, tipo_usuario_idtipo_usuario) VALUES (:cpf, :nome, :email, :senha, :tipo) ");
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->bindValue(':tipo', $tipo);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Usuário Cadastrado com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Cadastrar Usuário!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: form-usuario.php");
exit(); 
?>