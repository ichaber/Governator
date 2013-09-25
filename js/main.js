$(document).ready(function() {

    /*
     * Event handlers
     */

    //rent card button
    $('button.rent-button[data-id]').on('click', function(event) {
        var target = event.target,
            cardId = $(target).attr('data-id');

        if (!$(target).hasClass('disabled')) {
            $.ajax({
                url : 'php/controller/rent.php',
                data : {cardId: cardId},
                dataType: "json",
                type : "POST",
                success : function(data){
                    if(data.success == false){
                        onRentalError(data.errorId);
                    }else{
                        onRentalSuccess()
                    }
                }
            });
        }
    });

    /**
     * Handler for successful card rental
     */
    function onRentalSuccess() {
        window.location.href = '/return.php';
    }

    /**
     * Handler for failed card rental
     * @param {Integer} errorId
     */
    function onRentalError(errorId) {
        var mainContainer = $('#mainContainer'),
            alertBox = $('<div></div>'),
            errorMessage = "";

        switch (parseInt(errorId, 10)) {
            case 0:
                errorMessage = "Die Karte konnte nicht ausgeliehen werden";
                break;
            case 1:
                errorMessage = "Die Karte konnte nicht ausgeliehen werden (fehlende Card-ID)";
                break;
            case 2:
                errorMessage = "Die Karte konnte nicht ausgeliehen werden (Karte bereits ausgeliehen)";
                break;
            default:
                errorMessage = "Die Karte konnte nicht ausgeliehen werden";
        }

        alertBox
            .addClass('alert')
            .addClass('alert-block')
            .addClass('alert-error')
            .append(
                $('<button></button>')
                    .html('&times;')
                    .addClass('close')
                    .attr("data-dismiss", "alert")
            )
            .append(
                $('<h4></h4>')
                    .html('Warnung!')
            )
            .append(
                $('<p></p>')
                    .html(errorMessage)
            )
        ;

        mainContainer.prepend(alertBox);
    }

});