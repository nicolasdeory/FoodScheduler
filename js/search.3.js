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
                            <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                            <div class="numberlikes"> {2} </div>
                        </div>
                        <div class="time">
                            <div class="timeicon"><i class="far fa-clock"></i></div>
                            <div class="amounttime"> {3} min</div>
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
                        <input type="radio" name="schd-meal" id="schd-mean-comida" value="Almuerzo" required>
                        <label for="schd-mean-comida">Almuerzo</label>
                        <input type="radio" name="schd-meal" id="schd-mean-cena" value="Cena" required>
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

    function search(url)
    {
        $.get(url, (data) =>
        {
            $("#contenedor").children().slice(1).remove();
            data.forEach(x =>
            {
                $("#contenedor").append(RECIPE_HTML.format(x.ID_RECETA, x.NOMBRE, x.POPULARIDAD, x.TIEMPOELABORACION, x.DIFICULTAD));
            });

            $(".recipetitle").click(function()
            {
                const recipeId = $(this).parents().eq(4).attr("recipe-id");
                navigate("vistareceta.php?id=" + recipeId);
            });

            $(".add-schd-btn").click(function()
            {
                $(".result").removeClass("adding-schd");
                $(this).parents().eq(3).addClass("adding-schd");
            });

            $(".btn-schd-close").click(function() 
            {
                $(this).parents().eq(2).removeClass("adding-schd");
            });

            $(".add-to-schedule-prompt form").submit(function(e) 
            {
                e.preventDefault();
                const promptNode = $(this).parent();
                const parentNode = $(promptNode).parent();
                const recipeId = $(parentNode).attr("recipe-id");
                const schdDate = new Date($(parentNode).children().find("input[name='schd-date']").val());
                const schdMeal = $(parentNode).children().find("input[name='schd-meal']:checked").val();

                var schdDateFormatted = schdDate.getDate() + "-" + (schdDate.getMonth() + 1) + "-" + schdDate.getFullYear();

                $(parentNode).addClass("success-anim");
                $(parentNode).removeClass("adding-schd");

                $.ajax({
                    type: "POST",
                    url: `add_schedule.php`,
                    data: {
                        id: recipeId,
                        date: schdDateFormatted,
                        meal: schdMeal
                    },
                    success: () => {
                        console.log("recipe added to schedule");
                    }
                })
                .fail((data) => {
                    if (data.responseText == "already exists")
                    {
                        alert("Ya tienes planificada esa receta para el día que has indicado.");
                    } else 
                    {
                        alert("Ha ocurrido un error añadiendo la receta a la planificación.");
                    }
                });

                setTimeout(() => 
                {
                    $(parentNode).removeClass("success-anim");
                },1500);
            });

            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

            $("input[name='schd-date']").val(today);

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