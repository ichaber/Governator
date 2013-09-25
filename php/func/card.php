<?php
require_once __DIR__ . '/../Database.php';

/**
 * Has the logged in user rented a card
 *
 * @param {int} $userId The id of the user for which to check if cards are available
 *
 * @return bool
 */
function userHasRentedCards($userId)
{
    $db = new Database();

    $result = $db->query(
        '
                SELECT * FROM `Governator`.`Card`
                INNER JOIN `Governator`.`Transaction` USING (transactionId)
                WHERE userId = :userId
            ', array('userId' => $userId)
    );

    if (empty($result))
    {
        return false;
    }
    else
    {
        return true;
    }
}
