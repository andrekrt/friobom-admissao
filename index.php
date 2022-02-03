<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false){

    $idUsuario = $_SESSION['idUsuario'];

    $sql = $db->prepare("SELECT * FROM usuarios WHERE idusuarios = :idUsuario");
    $sql->bindValue(':idUsuario', $idUsuario);
    $sql->execute();

    if($sql->rowCount()>0){
        $dado = $sql->fetch();

        $nomeUsuario = $dado['nome_usuario'];
        $tipoUsuario = $dado['tipo_usuario_idtipo_usuario'];
        $_SESSION['tipoUsuario'] = $tipoUsuario;
        $_SESSION['nomeUsuario'] = $nomeUsuario;


        if($tipoUsuario==1){
            $qtdTotal = $db->query("SELECT * FROM documentos_admissao");
            $qtdTotal = $qtdTotal->rowCount();

            $qtdAnalise = $db->query("SELECT * FROM documentos_admissao WHERE situacao = 'Em Análise'");
            $qtdAnalise = $qtdAnalise->rowCount();

            $qtdPendente = $db->query("SELECT * FROM documentos_admissao WHERE situacao = 'Documentação Pendente'");
            $qtdPendente = $qtdPendente->rowCount();

            $qtdOk = $db->query("SELECT * FROM documentos_admissao WHERE situacao = 'Documentação OK'");
            $qtdOk = $qtdOk->rowCount();

        }elseif($tipoUsuario==2){
            $qtdTotal = $db->query("SELECT * FROM documentos_admissao WHERE usuarios_idusuarios = '$idUsuario'");
            $qtdTotal = $qtdTotal->rowCount();

            $qtdAnalise = $db->query("SELECT * FROM documentos_admissao WHERE usuarios_idusuarios = '$idUsuario' AND situacao = 'Em Análise'");
            $qtdAnalise = $qtdAnalise->rowCount();

            $qtdPendente = $db->query("SELECT * FROM documentos_admissao WHERE usuarios_idusuarios = '$idUsuario' AND situacao = 'Documentação Pendente'");
            $qtdPendente = $qtdPendente->rowCount();

            $qtdOk = $db->query("SELECT * FROM documentos_admissao WHERE usuarios_idusuarios = '$idUsuario' AND situacao = 'Documentação OK'");
            $qtdOk = $qtdOk->rowCount();
        }
        
    }else{
        header("Location:login.php");
    }

}else{
    header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FRIOBOM - TRANSPORTE</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="container-fluid corpo">
            <div class="menu-lateral" id="menu-lateral">
                <div class="logo">  
                    <img src="assets/images/logo.png" alt="">
                </div>
                <div class="opcoes" >
                    <div class="item">
                        <a href="index.php">
                            <img src="assets/images/menu/inicio.png" alt="">
                        </a>
                    </div>
                    <div class="item">
                        <a class="" onclick="menuProcesso()">
                            <img src="assets/images/menu/documentacao.png" alt="">
                        </a>
                        <nav id="submenuProcesso">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="documentos/documentos.php"> Documentações Enviadas </a> </li>
                                <?php if($tipoUsuario==2): ?>
                                <li class="nav-item"> <a class="nav-link" href="documentos/form-curriculo.php"> Enviar Documentação </a> </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php if($tipoUsuario==1): ?>
                    <div class="item">
                        <a onclick="menuAlmoxarifado()">
                            <img src="assets/images/menu/material.png" alt="">
                        </a>
                        <nav id="submenuAlmoxarifado">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="almoxarifado/estoque.php">Estoque</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="almoxarifado/entradas.php">Entradas</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="almoxarifado/saidas.php">Saídas</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="fornecedores/fornecedores.php">Fornecedores</a> </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="item">
                        <a onclick="menuUsuario()">
                            <img src="assets/images/menu/usuarios.png" alt="">
                        </a>
                        <nav id="submenuUsuario">
                            <ul class="nav flex-column">
                                <li class="nav-item"> <a class="nav-link" href="usuario/form-usuario.php"> Novo Usuário </a> </li>
                                <li class="nav-item"> <a class="nav-link" href="usuario/usuarios.php"> Listar Usuários </a> </li>
                            </ul> 
                        </nav> 
                    </div>
                    <?php endif; ?>
                    <div class="item">
                        <a href="sair.php">
                            <img src="assets/images/menu/sair.png" alt="">
                        </a>
                    </div>
                </div>                
            </div>
            <!-- Tela com os dados -->
            <div class="tela-principal">
                <div class="menu-superior">
                   <div class="icone-menu-superior">
                        <img src="assets/images/icones/home.png" alt="">
                   </div>
                   <div class="title">
                        <h2>Bem-Vindo <?php echo $nomeUsuario ?></h2>
                   </div>
                   <div class="menu-mobile">
                        <img src="assets/images/icones/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                   </div>
                </div>
                <div class="menu-principal">
                    <div class="area-indice-val">
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Documentações Enviadas</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/documento-enviado.png" alt="">
                                <p class="qtde"> <?= $qtdTotal ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Documentações Em Análise</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/documento-analise.png" alt="">
                                <p class="qtde"> <?=$qtdAnalise ?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Documentações Pendente</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/documento-pendente.png" alt="">
                                <p class="qtde"> <?=$qtdPendente?> </p>
                            </div>
                        </div>
                        <div class="indice-ind">
                            <div class="indice-ind-tittle">
                                <p>Documentações OK</p>
                            </div>
                            <div class="indice-qtde">
                                <img src="assets/images/icones/document-ok.png" alt="">
                                <p class="qtde"> <?=$qtdOk?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/menu.js"></script>
    </body>
</html>