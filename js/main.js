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

$(function() {

    $("#favorite-button").click(() => 
    {
        $("#page-content").addClass("hidden");
        $.get("favoritas.php", function(data) {
            $("#page-content").html(data);
            $("#page-loader").hide();
            $("#page-content").removeClass("hidden");
        });
    });

    $("#restaurant-button").click(() => 
    {
        $("#restaurant-button").addClass("hidden");
        $.get("busqueda.php", function(data) {
            $("#page-content").html(data);
            $("#page-loader").hide();
            $("#page-content").removeClass("hidden");
        });
    });

    $.get("schedule.html", function(data) {
        $("#page-content").html(data);
        $("#page-loader").hide();
        $("#page-content").removeClass("hidden");
    });

});