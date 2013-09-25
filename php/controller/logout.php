<?php
/**
 *
 * @author    Karl Bergthaler
 * @author    Georg Döhring
 * @copyright Copyright (c) 2013
 * @license   proprietary
 */

session_start();
unset($_SESSION['userId']);
unset($_SESSION['hash']);
session_destroy();

header("Location: /signin.php?logout=1");
die;