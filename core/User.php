<?php

namespace Core;

require 'Database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    /**
     * ======================
     * Klant
     * ======================
     */

    /**
     * Wrapper for klant registration
     *
     * @param $post
     */
    public function registerWrapper($post){
        $voorletters = $post['voorletters'];
        $tussenvoegsels = $post['tussenvoegsels'];
        $achternaam = $post['achternaam'];
        $telefoon = $post['telefoon'];
        $wachtwoord = $post['wachtwoord'];

        if($this->registerKlant($voorletters, $tussenvoegsels, $achternaam, $telefoon, $wachtwoord))
        {
            $this->redirect('login.php?msg=success');
        }
        else{
            $this->redirect('register.php?msg=failed');
        }

    }

    /**
     * Register a new user klant
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    public function registerKlant($voorletters, $tussenvoegsels, $achternaam, $telefoon, $wachtwoord)
    {
        try
        {
            $password = md5($wachtwoord);
            $stmt = $this->conn->prepare("INSERT INTO klant(voorletters, tussenvoegsels, achternaam, telefoon, wachtwoord) 
			                                             VALUES(:voorletters, :tussenvoegsels, :achternaam, :telefoon, :wachtwoord)");
            $stmt->bindparam(":voorletters",$voorletters);
            $stmt->bindparam(":tussenvoegsels",$tussenvoegsels);
            $stmt->bindparam(":achternaam",$achternaam);
            $stmt->bindparam(":telefoon",$telefoon);
            $stmt->bindparam(":wachtwoord",$password);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Login user klant
     *
     * @param $email
     * @param $upass
     * @return bool
     */
    public function loginKlant($achternaam,$upass)
    {
        $upass =  md5($upass);
        try {
            $stmt = $this->conn->prepare("SELECT * FROM klant WHERE achternaam=:achternaam");
            $stmt->execute(array(":achternaam"=>$achternaam));
            $userRow=$stmt->fetch(\PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1){
                if($userRow['wachtwoord'] == $upass) {
                    $_SESSION['userSession'] = $userRow['klantcode'];
                    $_SESSION['userSessionKlantNaam'] = $userRow['achternaam'];
                    header("Location: index.php?msg=You are logged in");
                    exit;
                }
                else{
                    header("Location: index.php?msg=wrong password");
                    exit;
                }
            }
            else {
                header("Location: index.php?msg='Something is wrong, please contact our customer service.'");
                exit;
            }
        }
        catch(\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * =======================
     * Medewerker
     * =======================
     */

    /**
     * Wrapper for medewerker registration
     *
     * @param $post
     */
    public function registerWrapperMedewerker($post){
        $voorletters = $post['voorletters'];
        $tussenvoegsels = $post['tussenvoegsels'];
        $achternaam = $post['achternaam'];
        $gebruikersnaam = $post['gebruikersnaam'];
        $wachtwoord = $post['wachtwoord'];

        if($this->registerMedewerker($voorletters, $tussenvoegsels, $achternaam, $gebruikersnaam, $wachtwoord))
        {
            $this->redirect('index.php?msg=success');
        }
        else{
            $this->redirect('register_admin.php?msg=failed');
        }

    }

    /**
     * Register a new user medewerker
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    public function registerMedewerker($voorletters, $tussenvoegsels, $achternaam, $gebruikersnaam, $wachtwoord)
    {
        try
        {
            $password = md5($wachtwoord);
            $stmt = $this->conn->prepare("INSERT INTO mederwerkers(voorletters, tussenvoegsels, achternaam, gebruikersnaam, wachtwoord) 
			                                             VALUES(:voorletters, :tussenvoegsels, :achternaam, :gebruikersnaam, :wachtwoord)");
            $stmt->bindparam(":voorletters",$voorletters);
            $stmt->bindparam(":tussenvoegsels",$tussenvoegsels);
            $stmt->bindparam(":achternaam",$achternaam);
            $stmt->bindparam(":gebruikersnaam",$gebruikersnaam);
            $stmt->bindparam(":wachtwoord",$password);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Edit an user
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function editMedewerker($medewerker_code, $voorletters, $tussenvoegsels, $achternaam, $gebruikersnaam, $wachtwoord)
    {
        try
        {
            $wachtwoord = md5($wachtwoord);
            $stmt_edit = $this->conn->prepare(
                "UPDATE `users` 
                            SET 
                            `full_name` = :full_name,
                            `email`     = :email, 
                            `password`  = :pass, 
                            WHERE 
                            `user_id`        = :uid"
            );
            $stmt_edit->bindparam(":full_name",$full_name,PDO::PARAM_STR);
            $stmt_edit->bindparam(":email",$email,PDO::PARAM_STR);
            $stmt_edit->bindparam(":pass",$wachtwoord,PDO::PARAM_STR);
            $stmt_edit->bindparam(":uid",$user_id,PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Login user klant
     *
     * @param $email
     * @param $upass
     * @return bool
     */
    public function loginMederwerker($gebruikersnaam,$upass)
    {
        $upass =  md5($upass);
        try {
            $stmt = $this->conn->prepare("SELECT * FROM mederwerkers WHERE gebruikersnaam=:gebruikersnaam");
            $stmt->execute(array(":gebruikersnaam"=>$gebruikersnaam));
            $userRow=$stmt->fetch(\PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1) {
                if($userRow['wachtwoord'] == $upass) {
                    $_SESSION['userSessionAdmin'] = $userRow['mederwerkerscode'];
                    header("Location: admin/index.php?msg=You are logged in");
                    exit;
                }
                else{
                    header("Location: index.php?msg=wrong password");
                    exit;
                }
            }
            else {
                header("Location: index.php?msg=Something is wrong, please contact our customer service.");
                exit;
            }
        }
        catch(\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Rent a car
     * @param $kenteken
     * @param $klantcode
     * @param $begindatum
     * @param $einddatum
     * @return string
     */
    public function reserveTafel($user_code, $datum, $tijd, $aantalPersonen)
    {
//        $stmtKlant = $this->conn->prepare("SELECT * FROM klant WHERE klant_code = :klant_code LIMIT 0,1");
//        $stmtKlant->execute(array(":klant_code"=>$user_code));
//        $klantRow = $stmtKlant->fetch(\PDO::FETCH_ASSOC);
//        $telefoon = $klantRow['telefoon'];
//        $naam = $klantRow['achternaam'];

        $stmtTafel = $this->conn->prepare("SELECT * FROM tafel WHERE datum = :datum");
        $stmtTafel->execute(array(":datum"=>$datum));
        $rowCount = $stmtTafel->rowCount();
        if($rowCount > 0){
            while($tafelRow = $stmtTafel->fetch(\PDO::FETCH_ASSOC)){
                $tijdBezet = $tafelRow['tijd'];
                if($tijdBezet == $tijd){
                    return "Tijd al bezet";
                }
                else{
                    $tafelnummer = $tafelRow['tafelnummer'];
                }
            }
        }
        else{
            $stmtTafel2 = $this->conn->prepare("SELECT * FROM tafel ORDER BY tafelnummer DESC LIMIT 0,1");
            $stmtTafel2->execute();
            $rowCount = $stmtTafel2->rowCount();
            if($rowCount > 0){
                while($tafelRow = $stmtTafel2->fetch(\PDO::FETCH_ASSOC)){
                    $tafelnummer = $tafelRow['tafelnummer'] + 1;
                }
            }
            else{
                $tafelnummer = 1;
            }
        }
        $betaald = 0;
        $reservering_gebruikt = 0;

        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tafel(tafelnummer, tijd, datum, betaald) 
			                     VALUES(:tafelnummer, :tijd, :datum, :betaald)");

            $stmt->bindparam(":tafelnummer",$tafelnummer);
            $stmt->bindparam(":tijd",$tijd);
            $stmt->bindparam(":datum",$datum);
            $stmt->bindparam(":betaald",$betaald);
            $stmt->execute();
            if($stmt){
                try {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO tafel_reservering(tafelnummer, klantcode, aantal_personen, reservering_gebruikt) 
			                     VALUES(:tafelnummer, :klantcode, :aantal_personen, :reservering_gebruikt)");

                    $stmt->bindparam(":tafelnummer",$tafelnummer);
                    $stmt->bindparam(":klantcode",$user_code);
                    $stmt->bindparam(":aantal_personen",$aantalPersonen);
                    $stmt->bindparam(":reservering_gebruikt",$reservering_gebruikt);
                    $stmt->execute();
                    if($stmt){
                        return $tafelnummer;
                    }
                }
                catch(\PDOException $ex)
                {
                    echo $ex->getMessage();die;
                }
            }
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * =====================
     * Main functions
     * =====================
     *
     */

    protected function __getConnection()
    {
        return $this->conn;
    }

    /**
     * Wrapper for the prepare statement
     *
     * @param $sql
     * @return mixed
     */
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    /**
     * Check if user is logged in admin
     *
     * @return bool
     */
    public function is_logged_in_admin()
    {
        if(isset($_SESSION['userSessionAdmin']))
        {
            return true;
        }
    }

    /**
     * Redirect to specified path
     *
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: $url");
    }

    /**
     * Log user out
     */
    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    /**
     * Log user out
     */
    public function logoutAdmin()
    {
        session_destroy();
        $_SESSION['userSessionAdmin'] = false;
    }

    /**
     * ===========================
     * Functions examples
     * ===========================
     */

    /**
     * Register a new user general
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    public function register($full_name, $email, $password)
    {
        try
        {
            $password = md5($password);
            $stmt = $this->conn->prepare("INSERT INTO users(full_name, email, password) 
			                                             VALUES(:full_name, :email, :password)");
            $stmt->bindparam(":full_name",$full_name);
            $stmt->bindparam(":password",$password);
            $stmt->bindparam(":email", $email);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Login user general
     *
     * @param $email
     * @param $upass
     * @return bool
     */
    public function login($email,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1)
            {
                if($userRow['password']==md5($upass)) {
                    $_SESSION['userSession'] = $userRow['id'];
                    return true;
                }
                else{
                    header("Location: index.php?error='wrong password'");
                    exit;
                }
            }
            else
            {
                header("Location: index.php?error='Something is wrong, please contact our customer service.'");
                exit;
            }
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Edit an user general
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function edit_user($full_name, $email, $password, $user_id)
    {
        try
        {
            $password = md5($password);
            $stmt_edit = $this->conn->prepare(
                "UPDATE `users` 
                            SET 
                            `full_name` = :full_name,
                            `email`     = :email, 
                            `password`  = :pass, 
                            WHERE 
                            `user_id`        = :uid"
            );
            $stmt_edit->bindparam(":full_name",$full_name,PDO::PARAM_STR);
            $stmt_edit->bindparam(":email",$email,PDO::PARAM_STR);
            $stmt_edit->bindparam(":pass",$password,PDO::PARAM_STR);
            $stmt_edit->bindparam(":uid",$user_id,PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
}