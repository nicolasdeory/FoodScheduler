$(document).ready(() => {

    $("button").click(function(e)
    {
        e.preventDefault();
        let title = $(this).parents().eq(1).find("h3").text();
        console.log(title);
        let url = title.replace("GET ", "").replace("POST ", "");
        if (title.indexOf("POST") >= 0)
        {
            // post request
        }
        else
        {
            // get request
            $.ajax
                ({
                type: "GET",
                url: `./api${url}`,
                dataType: "text",
                beforeSend: function (xhr){ 
                    xhr.setRequestHeader('Authorization', authHeaderValue); 
                },
                data: '{ "comment" }',
                success: function (data, textStatus, xhr){
                    $("#status").text(xhr.status + " OK");
                    $("#jsonoutput").val(data);
                }
                }).fail(function(xhr, textStatus)
                {
                    $("#status").text(xhr.status + " " + xhr.statusText);
                });

        }
        
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