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

    const SALT = "\$6\$rounds=5000\$dfjo32498zuiash8kko293n449dfm48ny0ßmrh647ui3h67smv0nbertm2n233qsrweol";

    private $pdo = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $dsn = 'mysql:dbname=' . static::DB_DATABASE . ';host=' . static::DB_HOST;

        try {
            $this->pdo = new PDO($dsn, static::DB_USER, static::DB_PASSWORD);
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
    public function query($query, $parameters = null)
    {
        /* @var $_statement PDOStatement */
        $_statement = $this->pdo->prepare($query);

        $_statement->execute($parameters);

        $_result = $_statement->fetchAll();

        return $_result;
    }


    /**
     * @param $username
     *
     * @return array
     */
    public function getUserInfo($username)
    {
        $sql = "
            select * from
                Governator.User
            where username = :username
        ";
        $params = array(
            ":username" => $username
        );
        $result = $this->query($sql, $params);
        return !empty($result) ? $result[0] : array();
    }

    /**
     * @param $pass
     *
     * @return string
     */
    public function getPassHash($pass)
    {
        return crypt($pass, self::SALT);
    }

}
