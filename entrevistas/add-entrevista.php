<?php

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1 ){

    $nome = filter_input(INPUT_POST, 'nome' );
    $vaga = filter_input(INPUT_POST, 'vaga');
    $processo = filter_input(INPUT_POST, 'processo');
    $referencia = filter_input(INPUT_POST, 'referencia');
    $entrevistou = filter_input(INPUT_POST, 'entrevistou');
    $teste = filter_input(INPUT_POST, 'teste');
    $obs = filter_input(INPUT_POST, 'obs');
    $usuario = $_SESSION['idUsuario'];

    // echo "$nome<br>$vaga<br>$processo<br>$referencia<br>$entrevistou<br>$teste<br>$obs<br>$usuario";


    $sql = $db->prepare("INSERT INTO entrevistas (nome_candidato, vaga, processo, referencia, entrevistado, passou, obs, usuario) VALUES(:nome, :vaga, :processo, :referencia, :entrevistado, :passou, :obs, :usuario)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':vaga', $vaga);
    $sql->bindValue(':processo', $processo);
    $sql->bindValue(':referencia', $referencia);
    $sql->bindValue(':entrevistado', $entrevistou);
    $sql->bindValue(':passou', $teste);
    $sql->bindValue(':obs', $obs);
    $sql->bindValue(':usuario', $usuario);

    if($sql->execute()){
        echo "<script>alert('Entrevista Registrada');</script>";
        echo "<script>window.location.href='entrevistas.php'</script>";

    }else{
        print_r($sql->errorInfo());
    }



}else{

    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";

}

?>