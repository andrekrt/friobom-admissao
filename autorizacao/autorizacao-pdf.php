<?php

session_start();
use Mpdf\Mpdf;
require_once __DIR__.'/../vendor/autoload.php';
require("../conexao.php");

$idautorizacao = filter_input(INPUT_GET, 'id');

try{
    $consulta = $db->prepare("SELECT * FROM autorizacoes LEFT JOIN usuarios ON autorizacoes.usuario = usuarios.idusuarios WHERE idautorizacao = :id");
    $consulta->bindValue(':id', $idautorizacao);
    $consulta->execute();

    $autorizacao = $consulta->fetch();  
}catch(PDOException $e){
    echo "erro ao imprimir PDF " .$e;
}


$nome = ucfirst($autorizacao['nome']);
$funcao = ucfirst($autorizacao['funcao']);
$dataAutorizacao = date("d/m/Y", strtotime($autorizacao['data_atual'])) ;
$valor =number_format($autorizacao['valor'],2,",",".");
$obs = $autorizacao['obs'];
$usuario = $autorizacao['nome_usuario'] ;
$cpf = $autorizacao['cpf'];

    $mpdf = new Mpdf();
    $mpdf->AddPage();
    $mpdf->WriteHTML("
    !DOCTYPE html>
    <html lang='pt-br'>
    <head>
    <body>
        <div style='display: flex; flex-direction: column;'>
            <div >
                <table border=''>
                    <tr>
                        <td style='width:50%'> <img src='../assets/images/logo.png'> </td>
                        <td style='width:50%;text-align:right'> <p style='font-size:20px'>Basto Mesquita Distribuição e Logística Ltda. <br>Rodoviária BR 316, KM 357, S/N – <br> Parque Rui Barbosa, Bacabal - MA <br> Fone: 0800 591 9184
                         </p> </td>
                    </tr>
                </table>
            </div>
            <div style='text-align:center;  border: 1px solid #000; border-radius: 15px; margin-bottom:10px; margin-top:20px'>
                <h2>Autorização </h2>
            </div>
            <div>
                <table border='1' style='width:100%; font-size:14pt' >
                    <tr>
                        <td> <span style='font-weight:bold'> Nº Autorização: </span> $idautorizacao</td>
                        
                        <td> <span style='font-weight:bold'> Data da Autorização: </span> $dataAutorizacao</td>
                       
                        <td> <span style='font-weight:bold'> Valor: </span> R$ $valor</td>
                    </tr>
                    <tr>
                        <td colspan='2'> <span  style='font-weight:bold'> Nome: </span> $nome</td>
                        <td> <span  style='font-weight:bold'> Função: </span> $funcao</td>
                    </tr>
                    <tr>
                        <td colspan='3'><span  style='font-weight:bold'> Obs.: </span> $obs</td>
                    </tr>
                </table>
            </div>
            
            <div style='font-size:16px; margin-top:100px; width:100%; text-align:center'>
                <img src='../assets/images/$cpf.png' style='height:100px; margin:auto; text-align:center;'>
                <p style='width: 60%; margin:auto; text-align:center; border-top: 1px solid #000;'> $usuario </p>
            </div>  
        </div>
    </body>
    </html>
    ");

$mpdf->Output();
?>