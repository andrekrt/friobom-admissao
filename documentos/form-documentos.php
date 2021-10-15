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
                            <div class="form-group espaco col-md-4">
                                <label for="rg">Anexo RG</label>
                                <input type="file" name="rg" class="form-control" id="rg" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="cpf">Anexo CPF(Desconsiderar caso tenha no RG)</label>
                                <input type="file" name="cpf" class="form-control" id="cpf" aria-describedby="inputGroupFileAddon03"  aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="titulo">Título de Eleitor</label>
                                <input type="file" name="titulo" class="form-control" id="titulo" aria-describedby="inputGroupFileAddon03" required  aria-label="Upload">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group espaco col-md-4">
                                <label for="cnh">CNH</label>
                                <input type="file" name="cnh" class="form-control" id="cnh" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="reservista">Reservista</label>
                                <input type="file" name="reservista" class="form-control" id="reservista" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="residencia">Comprovante de Residência</label>
                                <input type="file" name="residencia" class="form-control" id="residencia" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group espaco col-md-4">
                                <label for="certidao">Certidão de Nascimento (Casamento)</label>
                                <input type="file" name="certidao" class="form-control" id="certidao" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="escolaridade">Comprovante de Escolaridade</label>
                                <input type="file" name="escolaridade[]" multiple class="form-control" id="escolaridade" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="carteiraVac">Carteira de Vacinação </label>
                                <input type="file" name="carteiraVac" class="form-control" id="carteiraVac" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group espaco col-md-4">
                                <label for="certidaoFilhos">Certidão dos Filhos(Até 14 anos)</label>
                                <input type="file" name="certidaoFilhos[]" class="form-control" id="certidaoFilhos" multiple aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="vacFilhos">Carteira de Vacinação dos Filhos(Até 14 anos) </label>
                                <input type="file" name="vacFilhos[]" multiple class="form-control" id="vacFilhos" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                            </div>
                            <div class="form-group espaco col-md-4">
                                <label for="foto">Foto 3x4 </label>
                                <input type="file" name="foto" class="form-control" id="foto" aria-describedby="inputGroupFileAddon03" required aria-label="Upload">
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