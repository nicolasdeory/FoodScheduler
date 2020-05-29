var loaded = false;
if (!loaded)
{
    loaded = true;
    const FRIDGE_ITEM_HTML = `
        <div class="fridge-item" ingred-id={2}>
            <h3>{0}</h3>
            <span class="ingred-qty">{1}</span>
            <div class="btn-container">
                <div class="btn editbtn"><span class="material-icons btn-icon btn-create">create</span></div>
                <div class="btn removebtn"><span class="material-icons btn-icon btn-remove">delete</span></div>
            </div>
        </div>
    `;

    const INPUT_INGREDIENT_HTML = `
        <div class="fridge-item" id="input-item" ingred-input="{0}">
            <input type="text" name="ingredient" id="input-name" placeholder="Ingrediente"></input>
            <div class="btn-container spaced">
                <input type="text" class="small" id="input-qty" placeholder="Cantidad"></input>
                <select id="input-qty-type">
                    <option value="Gramo">gr.</option>
                    <option value="Mililitro">ml.</option>
                    <option value="Unidad">ud.</option>
                </select>
            </div>
            <div class="btn-container">
                <div class="btn addbtn"><span class="material-icons btn-icon btn-add">check</span></div>
                <div class="btn removebtn"><span class="material-icons btn-icon btn-remove">clear</span></div>
            </div>
        </div>
    `;

    const SHOPPING_ITEM_HTML = `
        <div class="fridge-item" ingred-id={2}>
            <h3>{0}</h3>
            <span class="ingred-qty">{1}</span>
            <div class="btn-container">
                <div class="btn addbtn"><span class="material-icons btn-icon btn-add">check</span></div>
                <div class="btn editbtn"><span class="material-icons btn-icon btn-create">create</span></div>
                <div class="btn removebtn"><span class="material-icons btn-icon btn-remove">delete</span></div>
            </div>
        </div>
    `;

    function attachEventListeners() 
    {
        // SHOPPING LIST
        $("#lista-compra .fridge-item .removebtn").click(function()
        {
            const ingredID = $(this).parent().parent().attr("ingred-id");
            $.get("delete_ingredient_qty.php?type=shoppinglist&id=" + ingredID, () =>
            {
                getFridgeAndShoppingList();
            });
           
        });

        // FRIDGE
        $("#nevera .fridge-item .removebtn").click(function()
        {
            const ingredID = $(this).parent().parent().attr("ingred-id");
            $.get("delete_ingredient_qty.php?type=fridge&id=" + ingredID, () =>
            {
                getFridgeAndShoppingList();
            });
        });
    }

    function getFridgeAndShoppingList()
    {
        $("#nevera").empty();
        $("#lista-compra").empty();
        $.get("fridge.php", function (data)
        {
            var fridge = data.nevera;
            var shopping = data.listaCompra;

            fridge.forEach((itm) =>
            {
                var udMedida = "?.";
                switch (itm.UNIDADDEMEDIDA)
                {
                    case "Mililitro":
                        udMedida = "ml.";
                        break;
                    case "Gramo":
                        udMedida = "gr.";
                        break;
                    case "Unidad":
                        udMedida = "ud.";
                        break;
                }
                $("#nevera").append(FRIDGE_ITEM_HTML.format(itm.NOMBRE, `${itm.CANTIDAD} ${udMedida}`, itm.ID_INGREDIENTE));
            });

            shopping.forEach((itm) =>
            {
                var udMedida = "?.";
                switch (itm.UNIDADDEMEDIDA)
                {
                    case "Mililitro":
                        udMedida = "ml.";
                        break;
                    case "Gramo":
                        udMedida = "gr.";
                        break;
                    case "Unidad":
                        udMedida = "ud.";
                        break;
                }
                $("#lista-compra").append(SHOPPING_ITEM_HTML.format(itm.NOMBRE, `${itm.CANTIDAD} ${udMedida}`, itm.ID_INGREDIENTE));
            });

            attachEventListeners();
        });
    }

    function createInputForm(where)
    {
        $("#input-item").remove();
        $(where).prepend(INPUT_INGREDIENT_HTML.format(where == "#nevera" ? "fridge" : "shoppinglist"));
        $("#input-item .removebtn").click(() =>
        {
            $("#input-item").remove();
        });

        $("#input-item .addbtn").click(() =>
        {
            var type = $("#input-item").attr("ingred-input");
            var name = $("#input-name").val();
            var qty = $("#input-qty").val();
            var qtyType = $("#input-qty-type").val();


            $.get(`add_ingredient_qty.php?type=${type}&name=${name}&qty=${qty}&qty-type=${qtyType}`, () =>
            {
                getFridgeAndShoppingList();
            });
        });
    }

    $(document).ready(() =>
    {

        getFridgeAndShoppingList();

        $("#add-shopping-btn").click(() =>
        {
            createInputForm("#lista-compra");
        });

        $("#add-fridge-btn").click(() =>
        {
            createInputForm("#nevera");
        });

    });
}
else
{
    getFridgeAndShoppingList();
}

