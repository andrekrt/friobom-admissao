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
                    <img src="../assets/images/icones/icon-fornecedor.png" alt="">
                </div>
                <div class="title">
                    <h2>Fornecedores</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalMaterial" data-whatever="@mdo" name="idMaterial">Novo Fornecedor</button>
                    </div>
                    <a href="fornecedores-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='tableForn' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">CNPJ</th>
                                <th scope="col" class="text-center text-nowrap">Razão Social</th>
                                <th scope="col" class="text-center text-nowrap" > Nome Fantasia </th>
                                <th scope="col" class="text-center text-nowrap">Endereço</th>
                                <th scope="col" class="text-center text-nowrap">Bairro</th>
                                <th scope="col" class="text-center text-nowrap">Cidade</th>
                                <th scope="col" class="text-center text-nowrap"> CEP</th>   
                                <th scope="col" class="text-center text-nowrap"> Estado</th> 
                                <th scope="col" class="text-center text-nowrap"> Telefone</th>       
                                <th scope="col" class="text-center text-nowrap"> Cadastrado por:</th>        
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
            $('#tableForn').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_forn.php'
                },
                'columns': [
                    { data: 'cnpj' },
                    { data: 'razao_social' },
                    { data: 'nome_fantasia' },
                    { data: 'endereco' },
                    { data: 'bairro' },
                    { data: 'cidade' },
                    { data: 'cep' },
                    { data: 'uf' },
                    { data: 'telefone' },
                    { data: 'nome_usuario' },
                    { data: 'acoes' },
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
        });

        //abrir modal
        $('#tableForn').on('click', '.editbtn', function(event){
            var table = $('#tableForn').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_fornec.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.idfornecedores);
                    $('#razaoSocial').val(json.razao_social);
                    $('#endereco').val(json.endereco);
                    $('#bairro').val(json.bairro);
                    $('#cidade').val(json.cidade);
                    $('#cepEdi').val(json.cep);
                    $('#estado').val(json.uf);
                    $('#cnpjEdi').val(json.cnpj);
                    $('#nomeFantasia').val(json.nome_fantasia);
                    $('#telefoneEdi').val(json.telefone);
                    $('#usuario').val(json.nome_usuario);
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
                <form action="atualiza-forn.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="razaoSocial" class="col-form-label">Razão Social</label>
                            <input type="text" name="razaoSocial" class="form-control" id="razaoSocial" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cnpj" class="col-form-label">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control" id="cnpjEdi" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nomeFantasia" readonly  class="col-form-label">Nome Fantasia</label>
                            <input type="text" name="nomeFantasia" id="nomeFantasia" class="form-control" value=""> 
                        </div>
                        <div class="form-group col-md-2 ">
                            <label for="telefone" class="col-form-label"> Telefone  </label>
                            <input type="text" required name="telefone" class="form-control" id="telefoneEdi" value="">
                        </div>
                    </div>   
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="endereco" class="col-form-label">Endereço</label>
                            <input type="text" class="form-control" name="endereco" id="endereco" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="bairro" class="col-form-label">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cidade" class="col-form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" value="">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="estado" class="col-form-label">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cep" class="col-form-label">CEP</label>
                            <input type="text" class="form-control" name="cep" id="cepEdi" value="">
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
                        <div class="form-group col-md-3 espaco ">
                            <label for="razaoSocial"> Razão Social</label>
                            <input type="text" required name="razaoSocial" class="form-control" id="razaoSocial">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="cnpj"> CNPJ  </label>
                            <input type="text" required name="cnpj" class="form-control" id="cnpj">
                        </div> 
                        <div class="form-group col-md-4 espaco ">
                            <label for="nomeFantasia"> Nome Fantasia  </label>
                            <input type="text" required name="nomeFantasia" class="form-control" id="nomeFantasia">
                        </div>                                          
                        <div class="form-group col-md-3 espaco ">
                            <label for="telefone"> Telefone  </label>
                            <input type="text" required name="telefone" class="form-control" id="telefone">
                        </div>                                          
                    </div>      
                    <div class="form-row">
                        <div class="form-group col-md-3 espaco ">
                            <label for="endereco"> Endereço </label>
                            <input type="text" class="form-control" id="endereco" name="endereco">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="bairro"> Bairro </label>
                            <input type="text" class="form-control" id="bairro" name="bairro">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="cidade"> Cidade </label>
                            <input type="text" class="form-control" id="cidade" name="cidade">
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="estado"> Estado </label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="">Selecione</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 espaco ">
                            <label for="cep"> CEP </label>
                            <input type="text" class="form-control" id="cep" name="cep">
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