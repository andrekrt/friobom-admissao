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

                $arquivo = 'estoque.xls';

                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> ID </td>';
                $html .= '<td class="text-center font-weight-bold">Material/Equipamento </td>';
                $html .= '<td class="text-center font-weight-bold"> Grupo </td>';
                $html .= '<td class="text-center font-weight-bold"> Medida </td>';
                $html .= '<td class="text-center font-weight-bold"> Estoque Mínimo </td>';
                $html .= '<td class="text-center font-weight-bold"> Total Entradas </td>';
                $html .= '<td class="text-center font-weight-bold"> Total Saídas </td>';
                $html .= '<td class="text-center font-weight-bold"> Total Estoque </td>';
                $html .= '<td class="text-center font-weight-bold"> Valor Comprado</td>';
                $html .= '<td class="text-center font-weight-bold"> Situação </td>';
                $html .= '<td class="text-center font-weight-bold"> Data Cadastro </td>';
                $html .= '<td class="text-center font-weight-bold">Usuário que Cadastrou</td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM estoque_material LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idmaterial_estoque']. '</td>';
                    $html .= '<td>'.$dado['descricao_material']. '</td>';
                    $html .= '<td>'.$dado['grupo_material']. '</td>';
                    $html .= '<td>'.$dado['un_medida']. '</td>';
                    $html .= '<td>'. number_format($dado['estoque_minimo'],1,",",".") . '</td>';
                    $html .= '<td>'. number_format($dado['total_entrada'],1,",",".") . '</td>';
                    $html .= '<td>'. number_format($dado['total_saida'],1,",",".") . '</td>';
                    $html .= '<td>'. number_format($dado['total_estoque'],1,",","."). '</td>';
                    $html .= '<td>'. number_format($dado['valor_total'],2,",",".") . '</td>';
                    $html .= '<td>'.$dado['situacao']. '</td>';
                    $html .= '<td>'.date("d/m/Y",strtotime($dado['data_cadastro'])).  '</td>';
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