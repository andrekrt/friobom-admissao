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
    <title>FRIOBOM </title>
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
                    <img src="../assets/images/icones/ICONE-ENTREVISTA.png" alt="">
                </div>
                <div class="title">
                    <h2>Entrevistas</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="table-responsive">
                    <table id='tableEnt' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">Código</th>
                                <th scope="col" class="text-center text-nowrap">Candidato</th>
                                <th scope="col" class="text-center text-nowrap" > Vaga</th>
                                <th scope="col" class="text-center text-nowrap">Processo</th>
                                <th scope="col" class="text-center text-nowrap">Referência Antigo Trabalho</th>
                                <th scope="col" class="text-center text-nowrap">Entrevistado?</th>
                                <th scope="col" class="text-center text-nowrap"> Passou no Teste?</th>   
                                <th scope="col" class="text-center text-nowrap"> Obs</th>  
                                <th scope="col" class="text-center text-nowrap"> Registrado</th>         
                                <th scope="col" class="text-center text-nowrap"> Ações</th>     
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/menu.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#tableEnt').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_entre.php'
                },
                'columns': [
                    { data: 'id' },
                    { data: 'nome_candidato' },
                    { data: 'vaga' },
                    { data: 'processo' },
                    { data: 'referencia' },
                    { data: 'entrevistado' },
                    { data: 'passou' },
                    { data: 'obs' },
                    { data: 'nome_usuario' },
                    { data: 'acoes' },
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                },
                "columnDefs":[{
                    "orderable":false,
                    "targets":9
                }]
            });
        });

        //abrir modal
        $('#tableEnt').on('click', '.editbtn', function(event){
            var table = $('#tableEnt').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_entre.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#nome').val(json.nome_candidato);
                    $('#vaga').val(json.vaga);
                    $('#processo').val(json.processo);
                    $('#referencia').val(json.referencia);
                    $('#entrevistou').val(json.entrevistado);
                    $('#teste').val(json.passou);
                    $('#obs').val(json.obs);
                }
            })
        });
    </script>

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-entrevista.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-2 espaco ">
                            <label for="nome"> Nome Candidato </label>
                            <input type="text" required name="nome" class="form-control" id="nome">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="vaga"> Vaga Disponível </label>
                            <select name="vaga" id="vaga" required class="form-control">
                                <option value=""></option>
                                <option value="Auxiliar de Escritório">Auxiliar de Escritório</option>
                                <option value="Auxiliar de Depósito">Auxiliar de Depósito</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Promotor">Promotor</option>
                                <option value="Motorista">Motorista</option>
                                <option value="Entregador">Entregador</option>
                                <option value="Supervisor de Vendas">Supervisor de Vendas</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="processo"> Processo </label>
                            <select name="processo" id="processo" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="referencia"> Referência </label>
                            <select name="referencia" id="referencia" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="entrevistou"> Entrevistou </label>
                            <select name="entrevistou" id="entrevistou" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="teste"> Passou no Teste </label>
                            <select name="teste" id="teste" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 espaco ">
                            <label for="obs"> Observações </label>
                            <textarea name="obs" id="obs" rows="3" class="form-control"></textarea>
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

<!-- MODAL CADASTRO DE MATERIAL -->
<div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Fornecedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-forn.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-2 espaco ">
                            <label for="nome"> Nome Candidato </label>
                            <input type="text" required name="nome" class="form-control" id="nome">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="vaga"> Vaga Disponível </label>
                            <select name="vaga" id="vaga" required class="form-control">
                                <option value=""></option>
                                <option value="Auxiliar de Escritório">Auxiliar de Escritório</option>
                                <option value="Auxiliar de Depósito">Auxiliar de Depósito</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Promotor">Promotor</option>
                                <option value="Motorista">Motorista</option>
                                <option value="Entregador">Entregador</option>
                                <option value="Supervisor de Vendas">Supervisor de Vendas</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="processo"> Processo </label>
                            <select name="processo" id="processo" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="referencia"> Referência </label>
                            <select name="referencia" id="referencia" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="entrevistou"> Entrevistou </label>
                            <select name="entrevistou" id="entrevistou" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="teste"> Passou no Teste </label>
                            <select name="teste" id="teste" class="form-control" required>
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 espaco ">
                            <label for="obs"> Observações </label>
                            <textarea name="obs" id="obs" rows="3" class="form-control"></textarea>
                        </div>
                    </div>  
            </div>
            <div class="modal-footer">
                <button type="submit" name="analisar" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIM MODAL CADASTRO DE PEÇA-->

<script src="../assets/js/jquery.mask.js"></script>
<script>
    jQuery(function($){
        $("#cnpj").mask("00.000.000/0000-00");
        $("#cnpjEdi").mask("00.000.000/0000-00");
        $("#cep").mask("00000-000");
        $("#cepEdi").mask("00000-000");
        $("#telefone").mask("(00)00000-0000");
        $("#telefoneEdi").mask("(00)00000-0000");
    });
</script>
</body>
</html>