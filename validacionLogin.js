//definimos las variables
var formLogin = document.getElementById('formLogin');
var usernameLogin = document.getElementById('user');
var passwdLogin = document.getElementById('pass');

//Capturamos el evento submit
formLogin.addEventListener('submit', (e) => {
    e.preventDefault();

    validarFormLogin();
});

//Funcion que comprueba los datos de los inputs
function validarFormLogin(){
    
    //cogemos los valores de los inputs
    var usernameValue = user.value.trim();
    var passwordValue = pass.value.trim();

    //Comprueba que el nombre de usuario no esté vacío y que se corresponda con la cantidad y los caracteres válidos
    if (usernameValue == '' || usernameValue== null || usernameValue < 5 || usernameValue > 15 || !/^[a-zA-Z0-9_-]{5,15}$/.test(usernameValue)) {
        
        //Si se cumple la condición salta una alerta en el navegador
        alert("El nombre de usuario debe tener entre 5 y 15 caracteres válidos");
        return false;
    
    //Comprueba que la contraseña no está vacía y que la longitud es la indicada
    } else if (passwordValue == '' || passwordValue== null ||passwordValue < 8 || !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(passwordValue)) {
        
        //Si se cumple la condición salta una alerta en el navegador
        alert("La contraseña debe tener más de 8 caracteres, minúsculas, mayúsculas, números y caracteres especiales");
        return false;

    }

    //Si no hay errores se envía el formulario
    return true;
}