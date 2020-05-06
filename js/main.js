$(function() {

    $.get( "schedule.html", function( data ) {
        $( "#page-content" ).html( data );
      });

});