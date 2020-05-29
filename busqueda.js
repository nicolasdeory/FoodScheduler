const RECIPE_HTML = `<div class="result">
<div class="photo">
    <img class="spaguetti" src="images/photo{0}.jpg">
    <div class= "id">
        
    </div>  
</div>
<div class="description">
    <div class="recipetitle">
        {1}
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
</div>`;

if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

$(document).ready(() => {
    var dif = "";
    $("#star1").click(() => {
        dif = "Sencillo";
    });
    $("#star2").click(() => {
        dif = "Fácil";
    });
    $("#star3").click(() => {
        dif = "Medio";
    });
    $("#star4").click(() => {
        dif = "Difícil";
    });
    $("#star5").click(() => {
        dif = "Muy difícil";
    });


    $("#buscar").click(() => {
        
        var nombre = $("#input-nombre").val();
        var ingred = $("#input-ingrediente").val();
        var url= "searchrecipe.php?"
        if(nombre.length>0) url+=`nombre=${nombre}`;
                                    //if nombre.length>0 return & else ''
        if(ingred.length>0) url+=`${nombre.length>0 ? '&' : ''}ingrediente=${ingred}`;
        if(dif.length>0) url+=`${(nombre.length>0 || ingred.length>0) ? '&' : ''}dificultad=${dif}`;
        $.get(url, (data) => {
            $("#contenedor").children().slice(1).remove();
            data.forEach(x => {
                $("#contenedor").append(RECIPE_HTML.format(x.ID_RECETA, x.NOMBRE, x.POPULARIDAD, x.TIEMPOELABORACION, x.DIFICULTAD));
            });
        }
        );
    });

    $.get('searchrecipe.php', (data) => {
        $("#contenedor").children().slice(1).remove();
        data.forEach(x => {
            $("#contenedor").append(RECIPE_HTML.format(x.ID_RECETA, x.NOMBRE, x.POPULARIDAD, x.TIEMPOELABORACION, x.DIFICULTAD));
        });
    }
    );
});