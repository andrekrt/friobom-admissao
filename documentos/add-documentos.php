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
    $situacao = 'Em análise';
    
    //arquivos
    $rg = $_FILES['rg']['name'];
    $cpf = $_FILES['cpf']['name']?$_FILES['cpf']['name']:null;
    $titulo = $_FILES['titulo']['name'];
    $cnh =  $_FILES['cnh']['name']? $_FILES['cnh']['name']:null;
    $reservista =  $_FILES['reservista']['name']? $_FILES['reservista']['name']:null;
    $comprovanteEndereco =  $_FILES['residencia']['name'];
    $certidao =  $_FILES['certidao']['name'];
    $comprovanteEscolaridade = $_FILES['escolaridade']['name'][0];
    $carteiraVacinacao = $_FILES['carteiraVac']['name'];
    $certidaoFilhos = $_FILES['certidaoFilhos']['name']?$_FILES['certidaoFilhos']['name'][0]:null;
    $vacinacaoFilhos = $_FILES['vacFilhos']['name']?$_FILES['vacFilhos']['name'][0]:null;
    $fotos = $_FILES['foto']['name'];

    /*echo "$idUsuario<br>$data<br>$nome<br>$dataNascimento<br>$sexo<br>$funcao<br>$rota<br>$pis<br>$tipoConta<br>$agencia<br>$conta<br>$varicaoOp<br>$situacao<br>$rg<br>$cpf<br>$titulo<br>$cnh<br>$reservista<br>$comprovanteEndereco<br>$certidao<br> $carteiraVacinacao<br>$fotos<br>";

    print_r($comprovanteEscolaridade);
    print_r($certidaoFilhos);
    print_r($vacinacaoFilhos);*/


    $sql = $db->prepare("INSERT INTO documentos_admissao (data_envio, nome_contratado, data_nascimento, sexo, funcao, rota, num_pis, tipo_conta, agencia, conta, variacao_op, rg, cpf, titulo, cnh, reservista, comprovante_endereco, certidao, comprovante_escolaridade, carteira_vacinacao, certidao_filhos, vacinacao_filhos, fotos, situacao, usuarios_idusuarios) VALUES (:dataEnvio, :nome, :dataNasc, :sexo, :funcao, :rota, :pis, :tipoConta, :agencia, :conta, :variacao, :rg, :cpf, :titulo, :cnh, :reservista, :endereco, :certidao, :escolaridade, :cartVac, :certFilhos, :vacFilhos, :foto, :situacao, :usuario)");
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
    $sql->bindValue(':rg', $rg);
    $sql->bindValue(':cpf', $cpf);
    $sql->bindValue(':titulo', $titulo);
    $sql->bindValue(':cnh', $cnh);
    $sql->bindValue(':reservista', $reservista);
    $sql->bindValue(':endereco', $comprovanteEndereco);
    $sql->bindValue(':certidao', $certidao);
    $sql->bindValue(':escolaridade', $comprovanteEscolaridade);
    $sql->bindValue(':cartVac', $carteiraVacinacao);
    $sql->bindValue(':certFilhos', $certidaoFilhos);
    $sql->bindValue(':vacFilhos', $vacinacaoFilhos);
    $sql->bindValue(':foto', $fotos);
    $sql->bindValue(':situacao', $situacao);
    $sql->bindValue(':usuario', $idUsuario);

    if($sql->execute()){
        $ultimoId = $db->lastInsertId();

        $diretorioPrincipal = "uploads/".$ultimoId;
        mkdir($diretorioPrincipal,0755);
        $anexoRg = $_FILES['rg'];
        $destinoRg = $diretorioPrincipal."/". $rg;
        move_uploaded_file($anexoRg['tmp_name'],$destinoRg);

        $anexoCpf = $_FILES['cpf'];
        $destinoCpf = $diretorioPrincipal."/". $cpf;
        move_uploaded_file($anexoCpf['tmp_name'],$destinoCpf);

        $anexoTitulo = $_FILES['titulo'];
        $destinoTitulo = $diretorioPrincipal."/".$titulo;
        move_uploaded_file($anexoTitulo['tmp_name'],$destinoTitulo);

        $anexoCnh = $_FILES['cnh'];
        $destinoCnh = $diretorioPrincipal."/". $cnh;
        move_uploaded_file($anexoCnh['tmp_name'],$destinoCnh);

        $anexoReservista = $_FILES['reservista'];
        $destinoReservista = $diretorioPrincipal."/". $reservista;
        move_uploaded_file($anexoReservista['tmp_name'],$destinoReservista);

        $anexoEndereco = $_FILES['residencia'];
        $destinoEndereco = $diretorioPrincipal."/". $comprovanteEndereco;
        move_uploaded_file($anexoEndereco['tmp_name'],$destinoEndereco);

        $anexoCertidao = $_FILES['certidao'];
        $destinoCertidao = $diretorioPrincipal."/". $certidao;
        move_uploaded_file($anexoCertidao['tmp_name'],$destinoCertidao);

        $anexoEscolaridade = $_FILES['escolaridade'];
        for($i=0;$i<count($anexoEscolaridade['name']);$i++){
            $destinoEscolaridade = $diretorioPrincipal."/". $anexoEscolaridade['name'][$i];
            move_uploaded_file($anexoEscolaridade['tmp_name'][$i],$destinoEscolaridade);
        }

        $anexoVacincao = $_FILES['carteiraVac'];
        $destinoVacinacao = $diretorioPrincipal."/". $carteiraVacinacao;
        move_uploaded_file($anexoVacincao['tmp_name'],$destinoVacinacao);

        $anexoVacincao = $_FILES['carteiraVac'];
        $destinoVacinacao = $diretorioPrincipal."/". $carteiraVacinacao;
        move_uploaded_file($anexoVacincao['tmp_name'],$destinoVacinacao);
        
        $anexoCertidaoFilhos = $_FILES['certidaoFilhos'];
        for($i=0;$i<count($anexoCertidaoFilhos['name']);$i++){
            $destinoCertidaoFilhos = $diretorioPrincipal."/". $anexoCertidaoFilhos['name'][$i];
            move_uploaded_file($anexoCertidaoFilhos['tmp_name'][$i],$destinoCertidaoFilhos);
        }

        $anexoVacFilhos = $_FILES['vacFilhos'];
        for($i=0;$i<count($anexoVacFilhos['name']);$i++){
            $destinoVacFilhos = $diretorioPrincipal."/". $anexoVacFilhos['name'][$i];
            move_uploaded_file($anexoVacFilhos['tmp_name'][$i],$destinoVacFilhos);
        }

        $anexoFoto= $_FILES['foto'];
        $destinoFoto = $diretorioPrincipal."/". $fotos;
        move_uploaded_file($anexoFoto['tmp_name'],$destinoFoto);

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