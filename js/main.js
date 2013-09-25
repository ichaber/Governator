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
                        onRentalError();
                    }else{
                        onRentalSuccess()
                    }
                }
            });
        }
    });

    function onRentalSuccess(){

    }

    function onRentalError(errorId) {
        var mainContainer = $('.container').last(),
            alertBox = $('<div></div>'),
            errorMessage = "";

        switch (parseInt(errorId, 10)) {
            case 0 :
                errorMessage = "Die Karte konnte nicht ausgeliehen werden";
        }

        alertBox
            .addClass('alert')
            .addClass('alert-block')
            .addClass('alert-error')
            .append(
                $('<h4></h4>')
                    .html('Warnung!')
            )
            .append(
                $('<p></p>')
                    .html(errorMessage)
                    .append(
                        $('<button></button>')
                            .html('&times;')
                            .addClass('close')
                            .attr("data-dismiss", "alert")
                    )
            )
        ;

        mainContainer.prepend(alertBox);
    }

});