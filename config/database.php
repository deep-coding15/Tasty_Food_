<?php
/**
 * This class is for connect to a database using PDO. 
 */
class Database{
    public ?PDO $connection = null;

    public function __construct() {
        self::dbConnect();
    }

    /**
     * This function is a private function can connect to a database. The default values are : 
     * @param string $host = 'localhost'
     * @param string $dbname = 'restaurant_tasty_food'
     * @param string $username = 'root'
     * @param string $password = ''
     * @return void
     */
    public function dbConnect(string $host = 'localhost', string $dbname = 'restaurant_tasty_food', string $username = 'root', string $password = '')
    {
        if( $this->connection === null ) {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        }
        return $this->connection;
    }

    /**
     * THis function can connect to a database. The default values are : 
     * @param string $host = 'localhost'
     * @param string $dbname = 'restaurant_tasty_food'
     * @param string $username = 'root'
     * @param string $password = ''
     * @return void
     */
    public function getConnection () : PDO | null{
        return $this->connection;
    }

    /**
     * This function execute an sql statement and its parameters in form of an array and return the statement
     * It uses the prepare statement and the execute function to do his work
     */
    public function executeSqlStatement(string $sql, array $params = []){
        $statement = $this->connection->prepare($sql);
        (isset($params)) ? $statement->execute($params) : $statement->execute();
        return $statement;
    }
}