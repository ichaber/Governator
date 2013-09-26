<?php
/**
 *
 *
 * @author <gdoehring@intelliad.de>
 * @author <kbergthaler@intelliad.de>
 * Created 2013-09-25
 */

class Database
{
    const DB_USER = "arnold";

    const DB_PASSWORD = "actionfuim";

    const DB_HOST = "10.97.33.2";

    const DB_DATABASE = "Governator";

    private $pdo = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $dsn = 'mysql:dbname=' . static::DB_DATABASE . ';host=' . static::DB_HOST;

        try {
            $this->pdo = new PDO($dsn, static::DB_USER, static::DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            die();
        }
    }

    /**
     * @param $query
     * @param array|null $parameters
     * @return array
     */
    public function query($query, $parameters = array())
    {
        /* @var $_statement PDOStatement */
        $_statement = $this->pdo->prepare($query);

        $_statement->execute($parameters);

        $_result = $_statement->fetchAll();

        return $_result;
    }

    public function insertQuery($query, $parameters = array())
    {
        /* @var $_statement PDOStatement */
        $_statement = $this->pdo->prepare($query);

        return $_statement->execute($parameters);
    }

    public function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $query
     * @param array|null $parameters
     * @return int Number of affected rows
     */
    public function update($query, $parameters) {
        $_statement = $this->pdo->prepare($query);

        $_statement->execute($parameters);

        return $_statement->rowCount();
    }
}
