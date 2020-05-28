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
            $("#page-content").html(data);
            $("#page-loader").hide();
            $("#page-content").removeClass("hidden");
        }).fail((err) => {
            alert("Ha ocurrido un error navegando al elemento que has especificado.");
            navigate("schedule.html");
        });
    }

$(function() {

    $("#favorite-button").click(() => 
    {
        navigate("saved.php");
    });

    $.get("schedule.html", function(data) {
        $("#page-content").html(data);
        $("#page-loader").hide();
        $("#page-content").removeClass("hidden");
    });

    

});