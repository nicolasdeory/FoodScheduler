var favoritasLoaded = false;
if (!favoritasLoaded)
{    
    $(document).ready(() => {

        window.attachEventsToRecipeCards();

        $(".result").each(function()
        {
            var dificultad = $(this).children().find(".rating .text").text().trim();
            console.log(dificultad);
            switch (dificultad)
            {
                case "Sencillo":
                    console.log("haols");
                    $(this).children().find(".rating :nth-child(5)").addClass("star-filled");
                    break;
                case "Fácil":
                    $(this).children().find(".rating :nth-child(5)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(4)").addClass("star-filled");
                    break;
                case "Medio":
                    $(this).children().find(".rating :nth-child(5)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(4)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(3)").addClass("star-filled");
                    break;
                case "Difícil":
                    $(this).children().find(".rating :nth-child(5)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(4)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(3)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(2)").addClass("star-filled");
                    break;
                case "Muy Difícil":
                    $(this).children().find(".rating :nth-child(5)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(4)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(3)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(2)").addClass("star-filled");
                    $(this).children().find(".rating :nth-child(1)").addClass("star-filled");
                    break;

            }
        });

        $(".likeicon span").click(function()
        {
            var favText = $(this).text().trim();
            var isFaved = favText == "favorite";
            var idReceta = $(this).parents().eq(5).attr("recipe-id");
            if (isFaved)
            {
                $.get("remove_favorite.php?id=" + idReceta, () =>
                {
                    // search(url); // we're not gonna reload
                    $(this).text("favorite_border");
                    var elem = $(this).parents().eq(3).find(".numberlikes");
                    var txt = parseInt($(elem).text());
                    $(elem).text(txt-1);
                })
                .fail(() =>
                {
                    alert("Ha ocurrido un error desmarcando la receta como favorita.");
                });
            }
            else 
            {
                $.get("add_favorite.php?id=" + idReceta, () =>
                {
                    //search(url); // we're not gonna reload
                    $(this).text("favorite");
                    var elem = $(this).parents().eq(3).find(".numberlikes");
                    var txt = parseInt($(elem).text());
                    $(elem).text(txt+1);
                })
                .fail(() =>
                {
                    alert("Ha ocurrido un error marcando la receta como favorita.");
                });
            }
        });

    });
}

