const RECIPE_TEMPLATE = `
<li><a href="recipe/{0}">{1}</a></li>
`;
// TODO: Show some brief info on hover

Date.prototype.addDays = function (days)
{
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

$(function ()
{

    function retrieveSchedule(mondayDate)
    {
        var sundayDate = mondayDate.addDays(6);
        console.log(sundayDate);
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
                console.log(timeDiff);
                const differenceInDays = Math.floor(timeDiff / (1000*60*60*24)) + 1;
                if (differenceInDays < 0 || differenceInDays > 7) return;
                const mealId = schd.COMIDA == "Almuerzo" ? 0 : 1;
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


    var prevMonday = new Date();
    prevMonday.setDate(prevMonday.getDate() - (prevMonday.getDay() + 6) % 7);
    console.log(prevMonday);
    retrieveSchedule(prevMonday);

    setDayHeaderPositions();
    setTimeout(setDayHeaderPositions, 150);


});