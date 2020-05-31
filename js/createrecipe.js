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

$(document).ready(() =>
{
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

    $("#form-recipe").submit((e) =>
    {
        e.preventDefault();
        var ingred = [];
        var pasos = [];
        $(".ingredientenew").each(function (index)
        {
            const ingred_name = $(this).children().find("input[name='input-name']").val();
            const ingred_qty = $(this).children().find("input[name='input-qty']").val();
            const ingred_qtyType = $(this).children().find("select[name='unidadDeMedida']").val();
            ingred.push({ name: ingred_name, qty: ingred_qty, qtyType: ingred_qtyType });
        });

        $(".input-paso").each(function (index)
        {
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
            else if (elm.name)
            {
                // warn user they have specified name but not qty
                alert("Debes especificar la cantidad de ingrediente.");
            }
        });

        var stepsSanitized = []
        pasos.forEach((str) =>
        {
            if (str)
            {
                stepsSanitized.push(str);
            }
        });

        console.log(ingredsSanitized);
        console.log(stepsSanitized);

        var formData = new FormData();
        if ($('#input-thumbnail').prop('files').length > 0)
        {
            file = $('#input-thumbnail').prop('files')[0];
            formData.append("thumbnail", file);
        }
        var name = $("#input-nombre").val();
        var time = $("#input-time").val();
        console.log("processing formData" + name + " " + time);
        formData.append("ingredients", JSON.stringify(ingredsSanitized));
        formData.append("steps", JSON.stringify(stepsSanitized));
        formData.append("nombre", name);
        formData.append("dif", dif);
        formData.append("visibility", tipo.toString());
        formData.append("tiempo", time);
        console.log(formData);

        $("#crear-receta").html(`<span class="material-icons iconocolumna loading-anim"> restaurant </span>`)
        $.ajax({
            type: "POST",
            url: "create_recipe.php",
            processData: false,
            contentType: false,
            data: formData,
            success: () =>
            {
                navigate("favoritas.php");
                $('.elemento').removeClass('elementoactivo');
                $('#favorite-button').addClass('elementoactivo');
            }
        })
            .fail((data) =>
            {
                $("#crear-receta").html(`Añadir Receta`);
                alert("Ha ocurrido un error creando la receta.");
                console.log(data);
            });
    });
});