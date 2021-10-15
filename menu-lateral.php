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
                    <li class="nav-item"> <a class="nav-link" href="../documentos/form-documentos.php"> Enviar Documentação </a> </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php if($tipoUsuario==1): ?>
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