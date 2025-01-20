<?php
/**
 * GraphenePHP DB Class
 *
 * This class contains all Database CRUD functions
 *
 * @package GraphenePHP
 * @version 2.0.0
 */


require('config.php');

return $config;
class DB
{
    private static $connection;

    /**
     * Connects to the database using the provided configuration.
     */

    public static function connect()
    {

        $config = [
            'APP_NAME' => 'intern-work',
            'APP_TITLE' => 'Cars - website',
            'APP_URL' => 'http://localhost/',
            'APP_SLUG' => 'intern-work',
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_DATABASE' => 'intern-work',
            'DB_USERNAME' => 'root',
            'DB_PASSWORD' => '',
            'SMTP_DRIVER' => 'smtp',
            'SMTP_HOST' => 'smtp-relay.sendinblue.com',
            'SMTP_PORT' => '587',
            'SMTP_USERNAME' => '',
            'SMTP_PASSWORD' => '',
            'SMTP_ENCRYPTION' => 'tls',
            'OPENAI_API_KEY' => '',
            'APP_DESC' => 'Personalized online invitation & Guest Management tool',
            'APP_SHORT_TITLE' => 'eSubhalekha',
            'APP_AUTHOR' => 'cars',
            'APP_ICON' => 'assets/img/eSubhalekhaIcon.png',
            'APP_OG_ICON' => 'assets/img/eSubhalekhaIcon.png',
            'APP_OG_ICON_MOBILE' => 'assets/img/eSubhalekhaIcon.png',
            'APP_THEME_COLOR' => '#86363B',
            'APP_KEYWORDS' => 'cars',
            'APP_TWITTER_CREATOR' => '@aditya',
        ];
        $host = $config['DB_HOST'];
        $username = $config['DB_USERNAME'];
        $password = $config['DB_PASSWORD'];
        $database = $config['DB_DATABASE'];
        self::$connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    /**
     * Inserts data into the specified table.
     *
     * @param string $table The name of the table.
     * @param array  $data  The data to be inserted.
     *
     * @return bool True if the insert operation was successful, false otherwise.
     */
    public static function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $statement = self::$connection->prepare($query);

        foreach ($data as $column => &$value) {
            $statement->bindParam(":$column", $value);
        }

        return $statement->execute();
    }

    /**
     * Updates data in the specified table based on the given condition.
     *
     * @param string $table The name of the table.
     * @param array  $data  The data to be updated.
     * @param string $where The condition for updating the data.
     *
     * @return int The number of rows affected by the update operation.
     */

    // public static function update($table, $data, $where)
    // {
    //     $set = "";
    //     foreach ($data as $column => $value) {
    //         if($value != null) $set .= "$column = '$value', ";
    //     }
    //     $set = rtrim($set, ", ");
    //     $query = "UPDATE $table SET $set WHERE $where";
    //     echo $query;
    //     $statement = self::$connection->prepare($query);
    //     $statement->execute();

    //     return $statement->rowCount();
    // }


    // handling nulls while updating
    public static function update($table, $data, $where)
{
    $set = [];
    $params = [];

    // Construct the SET part of the query and bind the parameters
    foreach ($data as $column => $value) {
        if ($value === null) {
            $set[] = "$column = NULL"; // If value is null, set it as NULL
        } else {
            $set[] = "$column = :$column"; // Use parameterized queries for other values
            $params[":$column"] = $value; // Bind the value to the parameter
        }
    }
    $setString = implode(", ", $set); // Join the set parts with commas
    $query = "UPDATE $table SET $setString WHERE $where"; // Correct query
// var_dump($query);
    // Prepare and execute the query using a prepared statement
    $statement = self::$connection->prepare($query);
    
    // Execute the query with the bound parameters
    $executed = $statement->execute($params);

    // Return the result of the execution
    return $executed;
}





    /**
     * Deletes data from the specified table based on the given condition.
     *
     * @param string $table The name of the table.
     * @param string $where The condition for deleting the data.
     *
     * @return int The number of rows affected by the delete operation.
     */
    public static function delete($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";

        $statement = self::$connection->prepare($query);
        $statement->execute();

        return $statement->rowCount();
    }

