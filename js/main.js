$(document).ready(function() {

    /*
     * Event handlers
     */

    //rent card button
    $('button.rent-button[data-id]').on('click', function(event) {
        var target = event.target,
            cardId = $(target).attr('data-id');

        if (!$(target).hasClass('disabled')) {
            $.post('php/controller/rent.php', {cardId: cardId}, undefined); //TODO: implement callback
        }
    });

});