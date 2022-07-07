<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario'] == 1 ) {

    $tipoUsuario = $_SESSION['tipoUsuario'];    
   
} else {
    echo "<script>alert('Acesso não permitido');</script>";
    echo "<script>window.location.href='../index.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRIOBOM - Documentação</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="../assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- arquivos para datatable -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.css"/>

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
                    <h2>Rescisões</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <a href="rescisoes-xls.php"><img src="../assets/images/excel.jpg" alt=""></a>
                </div>
                <div class="table-responsive">
                    <table id='tableRescisao' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap" > Código </th>
                                <th scope="col" class="text-center text-nowrap" > Funcionário </th>
                                <th scope="col" class="text-center text-nowrap">Função</th>
                                <th scope="col" class="text-center text-nowrap"> Admissão</th>   
                                <th scope="col" class="text-center text-nowrap"> Demissão </th>  
                                <th scope="col" class="text-center text-nowrap"> Valor </th> 
                                <th scope="col" class="text-center text-nowrap"> Motivo de Saída </th>       
                                <th scope="col" class="text-center text-nowrap"> Responsável </th> 
                                <th scope="col" class="text-center text-nowrap"> Ações</th>     
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/menu.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#tableRescisao').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_resc.php'
                },
                'columns': [
                    { data: 'idchecklist_rescisao'},
                    { data: 'nome_funcionario'},
                    { data: 'funcao'},
                    { data: 'admissao'},
                    { data: 'demissao'},
                    { data: 'valor'},
                    { data: 'motivo_saida'},
                    { data: 'nome_responsavel'},
                    { data: 'acoes'}
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                },
                order: [[0, 'desc']]
            });
        });

        //abrir modal
        $('#tableRescisao').on('click', '.editbtn', function(event){
            var table = $('#tableRescisao').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_single_data.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.idchecklist_rescisao); 
                    $('#nome').val(json.nome_funcionario); 
                    $('#funcao').val(json.funcao);
                    $('#admissao').val(json.admissao);
                    $('#demissao').val(json.demissao);
                    $('#valor').val(json.valor);
                    $('#responsavel').val(json.nome_responsavel);
                    $('#motivoSaida').val(json.motivo_saida);

                    (json.material == 1) ? $('#material').attr("checked", "") : $('#material').removeAttr("checked");
                    (json.contra_cheque == 1) ? $('#contraCheque').attr("checked", "") : $('#contraCheque').removeAttr("checked");
                    (json.copia_ctps == 1) ? $('#xeroxCtps').attr("checked", "") : $('#xeroxCtps').removeAttr("checked");
                    (json.devolucao_ctps == 1) ? $('#devolucaoCtps').attr("checked", "") : $('#devolucaoCtps').removeAttr("checked");
                    (json.vale_transporte == 1) ? $('#valeTransporte').attr("checked", "") : $('#valeTransporte').removeAttr("checked");
                    (json.plano_saude == 1) ? $('#planoSaude').attr("checked", "") : $('#planoSaude').removeAttr("checked");
                    (json.contrato_experiencia == 1) ? $('#contratoExperiencia').attr("checked", "") : $('#contratoExperiencia').removeAttr("checked");
                    (json.livro_assinado == 1) ? $('#livroAssinado').attr("checked", "") : $('#livroAssinado').removeAttr("checked");
                    (json.vales_descontado == 1) ? $('#valorDesontado').attr("checked", "") : $('#valorDesontado').removeAttr("checked");
                    (json.tit_aberto == 1) ? $('#verificado1221').attr("checked", "") : $('#verificado1221').removeAttr("checked");
                    (json.sem_carteira == 1) ? $('#semCarteira').attr("checked", "") : $('#semCarteira').removeAttr("checked");
                    (json.recibo == 1) ? $('#recibos').attr("checked", "") : $('#recibos').removeAttr("checked");
                    (json.exame == 1) ? $('#exames').attr("checked", "") : $('#exames').removeAttr("checked");
                    (json.carta_demissao == 1) ? $('#cartaDemissao').attr("checked", "") : $('#cartaDemissao').removeAttr("checked");
                    (json.ponto == 1) ? $('#ponto').attr("checked", "") : $('#ponto').removeAttr("checked");
                    (json.ferias == 1) ? $('#ferias').attr("checked", "") : $('#ferias').removeAttr("checked");
                    (json.chip == 1) ? $('#chip').attr("checked", "") : $('#chip').removeAttr("checked");
                    (json.assinada_1221 == 1) ? $('#assinado1221').attr("checked", "") : $('#assinado1221').removeAttr("checked");
                    (json.plano_cancelado == 1) ? $('#planoCancelado').attr("checked", "") : $('#planoCancelado').removeAttr("checked");
                    (json.desativado == 1) ? $('#desativado').attr("checked", "") : $('#desativado').removeAttr("checked");
                }
            })
        });
    </script> 

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rescisão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-rescisao.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="nome" class="col-form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" >
                        </div>
                        <div class="form-group col-md-2  ">
                            <label for="funcao"  class="col-form-label"> Função </label>
                            <input type="texts" required name="funcao" class="form-control" id="funcao">
                        </div>
                        <div class="form-group col-md-2  ">
                            <label for="admissao" class="col-form-label"> Admissão </label>
                            <input type="date" required name="admissao" id="admissao" class="form-control">
                        </div>
                        <div class="form-group col-md-2  ">
                            <label for="demissao" class="col-form-label"> Demissão </label>
                            <input type="date" required name="demissao" id="demissao" class="form-control">
                        </div>
                        <div class="form-group col-md-2  ">
                            <label for="valor" class="col-form-label"> Valor  </label>
                            <input type="text" required name="valor" id="valor" class="form-control">
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-4  ">
                            <label for="motivoSaida"> Motivo de Saída </label>
                            <input type="text" required name="motivoSaida" required class="form-control" id="motivoSaida">
                        </div>
                        <div class="form-group col-md-4  ">
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
            </div>
            <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </form> 
            </div>
        </div>
    </div>
</div>
</body>
</html>