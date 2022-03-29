<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1){

    $id = filter_input(INPUT_POST, 'id');
    $nomeFuncionario = filter_input(INPUT_POST, 'nome');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $admissao = filter_input(INPUT_POST, 'admissao');
    $demissao = filter_input(INPUT_POST, 'demissao');
    $valorFormt = str_replace(",", ".", filter_input(INPUT_POST, 'valor'));
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
 
    /*echo "$nomeFuncionario<br>$funcao<br>$admissao<br>$demissao<br>$valorFormt<br>$id<br><br>";
    echo "$material<br>$contraCheque<br>$xeroxCtps<br>$devolucaoCtps<br>$valeTransporte<br>$planoSaude<br>$contratoExperiencia<br>$livroAssinado<br>$valorDescontado<br>$verificado1221<br>$semCarteira<br>$recibos<br>$exames<br>$cartaDemissao<br>$motivoSaida<br>$ponto<br>$ferias<br>$chip<br>$assinado1221<br>$planoCancelado<br>$desativado<br>$responsavel";*/

    $sql = $db->prepare("UPDATE checklist_rescisao SET nome_funcionario = :funcionario, funcao = :funcao, admissao = :admissao, demissao = :demissao, valor = :valor, material = :material, contra_cheque = :contra_cheque, copia_ctps = :copiaCtps, devolucao_ctps = :devolucaoCtps, vale_transporte = :valeTransporte, plano_saude = :planoSaude, contrato_experiencia = :contratoExperiencia, livro_assinado = :livroAssinado, vales_descontado = :valesDescontado, tit_aberto = :titAberto, sem_carteira = :semCarteira, recibo = :recibo, exame = :exame, carta_demissao = :cartaDemissao, motivo_saida = :motivoSaida, ponto = :ponto, ferias = :ferias, chip = :chip, assinada_1221 = :assinada1221, plano_cancelado = :planoCancelado, desativado = :desativado, nome_responsavel = :responsavel WHERE idchecklist_rescisao = :id");
    $sql->bindValue(':funcionario', $nomeFuncionario);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':admissao', $admissao);
    $sql->bindValue(':demissao', $demissao);
    $sql->bindValue(':valor', $valorFormt);
    $sql->bindValue(':material', $material);
    $sql->bindValue(':contra_cheque', $contraCheque);
    $sql->bindValue(':copiaCtps', $xeroxCtps);
    $sql->bindValue(':devolucaoCtps', $devolucaoCtps);
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
    $sql->bindValue(':id', $id);

    if($sql->execute()){
        echo "<script>alert('Rescisão Atualizada!');</script>";
        echo "<script>window.location.href='rescisoes.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>