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
    $material = filter_input(INPUT_POST, 'material')?1:0;
    $contraCheque = filter_input(INPUT_POST, 'contraCheque')?1:0;
    $xeroxCtps = filter_input(INPUT_POST, 'xeroxCtps')?1:0;
    $devolucaoCtps = filter_input(INPUT_POST, 'devolucaoCtps')?1:0;
    $valeTransporte = filter_input(INPUT_POST, 'valeTransporte')?1:0;
    $planoSaude = filter_input(INPUT_POST, 'planoSaude')?1:0;
    $contratoExperiencia = filter_input(INPUT_POST, 'contratoExperiencia')?1:0;
    $livroAssinado = filter_input(INPUT_POST, 'livroAssinado')?1:0;
    $valorDescontado = filter_input(INPUT_POST, 'valorDesontado')?1:0;
    $verificado1221 = filter_input(INPUT_POST, 'verificado1221')?1:0; 
    $semCarteira = filter_input(INPUT_POST, 'semCarteira')?1:0;
    $recibos = filter_input(INPUT_POST, 'recibos')?1:0;
    $exames = filter_input(INPUT_POST, 'exames')?1:0;
    $cartaDemissao = filter_input(INPUT_POST, 'cartaDemissao')?1:0;
    $ponto = filter_input(INPUT_POST, 'ponto')?1:0;
    $ferias = filter_input(INPUT_POST, 'chip')?1:0;
    $chip = filter_input(INPUT_POST, 'chip')?1:0;
    $assinado1221 = filter_input(INPUT_POST, 'assinado1221')?1:0;
    $planoCancelado = filter_input(INPUT_POST, 'planoCancelado')?1:0;
    $desativado = filter_input(INPUT_POST, 'desativado')?1:0;  

    $db->beginTransaction();

    try{
        $sql = $db->prepare("INSERT INTO checklist_rescisao (nome_funcionario, funcao, admissao, demissao, valor, material, contra_cheque, copia_ctps, devolucao_ctps, vale_transporte, plano_saude, contrato_experiencia, livro_assinado, vales_descontado, tit_aberto, sem_carteira, recibo, exame, carta_demissao, motivo_saida, ponto, ferias, chip, assinada_1221, plano_cancelado, desativado, nome_responsavel) VALUES (:funcionario, :funcao, :admissao, :demissao, :valor, :material, :contra_cheque, :copiaCtps, :devolusaoCtps, :valeTransporte, :planoSaude, :contratoExperiencia, :livroAssinado, :valesDescontado, :titAberto, :semCarteira, :recibo, :exame, :cartaDemissao, :motivoSaida, :ponto, :ferias, :chip, :assinada1221, :planoCancelado, :desativado, :responsavel)");
        $sql->bindValue(':funcionario', $nomeFuncionario);
        $sql->bindValue(':funcao', $funcao);
        $sql->bindValue(':admissao', $admissao);
        $sql->bindValue(':demissao', $demissao);
        $sql->bindValue(':valor', $valorFormt);
        $sql->bindValue(':material', $material);
        $sql->bindValue(':contra_cheque', $contraCheque);
        $sql->bindValue(':copiaCtps', $xeroxCtps);
        $sql->bindValue(':devolusaoCtps', $devolucaoCtps);
        $sql->bindValue(':valeTransporte', $valeTransporte);
        $sql->bindValue(':planoSaude', $planoSaude);
        $sql->bindValue(':contratoExperiencia', $contratoExperiencia);
        $sql->bindValue(':livroAssinado', $livroAssinado);
        $sql->bindValue(':valesDescontado', $valorDescontado);
        $sql->bindValue(':titAberto', $verificado1221);
        $sql->bindValue(':semCarteira', $semCarteira);
        $sql->bindValue(':recibo', $recibos);
        $sql->bindValue(':exame', $exames);
        $sql->bindValue(':cartaDemissao', $cartaDemissao);
        $sql->bindValue(':motivoSaida', $motivoSaida);
        $sql->bindValue(':ponto', $ponto);
        $sql->bindValue(':ferias', $ferias);
        $sql->bindValue(':chip', $chip);
        $sql->bindValue(':assinada1221', $assinado1221);
        $sql->bindValue(':planoCancelado', $planoCancelado);
        $sql->bindValue(':desativado', $desativado);
        $sql->bindValue(':responsavel', $responsavel);
        $sql->execute();

        $db->commit();

        $_SESSION['msg'] = 'Rescisão Lançada com Sucesso!';
        $_SESSION['icon']='success';

    }catch(Exception $e){
        $db->rollBack();
        $_SESSION['msg'] = 'Erro ao Lançar Rescisão!';
        $_SESSION['icon']='error';
    }    

}else{

    $_SESSION['msg'] = 'Acesso não permitido!';
    $_SESSION['icon']='warning';
}
header("Location: form-rescisao.php");
exit(); 
?>