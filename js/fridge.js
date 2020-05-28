var loaded = false;
if (!loaded)
{
    loaded = true;
    const FRIDGE_ITEM_HTML = `
        <div class="fridge-item">
        <h3>{0}</h3>
        <span class="ingred-qty">{1}</span>
        <div class="btn-container">
            <div class="btn"><span class="material-icons btn-icon btn-create">create</span></div>
            <div class="btn"><span class="material-icons btn-icon btn-remove">delete</span></div>
        </div>
        </div>
    `;

    const SHOPPING_ITEM_HTML = `
        <div class="fridge-item">
        <h3>{0}</h3>
        <span class="ingred-qty">{1}</span>
        <div class="btn-container">
            <div class="btn"><span class="material-icons btn-icon btn-add">check</span></div>
            <div class="btn"><span class="material-icons btn-icon btn-create">create</span></div>
            <div class="btn"><span class="material-icons btn-icon btn-remove">delete</span></div>
        </div>
        </div>
    `;

    function getFridge()
    {
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
                $("#nevera").append(FRIDGE_ITEM_HTML.format(itm.NOMBRE, `${itm.CANTIDAD} ${udMedida}`));

                // TODO: Add click event handlers to buttons
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
                $("#lista-compra").append(SHOPPING_ITEM_HTML.format(itm.NOMBRE, `${itm.CANTIDAD} ${udMedida}`));

                // TODO: Add click event handlers to buttons
            });
        });
    }

    $(document).ready(() =>
    {

        getFridge();

    });
}
else
{
    getFridge();
}

