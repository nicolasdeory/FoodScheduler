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
        $("#page-content").addClass("hidden");
        $("#page-loader").show();
        $.get(url, function(data) {
            
            setTimeout(() =>
            {
                $("#page-content").html(data);
                $("#page-loader").hide();
                $("#page-content").removeClass("hidden");
            },100);
        }).fail((err) => {
            alert("Ha ocurrido un error navegando al elemento que has especificado.");
            navigate("schedule.html");
        });
        
    }

$(function() {

    $("#schedule-button").click(() => 
    {
        navigate("schedule.html");
    });

    $("#favorite-button").click(() => 
    {
        navigate("saved.php");
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