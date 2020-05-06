//definimos las variables
var formReg = document.getElementById('formReg');
var nombre = document.getElementById('nombre');
var apellidos = document.getElementById('apellidos');
var email = document.getElementById('email');
var user = document.getElementById('user');
var pass = document.getElementById('pass');

//Funcion que comprueba los datos introducidos en el formulario de registro(client-side)
function validaFormRegistro(){
    
    //cogemos los valores de los inputs
    var nombreValue = nombre.value.trim();
    var apellidosValue = apellidos.value.trim();
    var emailValue = email.value.trim();
    var usuarioValue = user.value.trim();
    var passValue = pass.value.trim();
    

    //Comprueba que el campo nombre no esté vacío
    if (nombreValue == '' || nombreValue== null) {
        
        //Salta una alerta en el navegador
        alert("El nombre no puede estar vacío");
        return false;
    
    //Comprueba que se corresponda con la cantidad y los caracteres válidos
    } else if(!/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}$/.test(nombreValue)){

        //Salta una alerta en el navegador
        alert("El nombre debe ser válido");
        return false;
    
    //Comprueba que el campo apellido no esté vacío 
    } else if (apellidosValue == '' || apellidosValue== null) {
        
        //Salta una alerta en el navegador
        alert("Los apellidos no pueden estar vacíos");
        return false;

    //Comprueba que se corresponda con la cantidad y los caracteres válidos
    }else if(!/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,64}$/.test(apellidosValue)){

        //Salta una alerta en el navegador
        alert("Los apellidos deben ser válidos");
        return false;

    //Comprueba que el correo electrónico no esté vacío
    }else if(emailValue == '' || emailValue== null ){
    
        //Salta una alerta en el navegador
        alert("El correo electrónico no puede estar vacío");
        return false;
    
    
    //Comprueba que se corresponda con la cantidad y los caracteres válidos
    }else if (!/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test(emailValue)) {
        
        //Salta una alerta en el navegador
        alert("El correo electrónico debe ser válido");
        return false;
    
    //Comprueba que el nombre de usuario no esté vacío y que se corresponda con la cantidad y los caracteres válidos
    }else if (usuarioValue == '' || usuarioValue== null || usuarioValue < 5 || usuarioValue > 15 || !/^[a-zA-Z0-9_-]{5,15}$/.test(usuarioValue)) {
        
        //Si se cumple la condición salta una alerta en el navegador
        alert("El nombre de usuario debe tener entre 5 y 15 caracteres válidos");
        return false;
    
    //Comprueba que la contraseña no está vacía, que la longitud y la forma sea la indicada
    } else if (passValue == '' || passValue== null ||passValue < 8 || !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(passValue)){
        
        //Si se cumple la condición salta una alerta en el navegador
        alert("La contraseña debe tener más de 8 caracteres, minúsculas, mayúsculas, números y caracteres especiales");
        return false;
    }

    //Si no hay errores se envía el formulario
    return true;
}  