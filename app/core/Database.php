<?php

trait Database
{
    public $conn;
    private function connect()
    {
        $this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if (!$this->conn) {
            throw new Exception('Failed to connect to database: ' . mysqli_connect_error());
        }
        return $this->conn;
    }

    public function query($sql)
    {
        $con = $this->connect();
        try {
            $result = mysqli_query($con, $sql);
            if ($result === false) {
                throw new Exception("Query failed: " . mysqli_error($con));
            }
            if (is_bool($result)) {
                return true;
            } else {
                return $result;
                
            }
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            mysqli_close($con);
        }
    }
}