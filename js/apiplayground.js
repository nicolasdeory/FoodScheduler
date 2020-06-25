$(document).ready(() => {

    $("button").click(function(e)
    {
        e.preventDefault();
    });

    var authHeaderValue = "";
    $("#authform input").change(() => 
    {
        let user = $("#user").val();
        let password = $("#password").val();
        let base64 = btoa(user + ":" + password);
        authHeaderValue = "Basic " + base64;
        $("#authheader").text("Authorization: " + authHeaderValue);
    });

    $("#page-content").scroll(() => 
    {
        var scrollTop = $("#page-content").scrollTop();
        $(".outputdiv").css("margin-top",scrollTop + "px");
    });

});