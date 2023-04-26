<?php 

session_start();
use Mpdf\Mpdf;
require_once __DIR__.'/../vendor/autoload.php';
require("../conexao.php");
$tipoUsuario = $_SESSION['tipoUsuario'];

if($tipoUsuario==1){
    $id = filter_input(INPUT_GET, 'id');
    $dataAtual = date("d/m/Y");


    $sql = $db->prepare("SELECT * FROM checklist_distrato WHERE iddistrato = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    
    $dados = $sql->fetch();

    $admissao = date("d/m/Y", strtotime($dados['admissao']));
    $demissao = date("d/m/Y", strtotime($dados['demissao']));
    $valor = str_replace(".",",", $dados['valor']);
    $responsavel = $dados['nome_responsavel'];

    //dados 
    $distrato = $dados['distrato']?"X":"";
    $nfs = $dados['nfs']?"X":"";
    $planoSaude = $dados['plano_saude']?"X":"";
    $contrato = $dados['contrato']?"X":"";
    $descontado = $dados['descontado']?"X":"";
    $debito = $dados['debito']?"X":"";
    $desativado = $dados['desativado']?"X":""; 
    $chip = $dados['chip']?"X":"";
    $assinado1221 = $dados['assinada_1221']?"X":"";
    $planoCancelado = $dados['plano_cancelado']?"X":"";
  


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
                    <h2>Check-List Distrato </h2>
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
                        <td style='font-size:12px'>DISTRATO:  </td>
                        <td style='text-align:center'>$distrato</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>TODAS AS NOTAS FISCAIS: </td>
                        <td style='text-align:center'>$nfs</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>DECLARAÇÃO PLANO DE SAÚDE ASSINADO PRA SER EXCLUIDO: </td>
                        <td style='text-align:center'>$planoSaude</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>CONTRATO DE REPRESENTAÇÃO: </td>
                        <td style='text-align:center'>$contrato</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>PEGAR OS VALES PRA SER DESCONTADO: </td>
                        <td style='text-align:center'>$descontado</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>SE FOR RCA, VERIFICAR SE TEM DÉBITO NA 1221: </td>
                        <td style='text-align:center'>$debito</td>
                    </tr>
                    <tr>
                        <td style='font-size:12px'>DESATIVADO NA 528 E 517: </td>
                        <td style='text-align:center'>$desativado</td>
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