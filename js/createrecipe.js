$(document).ready(() => {

    $("#form-recipe").submit((e) => {
        e.preventDefault();
        $("#enviar").html(`<span class="material-icons iconocolumna loading-anim"> restaurant </span>`)
        $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    user: $("#user").val(),
                    pass: $("#pass").val()
                },
                success: () => {
                    window.location.href = "dashboard.php";
                }
            })
            .fail((data) => {
                $("#enviar").html(`Entrar`)
                console.log(data);
                if (data.responseText == 'wrong pass') {
                    alert("Usuario o contraseña incorrectos.");
                }
            });
    });
});