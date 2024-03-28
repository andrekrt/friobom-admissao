<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99) ){

    $nomeFuncionario = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $admissao = filter_input(INPUT_POST, 'admissao');
    $demissao = filter_input(INPUT_POST, 'demissao');
    $valor = str_replace(".","",filter_input(INPUT_POST, 'valor')) ;
    $valorFormt = str_replace(",", ".", $valor);
    $motivoSaida = filter_input(INPUT_POST, 'motivoSaida');
    $responsavel = filter_input(INPUT_POST, 'responsavel');

    // checkbox
    $distrato = filter_input(INPUT_POST, 'distrato')?1:0;
    $nfs = filter_input(INPUT_POST, 'nf')?1:0;
    $planoSaude = filter_input(INPUT_POST, 'planoSaude')?1:0;
    $contrato = filter_input(INPUT_POST, 'contrato')?1:0;
    $valorDescontado = filter_input(INPUT_POST, 'valorDescontado')?1:0;
    $verificado1221 = filter_input(INPUT_POST, 'verificado1221')?1:0; 
    $desativado = filter_input(INPUT_POST, 'desativado')?1:0;  
    $chip = filter_input(INPUT_POST, 'chip')?1:0;
    $assinado1221 = filter_input(INPUT_POST, 'assinado1221')?1:0;
    $planoCancelado = filter_input(INPUT_POST, 'planoCancelado')?1:0;    

    $db->beginTransaction();

    try{
        $sql = $db->prepare("INSERT INTO checklist_distrato (nome_funcionario, funcao, admissao, demissao, valor, motivo_saida, nome_responsavel, distrato, nfs, plano_saude, contrato, descontado, debito, desativado, chip, assinada_1221, plano_cancelado) VALUES (:funcionario, :funcao, :admissao, :demissao, :valor, :motivoSaida, :responsavel, :distrato, :nfs, :planoSaude, :contrato, :desconto, :debito, :desativado, :chip, :assinada1221, :planoCancelado)");
        $sql->bindValue(':funcionario', $nomeFuncionario);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':admissao', $admissao);
        $sql->bindValue(':demissao', $demissao);
        $sql->bindValue(':valor', $valorFormt);
        $sql->bindValue(':motivoSaida', $motivoSaida);
        $sql->bindValue(':responsavel', $responsavel);
        $sql->bindValue(':distrato', $distrato);
        $sql->bindValue(':nfs', $nfs);
        $sql->bindValue(':planoSaude', $planoSaude);
        $sql->bindValue(':contrato', $contrato);
        $sql->bindValue(':desconto', $valorDescontado);
        $sql->bindValue(':debito', $verificado1221);
        $sql->bindValue(':desativado', $desativado);
        $sql->bindValue(':chip', $chip);
        $sql->bindValue(':assinada1221', $assinado1221);
        $sql->bindValue(':planoCancelado', $planoCancelado);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Distrato Lançada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Lançar Distrato!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: form-distrato.php");
exit(); 
?>