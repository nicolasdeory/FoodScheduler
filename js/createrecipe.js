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


//TODO COMPROBAR QUE ESTE TODO COMPLETADO

$(document).ready(() => {
    console.log("hola guapeton que quieres para comer hoy");


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
    });

    $("#form-recipe").submit((e) => {
         e.preventDefault();
        // $("#crearreceta").html(`<span class="material-icons iconocolumna loading-anim"> restaurant </span>`);
        var ingred = [];
        var pasos = [];
        $(".ingredientenew").each(function(index){
            const ingred_name = $(this).children().find("input[name='input-name']").val();
            const ingred_qty = $(this).children().find("input[name='input-qty']").val();
            const ingred_qtyType = $(this).children().find("select[name='unidadDeMedida']").val();
            ingred.push({name: ingred_name, qty: ingred_qty, qtyType: ingred_qtyType});
        });

        $(".input-paso").each(function(index){
            const text = $(this).val();
            pasos.push(text);
        });
        
        var ingredsSanitized = []
        ingred.forEach((elm) =>
        {
            if (elm.name && elm.qty)
            {
                ingredsSanitized.push(elm);
            }
        });

        var stepsSanitized = []
        paos.forEach((str) =>
        {
            if (str)
            {
                stepsSanitized.push(str);
            }
        });
        
        console.log(ingredsSanitized);
        console.log(stepsSanitized);

       /* $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    nombre: $("#input-nombre").val(),
                    dif,
                    tipo,
                    ingrediente: $("#input-ingrediente").val(),
                    cantidad: $("#input-cantidad").val(),
                    unidad: $("#input-unidad").val(),
                    paso: $("#input-paso").val()
                },
                success: () => {
                   navigate("dashboard.php");
                }
            })
            .fail((data) => {
                $("#crear-receta").html(`Entrar`)
                console.log(data);
            });*/
    });
});