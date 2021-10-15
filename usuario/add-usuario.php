<?php

session_start();
require("../conexao.php");

if( isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1 ){

    $idUsuario = $_SESSION['idUsuario'];

    $cpf = filter_input(INPUT_POST, 'cpf');
    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $senha = password_hash(filter_input(INPUT_POST, 'senha'), PASSWORD_DEFAULT);
    $tipo = filter_input(INPUT_POST, 'tipo');

    $consulta = $db->prepare("SELECT * FROM usuarios WHERE cpf = :cpf OR email = :email");
    $consulta->bindValue(':cpf', $cpf);
    $consulta->bindValue(':email', $email);
    $consulta->execute();

    if($consulta->rowCount()>0){
        echo "<script>alert('E-mail ou CPF já cadastrado!');</script>";
        echo "<script>window.location.href='form-usuario.php'</script>";
    }else{
        $sql= $db->prepare("INSERT INTO usuarios (cpf, nome_usuario, email, senha, tipo_usuario_idtipo_usuario) VALUES (:cpf, :nome, :email, :senha, :tipo) ");
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->bindValue(':tipo', $tipo);
        if($sql->execute()){

            echo "<script>alert('Usuário Cadastrado!');</script>";
            echo "<script>window.location.href='form-usuario.php'</script>";

        }else{
            print_r($sql->errorInfo());
        }
    }

}else{
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";
}

?>