<?php

session_start();
require("../conexao.php");

$tipoUsuario = $_SESSION['tipoUsuario'];

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Peças</title>
    </head>
    <body>
        <?php
        
            if($tipoUsuario==1){

                $arquivo = 'saidas.xls';

                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> ID </td>';
                $html .= '<td class="text-center font-weight-bold">Data Saída </td>';
                $html .= '<td class="text-center font-weight-bold"> Material/Equipamento </td>';
                $html .= '<td class="text-center font-weight-bold"> Qtd </td>';
                $html .= '<td class="text-center font-weight-bold">Solicitante </td>';
                $html .= '<td class="text-center font-weight-bold"> Obs </td>';
                $html .= '<td class="text-center font-weight-bold">Usuário que Cadastrou</td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM estoque_saidas LEFT JOIN estoque_material ON estoque_saidas.material = estoque_material.idmaterial_estoque LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idestoque_saidas']. '</td>';
                    $html .= '<td>'. date("d/m/Y", strtotime($dado['data_saida'])) . '</td>';
                    $html .= '<td>'.$dado['descricao_material']. '</td>';
                    $html .= '<td>'. number_format($dado['qtd'],1,",",".") . '</td>';
                    $html .= '<td>'. $dado['solicitante']. '</td>';
                    $html .= '<td>'.$dado['obs']. '</td>';
                    $html .= '<td>'.$dado['nome_usuario']. '</td>';
                    $html .= '</tr>';

                }

                $html .= '</table>';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$arquivo.'"');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');

                echo $html;
                
            }

        ?>
    </body>
</html>