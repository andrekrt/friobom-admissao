<?php

session_start();
require("../conexao.php");

$tipoUsuario = $_SESSION['tipoUsuario'];
        
    if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==2){

        $arquivo = 'rescisoes.xls';

        $html = '';
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Código') .'</td>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Funcionário'). '</td>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Função') .'</td>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Admissão').'  </td>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Demissão').'  </td>';
        $html .= '<td class="text-center font-weight-bold"> Valor</td>';
        $html .= '<td class="text-center font-weight-bold">'. utf8_decode('Motivo de Saída').'</td>';
        $html .= '</tr>';

        $sql = $db->query("SELECT * FROM checklist_rescisao");
        $dados = $sql->fetchAll();
        foreach($dados as $dado){

            $html .= '<tr>';
            $html .= '<td>'.$dado['idchecklist_rescisao']. '</td>';
            $html .= '<td>'.utf8_decode($dado['nome_funcionario']). '</td>';
            $html .= '<td>'.utf8_decode($dado['funcao']). '</td>';
            $html .= '<td>'. date("d/m/Y", strtotime($dado['admissao'])) . '</td>';
            $html .= '<td>'. date("d/m/Y", strtotime($dado['demissao'])) . '</td>';
            $html .= '<td>'. number_format($dado['valor'],2,",",".") . '</td>';
            $html .= '<td>'. utf8_decode($dado['motivo_saida']) . '</td>';
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