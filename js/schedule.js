var loaded = false;
if (!loaded)
{
    loaded = true;
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
                console.log(schedules);
                schedules.forEach(schd => {
                    const date = new Date(schd.FECHA);
                    const timeDiff = date.getTime() - mondayDate.getTime();
                    const differenceInDays = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1;
                    if (differenceInDays < 0 || differenceInDays > 7) return;
                    const mealId = schd.COMIDA == "Almuerzo" ? 0 : 1;
                    $(`#schd-${differenceInDays}${mealId}`).append(RECIPE_TEMPLATE.format(schd.ID_RECETA, schd.NOMBRE));
                });
    
                $("li a").click(function(e)
                {
                    window.navigate(`receta.php?id=${$(this).attr("recipe-id")}`);
                });
    
            });
        }
    
        function retrieveMissingIngredients(mondayDate) {
    
            $.get(`./missing_ingredients.php`, (ingredients) => {
                console.log(ingredients);
                if (ingredients.length > 0)
                {
                    $("#missing-ingredients-box").show();
                    ingredients.forEach(ing => {
                        var recipes = ing.PARA_RECETAS.split(",");
                        let uniqueRecipes = [...new Set(recipes)]; 
                        var ingredientHTML = MISSING_INGREDIENT_TEMPLATE.format(ing.ID_INGREDIENTE,ing.CANTIDAD,ing.UNIDADDEMEDIDA,ing.NOMBRE,uniqueRecipes);
                        $("#missing-ingredients-ul").append(ingredientHTML)
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
            var widthTableCell = $(`#schd-table td`).width() + 40; // padding
            for (let i = 0; i < 8; i++) {
                let widthSpan = $(`#day-container span`).eq(i).width();
                let leftTableCell = $(`#schd-table td`).eq(i).position().left;
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
    
    
        /* CLICK EVENTS */
    
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
    
        retrieveMissingIngredients(currentMonday);
    
        setDayHeaderPositions();
        setTimeout(setDayHeaderPositions, 150);
    
    
    });
}

