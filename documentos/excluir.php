<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1 ){
    $idDocumento = filter_input(INPUT_GET, 'idDocumento');

    $delete = $db->prepare("DELETE FROM documentos_admissao WHERE iddocumentos_admissao = :iddocumento ");
    $delete->bindValue(':iddocumento', $idDocumento);

    if($delete->execute()){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='documentos.php' </script>";
    }else{
        print_r($delete->errorInfo());
    }

}else{
    echo "<script> alert('Acesso não permitido!')</script>";
        echo "<script> window.location.href='usuarios.php' </script>";
}

?>