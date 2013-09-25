<?php
session_start();
require_once('php/Database.php');
require_once('header.php');
?>

<?php
/**
 * Print rental button
 *
 * @param $name
 * @param $disabled
 */
function printButton($name, $disabled)
{
    $disabledStr = $disabled ? 'disabled' : '';
    echo('<div class="span6" align="center"><button style="margin :10px" class="btn btn-info ' . $disabledStr . '">' . $name . '</button></div>');
}

/**
 * Get all cards and print buttons
 */
function getCards()
{
    $db = new Database();

    $result = $db->query('SELECT * FROM `Card` ');

    foreach ($result as $card)
    {
        printButton($card['name'], !empty($card['transactionId']));
    }
}

?>

    <div class="row">
        <?php
        getCards();
        ?>
    </div>

<?php
require_once('footer.php');
?>