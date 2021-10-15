<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==2 ){

    $idDocumentacao = filter_input(INPUT_POST, 'iddocumento');

    $consultaDoc = $db->prepare("SELECT * FROM documentos_admissao WHERE iddocumentos_admissao = :idDocumentacao");
    $consultaDoc->bindValue(':idDocumentacao', $idDocumentacao);
    $consultaDoc->execute();
    $dados = $consultaDoc->fetch();

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
    
    //arquivos
    $rg = $_FILES['rg']['name']?$_FILES['rg']['name']:$dados['rg'];
    $cpf = $_FILES['cpf']['name']?$_FILES['cpf']['name']:$dados['cpf'];
    $titulo = $_FILES['titulo']['name']?$_FILES['titulo']['name']:$dados['titulo'];
    $cnh =  $_FILES['cnh']['name']? $_FILES['cnh']['name']:$dados['cnh'];
    $reservista =  $_FILES['reservista']['name']? $_FILES['reservista']['name']:$dados['reservista'];
    $comprovanteEndereco =  $_FILES['residencia']['name']?$_FILES['residencia']['name']:$dados['comprovante_endereco'];
    $certidao =  $_FILES['certidao']['name']?$_FILES['certidao']['name']:$dados['certidao'];
    $comprovanteEscolaridade = $_FILES['escolaridade']['name'][0]?$_FILES['escolaridade']['name'][0]:$dados['comprovante_escolaridade'];
    $carteiraVacinacao = $_FILES['carteiraVac']['name']?$_FILES['carteiraVac']['name']:$dados['carteira_vacinacao'];
    $certidaoFilhos = $_FILES['certidaoFilhos']['name']?$_FILES['certidaoFilhos']['name'][0]:$dados['certidao_filhos'];
    $vacinacaoFilhos = $_FILES['vacFilhos']['name']?$_FILES['vacFilhos']['name'][0]:$dados['vacinacao_filhos'];
    $fotos = $_FILES['foto']['name']?$_FILES['foto']['name']:$dados['fotos'];

    /*echo "$idUsuario<br>$data<br>$nome<br>$dataNascimento<br>$sexo<br>$funcao<br>$rota<br>$pis<br>$tipoConta<br>$agencia<br>$conta<br>$varicaoOp<br>$situacao<br>$rg<br>$cpf<br>$titulo<br>$cnh<br>$reservista<br>$comprovanteEndereco<br>$certidao<br> $carteiraVacinacao<br>$fotos<br>";

    print_r($comprovanteEscolaridade);
    print_r($certidaoFilhos);
    print_r($vacinacaoFilhos);*/


    $sql = $db->prepare("UPDATE documentos_admissao SET nome_contratado = :nome, data_nascimento = :dataNasc, sexo = :sexo, funcao = :funcao, rota = :rota, num_pis = :pis, tipo_conta = :tipoConta, agencia = :agencia, conta = :conta, variacao_op = :variacao, rg =:rg, cpf = :cpf, titulo =:titulo, cnh = :cnh, reservista =:reservista, comprovante_endereco = :endereco, certidao = :certidao, comprovante_escolaridade = :escolaridade, carteira_vacinacao = :cartVac, certidao_filhos = :certFilhos, vacinacao_filhos = :vacFilhos, fotos = :foto, situacao = :situacao, obs = :obs WHERE iddocumentos_admissao = :idDocumentos ");
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
    $sql->bindValue(':obs', $obs);

    if($sql->execute()){

        $diretorioPrincipal = "uploads/".$idDocumentacao;
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