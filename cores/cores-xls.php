<?php

session_start();
require("../conexao.php");



if (isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] <> 2)   ) {

    $db->exec("set names utf8");
    $sql = $db->query("SELECT * FROM cores LEFT JOIN supervisores ON cores.supervisor=supervisores.idsupervisor LEFT JOIN rotas ON cores.rota=rotas.cod_rota LEFT JOIN usuarios ON cores.usuario=usuarios.idusuarios");

    header('Content-Type:text/csv; charset=UTF-8');
    header('Content-Disposition: attachement; filename=cores.csv');

    $arquivo = fopen("php://output", "w");

    $cabacelho = [
        "ID",
        "Nome",
        "CNPJ",
        "RCA",
        "Supervisor",
        "Rota",
        "Tipo de Contrato",
        mb_convert_encoding('Data de Emissão','ISO-8859-1', 'UTF-8'),
        "Validade",
        mb_convert_encoding('Situação','ISO-8859-1', 'UTF-8'),
        mb_convert_encoding('Usuário','ISO-8859-1', 'UTF-8'),
    ];
    
    fputcsv($arquivo, $cabacelho, ';');

    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach($dados as $dado){

        $diferencaDias = (strtotime($dado['data_validade'])-strtotime(date('Y-m-d'))) / (60*60*24);
        if($diferencaDias>30){
            $situacao = "Dentro do Prazo";
        }elseif($diferencaDias<=30 && $diferencaDias>=0){
            $situacao = "Vencimento Próximo";
        }else{
            $situacao = "Vencida";
        }

        fwrite($arquivo, 
            "$dado[id];".mb_convert_encoding($dado['nome'],'ISO-8859-1', 'UTF-8').";".$dado['cnpj']."; $dado[rca];". mb_convert_encoding($dado['nome_supervisor'],'ISO-8859-1', 'UTF-8').";".mb_convert_encoding($dado['nome_rota'],'ISO-8859-1', 'UTF-8') .";" .mb_convert_encoding($dado['tipo_contrato'],'ISO-8859-1', 'UTF-8') . ";".date("d/m/Y", strtotime($dado['data_emissao'])).";".date("d/m/Y", strtotime($dado['data_validade'])).";".$situacao . ";". mb_convert_encoding($dado['nome_usuario'],'ISO-8859-1', 'UTF-8') ."\n"
        );

        // fputcsv($arquivo, mb_convert_encoding($dado,'ISO-8859-1', 'UTF-8') , ';');
    }

    fclose($arquivo);
}


