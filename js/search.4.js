var busquedaLoaded = false;
if (!busquedaLoaded)
{
    busquedaLoaded = true;
    const RECIPE_HTML = `<div class="result" recipe-id="{0}">
            <div class="recipe-container">
                <div class="photo">
                    <img class="spaguetti" src="images/photo{0}.jpg">
                </div>
                <div class="description">
                    <div class="recipe-title-container">
                        <div class="recipetitle">{1}</div>
                        <div class="add-schd-btn"><i class="far fa-calendar-plus"></i></div>
                    </div>
                    
                    <div class="info">
                        <div class="like">
                            <div class="likeicon"> <span class="material-icons iconocolumna"> {5} </span> </div>
                            <div class="numberlikes"> {2} </div>
                        </div>
                        <div class="time">
                            <div class="timeicon"><i class="far fa-clock"></i></div>
                            <div class="amounttime"> {3} min.</div>
                        </div>
                        <div class="difficulty">
                        <div class="texto-dif">
                        <div class="dif">
                                <div class="rating">
                                    
                                        <div class="star"></div>                                  
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                
                                    <div class="text" id="rating-label-text"> {4} </div>
                                    <div class="clear"></div>
                                </div>
                        </div>
                    </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="add-to-schedule-prompt">
                <form>
                    <span class="material-icons btn-schd-close">close</span>
                    <h2>Añadir a planificación</h2>
                    <div class="btn-date">Fecha</div>
                    <input type="date" name="schd-date" required></input>
                    <div class="btn-date">
                        <input type="radio" name="schd-meal" value="Almuerzo" required>
                        <label for="schd-mean-comida">Almuerzo</label>
                        <input type="radio" name="schd-meal" value="Cena" required>
                        <label for="schd-mean-cena">Cena</label>
                    </div>
                    <div class="boton add-to-schd-submit">
                        <button class="button">Añadir</button>
                    </div>
                </form>
            </div>
        </div>`;

    if (!String.prototype.format)
    {
        String.prototype.format = function ()
        {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number)
            {
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }

    function attachListeners()
    {
        window.attachEventsToRecipeCards();
    }

    function search(url)
    {
        $.get(url, (data) =>
        {
            $("#contenedor").children().slice(1).remove();
            var processedI = 0;
            var tobeProcessed = data.length;
            data.forEach(x =>
            {
                $.get("is_favorited.php?id=" + x.ID_RECETA, function(res)
                {
                    var isFav = res;
                    var favString = isFav == "true" ? "favorite" : "favorite_border";
                    var appendedElem = $(RECIPE_HTML.format(x.ID_RECETA, x.NOMBRE, x.POPULARIDAD, 
                        x.TIEMPOELABORACION, x.DIFICULTAD, favString)).appendTo("#contenedor");

                    $(appendedElem).children().find(".likeicon span").click(function()
                    {
                        var favText = $(this).text().trim();
                        var isFaved = favText == "favorite";
                        if (isFaved)
                        {
                            $.get("remove_favorite.php?id=" + x.ID_RECETA, () =>
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
                            $.get("add_favorite.php?id=" + x.ID_RECETA, () =>
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

                    processedI++;
                    if (processedI >= data.length - 1) 
                    {
                        attachListeners();
                    }
                });
            });

        });
    }

    $(document).ready(() =>
    {
        var dif = "";
        $("#star1").click(() =>
        {
            dif = "Sencillo";
        });
        $("#star2").click(() =>
        {
            dif = "Fácil";
        });
        $("#star3").click(() =>
        {
            dif = "Medio";
        });
        $("#star4").click(() =>
        {
            dif = "Difícil";
        });
        $("#star5").click(() =>
        {
            dif = "Muy difícil";
        });

        /*var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
          ];
          $( "#input-ingrediente" ).autocomplete({
            source: availableTags
          });*/

        $("#buscar").click(() =>
        {

            var nombre = $("#input-nombre").val();
            var ingred = $("#input-ingrediente").val();
            var url = "searchrecipe.php?"
            if (nombre.length > 0) url += `nombre=${nombre}`;
            //if nombre.length>0 return & else ''
            if (ingred.length > 0) url += `${nombre.length > 0 ? '&' : ''}ingrediente=${ingred}`;
            if (dif.length > 0) url += `${(nombre.length > 0 || ingred.length > 0) ? '&' : ''}dificultad=${dif}`;
            
            search(url);
        });

        search('searchrecipe.php');

    });
}