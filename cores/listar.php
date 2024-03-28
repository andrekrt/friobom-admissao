<?php

session_start();
require("../conexao.php");

if (isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && ($_SESSION['tipoUsuario'] <> 2)) {

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
    <title>FRIOBOM - CORES</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.css" />

    <!-- select2 -->
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
                    <img src="../assets/images/icones/icon-core.png" alt="">
                </div>
                <div class="title">
                    <h2>Cores</h2>
                </div>
            </div>
            <!-- dados exclusivo da página-->
            <div class="menu-principal">

                <div class="icon-exp">
                    <div class="area-opcoes-button">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCore" data-whatever="@mdo" name="idMaterial">Nova Entrada</button>
                    </div>
                    <a href="cores-xls.php"><img src="../assets/images/excel.jpg" alt=""></a>
                </div>
                <div class="table-responsive">
                    <table id='tableCore' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap"> ID </th>
                                <th scope="col" class="text-center text-nowrap"> Nome </th>
                                <th scope="col" class="text-center text-nowrap">CNPJ</th>
                                <th scope="col" class="text-center text-nowrap"> RCA </th>
                                <th scope="col" class="text-center text-nowrap"> Supervisor </th>
                                <th scope="col" class="text-center text-nowrap"> Rota </th>
                                <th scope="col" class="text-center text-nowrap"> Tipo de Contrato </th>
                                <th scope="col" class="text-center text-nowrap"> Data de Emissão </th>
                                <th scope="col" class="text-center text-nowrap"> Validade </th>
                                <th scope="col" class="text-center text-nowrap"> Situação </th>
                                <th scope="col" class="text-center text-nowrap"> Anexos </th>
                                <th scope="col" class="text-center text-nowrap"> Usuário </th>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- sweert alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#tableCore').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'pesq_core.php'
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'nome'
                    },
                    {
                        data: 'cnpj'
                    },
                    {
                        data: 'rca'
                    },
                    {
                        data: 'supervisor'
                    },
                    {
                        data: 'rota'
                    },
                    {
                        data: 'tipo_contrato'
                    },
                    {
                        data: 'data_emissao'
                    },
                    {
                        data: 'data_validade'
                    },
                    {
                        data: 'situacao'
                    },
                    {
                        data: 'anexos'
                    },
                    {
                        data: 'nome_usuario'
                    },
                    {
                        data: 'acoes'
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                },
                order: [
                    [0, 'desc']
                ]
            });


        });

        //abrir modal
        $('#tableCore').on('click', '.editbtn', function(event) {
            var table = $('#tableCore').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');

            $('#modalEditar').modal('show');

            $.ajax({
                url: "get_core.php",
                data: {
                    id: id
                },
                type: 'post',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#nome').val(json.nome);
                    $('#cnpj').val(json.cnpj);
                    $('#rca').val(json.rca);
                    $('#supervisor').val(json.supervisor);
                    $('#emissao').val(json.data_emissao);
                    $('#validade').val(json.data_validade);
                    $('#rota').val(json.rota);
                    $('#tipo').val(json.tipo_contrato);
                }
            })
        });
    </script>

    <!-- modal visualisar e editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Core</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="atualiza-core.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="trid" id="trid" value="">
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco ">
                                <label for="nome"> Nome </label>
                                <input type="text" name="nome" required id="nome" class="form-control">
                            </div>
                            <div class="form-group col-md-3 espaco ">
                                <label for="cnpj"> CNPJ </label>
                                <input type="text" name="cnpj" required id="cnpj" class="form-control cnpj">
                            </div>
                            <div class="form-group col-md-1 espaco ">
                                <label for="rca"> RCA </label>
                                <input type="text" name="rca" required id="rca" class="form-control ">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="emissao"> Data Emissão </label>
                                <input type="date" name="emissao" required id="emissao" class="form-control ">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="validade">Data Validade </label>
                                <input type="date" name="validade" required id="validade" class="form-control ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 espaco ">
                                <label for="supervisor">Supervisor</label>
                                <select required name="supervisor" id="supervisor" class="form-control select2">
                                    <option value=""></option>
                                    <?php
                                    $supervisores = $db->query("SELECT * FROM supervisores");
                                    $supervisores = $supervisores->fetchAll();
                                    foreach ($supervisores as $supervisor) :
                                    ?>
                                        <option value="<?= $supervisor['idsupervisor'] ?>"><?= $supervisor['nome_supervisor'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco ">
                                <label for="rota">Rota</label>
                                <select required name="rota" id="rota" class="form-control select2">
                                    <option value=""></option>
                                    <?php
                                    $supervisores = $db->query("SELECT * FROM rotas");
                                    $supervisores = $supervisores->fetchAll();
                                    foreach ($supervisores as $supervisor) :
                                    ?>
                                        <option value="<?= $supervisor['cod_rota'] ?>"><?= $supervisor['nome_rota'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco">
                                <label for="tipo">Tipo Contrato</label>
                                <select required name="tipo" id="tipo" class="form-control">
                                    <option value=""></option>
                                    <option value="Contrato Representação Comercial" selected>Contrato Representação Comercial</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco">
                                <label for="anexos">Anexos</label>
                                <input type="file" class="form-control" id="anexos" name="anexos[]" multiple>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal registrar CORE -->
    <div class="modal fade" id="modalCore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Core</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add-core.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco ">
                                <label for="nome"> Nome </label>
                                <input type="text" name="nome" required id="nome" class="form-control">
                            </div>
                            <div class="form-group col-md-3 espaco ">
                                <label for="cnpj"> CNPJ </label>
                                <input type="text" name="cnpj" required id="cnpj" class="form-control cnpj">
                            </div>
                            <div class="form-group col-md-1 espaco ">
                                <label for="rca"> RCA </label>
                                <input type="text" name="rca" required id="rca" class="form-control ">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="emissao"> Data Emissão </label>
                                <input type="date" name="emissao" required id="emissao" class="form-control ">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="validade">Data Validade </label>
                                <input type="date" name="validade" required id="validade" class="form-control ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 espaco ">
                                <label for="supervisor">Supervisor</label>
                                <select required name="supervisor" id="supervisor" class="form-control select2">
                                    <option value=""></option>
                                    <?php
                                    $supervisores = $db->query("SELECT * FROM supervisores");
                                    $supervisores = $supervisores->fetchAll();
                                    foreach ($supervisores as $supervisor) :
                                    ?>
                                        <option value="<?= $supervisor['idsupervisor'] ?>"><?= $supervisor['nome_supervisor'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco ">
                                <label for="rota">Rota</label>
                                <select required name="rota" id="rota" class="form-control select2">
                                    <option value=""></option>
                                    <?php
                                    $supervisores = $db->query("SELECT * FROM rotas");
                                    $supervisores = $supervisores->fetchAll();
                                    foreach ($supervisores as $supervisor) :
                                    ?>
                                        <option value="<?= $supervisor['cod_rota'] ?>"><?= $supervisor['nome_rota'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco">
                                <label for="tipo">Tipo Contrato</label>
                                <select required name="tipo" id="tipo" class="form-control">
                                    <option value=""></option>
                                    <option value="Contrato Representação Comercial" selected>Contrato Representação Comercial</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco">
                                <label for="anexos">Anexos</label>
                                <input type="file" class="form-control" id="anexos" name="anexos[]" multiple>
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

    <script src="../assets/js/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                dropdownParent: "#modalCore",
                theme: 'bootstrap4'
            });

        });
        jQuery(function($) {
            $(".cnpj").mask('00.000.000/0000-00', {
                reverse: true
            });
        })

        function confirmaDelete(id){
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você realmente deseja excluir esse CORE  ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se o usuário confirmar, redirecione para a página de exclusão
                    window.location.href = 'excluir.php?id=' + id;
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