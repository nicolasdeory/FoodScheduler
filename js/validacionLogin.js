//definimos las variables
var usernameLogin = document.getElementById('user');
var passwdLogin = document.getElementById('pass');

//Funcion que comprueba los datos introducidos en el formulario(client-side)
function validarFormLogin(){
    
    //cogemos los valores de los inputs
    var usernameValue = user.value.trim();
    var passwordValue = pass.value.trim();

    //Comprueba que el nombre de usuario no esté vacío y que se corresponda con la cantidad y los caracteres válidos
    if (usernameValue == '' || usernameValue== null) 
    {
        //Si se cumple la condición salta una alerta en el navegador
        alert("Introduce el nombre de usuario.");
        return false;
    
    //Comprueba que la contraseña no está vacía y que la longitud es la indicada
    } 
    else if (passwordValue == '' || passwordValue== null ) 
    {
        
        //Si se cumple la condición salta una alerta en el navegador
        alert("Introduce la contraseña.");
        return false;

    }

    //Si no hay errores se envía el formulario
    return true;
}