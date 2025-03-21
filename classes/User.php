<?php

class User
{
    // Attribut
    private $id; // ID auto-generated by the database
    private $pseudo; // string
    private $email; // string
    private $password; // string
    private $is_breeder; // bool
    private $siret; // int
    private $city; // string
    private $phone_number; // string

    // Method
    public function __construct(string $pseudo, string $email, string $password,  string $city, bool $is_breeder = false, int $siret = null, string $phone_number = null) 
    {
        $this -> pseudo = $pseudo;
        $this -> email = $email;
        $this -> password = $password;
        $this -> is_breeder = $is_breeder;
        $this -> city = $city;

        if($is_breeder){
            // If is_breeder, siret and phone_number required
            if (empty($siret) || empty($phone_number)) {
                throw new Exception("SIRET et numéro de téléphone sont requis pour les éleveurs.");
            }
            $this->siret = $siret;
            $this->phone_number = $phone_number;
        }else{
            $this->siret = null;
            $this->phone_number = null;
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getPseudo()
    {
        return $this-> pseudo;
    }
    public function getEmail()
    {
        return $this-> email;
    }
    public function getPassword()
    {
        return $this-> password;
    }
    public function getIsBreeder()
    {
        return $this-> is_breeder;
    }
    public function getSiret()
    {
        return $this-> siret;
    }
    public function getCity()
    {
        return $this-> city;
    }
    public function getPhoneNumber()
    {
        return $this-> phone_number;
    }

    // // Setter
    // public function setPseudo($pseudo)
    // {
    //     $this->pseudo = $pseudo;
    // }
    // public function setEmail($email)
    // {
    //     $this-> email = $email;
    // }
    // public function setPassword($password)
    // {
    //     $this-> password = $password;
    // }
    // public function setIsBreeder($is_breeder)
    // {
    //     $this-> is_breeder = $is_breeder;
    // }
    // public function setSiret($siret)
    // {
    //     if ($this->is_breeder) {
    //         $this->siret = $siret;
    //     }
    // }
    // public function setCity($city)
    // {
    //     $this-> city = $city;
    // }
    // public function setPhoneNumber($phone_number) {
    //     if ($this->is_breeder) {
    //         $this->phone_number = $phone_number;
    //     }
    // }

    // Method to insert a user into the database
    public function save($pdo) {
        $sql = "INSERT INTO user (pseudo, email, password, is_breeder, siret, city, phone_number) 
            VALUES (:pseudo, :email, :password, :is_breeder, :siret, :city, :phone_number)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pseudo' => $this->pseudo,
            ':email' => $this->email,
            ':password' => $this->password,
            ':is_breeder' => $this->is_breeder,
            ':siret' => $this->siret,
            ':city' => $this->city,
            ':phone_number' => $this->phone_number
        ]);
        $this->id = $pdo->lastInsertId(); // Retrieve the generated ID after insert
    }

    // Method to update a user in the database
    public function update($pdo) {
        $sql = "UPDATE user 
                SET pseudo = :pseudo, email = :email, password = :password, is_breeder = :is_breeder, 
                    siret = :siret, city = :city, phone_number = :phone_number 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pseudo' => $this->pseudo,
            ':email' => $this->email,
            ':password' => $this->password,
            ':is_breeder' => $this->is_breeder,
            ':siret' => $this->siret,
            ':city' => $this->city,
            ':phone_number' => $this->phone_number,
            ':id' => $this->id
        ]);
    }

    // Method to delete a user
    public function delete($pdo) {
        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $this->id]);
    }


    // Method to find a user by his ID
    public static function findById($pdo, $id) {
        // Preparing the SQL query to select the user
        $sql = "SELECT * FROM user WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    
        // Data recovery
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found
        if ($data) {
            // Creating a User object with the retrieved data
            $user = new User(
                $data['pseudo'],
                $data['email'],
                $data['password'],
                $data['city'],
                $data['is_breeder'],
                $data['siret'],
                $data['phone_number']
            );
            
            $user->id = $data['id']; // Set User ID
            return $user;
        } else {
            return null; // Not found
        }
    }
    
    // Method to display user information
    public function displayUser() {
        echo "ID : " . $this->id . "<br>";
        echo "Pseudo : " . $this->pseudo . "<br>";
        echo "Email : " . $this->email . "<br>";
        echo "Is Breeder : " . ($this->is_breeder ? 'Yes' : 'No') . "<br>";
        echo "City : " . $this->city . "<br>";
        if ($this->is_breeder) {
            echo "SIRET : " . $this->siret . "<br>";
            echo "Phone Number : " . $this->phone_number . "<br>";
        }
    }    
}

?>