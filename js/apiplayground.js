function getParamsFromButtonObject(button) 
{
    let dataParams = {};
    $(button).parent().find("input").each(function() 
    {
        let paramName = $(this).attr("param-name");
        let paramValue = $(this).val();
        if (paramValue.length > 0)
            dataParams[paramName] = paramValue;
    });
    return dataParams;
}

function getQueryStringFromParams(params) 
{
    let paramString = "";
    let paramKeys = Object.keys(params);
    for (let i = 0; i < paramKeys.length; i++) {
        if (!params[paramKeys[i]] || params[paramKeys[i]].length == 0)
            continue;
        if (paramString.length > 0)
            paramString += "&";
        paramString += paramKeys[i] + "=" + params[paramKeys[i]];
    }
    return paramString;
}

$(document).ready(() => {

    function doCreateRecipe(object)
{
    let params = getParamsFromButtonObject($(object));
    var formData = new FormData();
    if ($('#create-recipe-file').prop('files').length > 0)
    {
        file = $('#create-recipe-file').prop('files')[0];
        formData.append("thumbnail", file);
    }
    if (params.ingredients)
        formData.append("ingredients", params.ingredients);
    if (params.steps)
        formData.append("steps", params.steps);
    if (params.nombre)
        formData.append("nombre", params.nombre);
    if (params.dif)
        formData.append("dif", params.dif);
    if (params.visibility)
        formData.append("visibility", params.visibility);
    if (params.tiempo)
        formData.append("tiempo", params.tiempo);

    $.ajax({
        type: "POST",
        url: "./api/create_recipe.php",
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function (xhr){ 
            xhr.setRequestHeader('Authorization', authHeaderValue); 
        },
        success: function(data, textStatus, xhr)
        {
            $("#status").text(xhr.status + " OK");
            $("#jsonoutput").val(data);
        }
    })
    .fail(function(xhr, textStatus)
    {
        $("#status").text(xhr.status + " " + xhr.statusText);
        $("#jsonoutput").val(xhr.responseText);
    });
}

    $(".tester-div input").change(function() 
    {
        let title = $(this).parent().parent().find("h3").text();
        if (title.indexOf("create_recipe.php") >= 0)
            return; // create_recipe is a special request
        let url = title.replace("GET ", "").replace("POST ", "");
        
        let params = getParamsFromButtonObject($(this));
        let queryString = getQueryStringFromParams(params);
        console.log(queryString);
        if (title.indexOf("POST") >= 0)
        {
            url = ""; // omit url
        } else if (queryString.length > 0)
        {
            url += "?";
        }
        
        $(this).parent().find("p").text(`${url}${queryString}`)
    });

    $("button").click(function(e)
    {
        e.preventDefault();
        let title = $(this).parents().eq(1).find("h3").text();
        if (title.indexOf("create_recipe.php") >= 0)
        {
            doCreateRecipe(this);
            return;
        }
        console.log(title);
        let url = title.replace("GET ", "").replace("POST ", "");
        let dataParams = getParamsFromButtonObject($(this));

        if (title.indexOf("POST") >= 0)
        {
            // post request
            $.ajax(
            {
                type: "POST",
                url: `./api${url}`,
                contentType: "application/x-www-form-urlencoded",
                dataType: "text; charset=ISO-8859-15",
                data: dataParams,
                beforeSend: function (xhr){ 
                    xhr.setRequestHeader('Authorization', authHeaderValue); 
                },
                success: function (data, textStatus, xhr){
                    $("#status").text(xhr.status + " OK");
                    $("#jsonoutput").val(data);
                }
            }).fail(function(xhr, textStatus)
            {
                $("#status").text(xhr.status + " " + xhr.statusText);
                $("#jsonoutput").val(xhr.responseText);
            });
        }
        else
        {
            let queryString = getQueryStringFromParams(dataParams);
            // get request
            $.ajax(
            {
                type: "GET",
                url: `./api${url}?${queryString}`,
                dataType: "text",
                beforeSend: function (xhr){ 
                    xhr.setRequestHeader('Authorization', authHeaderValue); 
                },
                success: function (data, textStatus, xhr){
                    $("#status").text(xhr.status + " OK");
                    $("#jsonoutput").val(xhr.responseText);
                }
            }).fail(function(xhr, textStatus)
            {
                $("#status").text(xhr.status + " " + xhr.statusText);
                $("#jsonoutput").val(xhr.responseText);
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