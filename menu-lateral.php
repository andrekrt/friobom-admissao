<div class="menu-lateral" id="menu-lateral">
    <div class="logo">  
        <img src="../assets/images/logo.png" alt="">
    </div>
    <div class="opcoes" >
        <div class="item">
            <a href="../index.php">
                <img src="../assets/images/menu/inicio.png" alt="">
            </a>
        </div>
        <div class="item">
            <a onclick="menuProcesso()">
                <img src="../assets/images/menu/documentacao.png" alt="">
            </a>
            <nav id="submenuProcesso">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../documentos/documentos.php"> Documentações Enviadas </a> </li>
                    <?php if($tipoUsuario==2): ?>
                    <li class="nav-item"> <a class="nav-link" href="../documentos/form-curriculo.php"> Enviar Documentação </a> </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php if($tipoUsuario==1): ?>
        <div class="item">
            <a onclick="menuAlmoxarifado()">
                <img src="../assets/images/menu/material.png" alt="">
            </a>
            <nav id="submenuAlmoxarifado">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../almoxarifado/estoque.php">Estoque</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../almoxarifado/entradas.php">Entradas</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../almoxarifado/saidas.php">Saídas</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../fornecedores/fornecedores.php">Fornecedores</a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuRescisao()">
                <img src="../assets/images/menu/rescisao.png" alt="">
            </a>
            <nav id="submenuRescisao">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../rescisao/form-rescisao.php">Registrar Rescisão</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../rescisao/rescisoes.php">Rescisões</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../rescisao/form-distrato.php">Registrar Distrato</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../rescisao/distratos.php">Distratos</a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuAdvertencia()">
                <img src="../assets/images/menu/menu-advertencia.jpg" alt="">
            </a>
            <nav id="submenuAdvertencia">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../advertencias/form-advertencia.php">Registrar Advertência/Suspensão</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../advertencias/advertencias.php">Advertências</a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuEntrevista()">
                <img src="../assets/images/menu/MENU-ENTREVISTA.png" alt="">
            </a>
            <nav id="submenuEntrevista">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../entrevistas/form-entrevista.php">Registrar Entrevista</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../entrevistas/entrevistas.php">Entrevistas</a> </li>
                </ul>
            </nav>
        </div>
        <div class="item">
            <a onclick="menuUsuario()">
                <img src="../assets/images/menu/usuarios.png" alt="">
            </a>
            <nav id="submenuUsuario">
                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link" href="../usuario/form-usuario.php"> Novo Usuário </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="../usuario/usuarios.php"> Listar Usuários </a> </li>
                </ul> 
            </nav> 
        </div>
        <?php endif; ?>
        <div class="item">
            <a href="../sair.php">
                <img src="../assets/images/menu/sair.png" alt="">
            </a>
        </div>
    </div>                
</div>