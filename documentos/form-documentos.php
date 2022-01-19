<?php 

session_start();
require("../conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] ==2){

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
                            <img src="../assets/images/icones/documentos.png" alt="">
                    </div>
                    <div class="title">
                            <h2> Documentação Funcionário</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="../assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <form action="add-documentos.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco ">
                                <label for="nome"> Nome completo Funcionário </label>
                                <input type="text" required name="nome" class="form-control" id="nome">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="dataNasc"> Data Nascimento </label>
                                <input type="date" required name="dataNasc" class="form-control" id="dataNasc">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="sexo"> Sexo </label>
                                <select name="sexo" required id="sexo" class="form-control">
                                    <option value=""></option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminno">Feminino</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 espaco ">
                                <label for="funcao"> Função </label>
                                <input type="texts" required name="funcao" class="form-control" id="funcao">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2 espaco ">
                                <label for="rota"> Rota </label>
                                <input type="text" required name="rota" id="rota" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="pis"> Nº PIS </label>
                                <input type="text" required name="pis" id="pis" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco">
                                <label for="tipoConta">Tipo de Conta</label>
                                <select name="tipoConta" id="tipoConta" class="form-control">
                                    <option value=""></option>
                                    <option value="Corrente">Corrente</option>
                                    <option value="Poupança">Poupança</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="agencia"> Agência  </label>
                                <input type="text" required name="agencia" id="agencia" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="conta"> Conta  </label>
                                <input type="text" required name="conta" id="conta" class="form-control">
                            </div>
                            <div class="form-group col-md-2 espaco ">
                                <label for="variacao"> Variação/Op  </label>
                                <input type="text" name="variacao" id="variacao" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group espaco col-md-6">
                                <label for="documentos">Anexar Documentação (Abaixo Documentação a ser Enviada) </label>
                                <input type="file" name="documentos[]" multiple class="form-control" id="documentos" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 espaco">
                                <ul class="list-group">
                                    <li class="list-group-item">RG</li>
                                    <li class="list-group-item">CPF(Desconsidere caso tenha no RG)</li>
                                    <li class="list-group-item">Título Eleitor</li>
                                    <li class="list-group-item">CNH</li>
                                    <li class="list-group-item">Reservista(Homem)</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-4 espaco">
                                <ul class="list-group">
                                    <li class="list-group-item">Comprovante de Endereço</li>
                                    <li class="list-group-item">Certidão Nascimento(Casamento)</li>
                                    <li class="list-group-item">Comprovante Escolaridade</li>
                                    <li class="list-group-item">Carteira de Vacinação</li>
                                    <li class="list-group-item">Certidão Filhos até 14 anos</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-4 espaco">
                                <ul class="list-group">
                                    <li class="list-group-item">Carteira de Vacinação Filhos até 14 anos</li>
                                    <li class="list-group-item">Foto 3x4</li>
                                    <li class="list-group-item">Atestado de Antencedentes Criminais</li>
                                    <li class="list-group-item">Conta Banco do Brasil ou Caixa</li>
                                    <li class="list-group-item">CTPS Digital e Exames Admicionais</li>
                                </ul>
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