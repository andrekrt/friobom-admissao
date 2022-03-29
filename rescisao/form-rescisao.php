<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==1){

    $nomeUsuario = $_SESSION['nomeUsuario'];
    $tipoUsuario = $_SESSION['tipoUsuario'];
    
}else{
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enviar Documentação</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="../assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="../assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="container-fluid corpo">
            <?php require('../menu-lateral.php') ?>
            <!-- Tela com os dados -->
            <div class="tela-principal">
                <div class="menu-superior">
                    <div class="icone-menu-superior">
                            <img src="../assets/images/icones/rescisao.png" alt="">
                    </div>
                    <div class="title">
                            <h2> Registrar Rescisão</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <form action="add-rescisao.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco ">
                                <label for="nome"> Nome Funcionário </label>
                                <input type="text" required name="nome" class="form-control" id="nome">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="funcao"> Função </label>
                                <input type="texts" required name="funcao" class="form-control" id="funcao">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="admissao"> Data Admissão </label>
                                <input type="date" required name="admissao" id="admissao" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="demissao"> Data Demissão </label>
                                <input type="date" required name="demissao" id="demissao" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="valor"> Valor </label>
                                <input type="text" required name="valor" id="valor" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco ">
                                <label for="motivoSaida"> Motivo de Saída </label>
                                <input type="text" required name="motivoSaida" required class="form-control" id="motivoSaida">
                            </div>
                            <div class="form-group col-md-4 espaco ">
                                <label for="responsavel"> Responsável por Organizar Documentação </label>
                                <input type="text" required name="responsavel" class="form-control" id="responsavel">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="material" name="material">
                                <label class="form-check-label" for="material">DEVOLUÇÃO DE FARDA, BOTA ,CRACHÁ, MOCHILHA E CHIP</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="contraCheque" name="contraCheque">
                                <label class="form-check-label" for="contraCheque">TODOS CONTRA-CHEQUES ASSINADO SEM ABREVIAÇÃO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="xeroxCtps" name="xeroxCtps">
                                <label class="form-check-label" for="xeroxCtps">XEROXS DA CARTEIRA</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="devolucaoCtps" name="devolucaoCtps">
                                <label class="form-check-label" for="devolucaoCtps">COMPROVANTE DEVOLUÇÃO DE CARTEIRA ASSINADO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="valeTransporte" name="valeTransporte">
                                <label class="form-check-label" for="valeTransporte">DECLARAÇÃO E TERMO VALE TRANSPORTE ASSINADO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="planoSaude" name="planoSaude">
                                <label class="form-check-label" for="planoSaude">DECLARAÇÃO PLANO DE SAÚDE ASSINADO PRA SER EXCLUIDO</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="contratoExperiencia" name="contratoExperiencia">
                                <label class="form-check-label" for="contratoExperiencia">CONTRATO DE TRABALHO A TÍTULO DE EXPERIENCIA ASSINADO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="livroAssinado" name="livroAssinado">
                                <label class="form-check-label" for="livroAssinado">LIVRO ASSINADO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="valorDesontado" name="valorDesontado">
                                <label class="form-check-label" for="valorDesontado">PEGAR OS VALES PRA SER DESCONTADO</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="verificado1221" name="verificado1221">
                                <label class="form-check-label" for="verificado1221">SE FOR RCA, VERIFICAR SE TEM DÉBITO NA 1221</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="semCarteira" name="semCarteira">
                                <label class="form-check-label" for="semCarteira">PASSOU TEMPO SEM CARTEIRA ASSINADA</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="recibos" name="recibos">
                                <label class="form-check-label" for="recibos">RECIBOS</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="exames" name="exames">
                                <label class="form-check-label" for="exames">EXAMES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cartaDemissao" name="cartaDemissao">
                                <label class="form-check-label" for="cartaDemissao">CARTA DE DEMISSÃO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="desativado" name="desativado">
                                <label class="form-check-label" for="desativado">DESATIVADO NA 528 E 517</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="ponto" name="ponto">
                                <label class="form-check-label" for="ponto">PONTO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="ferias" name="ferias">
                                <label class="form-check-label" for="ferias">FÉRIAS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chip" name="chip">
                                <label class="form-check-label" for="chip">CHIP</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="assinado1221" name="assinado1221">
                                <label class="form-check-label" for="assinado1221">1221 ASSINADO PELO RCA</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="planoCancelado" name="planoCancelado">
                                <label class="form-check-label" for="planoCancelado">PLANO CANCELADO</label>
                            </div>
                            
                        </div>
                        
                        <button type="submit" class="btn btn-primary"> Enviar </button>
                    </form>
                </div>
            </div>
        </div>

        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/menu.js"></script>
        <script src="../assets/js/jquery.mask.js"></script>
        <script>
            $(document).ready(function(){
                $('#valor').mask("#.##0,00", {reverse: true});
            });
        </script>
    </body>
</html>