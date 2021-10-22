<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==2 ){

    $idUsuario = $_SESSION['idUsuario'];
    $data = date("Y-m-d H:i:s");
    $nome = filter_input(INPUT_POST, 'nome' );
    $dataNascimento = filter_input(INPUT_POST, 'dataNasc');
    $sexo = filter_input(INPUT_POST, 'sexo');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $rota = filter_input(INPUT_POST, 'rota');
    $pis = filter_input(INPUT_POST, 'pis');
    $tipoConta = filter_input(INPUT_POST, 'tipoConta');
    $agencia = filter_input(INPUT_POST, 'agencia');
    $conta = filter_input(INPUT_POST, 'conta');
    $varicaoOp = filter_input(INPUT_POST, 'variacao')?filter_input(INPUT_POST, 'variacao'):null;
    $documentosNome = "Anexos";
    $situacao = 'Em análise';
    $anexoDocumentos = $_FILES['documentos'];

    /*echo "$idUsuario<br>$data<br>$nome<br>$dataNascimento<br>$sexo<br>$funcao<br>$rota<br>$pis<br>$tipoConta<br>$agencia<br>$conta<br>$varicaoOp<br>$situacao<br>$rg<br>$cpf<br>$titulo<br>$cnh<br>$reservista<br>$comprovanteEndereco<br>$certidao<br> $carteiraVacinacao<br>$fotos<br>";

    print_r($comprovanteEscolaridade);
    print_r($certidaoFilhos);
    print_r($vacinacaoFilhos);*/


    $sql = $db->prepare("INSERT INTO documentos_admissao (data_envio, nome_contratado, data_nascimento, sexo, funcao, rota, num_pis, tipo_conta, agencia, conta, variacao_op, documentos, situacao, usuarios_idusuarios) VALUES (:dataEnvio, :nome, :dataNasc, :sexo, :funcao, :rota, :pis, :tipoConta, :agencia, :conta, :variacao, :documentos, :situacao, :usuario)");
    $sql->bindValue(':dataEnvio', $data);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':dataNasc', $dataNascimento);
    $sql->bindValue(':sexo', $sexo);
    $sql->bindValue(':funcao', $funcao);
    $sql->bindValue(':rota', $rota);
    $sql->bindValue(':pis', $pis);
    $sql->bindValue(':tipoConta', $tipoConta);
    $sql->bindValue(':agencia', $agencia);
    $sql->bindValue(':conta', $conta);
    $sql->bindValue(':variacao', $varicaoOp);
    $sql->bindValue(':documentos', $documentosNome);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':usuario', $idUsuario);

    if($sql->execute()){
        $ultimoId = $db->lastInsertId();
        $diretorioPrincipal = "uploads/".$ultimoId;
        mkdir($diretorioPrincipal,0755);
        for($i=0;$i<count($anexoDocumentos['name']);$i++){
            $destinoDocumentos = $diretorioPrincipal."/". $anexoDocumentos['name'][$i];
            move_uploaded_file($anexoDocumentos['tmp_name'][$i],$destinoDocumentos);
        }

        

        echo "<script>alert('Documentação Enviada!');</script>";
        echo "<script>window.location.href='form-documentos.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }



}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>