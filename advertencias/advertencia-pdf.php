<?php

session_start();
use Mpdf\Mpdf;
require_once __DIR__.'/../vendor/autoload.php';
require("../conexao.php");

$idAdvertencia = filter_input(INPUT_GET, 'id');
$consulta = $db->prepare("SELECT * FROM advertencias WHERE idadvertencia = :id");
$consulta->bindValue(':id', $idAdvertencia);
$consulta->execute();

$advertencia = $consulta->fetch();

$funcionario = ucfirst($advertencia['funcionario']);
$funcao = ucfirst($advertencia['funcao']);
$dataOcorrencia = date("d/m/Y", strtotime($advertencia['data_ocorrencia'])) ;
$assunto = $advertencia['assunto'];
$diasSuspenso = $advertencia['dias_suspencao'];
$dataRetorno = date("d/m/Y", strtotime($advertencia['data_retorno'])) ;
$motivo = ucfirst($advertencia['motivo']);

if($assunto=='Suspensão'){
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
                        <td style='width:50%;text-align:right'> <p style='font-size:20px'>Basto Mesquita Distribuição e Logística Ltda. <br>Rodoviária BR 316, KM 357, S/N – <br> Parque Rui Barbosa, Bacabal - MA <br> Fone (99) 3621-7830
                         </p> </td>
                    </tr>
                </table>
            </div>
            <div style='margin-top:20px; font-size:16px'>
                <p> De: Basto Mesquita Distribuição e Logística Ltda </p>
                <p> Para: $funcionario </p>
                <p> Função: $funcao</p>
                <p>Data: $dataOcorrencia</p>
                <p>Assunto: $assunto</p>
                <p>
                    Comunicamos sua <span style='font-weight:weight'>suspensão</span> durante o perído de $diasSuspenso dias, devendo V. Sª. Retornar às suas atividades no dia $dataRetorno , em virtudade do motivo abaixo citado: <br> $motivo
                </p>
                
                <br>
                
            </div>
            <div style='font-size:16px'>
                <p>Solicitamos a sua colaboração, para que as normas e determinações da Empresa não sejam descumpridas, pois nesta hipótese, seremos obrigados a rescindir seu contrato de trabalho por justa causa conforme (Art. 482 da CLT).</p>
            </div>
            <div style='font-size:16px'>
                <p style='text-align:center; margin-bottom:50px'>Atenciosamente,</p>
                <p style='width: 60%; margin:auto; text-align:center; border-top: 1px solid #000;'> Basto Mesquita Distribuição e Logística Ltda </p>
            </div>  

            <div style='margin-top:100px; width:100%; text-align:center; font-size:16px'>
                <p style=' width: 50%; text-align:left; border-top: 1px solid #000; margin-top:50px'>Ciente </p>
                <p style='width: 50%; text-align:left; border-top: 1px solid #000;margin-top:50px'>Testemunha 01</p>
                <p style='width: 50%; text-align:left; border-top: 1px solid #000;margin-top:50px'>Testemunha 02</p>
            </div>
        </div>
    </body>
    </html>
    ");
}elseif($assunto=='Advertência'){
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
                        <td style='width:50%;text-align:right'> <p style='font-size:20px'>Basto Mesquita Distribuição e Logística Ltda. <br>Rodoviária BR 316, KM 357, S/N – <br> Parque Rui Barbosa, Bacabal - MA <br> Fone (99) 3621-7830
                         </p> </td>
                    </tr>
                </table>
            </div>
            <div style='margin-top:20px; font-size:16px'>
                <p> De: Basto Mesquita Distribuição e Logística Ltda </p>
                <p> Para: $funcionario </p>
                <p> Função: $funcao</p>
                <p>Data: $dataOcorrencia</p>
                <p>Assunto: $assunto</p>
                <p>Sirva o presente para adverti-lo(a) em virtudo do motivo abaixo: <br> $motivo </p>
                <br>
                
            </div>
            <div style='font-size:16px'>
                <p>Solicitamos a sua colaboração, para que as normas e determinações da Empresa não sejam descumpridas, pois nesta hipótese, seremos obrigados a rescindir seu contrato de trabalho por justa causa conforme (Art. 482 da CLT).</p>
            </div>
            <div style='font-size:16px'>
                <p style='text-align:center; margin-bottom:50px'>Atenciosamente,</p>
                <p style='width: 60%; margin:auto; text-align:center; border-top: 1px solid #000;'> Basto Mesquita Distribuição e Logística Ltda </p>
            </div>  

            <div style='margin-top:100px; width:100%; text-align:center; font-size:16px'>
                <p style=' width: 50%; text-align:left; border-top: 1px solid #000; margin-top:50px'>Ciente </p>
                <p style='width: 50%; text-align:left; border-top: 1px solid #000;margin-top:50px'>Testemunha 01</p>
                <p style='width: 50%; text-align:left; border-top: 1px solid #000;margin-top:50px'>Testemunha 02</p>
            </div>
        </div>
    </body>
    </html>
    ");
}

$mpdf->Output();
?>