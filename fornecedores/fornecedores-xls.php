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

                $arquivo = 'fornecedores.xls';

                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> CNPJ </td>';
                $html .= '<td class="text-center font-weight-bold">Razão Social </td>';
                $html .= '<td class="text-center font-weight-bold"> Nome Fantasia </td>';
                $html .= '<td class="text-center font-weight-bold"> Endereço </td>';
                $html .= '<td class="text-center font-weight-bold">Bairro </td>';
                $html .= '<td class="text-center font-weight-bold"> Cidade </td>';
                $html .= '<td class="text-center font-weight-bold"> CEP </td>';
                $html .= '<td class="text-center font-weight-bold"> Estado </td>';
                $html .= '<td class="text-center font-weight-bold"> Telefone</td>';
                $html .= '<td class="text-center font-weight-bold">Usuário que Cadastrou</td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT * FROM fornecedores LEFT JOIN usuarios ON fornecedores.usuarios_idusuarios = usuarios.idusuarios");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){

                    $html .= '<tr>';
                    $html .= '<td>'.$dado['cnpj']. '</td>';
                    $html .= '<td>'.$dado['razao_social']. '</td>';
                    $html .= '<td>'.$dado['endereco']. '</td>';
                    $html .= '<td>'.$dado['bairro']. '</td>';
                    $html .= '<td>'. $dado['cidade'] . '</td>';
                    $html .= '<td>'. $dado['cep'] . '</td>';
                    $html .= '<td>'. $dado['uf'] . '</td>';
                    $html .= '<td>'.$dado['cnpj']. '</td>';
                    $html .= '<td>'. $dado['nome_fantasia'] . '</td>';
                    $html .= '<td>'.$dado['telefone']. '</td>';
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