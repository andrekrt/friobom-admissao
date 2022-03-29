<?php 

session_start();
use Mpdf\Mpdf;
require_once __DIR__.'/../vendor/autoload.php';
require("../conexao.php");
$tipoUsuario = $_SESSION['tipoUsuario'];

if($tipoUsuario==1){
    $id = filter_input(INPUT_GET, 'id');
    $dataAtual = date("d/m/Y");


    $sql = $db->prepare("SELECT * FROM checklist_rescisao WHERE idchecklist_rescisao = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    
    $dados = $sql->fetch();

    $admissao = date("d/m/Y", strtotime($dados['admissao']));
    $demissao = date("d/m/Y", strtotime($dados['demissao']));
    $valor = str_replace(".",",", $dados['valor']);
    $responsavel = $dados['nome_responsavel'];

    //dados 
    $material = $dados['material']?"X":"";
    $contraCheque = $dados['contra_cheque']?"X":"";
    $xeroxCtps = $dados['copia_ctps']?"X":"";
    $devolucaoCtps = $dados['devolucao_ctps']?"X":"";
    $valeTransporte = $dados['vale_transporte']?"X":"";
    $planoSaude = $dados['plano_saude']?"X":"";
    $contratoExperiencia = $dados['contrato_experiencia']?"X":"";
    $livroAssinado =$dados['livro_assinado']?"X":"";
    $valorDescontado = $dados['vales_descontado']?"X":"";
    $verificado1221 = $dados['tit_aberto']?"X":""; 
    $semCarteira = $dados['sem_carteira']?"X":"";
    $recibos = $dados['recibo']?"X":"";
    $exames = $dados['exame']?"X":"";
    $cartaDemissao = $dados['carta_demissao']?"X":"";
    $ponto = $dados['ponto']?"X":"";
    $ferias = $dados['ferias']?"X":"";
    $chip = $dados['chip']?"X":"";
    $assinado1221 = $dados['assinada_1221']?"X":"";
    $planoCancelado = $dados['plano_cancelado']?"X":"";
    $desativado = $dados['desativado']?"X":""; 



    $mpdf = new Mpdf();
    $mpdf->AddPage();
    $mpdf->WriteHTML("
    !DOCTYPE html>
    <html lang='pt-br'>
    <head>
        
    <body>
        <div style='display: flex; flex-direction: column;'>
            <div style='width: 100%;'>
                <div style='text-align:center; margin-bottom:15px'> 
                    <img style='width: 300px; ' src='../assets/images/logo.png'> 
                </div>
                <div style='text-align:center;  border: 1px solid #000; border-radius: 15px; margin-bottom:10px'>
                    <h2>Check-List de Rescisão </h2>
                </div>
            </div>
            <div style='width: 100%; border: 1px solid #000; border-radius: 15px;'>
                <p> 
                    Funcionário(a): $dados[nome_funcionario] <br>
                    Função: $dados[funcao] <br>
                    Admissão: $admissao  </span> <br>
                    Demissão: $demissao <br>
                    Valor: R$$valor <br>
                    Motivo de Saída: $dados[motivo_saida] <br>
                </p>
            </div>
            <div>
                <table border='1' style='width: 100%; margin-top:10px; '>
                    <tr >
                        <td style='font-size:12px'>DEVOLUÇÃO DE FARDA, BOTA ,CRACHÁ, MOCHILHA E CHIP:  </td>
                        <td style='text-align:center'>$material</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>TODOS CONTRA-CHEQUES ASSINADO SEM ABREVIAÇÃO: </td>
                        <td style='text-align:center'>$contraCheque</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>XEROXS DA CARTEIRA: </td>
                        <td style='text-align:center'>$xeroxCtps</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>COMPROVANTE DEVOLUÇÃO DE CARTEIRA ASSINADO: </td>
                        <td style='text-align:center'>$devolucaoCtps</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>DECLARAÇÃO E TERMO VALE TRANSPORTE ASSINADO: </td>
                        <td style='text-align:center'>$valeTransporte</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>DECLARAÇÃO PLANO DE SAÚDE ASSINADO PRA SER EXCLUIDO: </td>
                        <td style='text-align:center'>$planoSaude</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>CONTRATO DE TRABALHO A TÍTULO DE EXPERIENCIA ASSINADO: </td>
                        <td style='text-align:center'>$contratoExperiencia</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>LIVRO ASSINADO: </td>
                        <td style='text-align:center'>$livroAssinado</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>PEGAR OS VALES PRA SER DESCONTADO: </td>
                        <td style='text-align:center'>$valorDescontado</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>SE FOR RCA, VERIFICAR SE TEM DÉBITO NA 1221: </td>
                        <td style='text-align:center'>$verificado1221</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>PASSOU TEMPO SEM CARTEIRA ASSINADA: </td>
                        <td style='text-align:center'>$semCarteira</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>RECIBOS: </td>
                        <td style='text-align:center'>$recibos</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>EXAMES: </td>
                        <td style='text-align:center'>$exames</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>CARTA DE DEMISSÃO: </td>
                        <td style='text-align:center'>$cartaDemissao</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>DESATIVADO NA 528 E 517: </td>
                        <td style='text-align:center'>$desativado</td>
                    </tr> 
                    <tr>
                        <td style='font-size:12px'>PONTO: </td>
                        <td style='text-align:center'>$ponto</td>
                    </tr> 
                    <tr>
                        <td style='font-size:12px'>FÉRIAS: </td>
                        <td style='text-align:center'>$ferias</td>
                    </tr> 
                    <tr>
                        <td style='font-size:12px'>CHIP: </td>
                        <td style='text-align:center'>$chip</td>
                    </tr> 
                    <tr>
                        <td style='font-size:12px'>1221 ASSINADA PELO RCA: </td>
                        <td style='text-align:center'>$assinado1221</td>
                    </tr> 
                    <tr>
                        <td style='font-size:12px'>PLANO CANCELADO: </td>
                        <td style='text-align:center'>$planoCancelado</td>
                    </tr>               
                </table>
            </div>
            <div style='margin-top:100px; width:100%; text-align:center '>
                <div style=' width: 40%; float:left; border-top: 1px solid #000;'>Responsável Documentação </div>
                <div style='width: 40%; float:right; border-top: 1px solid #000;'>Conferente</div>
            </div>
        </div>
    </body>
    </html>
    ");


    $mpdf->Output();
}else{
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='descargas.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    
<body>
    <div style='display: flex; flex-direction: column;'>
        <div style='width: 100%;'>
            <div style='width: 100%; float: left; '> 
                <img style='width: 300px;' src='../assets/images/logo.png'> 
            </div>
        </div>
        <div style='width: 100%; border: 1px solid #000; border-radius: 15px;'>
            <p> 
                Funcionário(a): <?=$dados['nome_funcionario']?> <br>
                Função: <?=$dados['funcao']?> <br>
                Admissão: <?=$dados['admissao']?>  </span> <br>
                Demissão: <?=$dados['demissao']?> <br>
                Valor: <?=$dados['valor']?> <br>
                Motivo de Saída: <?=$dados['motivo_saida']?> <br>
            </p>
        </div>
        <div>
            <table border='1' style='width: 100%; margin-top:10px'>
                <tr>
                    <td>DEVOLUÇÃO DE FARDA, BOTA ,CRACHÁ, MOCHILHA E CHIP: <?=$dados['material']?'OK':''?></td>
                    <td>TODOS CONTRA-CHEQUES ASSINADO SEM ABREVIAÇÃO: <?=$dados['contra_cheque']?'OK':''?></td>
                    <td>XEROXS DA CARTEIRA: <?=$dados['copia_ctps']?'OK':''?></td>
                    <td>XEROXS DA CARTEIRA: <?=$dados['devolucao_ctps']?'OK':''?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>