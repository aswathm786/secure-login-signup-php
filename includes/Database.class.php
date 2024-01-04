<?php
class Database
{
    public static $conn = null;

    // Function to establish a database connection
    public static function getconnection()
    {
        // Check if the connection is not already established
        if (self::$conn == null) {
            // Get database configuration from JSON file
            $filePath = __DIR__ . '/../config/db.json';
            $config_file = file_get_contents($filePath);
            $config = json_decode($config_file, true);

            $servername = $config['host'];
            $username = $config['username'];
            $password = $config['password'];
            $dbname = $config['dbname'];

            // Create a new MySQLi connection
            $connection = new mysqli($servername, $username, $password, $dbname);

            // Check if the connection was successful
            if ($connection->connect_error) {
                // If connection fails, terminate with an error message
                die("Connection failed: " . $connection->connect_error);
            } else {
                // If connection successful, set the connection and return it
                self::$conn = $connection;
                return self::$conn;
            }
        } else {
            // If the connection is already established, return the existing connection
            return self::$conn;
        }
    }

    // Destructor to close the database connection when the object is destroyed
    public function __destruct()
    {
        // Check if the connection exists and close it
        if (self::$conn !== null) {
            self::$conn->close();
        }
    }
}
