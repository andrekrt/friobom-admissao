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
    <title>FRIOBOM - Almoxarifado</title>
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
                    <img src="../assets/images/icones/icon-material.png" alt="">
                </div>
                <div class="title">
                    <h2>Estoque</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalMaterial" data-whatever="@mdo" name="idMaterial">Novo Material/Equipamento</button>
                    </div>
                    <a href="estoque-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='tableEstoque' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">ID</th>
                                <th scope="col" class="text-center text-nowrap" > Material/Equipamento </th>
                                <th scope="col" class="text-center text-nowrap">Grupo</th>
                                <th scope="col" class="text-center text-nowrap">Medida</th>
                                <th scope="col" class="text-center text-nowrap">Estoque Mínimo</th>
                                <th scope="col" class="text-center text-nowrap"> Total Entradas</th>   
                                <th scope="col" class="text-center text-nowrap"> Total Saídas</th> 
                                <th scope="col" class="text-center text-nowrap"> Estoque Atual</th>     
                                <th scope="col" class="text-center text-nowrap"> Valor Comprado</th>   
                                <th scope="col" class="text-center text-nowrap"> Situação</th>   
                                <th scope="col" class="text-center text-nowrap"> Data Cadastro</th>  
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
            $('#tableEstoque').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_estoque.php'
                },
                'columns': [
                    { data: 'idmaterial_estoque' },
                    { data: 'descricao_material' },
                    { data: 'grupo_material' },
                    { data: 'un_medida' },
                    { data: 'estoque_minimo' },
                    { data: 'total_entrada' },
                    { data: 'total_saida' },
                    { data: 'total_estoque' },
                    { data: 'valor_comprado' },
                    { data: 'situacao' },
                    { data: 'data_cadastro' },
                    { data: 'nome_usuario' },
                    { data: 'acoes' },
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
        });

        //abrir modal
        $('#tableEstoque').on('click', '.editbtn', function(event){
            var table = $('#tableEstoque').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_estoque.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#idMaterial').val(json.idmaterial_estoque);
                    $('#descricao').val(json.descricao_material);
                    $('#medida').val(json.un_medida);
                    $('#grupo').val(json.grupo_material);
                    $('#estoqueMinimo').val(json.estoque_minimo);
                    $('#entradas').val(json.total_entrada);
                    $('#saidas').val(json.total_saida);
                    $('#totalEstoque').val(json.total_estoque);
                    $('#valorTotal').val(json.valor_total);
                    $('#situacao').val(json.situacao);
                    $('#dataCadastro').val(json.data_cadastro);
                    $('#usuario').val(json.nome_usuario);
                }
            })
        });
    </script>

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Material/Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-material.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-1">
                            <label for="idMaterial" class="col-form-label">ID</label>
                            <input type="text" readonly name="idMaterial" class="form-control" id="idMaterial" value="">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <input type="text" name="descricao" class="form-control" id="descricao" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="medida" readonly  class="col-form-label">Medida</label>
                            <select required name="medida" id="medida" class="form-control">
                                <option value=""></option>
                                <option value="Litros">Litros</option>
                                <option value="UND">UND</option>
                                <option value="Metro">Metro</option>
                                <option value="Kg">Kg</option>
                                <option value="Par">Par</option>
                                <option value="Caixa">Caixa</option>
                                <option value="Pacote">Pacote</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="grupo" class="col-form-label">Grupo</label>
                            <select required name="grupo" id="grupo" class="form-control">
                                <option value="Material de Escritório">Material de Escritório</option>
                                <option value="EPI">EPI</option>
                                <option value="Fardamento">Fardamento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="estoqueMinimo" class="col-form-label">Estoque Mínimo</label>
                            <input type="text" class="form-control" name="estoqueMinimo" id="estoqueMinimo" value="">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="entradas" class="col-form-label">Total de Entrada</label>
                            <input type="text" class="form-control" name="entradas" id="entradas" readonly value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="saidas" class="col-form-label">Total de Saída</label>
                            <input type="text" class="form-control" name="saidas" id="saidas" readonly value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="totalEstoque" class="col-form-label">Total no Estoque</label>
                            <input type="text" class="form-control" name="totalEstoque" id="totalEstoque" readonly value="">
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="situacao" class="col-form-label">Situação</label>
                            <input type="text" class="form-control" name="situacao" id="situacao" readonly value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dataCadastro" class="col-form-label">Data de Cadastro</label>
                            <input type="date" class="form-control" name="dataCadastro" id="dataCadastro" readonly value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="usuario" class="col-form-label">Usuário Lançou</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" readonly value="">
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-material.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12 espaco ">
                            <label for="descricao"> Descrição Material/Equipamento </label>
                            <input type="text" required name="descricao" class="form-control" id="descricao">
                        </div>
                    </div>    
                    <div class="form-row">
                        <div class="form-group col-md-5 espaco ">
                            <label for="medida"> Medida </label>
                            <select required name="medida" id="medida" class="form-control">
                                <option value=""></option>
                                <option value="Litros">Litros</option>
                                <option value="UND">UND</option>
                                <option value="Metro">Metro</option>
                                <option value="Kg">Kg</option>
                                <option value="Par">Par</option>
                                <option value="Caixa">Caixa</option>
                                <option value="Pacote">Pacote</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5 espaco ">
                            <label for="grupo"> Grupo </label>
                            <select required  name="grupo" id="grupo" class="form-control" style="width: 100%;">
                                <option value=""></option>
                                <option value="Material de Escritório">Material de Escritório</option>
                                <option value="EPI">EPI</option>
                                <option value="Fardamento">Fardamento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 espaco ">
                            <label for="estoqueMinimo"> Estoque Mínimo </label>
                            <input type="text" required name="estoqueMinimo" class="form-control" id="estoqueMinimo">
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
</body>
</html>