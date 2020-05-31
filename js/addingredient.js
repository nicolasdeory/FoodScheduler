$(document).ready(function ()
{


    var INGREDIENT_HTML = `<div class="ingredientenuevo" id="columna` + i + `">
    
    <div class="texto-antes">
        <p>Nuevo ingrediente</p>
    </div>
    <div class="ingredientenew">
        <div class="ing">
            <div class="icon2">
                <i class="fas fa-cheese"></i>
            </div>
            <input type="text" placeholder="Nombre" name="input-name" class="input-ing"></input>
        </div>
        <div class="cant">
                <div class="icon2">
                     <i class="fas fa-balance-scale"></i>
                </div>
                <input type="number" placeholder="Cantidad" name="input-qty" class="input-ing" required></input>
            </div>
        <div class="unid">


            <select name="unidadDeMedida" class="unidadmed">
                <option value="Unidad">Unidad</option>
                <option value="Gramo">Gramos</option>
                <option value="Mililitro">Mililitro</option>


            </select>
        </div>
    </div>
</div>`;

    var i = 1;





    $('#nuevoing').click(function ()
    {
        $('#contenedornewingredientes').append(INGREDIENT_HTML);
    });
    $(document).on('click', '#quitaring', function ()
    {

        if ($("#contenedornewingredientes").children().length > 1)
        {
            $("#contenedornewingredientes > :last-child").remove();
        }
    });

    $('#nuevopaso').click(function ()
    {
        i++;
        console.log("Tenemos " + i + " contenedores");
        STEP_HTML = `<div class="paso">
        <div class="texto-antes" id="row`+ i + `">
            <p>Paso número: `+ i + `</p>
        </div>
        <textarea class="input-paso" type="text" placeholder="Describe cómo realizar este paso"></textarea>
    </div>`;
        $('#contenedorpasos').append(STEP_HTML);

    });

    $(document).on('click', '#quitarpaso', function ()
    {

        if ($("#contenedorpasos").children().length > 1)
        {
            $("#contenedorpasos > :last-child").remove();
            i--;
        }
    });


    var STEP_HTML = `<div class="paso">
        <div class="texto-antes" id="row`+ i + `">
            <p>Paso número: `+ i + `</p>
        </div>
        <textarea class="input-paso" type="text" placeholder="Describe cómo realizar este paso"></textarea>
    </div>`;

});  
