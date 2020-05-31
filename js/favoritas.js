var favoritasLoaded = false;
if (!favoritasLoaded)
{
    const RECIPE_HTML = `<div class="result">
    <div class="photo">
        <img class="spaguetti" src="images/photo1.jpg">
    </div>
    <div class="description">
        <div class="recipetitle">
            {0}
        </div>
        <div class="info">
            <div class="like">
                <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                <div class="numberlikes"> {1} </div>
            </div>
            <div class="time">
                <div class="timeicon"><i class="far fa-clock"></i></div>
                <div class="amounttime"> {2} min</div>
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
                       
                        <div class="text" id="rating-label-text"> {3} </div>
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
        $.get('favoritas.php', (data) => {
            data.forEach(x => {
                $("#contenedor").append(RECIPE_HTML.format(x.NOMBRE, x.POPULARIDAD, x.TIEMPOELABORACION, x.DIFICULTAD));
            });
        }
        );
    });
}

