<?php

require_once "../Database.php";

session_start();

$userId = $_SESSION['userId'];

if ($userId) {

    $success = returnCardForUser($userId);
    if ($success) {
        header("Location: /rental.php");
        die;
    } else {
        header("Location: /return-failed.php");
        die;
    }
}

/**
 * @param $userId int
 *
 * @return array
 */
function returnCardForUser($userId)
{
    $db = new Database();

    $sql = "
        UPDATE
            Governator.`Card` AS c,
            Governator.`Transaction` AS t
        SET
            t.untilDate = NOW(),
            c.transactionId = 0
        WHERE
            t.userId = :userId
            AND t.transactionId = c.transactionId
            AND t.cardId = c.cardId
            AND t.untilDate IS NULL
            AND c.transactionId != 0
    ";

    $params = array(
        ":userId" => $userId
    );

    $affectedRows = $db->update($sql, $params);

    return ($affectedRows === 2) ? true : false;
}
