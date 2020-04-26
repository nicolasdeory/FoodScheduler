$(function() 
{

    function setDayHeaderPositions() 
    {
        var widthTableCell = $(`#schd-table td`).width() + 40; // padding
        for (let i = 0; i < 8; i++) 
        {
            let widthSpan = $(`#day-container span`).eq(i).width();
            let leftTableCell = $(`#schd-table td`).eq(i).position().left;
            let computedLeft = leftTableCell + ((widthTableCell - widthSpan)/2);
            $(`#day-container :nth-child(${i+1})`).css("left", computedLeft +"px");
        }
    }

    $(window).on('resize', function(e)
    {
        setDayHeaderPositions();
    });


    var isSyncingTopScroll = false;
    var isSyncingDownScroll = false;

    $("#day-container").scroll(function(e)
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

    $("#schd-table-cont").scroll(function(e)
    {
        if (!isSyncingTopScroll) {
            isSyncingDownScroll = true;
            if (!e.originalEvent) return;
            //let scrollPct = $("#schd-table-cont").scrollLeft() / ($("#schd-table-cont").width()-70);
            //console.log(scrollPct);
            //$("#day-container").scrollLeft(scrollPct * ($("#day-container").width()-80))
            $("#day-container").scrollLeft($("#schd-table-cont").scrollLeft());
        }
        isSyncingTopScroll = false;
    });

    setDayHeaderPositions();
    setTimeout(setDayHeaderPositions, 150);

});