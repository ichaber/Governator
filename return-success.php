<?php
session_start();
require_once('php/Database.php');
require_once('header.php');

$userId = $_SESSION['userId'];
$cardName = getLastUserCardName($userId);

?>

<div class="alert alert-block alert-success fade in">
    <h4 class="alert-heading">Sie haben <?php echo $cardName; ?> zurück gegeben!</h4>
</div>

<?php
require_once('footer.php');

function getLastUserCardName($userId) {
    $db = new Database();
    $sql = "SELECT
        c.name
    FROM
       Governator.`Transaction` AS t
    JOIN
        Governator.`Card` AS c
        USING (cardId)
    WHERE
        t.userId = :userId
    ORDER BY
        untilDate DESC
    LIMIT
        1";
    $result = $db->query($sql, array(':userId' => $userId));
    return $result[0]['name'];
}
