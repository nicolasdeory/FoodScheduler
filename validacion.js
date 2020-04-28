function validaFormLogin(){

    var user=document.getElementById("usernameLogin");
    var pass=document.getElementById("passwdLogin");

    if (user==null || user.length==0 || pass==null || pass.length==0) {
        alert("Los campos no pueden estar vacíos");
        return false;
    
    } else if(user.length<5 || user.length>15) {
        alert("El nombre de usuario debe tener más de 5 carácteres y menos de 15");
        return false;
    
    }else if (!(/^[a-zA-Z0-9]+$/).test(user)) {
        alert("Introduzca un valor válido en el nombre de usuario");
        return false;

    } else if(pass.length<8) {
        alert("La contraseña debe tener más de 8 carácteres");
        return false;
    
    } else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]$/).test(user)) {
        alert("La contraseña debe tener al menos una letra minúscula, una mayúscula, un número y un carácter especial");
        return false;

    }
    return true;

}