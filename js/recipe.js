var loaded = false;
if (!loaded)
{
    loaded = true;

    if (!String.prototype.format)
    {
        String.prototype.format = function ()
        {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number)
            {
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }

    

    $(document).ready(() =>
    {
        $("#back-button").click(() =>
        {
            navigateBack();
        });

    });
}