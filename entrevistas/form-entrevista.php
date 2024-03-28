<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99)){

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
                        <img src="../assets/images/icones/ICONE-ENTREVISTA.png" alt="">
                    </div>
                    <div class="title">
                        <h2> Registrar Entrevista</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <form action="add-entrevista.php" method="post" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-primary"> Enviar </button>
                    </form>
                </div>
            </div>
        </div>

        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/menu.js"></script>
    </body>
</html>