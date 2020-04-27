//Validación del Login

function validarFormLogin(){
     
    var user=document.getElementById("username").value;
    var pass=document.getElementById("passwd").value;
    var expresionUser=/[A-Za-z0-9_]{5,15}$/;
    var expresionPass=/(?=.*[\d\W])(?=.*[a-z])(?=.*[A-Z]){8,}$/;


if (user==null || user==0 || pass == null || pass==0) {

    alert("Los campos son obligatorios");
    return false;
    
}

else if (!expresionUser.test(user)) {
    
        alert("El Nombre de Usuario debe contener 5 carácteres sin superar los 15.");
        return false;
    }
    
else if (!expresionPass.test(pass)) {
    
        alert("La contraseña debe contener 8 carácteres, números, letras en mayúsculas y minúsculas.");
        return false;
    } 
    
}