<?php


require_once "../Database.php";

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
            c.transactionId = NULL
        WHERE
            t.userId = :userId
            AND t.transactionId = c.transactionId
            AND t.cardId = c.cardId
            AND t.untilDate IS NULL
            AND c.transactionId IS NOT NULL
    ";

    $params = array(
        ":userId" => $userId
    );

    $affectedRows = $db->update($sql, $params);

    return ($affectedRows === 1) ? true : false;
}
