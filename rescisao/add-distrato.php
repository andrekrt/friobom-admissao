<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 ){

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

    // echo "$nomeFuncionario<br>$funcao<br>$admissao<br>$demissao<br>$valorFormt<br>";
    // echo "$distrato<br>$nfs<br>$planoSaude<br>$contrato<br>$valorDescontado<br>$verificado1221<br>$motivoSaida<br>$chip<br>$assinado1221<br>$planoCancelado<br>$desativado";

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

    if($sql->execute()){
        echo "<script>alert('Distrato Lançado!');</script>";
        echo "<script>window.location.href='form-distrato.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }

}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>