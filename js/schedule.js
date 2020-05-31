var scheduleLoaded = false;
if (!scheduleLoaded)
{
    scheduleLoaded = true;
    const RECIPE_TEMPLATE = `
    <li><a recipe-id="{0}">{1}</a></li>
    `;
    
    const MISSING_INGREDIENT_TEMPLATE = `
    <li ingred-id="{0}" ingred-qty="{1}" ingred-msr="{2}">
        <i class="fas fa-plus add-icon"></i>
        <span class="ingredient">{3}</span>
        <span class="description">Para cocinar {4}</span>
    </li>
    `;
    
    // TODO: Show some brief info on hover
    
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }
    
    $(function() {
    
        function retrieveSchedule(mondayDate) {
            var today = new Date();
            var diff = today - mondayDate;
            $(`#day-container span`).removeClass("selected");
            if (diff > 0 && diff <= 7*24*3600*1000)
            {
                // highlight the relevant day
                var day = Math.floor(diff / (24*3600*1000));
                $(`#day-container :nth-child(${day+1}`).addClass("selected");
            }
            var sundayDate = mondayDate.addDays(6);
            var mondayDateDay = mondayDate.getDate().toString();
            var sundayDateDay = sundayDate.getDate().toString();
            var mondayDateMonth = (mondayDate.getMonth() + 1).toString();
            var sundayDateMonth = (sundayDate.getMonth() + 1).toString();
            var mondayDateString = (mondayDateDay.length < 2 ? "0" : "") + mondayDateDay + "/" +
                (mondayDateMonth.length < 2 ? "0" : "") + mondayDateMonth;
            var sundayDateString = (sundayDateDay.length < 2 ? "0" : "") + sundayDateDay + "/" +
                (sundayDateMonth.length < 2 ? "0" : "") + sundayDateMonth;
            $("#date-string").text(`Semana del ${mondayDateString} al ${sundayDateString}`);
    
            var mondayDateFormatted = mondayDate.getDate() + "-" + (mondayDate.getMonth() + 1) + "-" + mondayDate.getFullYear();
            var sundayDateFormatted = sundayDate.getDate() + "-" + (sundayDate.getMonth() + 1) + "-" + sundayDate.getFullYear();
    
            $.get(`./schedule.php?from=${mondayDateFormatted}&to=${sundayDateFormatted}`, (schedules) => {
                $("td ul").empty();
                schedules.forEach(schd => {
                    const date = new Date(schd.FECHA);
                    const timeDiff = date.getTime() - mondayDate.getTime();
                    const differenceInDays = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1;
                    if (differenceInDays < 0 || differenceInDays > 7) return;
                    const mealId = schd.COMIDA == "Almuerzo" ? 0 : 1;
                    var elem = $(RECIPE_TEMPLATE.format(schd.ID_RECETA, schd.NOMBRE)).appendTo(`#schd-${differenceInDays}${mealId}`);
                    $(elem).click(function()
                    {
                        navigate("vistareceta.php?id=" + schd.ID_RECETA);
                    });

                    var node = $(`#schd-${differenceInDays}${mealId}`).parent();
                    $(node).children().eq(0).off("click");
                    var schdDateFormatted = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                    $(node).children().eq(0).click(function() // closebtn
                    {
                        
                        $.get(`delete_schedule.php?date=${schdDateFormatted}&meal=${schd.COMIDA}`, function()
                        {
                            retrieveSchedule(currentMonday);
                            retrieveMissingIngredients(new Date());
                        }).fail(() =>
                        {
                            alert("Ha ocurrido un error borrando la planificación que has especificado.")
                        });
                    });
                });

                setTimeout(() => {
                    $(".close-btn").removeClass("visible");
                },300);
    
            });
        }
    
        function retrieveMissingIngredients(mondayDate) {
    
            
            $.get(`./missing_ingredients.php`, (ingredients) => {
                $("#missing-ingredients-ul").empty();
                if (ingredients.length > 0)
                {
                    $("#missing-ingredients-box").show();
                    ingredients.forEach(ing => {
                        var recipes = ing.PARA_RECETAS.split(",");
                        let uniqueRecipes = [...new Set(recipes)]; 
                        let uniqueRecipesStr = uniqueRecipes.join(", ");
                        var ingredientHTML = MISSING_INGREDIENT_TEMPLATE.format(ing.ID_INGREDIENTE,ing.CANTIDAD,ing.UNIDADDEMEDIDA,ing.NOMBRE,uniqueRecipesStr);
                        $("#missing-ingredients-ul").append(ingredientHTML)
                    });

                    $(".missing-ingredient-list li").click(function()
                    {
                        const ingredId = $(this).attr("ingred-id");
                        const ingredQty = $(this).attr("ingred-qty");
                        const ingredMsr = $(this).attr("ingred-msr");
                        $.get(`add_ingredient_qty.php?type=shoppinglist&id=${ingredId}&qty=${ingredQty}&qty-type=${ingredMsr}`,function()
                        {
                            retrieveMissingIngredients(new Date());
                        })
                        .fail(() =>
                        {
                            alert("Ha ocurrido un error apuntando el ítem seleccionado en la lista de la compra.");
                        });

                    });
                }
                else
                {
                    $("#missing-ingredients-box").hide();
                }
            });
        }
    
        function setDayHeaderPositions() {
            if ($(`#schd-table td`).length == 0) return;
            let firstLeft = $(`#schd-table tr > td`).eq(0).position().left;
            var widthTableCell = $(`#schd-table td`).width() + 40; // padding
            for (let i = 0; i < 7; i++) {
                let widthSpan = $(`#day-container > span`).eq(i).width();
                let leftTableCell = $(`#schd-table tr > td`).eq(i).position().left - firstLeft;
                let computedLeft = leftTableCell + ((widthTableCell - widthSpan) / 2);
                $(`#day-container :nth-child(${i + 1})`).css("left", computedLeft + "px");
            }
    
            //$("#schd-table td").css("max-width", `${$("#schd-table").width() / 8}px`);
        }
    
        /* RESIZING AND SCROLLING BEHAVIOR */
        $(window).on('resize', function(e) {
            setDayHeaderPositions();
        });
    
        var isSyncingTopScroll = false;
        var isSyncingDownScroll = false;
    
        $("#day-container").scroll(function(e) {
            if (!isSyncingDownScroll) {
                isSyncingTopScroll = true;
                if (!e.originalEvent) return;
                $("#schd-table-cont").scrollLeft($("#day-container").scrollLeft());
            }
            isSyncingDownScroll = false
        });
    
        $("#schd-table-cont").scroll(function(e) {
            if (!isSyncingTopScroll) {
                isSyncingDownScroll = true;
                if (!e.originalEvent) return;
                $("#day-container").scrollLeft($("#schd-table-cont").scrollLeft());
            }
            isSyncingTopScroll = false;
        });
    
    
        /* CLICK AND HOVER EVENTS */
    
        $("#next-schedule-btn").click(() => {
            $("#schd-table").html(placeholderHtml);
            currentMonday = currentMonday.addDays(7);
            retrieveSchedule(currentMonday);
        });
    
        $("#back-schedule-btn").click(() => {
            $("#schd-table").html(placeholderHtml);
            currentMonday = currentMonday.addDays(-7);
            retrieveSchedule(currentMonday);
        });

        /* INICIALIZATIONS */
    
        const placeholderHtml = $("#schd-table").html();
    
        var currentMonday = new Date();
        currentMonday.setDate(currentMonday.getDate() - (currentMonday.getDay() + 6) % 7);
        retrieveSchedule(currentMonday);
    
        retrieveMissingIngredients(new Date());
    
        setDayHeaderPositions();
        setTimeout(setDayHeaderPositions, 150);
    
    
    });
}

