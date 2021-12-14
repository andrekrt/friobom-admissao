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

                $arquivo = 'entradas.xls';

                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> ID </td>';
                $html .= '<td class="text-center font-weight-bold">Data Entrada </td>';
                $html .= '<td class="text-center font-weight-bold"> NF </td>';
                $html .= '<td class="text-center font-weight-bold"> Material/Equipamento </td>';
                $html .= '<td class="text-center font-weight-bold"> Valor Und. </td>';
                $html .= '<td class="text-center font-weight-bold"> Qtd </td>';
                $html .= '<td class="text-center font-weight-bold">Valor Total </td>';
                $html .= '<td class="text-center font-weight-bold"> Fornecedor </td>';
                $html .= '<td class="text-center font-weight-bold">Usuário que Cadastrou</td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM estoque_entradas LEFT JOIN estoque_material ON estoque_entradas.material = estoque_material.idmaterial_estoque LEFT JOIN fornecedores ON estoque_entradas.fornecedores_idfornecedores = fornecedores.idfornecedores LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['idestoque_entradas']. '</td>';
                    $html .= '<td>'. date("d/m/Y", strtotime($dado['data_entrada'])) . '</td>';
                    $html .= '<td>'.$dado['nf']. '</td>';
                    $html .= '<td>'.$dado['descricao_material']. '</td>';
                    $html .= '<td>'. number_format($dado['valor_unit'],1,",",".") . '</td>';
                    $html .= '<td>'. number_format($dado['qtd'],1,",",".") . '</td>';
                    $html .= '<td>'. number_format($dado['valor_total'],1,",",".") . '</td>';
                    $html .= '<td>'.$dado['nome_fantasia']. '</td>';
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