<?php
session_start();
require_once('php/Database.php');
require_once ('php/func/redirect.php');
require_once('header.php');


$userId = $_SESSION['userId'];
$role = $_SESSION['userRole'];

if($role !== 'admin')
{
    unset($_SESSION['userId']);
    unset($_SESSION['userRole']);
    unset($_SESSION['hash']);
    session_destroy();

    header("Location: /signin.php?logout=1");
    die;
}




/**
 * Get all Transactions
 */
function getTransactions()
{
    $db = new Database();

    $result = $db->query('SELECT
     Transaction.transactionId, username, firstname, lastname, email, fromDate, untilDate
     FROM Governator.Transaction
        INNER JOIN Governator.User USING(userId)
        INNER JOIN Governator.Card USING(cardId)
    ');


    $i=0;
    foreach ($result as $transaction)
    {
        if($i==0)
        {
            printHeader(array_keys($transaction));
            echo '<tbody>';
        }
        $i++;
        printRow($transaction);
    }
    if($i>0)
    {
        echo '</tbody>';
    }
}

function printHeader($data)
{
    echo '<THEAD><tr>'.implode('',array_map(function($el) {return('<th>'.$el.'</th>');},$data)).'</tr></THEAD>  ';
}
function printRow($data)
{
    $class = is_null($data['untilDate']) ?  'class="pending"' : '';

    echo '<tr '.$class.'>'.implode('',array_map(function($el) {return('<td>'.$el.'</td>');},$data)).'</tr>';
}

?>

    <div class="row">
        <table id="adminTable" class="tablesorter">
        <?php
            getTransactions();
        ?>
        </table>
    </div>

<?php
require_once('footer.php');
?>






