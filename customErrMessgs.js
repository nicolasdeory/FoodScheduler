/*
        Mensaje personalizado input del usuario. 
        Aparece cuando el pattern no hace match.
        */ 
       var inputUsername = document.getElementById('username');
       inputUsername.oninvalid = function(event) {
       event.target.setCustomValidity('El Nombre de Usuario debe contener 5 carácteres sin superar los 15.');
       inputUsername.oninput=function(event){
       event.target.setCustomValidity("");
           };
       }



/*
       Mensaje personalizado input de la contraseña. 
       Aparece cuando el pattern no hace match.
       */ 
       var inputPasswd = document.getElementById('passwd');
       inputPasswd.oninvalid = function(event) {
       event.target.setCustomValidity('La contraseña debe contener 8 carácteres, números, letras en mayúsculas y minúsculas.');
       inputPasswd.oninput=function(event){
       event.target.setCustomValidity("");
           };
       }
    


/*
Mensaje personalizado input del nombre. 
Aparece cuando el pattern no hace match.
*/ 
var inputName = document.getElementById('nombre');
    inputName.oninvalid = function(event) {
    event.target.setCustomValidity('Introduzca un Nombre válido');
    inputName.oninput=function(event){
        event.target.setCustomValidity("");
    };
} 

/*
Mensaje personalizado input del apellido. 
Aparece cuando el pattern no hace match.
*/ 
var inputSurname = document.getElementById('apellidos');
    inputSurname.oninvalid = function(event) {
    event.target.setCustomValidity('Introduzca un Apellido válido');
    inputSurname.oninput=function(event){
        event.target.setCustomValidity("");
    };
} 

/*
Mensaje personalizado input del email. 
Aparece cuando el pattern no hace match.
*/ 
var inputEmail = document.getElementById('email');
    inputEmail.oninvalid = function(event) {
    event.target.setCustomValidity('Introduzca una Dirección de Correo Electrónico válido');
    inputEmail.oninput=function(event){
        event.target.setCustomValidity("");
    };
} 
