<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==99) ) {

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
    <!-- select02 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
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
                    <h2>Saídas</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalMaterial" data-whatever="@mdo" name="idMaterial">Nova Saída</button>
                    </div>
                    <a href="saidas-xls.php" ><img src="../assets/images/excel.jpg" alt=""></a>    
                </div>
                <div class="table-responsive">
                    <table id='tableSaidas' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">ID</th>
                                <th scope="col" class="text-center text-nowrap" > Data Saída </th>
                                <th scope="col" class="text-center text-nowrap">Qtd</th>
                                <th scope="col" class="text-center text-nowrap">Material/Equipamento</th>
                                <th scope="col" class="text-center text-nowrap">Solicitante</th>
                                <th scope="col" class="text-center text-nowrap">Obs</th>        
                                <th scope="col" class="text-center text-nowrap"> Lançado por:</th>        
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
    <!-- sweert alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('#tableSaidas').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_saidas.php'
                },
                'columns': [
                    { data: 'idestoque_saidas' },
                    { data: 'data_saida' },
                    { data: 'qtd' },
                    { data: 'descricao_material' },
                    { data: 'solicitante' },
                    { data: 'obs' },
                    { data: 'nome_usuario' },
                    { data: 'acoes' },
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
        });

        //abrir modal
        $('#tableSaidas').on('click', '.editbtn', function(event){
            var table = $('#tableSaidas').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_saida.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#idSaida').val(json.idestoque_saidas);
                    $('#dataSaida').val(json.data_saida);
                    $('#qtd').val(json.qtd);
                    $('#material').val(json.material);
                    $('#solicitante').val(json.solicitante);
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
                <h5 class="modal-title" id="exampleModalLabel">Saída</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-saida.php" method="post" >
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-1">
                            <label for="idSaida" class="col-form-label">ID</label>
                            <input type="text" readonly name="idSaida" class="form-control" id="idSaida" value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dataSaida" class="col-form-label">Data Saída</label>
                            <input type="date" readonly name="dataSaida" class="form-control" id="dataSaida" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="qtd"  class="col-form-label">Qtd</label>
                            <input type="text" required name="qtd" id="qtd" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="material" class="col-form-label">Material/Equipamento</label>
                            <select required name="material" id="material" class="form-control">
                                <option value=""></option>
                                <?php
                                $material = $db->query("SELECT * FROM estoque_material");
                                $materiais=$material->fetchAll();
                                foreach($materiais as $material):
                                ?>
                                    <option value="<?=$material['idmaterial_estoque']?>"><?=$material['descricao_material']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="solicitante" class="col-form-label">Solicitante</label>
                            <input type="text" class="form-control" required name="solicitante" id="solicitante" value="">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="obs" class="col-form-label">Obs</label>
                            <input type="text" class="form-control" required name="obs" id="obs" value="">
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
                <h5 class="modal-title" id="exampleModalLabel">Lançar Saída</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-saida.php" method="post"> 
                    <div class="form-row">
                        <div class="form-group col-md-6 espaco ">
                            <label for="material">Material/Equipamento</label>
                            <select required name="material" id="material" class="form-control select2">
                                <option value=""></option>
                                <?php
                                $material = $db->query("SELECT * FROM estoque_material");
                                $materiais=$material->fetchAll();
                                foreach($materiais as $material):
                                ?>
                                    <option value="<?=$material['idmaterial_estoque']?>"><?=$material['descricao_material']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3 espaco">
                            <label for="qtd">Qtd</label>
                            <input type="text" required name="qtd" id="qtd" class="form-control">
                        </div>
                        <div class="form-group col-md-3 espaco">
                            <label for="solic">Solicitante</label>
                            <input type="text" required name="solic" id="solic" class="form-control">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-12 espaco">
                            <label for="obs">Obs</label>
                            <input type="text" name="obs" id="obs" class="form-control">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="analisar" class="btn btn-primary">Lançar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIM MODAL CADASTRO DE PEÇA-->

<script src="../assets/js/jquery.mask.js"></script>
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    jQuery(function($){
        $("#valor").mask('###0,00', {reverse: true});
        $("#vlUnit").mask('###0,00', {reverse: true});
    })

    $(document).ready(function(){
        $('.select2').select2({
            width: '100%',
            dropdownParent:"#modalMaterial",
            theme: 'bootstrap4'
        });       
    });

    function confirmaDelete(id){
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você realmente deseja excluir esse Saída?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se o usuário confirmar, redirecione para a página de exclusão
                window.location.href = 'excluir-saida.php?idSaida=' + id;
            }
        });
    }
</script>

<!-- msg de sucesso ou erro -->
<?php
    // Verifique se há uma mensagem de confirmação na sessão
    if (isset($_SESSION['msg']) && isset($_SESSION['icon'])) {
        // Exiba um alerta SweetAlert
        echo "<script>
                Swal.fire({
                  icon: '$_SESSION[icon]',
                  title: '$_SESSION[msg]',
                  showConfirmButton: true,
                });
              </script>";

        // Limpe a mensagem de confirmação da sessão
        unset($_SESSION['msg']);
        unset($_SESSION['status']);
    }
?>
</body>
</html>