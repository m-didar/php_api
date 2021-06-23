<?php

    class Category {
        // DB stuff
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $name;
        public $created_at;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            // Create query
            $query = 'SELECT
                    id,
                    name
                FROM ' . $this->table . '
                ORDER BY
                    created_at DESC';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();
            return $stmt;
        }

        // Get Single Category
        public function read_single() {
            // Create query
            $query = 'SELECT
                    id,
                    name
                FROM ' . $this->table . '
                WHERE
                    id = :id
                LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParams(':id', $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->name = $row['name'];
        }

        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    name = :name
                WHERE
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            // Bind ID
            $stmt->bindParams(':id', $this->id);
            $stmt->bindParams(':name', $this->name);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);

            return false;
        }

        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . '
                WHERE
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind ID
            $stmt->bindParams(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

?>