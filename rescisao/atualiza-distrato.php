<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99)){

    $id = filter_input(INPUT_POST, 'id');
    $nomeFuncionario = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $admissao = filter_input(INPUT_POST, 'admissao');
    $demissao = filter_input(INPUT_POST, 'demissao');
    $valorFormt = str_replace(",", ".", filter_input(INPUT_POST, 'valor'));
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
        $sql = $db->prepare("UPDATE checklist_distrato SET nome_funcionario=:funcionario, funcao=:funcao, admissao=:admissao, demissao=:demissao, valor=:valor, motivo_saida=:motivo, nome_responsavel=:responsavel, distrato=:distrato, nfs=:nfs, plano_saude=:planoSaude, contrato=:contrato, descontado=:descontado, debito=:debito, desativado=:desativado, chip=:chip, assinada_1221=:assinado1221, plano_cancelado=:planoCancelado WHERE iddistrato = :id");
        $sql->bindValue(':funcionario', $nomeFuncionario);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':admissao', $admissao);
        $sql->bindValue(':demissao', $demissao);
        $sql->bindValue(':valor', $valorFormt);
        $sql->bindValue(':motivo', $motivoSaida);
        $sql->bindValue(':responsavel', $responsavel);
        $sql->bindValue(':distrato', $distrato);
        $sql->bindValue(':nfs', $nfs);
        $sql->bindValue(':planoSaude', $planoSaude);
        $sql->bindValue(':contrato', $contrato);
        $sql->bindValue(':descontado', $valorDescontado);
        $sql->bindValue(':debito', $verificado1221);
        $sql->bindValue(':desativado', $desativado);
        $sql->bindValue(':chip', $chip);
        $sql->bindValue(':assinado1221', $assinado1221);
        $sql->bindValue(':planoCancelado', $planoCancelado);
        $sql->bindValue(':id', $id);
        $sql->execute();
        
        $db->commit();

        $_SESSION['msg'] = 'Distrato Atualizado com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Atualizar Distrato!';
        $_SESSION['icon']='error';
    }

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';

}
header("Location: distratos.php");
exit(); 
?>