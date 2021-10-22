<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==2 ){

    $idDocumentacao = filter_input(INPUT_POST, 'iddocumento');

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
    $situacao = filter_input(INPUT_POST, 'situacao');
    $obs = filter_input(INPUT_POST, 'obs');
    $documentos = "Anexo";
    $documentosAnexos = $_FILES['documentos'];

    /*echo "$idUsuario<br>$data<br>$nome<br>$dataNascimento<br>$sexo<br>$funcao<br>$rota<br>$pis<br>$tipoConta<br>$agencia<br>$conta<br>$varicaoOp<br>$situacao<br>$rg<br>$cpf<br>$titulo<br>$cnh<br>$reservista<br>$comprovanteEndereco<br>$certidao<br> $carteiraVacinacao<br>$fotos<br>";

    print_r($comprovanteEscolaridade);
    print_r($certidaoFilhos);
    print_r($vacinacaoFilhos);*/


    $sql = $db->prepare("UPDATE documentos_admissao SET nome_contratado = :nome, data_nascimento = :dataNasc, sexo = :sexo, funcao = :funcao, rota = :rota, num_pis = :pis, tipo_conta = :tipoConta, agencia = :agencia, conta = :conta, variacao_op = :variacao, documentos = :documentos, situacao = :situacao, obs = :obs WHERE iddocumentos_admissao = :idDocumentos ");
    $sql->bindValue(':idDocumentos', $idDocumentacao);
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
    $sql->bindValue(':documentos', $documentos);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':obs', $obs);

    if($sql->execute()){

        $diretorioPrincipal = "uploads/".$idDocumentacao;

        for($i=0;$i<count($documentosAnexos['name']);$i++){
            $destino = $diretorioPrincipal."/". $documentosAnexos['name'][$i];
            move_uploaded_file($documentosAnexos['tmp_name'][$i],$destino);
        }

        echo "<script>alert('Atualizado!');</script>";
        echo "<script>window.location.href='documentos.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }



}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>