//CREAMOS LAS VARIABLES:
var nombre = document.getElementById('input-nombre');
var dif = "";
var tipo = 1;


// DATOS DE LOS INGREDIENTES
var ingrediente = document.getElementById('input-ingrediente');
var cantidad = document.getElementById('input-cantidad');
var unidad = document.getElementById('input-unidad');

// PASOS
var paso = document.getElementById('input-paso')




$(document).ready(() => {

    $("#star1").click(() =>
    {
        dif = "Sencillo";
    });
    $("#star2").click(() =>
    {
        dif = "Fácil";
    });
    $("#star3").click(() =>
    {
        dif = "Medio";
    });
    $("#star4").click(() =>
    {
        dif = "Difícil";
    });
    $("#star5").click(() =>
    {
        dif = "Muy difícil";
    });


    $("#private").click(() =>
    {
        tipo = 0;
    })

    $("#public").click(() =>
    {
        tipo = 1;
    })


    $("#form-recipe").submit((e) => {
        e.preventDefault();
        $("#enviar").html(`<span class="material-icons iconocolumna loading-anim"> restaurant </span>`)
        $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    user: $("#user").val(),
                    pass: $("#pass").val()
                },
                success: () => {
                    window.location.href = "dashboard.php";
                }
            })
            .fail((data) => {
                $("#enviar").html(`Entrar`)
                console.log(data);
                if (data.responseText == 'wrong pass') {
                    alert("Usuario o contraseña incorrectos.");
                }
            });
    });
});