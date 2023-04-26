<?php

session_start();
require("../conexao.php");

if($_SESSION['tipoUsuario'] == 1 ){

    $db->exec("set names utf8");
    $sql = $db->query("SELECT iddistrato, nome_funcionario, funcao, admissao, demissao, valor, motivo_saida FROM checklist_distrato");

    header('Content-Type:text/csv; charset=UTF-8');
    header('Content-Disposition: attachement; filename=distratos.csv');

    $arquivo = fopen("php://output", "w");

    $cabacelho = [
        mb_convert_encoding('Código','ISO-8859-1', 'UTF-8'),
        mb_convert_encoding('Funcionário','ISO-8859-1', 'UTF-8'),
        mb_convert_encoding('Função','ISO-8859-1', 'UTF-8'),
        mb_convert_encoding('Admissão','ISO-8859-1', 'UTF-8'),
        mb_convert_encoding('Demissão','ISO-8859-1', 'UTF-8'),
        "Valor",
        mb_convert_encoding('Motivo de Saída','ISO-8859-1', 'UTF-8'),
    ];
    
    fputcsv($arquivo, $cabacelho, ';');

    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach($dados as $dado){
        fputcsv($arquivo, mb_convert_encoding(str_replace(".",",",$dado) ,'ISO-8859-1', 'UTF-8') , ';');
    }

    fclose($arquivo);
}