    /**
     * Selects data from the specified table based on the given parameters.
     *
     * @param string $table   The name of the table.
     * @param string $columns The columns to be selected.
     * @param string $where   The condition for selecting the data.
     * @param string $orderBy The order in which the data should be sorted.
     * @param string $limit   The maximum number of rows to be returned.
     *
     * @return PDOStatement The result set of the select operation.
     */
    public static function select($table, $columns = "*", $where = "", $orderBy = "", $limit = "", $bindings = [])
    {
        try {
            // Ensure the database connection is available
            if (self::$connection === null) {
                self::connect();
            }

            // Build the base query
            $query = "SELECT $columns FROM $table";

            // Add conditions, order, and limit if provided
            if ($where) {
                $query .= " WHERE $where";
            }

            if ($orderBy) {
                $query .= " ORDER BY $orderBy";
            }

            if ($limit) {
                $query .= " LIMIT $limit";
            }

            // Prepare the query
            $statement = self::$connection->prepare($query);

            // Bind values if provided
            if (!empty($bindings)) {
                foreach ($bindings as $key => $value) {
                    $statement->bindValue($key, $value);
                }
            }

            // Execute the query
            $statement->execute();

            // Return the fetched results as an associative array
            return $statement;
        } catch (PDOException $e) {
            // Handle the exception (log it, rethrow it, or return a custom error message)
            throw new Exception("Database query error: " . $e->getMessage());
        }
    }


    /**
     * Executes a custom query with optional parameter bindings.
     *
     * @param string $query    The custom SQL query.
     * @param array  $bindings The parameter bindings for the query.
     *
     * @return array The result set of the query.
     */
    public static function query($query, $bindings = [])
    {
        $statement = self::$connection->prepare($query);
        $statement->execute($bindings);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Counts the number of rows in the specified table based on the given condition.
     *
     * @param string $table The name of the table.
     * @param string $where The condition for counting the rows.
     *
     * @return int The number of rows in the table.
     */
    public static function count($table, $where = "")
    {
        $query = "SELECT COUNT(*) as count FROM $table";

        if ($where) {
            $query .= " WHERE $where";
        }

        $statement = self::$connection->prepare($query);
        $statement->execute();

        return $statement->fetchColumn();
    }

    /**
     * Checks if records exist in the specified table based on the given condition.
     *
     * @param string $table The name of the table.
     * @param string $where The condition for checking the existence of records.
     *
     * @return bool True if records exist, false otherwise.
     */
    public static function exists($table, $where = "")
    {
        $query = "SELECT EXISTS(SELECT 1 FROM $table";

        if ($where) {
            $query .= " WHERE $where";
        }

        $query .= ") as result";

        $statement = self::$connection->prepare($query);
        $statement->execute();

        return $statement->fetchColumn();
    }

    /**
     * Truncates the specified table.
     *
     * @param string $table The name of the table to be truncated.
     *
     * @return int The number of rows affected by the truncate operation.
     */
    public static function truncate($table)
    {
        $query = "TRUNCATE TABLE $table";

        $statement = self::$connection->prepare($query);
        $statement->execute();

        return $statement->rowCount();
    }

    /**
     * Executes a custom query with optional parameter bindings.
     *
     * @param string $query    The custom SQL query.
     * @param array  $bindings The parameter bindings for the query.
     *
     * @return int The number of rows affected by the query.
     */
    public static function execute($query, $bindings = [])
    {
        $statement = self::$connection->prepare($query);
        $statement->execute($bindings);

        return $statement->rowCount();
    }

    /**
     * Begins a transaction.
     */
    public static function beginTransaction()
    {
        self::$connection->beginTransaction();
    }

    /**
     * Commits a transaction.
     */
    public static function commit()
    {
        self::$connection->commit();
    }

    /**
     * Rolls back a transaction.
     */
    public static function rollback()
    {
        self::$connection->rollBack();
    }

    /**
     * Closes the database connection.
     */
    public static function close()
    {
        self::$connection = null;
    }

    /**
     * Sets a custom PDO connection.
     *
     * @param PDO $connection The PDO connection object.
     */
    public static function setConnection(PDO $connection)
    {
        self::$connection = $connection;
    }

    /**
     * Retrieves the current PDO connection.
     *
     * @return PDO The PDO connection object.
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * Checks if a connection to the database is established.
     *
     * @return bool True if connected, false otherwise.
     */
    public static function isConnected()
    {
        return self::$connection !== null;
    }

    /**
     * Sanitizes a value for safe database insertion.
     *
     * @param mixed $value The value to be sanitized.
     *
     * @return string The sanitized value.
     */
    public static function sanitize($value)
    {
        $sanitizedValue = self::$connection->quote($value);
        $sanitizedValue = substr($sanitizedValue, 1, -1);

        return $sanitizedValue;
    }
}
