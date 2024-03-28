<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && ($_SESSION['tipoUsuario'] ==1 || $_SESSION['tipoUsuario']==99)){

    $nomeUsuario = $_SESSION['nomeUsuario'];
    $tipoUsuario = $_SESSION['tipoUsuario'];

    $idAdvertencia = filter_input(INPUT_GET, 'id');
    $consulta = $db->prepare("SELECT * FROM advertencias WHERE idadvertencia = :id");
    $consulta->bindValue(':id', $idAdvertencia);
    $consulta->execute();
    $advertencia = $consulta->fetch();
    
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
        <title>Advertência</title>
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
                            <img src="../assets/images/icones/icon-advertencia.png" alt="">
                    </div>
                    <div class="title">
                            <h2> Registrar Advertência</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <form action="atualiza-advertencia.php" method="post" enctype="multipart/form-data">
                        <div id="formulario">
                            <input type="hidden" value="<?=$advertencia['idadvertencia']?>" name="idadvertencia">
                            <div class="form-row">
                                <div class="form-group col-md-4 espaco ">
                                    <label for="nome"> Nome Funcionário </label>
                                    <input type="text" value="<?=$advertencia['funcionario']?>" required name="nome" class="form-control" id="nome">
                                </div>
                                <div class="form-group col-md-2 espaco ">
                                    <label for="funcao"> Função </label>
                                    <input type="texts" value="<?=$advertencia['funcao']?>" required name="funcao" class="form-control" id="funcao">
                                </div>
                                <div class="form-group col-md-2 espaco ">
                                    <label for="dataOcorrencia"> Data Ocorrência </label>
                                    <input type="date" value="<?=$advertencia['data_ocorrencia']?>" required name="dataOcorrencia" id="dataOcorrencia" class="form-control">
                                </div>
                                <div class="form-group col-md-2 espaco ">
                                    <label for="assunto"> Assunto: </label>
                                    <select name="assunto" require_once id="assunto" class="form-control">
                                        <option value="<?=$advertencia['assunto']?>"><?=$advertencia['assunto']?></option>
                                        <option value="Advertência">Advertência</option>
                                        <option value="Suspensão">Suspensão</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 espaco ">
                                    <label for="motivo"> Motivo </label>
                                    <textarea class="form-control" required name="motivo" id="motivo" rows="5"><?=$advertencia['motivo']?></textarea>
                                </div>
                            </div>  
                            <?php
                            if($advertencia['assunto']=="Suspensão"): ?>
                                <div class="form-row" id="extras"> 
                                    <div class="form-group col-md-6 espaco">
                                        <label for="diasSuspenso">Dias de Suspensão</label> 
                                        <input type="text" value="<?=$advertencia['dias_suspencao']?>" required name="diasSuspenso" id="diasSuspenso" class="form-control"> 
                                    </div>   
                                    <div class="form-group col-md-6 espaco"> 
                                        <label for="dataRetorno">Data de Retorno</label>
                                        <input type="date" value="<?=$advertencia['data_retorno']?>" required name="dataRetorno" id="dataRetorno" class="form-control"> 
                                    </div> 
                                </div>
                            <?php endif; ?>
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
               $('#assunto').change(function(){
                    var assunto= $(this).val();
                    if(assunto=="Suspensão"){
                        $('#formulario').append('<div class="form-row" id="extras"> <div class="form-group col-md-6 espaco"> <label for="diasSuspenso">Dias de Suspensão</label> <input type="text" required name="diasSuspenso" id="diasSuspenso" class="form-control"> </div>   <div class="form-group col-md-6 espaco"> <label for="dataRetorno">Data de Retorno</label> <input type="date" required name="dataRetorno" id="dataRetorno" class="form-control"> </div> </div>');
                    }else if(assunto=="Advertência"){
                        $('#extras').remove();
                    }
               });
            });
        </script>
    </body>
</html>