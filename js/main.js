if (!String.prototype.format)
{
    String.prototype.format = function ()
    {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number)
        {
            return typeof args[number] != 'undefined' ?
                args[number] :
                match;
        });
    };
}

function attachEventsToRecipeCards()
{
    $(".recipetitle").click(function ()
    {
        const recipeId = $(this).parents().eq(3).attr("recipe-id");
        navigate("vistareceta.php?id=" + recipeId);
    });

    $(".add-schd-btn").click(function ()
    {
        $(".result").removeClass("adding-schd");
        $(this).parents().eq(3).addClass("adding-schd");
    });

    $(".btn-schd-close").click(function () 
    {
        $(this).parents().eq(2).removeClass("adding-schd");
    });

    $(".add-to-schedule-prompt form").submit(function (e) 
    {
        e.preventDefault();
        const promptNode = $(this).parent();
        const parentNode = $(promptNode).parent();
        const recipeId = $(parentNode).attr("recipe-id");
        const schdDate = new Date($(parentNode).children().find("input[name='schd-date']").val());
        const schdMeal = $(parentNode).children().find("input[name='schd-meal']:checked").val();

        var schdDateFormatted = schdDate.getDate() + "-" + (schdDate.getMonth() + 1) + "-" + schdDate.getFullYear();

        $(parentNode).addClass("success-anim");
        $(parentNode).removeClass("adding-schd");

        $.ajax({
            type: "POST",
            url: `add_schedule.php`,
            data: {
                id: recipeId,
                date: schdDateFormatted,
                meal: schdMeal
            },
            success: () =>
            {
                console.log("recipe added to schedule");
            }
        })
            .fail((data) =>
            {
                if (data.responseText == "already exists")
                {
                    alert("Ya tienes planificada esa receta para el día que has indicado.");
                } else 
                {
                    alert("Ha ocurrido un error añadiendo la receta a la planificación.");
                }
            });

        setTimeout(() => 
        {
            $(parentNode).removeClass("success-anim");
        }, 1500);
    });

    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $("input[name='schd-date']").val(today);
}

function navigate(url)
{
    lastUrl = currentUrl;
    $("#page-content").addClass("hidden");
    $("#page-loader").show();
    $.get(url, function (data)
    {
        $("#page-content").scrollTop(0);
        setTimeout(() =>
        {
            $("#page-content").html(data);
            $("#page-loader").hide();
            $("#page-content").removeClass("hidden");
            currentUrl = url;
        }, 100);
    }).fail((err) =>
    {
        alert("Ha ocurrido un error navegando al elemento que has especificado.");
        navigate("schedule.html");
    });

}

var currentUrl = "schedule.html";
var lastUrl = currentUrl;
function navigateBack() 
{
    navigate(lastUrl);
}

$(function ()
{

    $("#schedule-button").click(() => 
    {
        navigate("schedule.html");
        $('.elemento').removeClass('elementoactivo');
        $('#schedule-button').addClass('elementoactivo');


    });

    $("#search-button").click(() => 
    {
        navigate("busqueda.php");
        $('.elemento').removeClass('elementoactivo');
        $('#search-button').addClass('elementoactivo');


    });

    $("#favorite-button").click(() => 
    {
        navigate("favoritas.php");
        $('.elemento').removeClass('elementoactivo');
        $('#favorite-button').addClass('elementoactivo');

    });

    $("#fridge-button").click(() => 
    {
        navigate("fridge.html");
        $('.elemento').removeClass('elementoactivo');
        $('#fridge-button').addClass('elementoactivo');


    });

    $("#create-button").click(() => 
    {
        navigate("create_recipe.php");
        $('.elemento').removeClass('elementoactivo');
        $('#create-button').addClass('elementoactivo');


    });

    $("#campanacambiar").click(() =>
    {
        navigate("schedule.html")
        $('.elemento').removeClass('elementoactivo');
        $('#schedule-button').addClass('elementoactivo');
        window.location.reload();
    });


    $("#help-button").click(() => 
    {
        navigate("ayuda.html");
    });

    $("#acc-button").click(() => 
    {
        navigate("myaccount.php");
    });

    $.get("schedule.html", function (data)
    {
        $("#page-content").html(data);
        $("#page-loader").hide();
        $("#page-content").removeClass("hidden");
    });

});