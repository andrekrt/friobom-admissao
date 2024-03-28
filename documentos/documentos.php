<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario']==2 || $_SESSION['tipoUsuario']==99)) {

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
                    <img src="../assets/images/icones/documentos.png" alt="">
                </div>
                <div class="title">
                    <h2>Documentação</h2>
                </div>
                <div class="menu-mobile">
                    <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">
                <div class="table-responsive">
                    <table id='tableDocumentos' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap" > Data Envio </th>
                                <th scope="col" class="text-center text-nowrap">Nome Contrado</th>
                                <th scope="col" class="text-center text-nowrap"> Função</th>   
                                <th scope="col" class="text-center text-nowrap"> Rota</th>  
                                <th scope="col" class="text-center text-nowrap"> Documentos</th>   
                                <th scope="col" class="text-center text-nowrap"> Situação</th> 
                                <th scope="col" class="text-center text-nowrap"> Obs</th>  
                                <th scope="col" class="text-center text-nowrap"> Enviado por</th>    
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
    <!-- sweert alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('#tableDocumentos').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'pesq_doc.php'
                },
                'columns': [
                    { data: 'data_envio'},
                    { data: 'nome_contratado'},
                    { data: 'funcao'},
                    { data: 'rota'},
                    { data: 'documentos'},
                    { data: 'situacao'},
                    { data: 'obs'},
                    { data: 'nome_usuario'},
                    { data: 'acoes'}
                ],
                "language":{
                    "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
        });

        //abrir modal
        $('#tableDocumentos').on('click', '.editbtn', function(event){
            var table = $('#tableDocumentos').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url:"get_single_data.php",
                data:{id:id},
                type:'post',
                success: function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.iddocumentos_admissao); 
                    $('#nome').val(json.nome_contratado); 
                    $('#funcao').val(json.funcao);
                    $('#rota').val(json.rota);
                    $('#situacao').val(json.situacao);
                    $('#obs').val(json.obs);
                }
            })
        });
    </script> 

<!-- modal visualisar e editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Documentação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="atualiza-doc.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nome" class="col-form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" >
                        </div>
                        <div class="form-group col-md-3  ">
                            <label for="funcao"  class="col-form-label"> Função </label>
                            <input type="texts" required name="funcao" class="form-control" id="funcao">
                        </div>
                        <div class="form-group col-md-2  ">
                            <label for="rota" class="col-form-label"> Rota </label>
                            <input type="text" required name="rota" id="rota" class="form-control">
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="situacao"  class="col-form-label"> Situação </label>
                            <?php if($tipoUsuario==1):?>
                            <select name="situacao" required id="situacao" class="form-control">
                                <option value=""></option>
                                <option value="Em Análise">Em Análise</option>
                                <option value="Currículo Aprovado">Currículo Aprovado</option>
                                <option value="Currículo Reprovado">Currículo Reprovado</option>
                                <option value="Documentação OK">Documentação OK</option>
                                <option value="Documentação Pendente">Documentação Pendente</option>
                                <option value="Documentação em Análise">Documentação em Análise</option>
                            </select>
                            <?php elseif($tipoUsuario==2): ?>
                                <input type="text" name="situacao" readonly id="situacao" class="form-control">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="obs" class="col-form-label">Obs.</label>
                            <input type="text" id="obs" name="obs" class="form-control" <?php if($tipoUsuario==2){echo 'readonly';}   ?> >
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