function menuProcesso(){

    if(document.getElementById("submenuProcesso").style.display == "none" || document.getElementById("submenuProcesso").style.display == "" ){
        document.getElementById("submenuProcesso").style.display = "block";
    }else{
        document.getElementById("submenuProcesso").style.display = "none";
    }
    
}

function menuUsuario(){

    if(document.getElementById("submenuUsuario").style.display == "none" || document.getElementById("submenuUsuario").style.display == "" ){
        document.getElementById("submenuUsuario").style.display = "block";
    }else{
        document.getElementById("submenuUsuario").style.display = "none";
    }
    
}

function abrirMenuMobile(){
    if(document.getElementById('menu-lateral').style.display=='none' || document.getElementById('menu-lateral').style.display==''){
        document.getElementById('menu-lateral').style.display='block';
    }else{
        document.getElementById('menu-lateral').style.display='none';
    }
}
