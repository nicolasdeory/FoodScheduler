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
        $.get("vistareceta.php?id=1", function(data) {
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