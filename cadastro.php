<?php

require('conexao.php');

$cpf = '04006292325';
$nome = 'André Santos';
$email = 'andrekrt1922@gmail.com';
$senha = password_hash('andre123', PASSWORD_DEFAULT);
$tipo = 1;

$sql = $db->prepare("INSERT INTO usuarios (cpf, nome_usuario, email, senha, tipo_usuario_idtipo_usuario) VALUES(:cpf, :nome, :email, :senha, :tipo)");
$sql->bindValue(':cpf', $cpf);
$sql->bindValue(':nome', $nome);
$sql->bindValue(':email', $email);
$sql->bindValue(':senha', $senha);
$sql->bindValue(':tipo', $tipo);

if($sql->execute()){
    echo "cadastrado";
}else{
    print_r($sql->errorInfo());
}

?>