$(function() {
    function view_recipe(recetaId) {
        console.log(recetaId);

        var idReceta = parseInt(recetaId.toString());

        $.get(`./vistareceta.php?recipeID=${mondayDateFormatted}&to=${sundayDateFormatted}`, (schedules) => {
            $("td ul").empty();
            console.log(recetaId);
            const recipeId = receta.ID_RECETA;
            const name = receta.NOMBRE;
            const time = receta.TIEMPOELABORACION;
            const difficulty = receta.DIFICULTAD;
            $(`#recipeId`).append(recipeId);
            $(`#recipe-name`).append(name);
            $(`#tiempo`).append(tiempo);
            $(`#difficulty`).append(tiempo);
        });
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

    /* INICIALIZATIONS */

    const placeholderHtml = $("#schd-table").html();

});
