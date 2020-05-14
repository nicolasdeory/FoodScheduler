const RECIPE_TEMPLATE = `
<li><a href="recipe/{0}">{1}</a></li>
`;
// TODO: Show some brief info on hover


$(function ()
{

    function retrieveSchedule(mondayDate)
    {
        var sundayDate = mondayDate + 6;
        var mondayDateFormatted = mondayDate.getDate() + "-" + (mondayDate.getMonth() + 1) + "-" + mondayDate.getFullYear();
        var sundayDateFormatted = sundayDate.getDate() + "-" + (sundayDate.getMonth() + 1) + "-" + sundayDate.getFullYear();
        $.get(`./schedule.php?from=${mondayDateFormatted}&to=${sundayDateFormatted}`, (schedules) =>
        {
            $("td ul").empty();
            console.log(schedules);
            schedules.forEach(schd =>
            {
                const date = new Date(schd.FECHA);
                const timeDiff = date.getTime() - mondayDate.getTime();
                const differenceInDays = Math.floor(timeDiff / (1000*60*60*24))
                if (differenceInDays < 0 || differenceInDays > 7) return;
                const mealId = schd.COMIDA == "Almuerzo" ? 0 : 1;
                console.log(`#schd-${differenceInDays}${mealId}`);
                $(`#schd-${differenceInDays}${mealId}`).append(RECIPE_TEMPLATE.format(schd.ID_RECETA,schd.NOMBRE));
            });
        });
    }

    function setDayHeaderPositions()
    {
        var widthTableCell = $(`#schd-table td`).width() + 40; // padding
        for (let i = 0; i < 8; i++)
        {
            let widthSpan = $(`#day-container span`).eq(i).width();
            let leftTableCell = $(`#schd-table td`).eq(i).position().left;
            let computedLeft = leftTableCell + ((widthTableCell - widthSpan) / 2);
            $(`#day-container :nth-child(${i + 1})`).css("left", computedLeft + "px");
        }
        
       // $("td").css("max-width", "100px");

    }

    $(window).on('resize', function (e)
    {
        setDayHeaderPositions();
    });





    var isSyncingTopScroll = false;
    var isSyncingDownScroll = false;

    $("#day-container").scroll(function (e)
    {
        if (!isSyncingDownScroll)
        {
            isSyncingTopScroll = true;
            if (!e.originalEvent) return;
            //let scrollPct = $("#day-container").scrollLeft() / $("#day-container").width();
            //$("#schd-table-cont").scrollLeft(scrollPct * ($("#schd-table-cont").width()))
            $("#schd-table-cont").scrollLeft($("#day-container").scrollLeft());
            //console.log("day" + scrollPct);
        }
        isSyncingDownScroll = false
    });

    $("#schd-table-cont").scroll(function (e)
    {
        if (!isSyncingTopScroll)
        {
            isSyncingDownScroll = true;
            if (!e.originalEvent) return;
            //let scrollPct = $("#schd-table-cont").scrollLeft() / ($("#schd-table-cont").width()-70);
            //console.log(scrollPct);
            //$("#day-container").scrollLeft(scrollPct * ($("#day-container").width()-80))
            $("#day-container").scrollLeft($("#schd-table-cont").scrollLeft());
        }
        isSyncingTopScroll = false;
    });

    
    retrieveSchedule(new Date("05-11-2020"));

    setDayHeaderPositions();
    setTimeout(setDayHeaderPositions, 150);


});