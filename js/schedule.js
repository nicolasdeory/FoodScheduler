$(function() 
{

    function setDayHeaderPositions() 
    {
        var widthTableCell = $(`#schd-table td`).width();
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

    setDayHeaderPositions();
    setTimeout(setDayHeaderPositions, 150);

});