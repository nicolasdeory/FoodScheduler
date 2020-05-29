if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined' ?
                args[number] :
                match;
        });
    };
}

function navigate(url)
    {
        lastUrl = currentUrl;
        $("#page-content").addClass("hidden");
        $("#page-loader").show();
        $.get(url, function(data) {
            $("#page-content").scrollTop(0);
            setTimeout(() =>
            {
                $("#page-content").html(data);
                $("#page-loader").hide();
                $("#page-content").removeClass("hidden");
                currentUrl = url;
            },100);
        }).fail((err) => {
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

$(function() {

    $("#schedule-button").click(() => 
    {
        navigate("schedule.html");
    });

    $("#search-button").click(() => 
    {
        navigate("busqueda.php");
    });

    $("#favorite-button").click(() => 
    {
        navigate("favoritas.php");
    });

    $("#fridge-button").click(() => 
    {
        navigate("fridge.html");
    });

    $.get("schedule.html", function(data) {
        $("#page-content").html(data);
        $("#page-loader").hide();
        $("#page-content").removeClass("hidden");
    });

    

});