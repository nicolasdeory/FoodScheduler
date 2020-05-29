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
            $.get("delete_shopping.php?id=" + ingredID, () =>
            {
                getFridgeAndShoppingList();
            });
           
        });

        // FRIDGE
        $("#nevera .fridge-item .removebtn").click(function()
        {
            const ingredID = $(this).parent().parent().attr("ingred-id");
            $.get("delete_fridge.php?id=" + ingredID, () =>
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

    $(document).ready(() =>
    {

        getFridgeAndShoppingList();

    });
}
else
{
    getFridgeAndShoppingList();
}

