<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2) ){

    $idUsuario = $_SESSION['idUsuario'];
    $nome = filter_input(INPUT_POST, 'nome');
    $cnpj = filter_input(INPUT_POST, 'cnpj' );
    $rca = filter_input(INPUT_POST, 'rca');
    $emissao = filter_input(INPUT_POST, 'emissao');
    $validade = filter_input(INPUT_POST, 'validade');
    $supervisor = filter_input(INPUT_POST, 'supervisor');
    $rota = filter_input(INPUT_POST, 'rota');
    $tipoContrato = filter_input(INPUT_POST, 'tipo');
    $anexos = $_FILES['anexos'];
    $id = filter_input(INPUT_POST, 'id');

    $db->beginTransaction();

    try{
        $sql = $db->prepare("UPDATE cores SET cnpj=:cnpj, nome=:nome, tipo_contrato=:tipo, data_emissao=:emissao, data_validade=:validade, rca=:rca, supervisor=:supervisor, rota=:rota, usuario=:usuario WHERE id=:id");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':cnpj', $cnpj);
        $sql->bindValue(':tipo', $tipoContrato);
        $sql->bindValue(':emissao', $emissao);
        $sql->bindValue(':validade', $validade);
        $sql->bindValue(':rca', $rca);
        $sql->bindValue(':supervisor',$supervisor);
        $sql->bindValue(':rota',$rota);
        $sql->bindValue(':usuario', $idUsuario);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount()>0){
            $pasta = "uploads/$id";
            if(!file_exists($pasta)){
                mkdir($pasta,0777,true);
            }
            for($i=0;$i<count($anexos['tmp_name']);$i++){
                $nomeArquivo = $anexos['name'][$i];
                $caminhoArquivo =$pasta . "/" . $nomeArquivo;

                move_uploaded_file($anexos['tmp_name'][$i], $caminhoArquivo);
            }
           
        }

        $db->commit();

        $_SESSION['msg'] = 'Core Atualizado com Sucesso!';
        $_SESSION['icon']='success';
        
    }catch(PDOException $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Core!';
        $_SESSION['icon']='error';
        echo $e;
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: listar.php");
exit(); 
?>