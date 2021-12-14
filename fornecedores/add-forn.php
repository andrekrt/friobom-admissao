<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1 ){

    $idUsuario = $_SESSION['idUsuario'];
    $razaoSocial = filter_input(INPUT_POST, 'razaoSocial');
    $endereco = filter_input(INPUT_POST, 'endereco');
    $bairro = filter_input(INPUT_POST, 'bairro');
    $cidade = filter_input(INPUT_POST, 'cidade');
    $cep = filter_input(INPUT_POST, 'cep');
    $uf = filter_input(INPUT_POST, 'estado');
    $cnpj = filter_input(INPUT_POST, 'cnpj');
    $nome_fantasia = filter_input(INPUT_POST, 'nomeFantasia');
    $telefone = filter_input(INPUT_POST, 'telefone');

    $verificaCnpj = $db->prepare("SELECT * FROM fornecedores WHERE cnpj = :cnpj");
    $verificaCnpj->bindValue(':cnpj', $cnpj);
    $verificaCnpj->execute();
    if($verificaCnpj->rowCount()>0){

        echo "<script>alert('Esse Fornecedor já está cadastrado!');</script>";
        echo "<script>window.location.href='fornecedores.php'</script>";

    }else{

        $inserir = $db->prepare("INSERT INTO fornecedores (razao_social, endereco, bairro, cidade, cep, uf, cnpj, nome_fantasia, telefone, usuarios_idusuarios) VALUES (:razaosocial, :endereco, :bairro, :cidade, :cep, :uf, :cnpj, :nomeFantasia, :telefone, :usuarios)");
        $inserir->bindValue(':razaosocial', $razaoSocial);
        $inserir->bindValue(':endereco', $endereco);
        $inserir->bindValue(':bairro', $bairro);
        $inserir->bindValue(':cidade', $cidade);
        $inserir->bindValue(':cep', $cep);
        $inserir->bindValue(':uf', $uf);
        $inserir->bindValue(':cnpj', $cnpj);
        $inserir->bindValue(':nomeFantasia', $nome_fantasia);
        $inserir->bindValue(':telefone', $telefone);
        $inserir->bindValue(':usuarios', $idUsuario);

        if($inserir->execute()){
            echo "<script>alert('Fornecedor Cadastrado com Sucesso!');</script>";
            echo "<script>window.location.href='fornecedores.php'</script>";
        }else{
            print_r($inserir->errorInfo());
        }

    }

    

}

?>