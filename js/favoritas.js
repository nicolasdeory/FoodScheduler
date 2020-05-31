var favoritasLoaded = false;
if (!favoritasLoaded)
{    
    $(document).ready(() => {

        window.attachEventsToRecipeCards();

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

