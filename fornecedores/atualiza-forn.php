<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1 ){

    $razaoSocial = filter_input(INPUT_POST, 'razaoSocial');
    $endereco = filter_input(INPUT_POST, 'endereco');
    $bairro = filter_input(INPUT_POST, 'bairro');
    $cidade = filter_input(INPUT_POST, 'cidade');
    $cep = filter_input(INPUT_POST, 'cep');
    $uf = filter_input(INPUT_POST, 'estado');
    $cnpj = filter_input(INPUT_POST, 'cnpj');
    $nome_fantasia = filter_input(INPUT_POST, 'nomeFantasia');
    $telefone = filter_input(INPUT_POST, 'telefone');
    $id = filter_input(INPUT_POST, 'id');

    $atualiza = $db->prepare("UPDATE fornecedores SET razao_social = :razaoSocial, endereco = :endereco, bairro = :bairro, cidade = :cidade, cep = :cep, uf = :uf, cnpj = :cnpj, nome_fantasia = :fantasia, telefone = :telefone WHERE idfornecedores = :idForn");
    $atualiza->bindValue(':razaoSocial', $razaoSocial);
    $atualiza->bindValue(':endereco', $endereco);
    $atualiza->bindValue(':bairro', $bairro);
    $atualiza->bindValue(':cidade', $cidade);
    $atualiza->bindValue(':cep', $cep);
    $atualiza->bindValue(':uf', $uf);
    $atualiza->bindValue(':cnpj', $cnpj);
    $atualiza->bindValue(':fantasia', $nome_fantasia);
    $atualiza->bindValue(':telefone', $telefone);
    $atualiza->bindValue(':idForn', $id);

    if($atualiza->execute()){
        echo "<script> alert('Atualizado com Sucesso!')</script>";
        echo "<script> window.location.href='fornecedores.php' </script>";
    }else{
        print_r($atualiza->errorInfo());
    }

}else{

}

?>