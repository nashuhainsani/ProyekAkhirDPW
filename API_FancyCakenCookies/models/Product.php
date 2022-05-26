<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'Product';

    // Post Properties
    public $id;
    public $name;
    public $price;
    public $uom;
    public $idToChoose;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->name = $row['Name'];
          $this->price = $row['Price'];
          $this->uom = $row['UOM'];
    }

    // Create Post
    public function create() {
      // Create query
      $query = 'INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          name = :Name,
          price = :Price,
          uom = :UOM';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->price = htmlspecialchars(strip_tags($this->price));
      $this->uom = htmlspecialchars(strip_tags($this->uom));

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':Name', $this->name);
      $stmt->bindParam(':Price', $this->price);
      $stmt->bindParam(':UOM', $this->uom);

      // Execute query
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
      // Create query
      $query = 'UPDATE ' .
          $this->table . '
        SET
          id = :id,
          name = :Name,
          price = :Price,
          uom = :UOM
        WHERE
          id = :idToChoose';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->price = htmlspecialchars(strip_tags($this->price));
      $this->uom = htmlspecialchars(strip_tags($this->uom));
      $this->idToChoose = htmlspecialchars(strip_tags($this->idToChoose));

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':Name', $this->name);
      $stmt->bindParam(':Price', $this->price);
      $stmt->bindParam(':UOM', $this->uom);
      $stmt->bindParam(':idToChoose', $this->idToChoose);

      // Execute query
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete Post
    public function delete() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :idToChoose';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->idToChoose = htmlspecialchars(strip_tags($this->idToChoose));
      
      // Bind data
      $stmt->bindParam(':idToChoose', $this->idToChoose);

      // Execute query
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
