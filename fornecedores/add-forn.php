<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario']==1 || $_SESSION['tipoUsuario']==99) ){

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

    $db->beginTransaction();

    try{
        $verificaCnpj = $db->prepare("SELECT * FROM fornecedores WHERE cnpj = :cnpj");
        $verificaCnpj->bindValue(':cnpj', $cnpj);
        $verificaCnpj->execute();
        if($verificaCnpj->rowCount()>0){

            $_SESSION['msg'] = 'Esse Fornecedor já está cadastrado!';
            $_SESSION['icon']='warning';
            header("Location: fornecedores.php");
            exit(); 

        }

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
        $inserir->execute();

        $db->commit();

        $_SESSION['msg'] = 'Fornecedor Cadastrado com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Cadastrar Material!';
        $_SESSION['icon']='error';
    }

}else{
    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: fornecedores.php");
exit(); 
?>