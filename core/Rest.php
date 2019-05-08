<?php

namespace Core;

require 'User.php';

class Rest extends User
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::__getConnection();
    }

    /**
     * ===============================================================
     * ==============DRINKS===========================================
     * ===============================================================
     */
    /**
     * SELECT Drink
     */
    public function selectDrinkItem($drinkItemId)
    {
        $stmt_user = $this->runQuery("SELECT * FROM drink_item WHERE drink_item_id=:drink_item_id");
        $stmt_user->execute(array(":drink_item_id"=>$drinkItemId));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectDrinkMain($drinkCode)
    {
        $stmt_user = $this->runQuery("SELECT * FROM drink WHERE drink_code=:drink_code");
        $stmt_user->execute(array(":drink_code"=>$drinkCode));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectSubDrink($drinkCode)
    {
        $stmt_user = $this->runQuery("SELECT * FROM drink _subcat WHERE subdrink_code=:subdrink_code");
        $stmt_user->execute(array(":subdrink_code"=>$drinkCode));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * ADD DRINKS
     */
    /**
     * Add Drink Wrapper
     */
    public function addDrinkWrapper($post){
        $drinkItemNaam = $post['drink_item_name'];
        $drinkItemPrijs = $post['drink_item_prijs'];
        $subdrinkCode = $post['subdrink_code'];

        if($this->addDrink($drinkItemNaam, $drinkItemPrijs, $subdrinkCode))
        {
            $this->redirect('drink.php?msg=drink toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add drink
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    private function addDrink($drinkItemNaam, $drinkItemPrijs, $subdrinkCode)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO drink_item(drink_item_name, drink_item_prijs, subdrink_code) 
			                                             VALUES(:drink_item_name, :drink_item_prijs, :subdrink_code)");
            $stmt->bindparam(":drink_item_name",$drinkItemNaam);
            $stmt->bindparam(":drink_item_prijs",$drinkItemPrijs);
            $stmt->bindparam(":subdrink_code",$subdrinkCode);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Add Subdrink Wrapper
     */
    public function addSubDrinkWrapper($post){
        $subdrinkNaam = $post['subdrink_name'];
        $drinkCode = $post['drink_code'];

        if($this->addSubDrink($subdrinkNaam, $drinkCode))
        {
            $this->redirect('drink.php?msg=sub categorie drink toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add sub drink
     *
     * @return mixed
     */
    private function addSubDrink($subdrinkNaam, $drinkCode)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO drink_subcat(subdrink_name, drink_code) 
			                                             VALUES(:subdrink_name, :drink_code)");
            $stmt->bindparam(":subdrink_name",$subdrinkNaam);
            $stmt->bindparam(":drink_code",$drinkCode);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage(); die;
        }
    }

    /**
     * Add Main Drink Wrapper
     */
    public function addMainDrinkWrapper($post){
        $drinkNaam = $post['drink_name'];

        if($this->addMainDrink($drinkNaam))
        {
            $this->redirect('drink.php?msg=Categorie drink toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add Main Drink
     *
     * @return mixed
     */
    private function addMainDrink($drinkNaam)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO drink(drink_name) 
			                                             VALUES(:drink_name)");
            $stmt->bindparam(":drink_name",$drinkNaam);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage(); die;
        }
    }

    /**
     * EDIT DRINKS
     */
    /**
     * Edit a drinkitem
     *
     * @param $post
     * @return string
     */
    public function editDrink($post)
    {
        $drinkId = trim($post['drink_item_id']);
        $subdrinkCode = trim($post['subdrink_code']);
        $drinkItemNaam = trim($post['drink_item_name']);
        $drinkPrijs = trim($post['drink_item_prijs']);


        //check if nothing is empty
        if(empty($drinkId )) {
            $msg_intern = "Wij hebben een drink_item_id";
        }
        else if(empty($subdrinkCode )) {
            $msg_intern = "Wij hebben een subdrink_code";
        }
        else if(empty($drinkItemNaam )) {
            $msg_intern = "Wij hebben een drink_item_name";
        }
        else if(empty($drinkPrijs )) {
            $msg_intern = "Wij hebben een drink_item_prijs";
        }
        else {
            if($this->editDrinkAction($drinkId , $subdrinkCode , $drinkItemNaam , $drinkPrijs )) {
                $msg_intern = "<strong>Success!</strong>  The User Information is Updated.";
                header( "Location: drink.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }

        return $msg_intern;
    }

    /**
     * Edit an drink action
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function editDrinkAction($drinkId , $subdrinkCode , $drinkItemNaam , $drinkPrijs )
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `drink_item` 
                            SET 
                            `drink_item_id` = :drink_item_id,
                            `subdrink_code`     = :subdrink_code, 
                            `drink_item_name`  = :drink_item_name, 
                            `drink_item_prijs`  = :drink_item_prijs
                            WHERE 
                            `drink_item_id` = :drink_item_id"
            );
            $stmt_edit->bindparam(":drink_item_id",$drinkId,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subdrink_code",$subdrinkCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":drink_item_name",$drinkItemNaam,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":drink_item_prijs",$drinkPrijs,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Edit main drink
     * @param $post
     * @return string
     */
    public function editDrinkMain($post)
    {
        $drinkCode = trim($post['drink_code']);
        $drinkNaam = trim($post['drink_name']);



        //check if nothing is empty
        if(empty($drinkCode )) {
            $msg_intern = "Wij hebben een drink_code";
        }
        else if(empty($drinkNaam )) {
            $msg_intern = "Wij hebben een drink naam";
        }
        else {
            if($this->editDrinkMainAction($drinkCode , $drinkNaam )) {
                $msg_intern = "<strong>Success!</strong>  The User Information is Updated.";
                header( "Location: drink.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }

        return $msg_intern;
    }

    /**
     * Edit an drink action
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function editDrinkMainAction($drinkCode , $drinkNaam  )
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `drink` 
                            SET 
                            `drink_code` = :drink_code,
                            `drink_name`     = :drink_name, 
                            WHERE 
                            `drink_code` = :drink_code"
            );
            $stmt_edit->bindparam(":drink_code",$drinkCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":drink_name",$drinkNaam,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Edit suddrink
     * @param $post
     * @return string
     */
    public function editSubDrink($post)
    {
        $drinkCode = trim($post['drink_code']);
        $subDrinkCode = trim($post['subdrink_code']);
        $subDrinkNaam = trim($post['subdrink_name']);

        //check if nothing is empty
        if(empty($drinkCode )) {
            $msg_intern = "Wij hebben een drink_code";
        }
        else if(empty($subDrinkNaam )) {
            $msg_intern = "Wij hebben een drink naam";
        }
        else if(empty($subDrinkCode )) {
            $msg_intern = "Wij hebben een sub drink code nodig";
        }
        else {
            if($this->editSubDrinkAction($drinkCode , $subDrinkCode, $subDrinkNaam )) {
                $msg_intern = "<strong>Success!</strong>  The User Information is Updated.";
                header( "Location: drink.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }
        return $msg_intern;
    }

    /**
     * Edit an sub drink action
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function editSubDrinkAction($drinkCode , $subDrinkCode, $subDrinkNaam)
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `drink_subcat` 
                            SET 
                            `drink_code` = :drink_code,
                            `subdrink_code` = :subdrink_code,
                            `subdrink_name`     = :subdrink_name, 
                            WHERE 
                            `subdrink_code` = :subdrink_code"
            );
            $stmt_edit->bindparam(":drink_code",$drinkCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subdrink_code",$subDrinkCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subdrink_name",$subDrinkNaam,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Bestel drinks
     */
    /**
     * Bestel Drink Wrapper
     */
    public function bestelDrinkWrapper($post){
        $drinkItemId = $post['drink_item_id'];
        $drinkItemAantal = $post['drink_aantal'];
        $tafelNummer = $post['tafelnummer'];

        if($this->bestelDrink($drinkItemId, $drinkItemAantal, $tafelNummer))
        {
            $this->redirect('ober.php?msg=bestel toevoegd');
        }
        else{
            $this->redirect('ober.php?msg=failed');
        }
    }

    /**
     * Bestel drink
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    private function bestelDrink($drinkItemId, $drinkItemAantal, $tafelNummer)
    {
        /**
         * INSERT INTO Users (id, weight, desiredWeight) VALUES(1, 160, 145) ON DUPLICATE KEY UPDATE weight=160, desiredWeight=145
         */
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO tafel_product(tafelnummer, drink_item_id, drink_aantal) 
			                                             VALUES(:tafelnummer, :drink_item_id, :drink_aantal)
			                                            ON DUPLICATE KEY UPDATE 
			                                            drink_item_id=:drink_item_id, drink_aantal=:drink_aantal");
            $stmt->bindparam(":drink_item_id",$drinkItemId);
            $stmt->bindparam(":drink_aantal",$drinkItemAantal);
            $stmt->bindparam(":tafelnummer",$tafelNummer);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }


    /**
     * ===============================================================
     * ==============ETEN===========================================
     * ===============================================================
     */
    /**
     * SELECT ETEN
     */
    public function selectEtenItem($etenId)
    {
        $stmt_user = $this->runQuery("SELECT * FROM eten_item WHERE eten_item_id=:eten_item_id");
        $stmt_user->execute(array(":eten_item_id"=>$etenId));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectEtenMain($etenId)
    {
        $stmt_user = $this->runQuery("SELECT * FROM eten WHERE eten_code=:eten_code");
        $stmt_user->execute(array(":eten_code"=>$etenId));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectSubEten($etenId)
    {
        $stmt_user = $this->runQuery("SELECT * FROM subeten WHERE subeten_code=:subeten_code");
        $stmt_user->execute(array(":subeten_code"=>$etenId));
        return $stmt_user->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * ADD ETEN
     */
    /**
     * Add Eten Wrapper
     */
    public function addEtenWrapper($post){
        $etenItemNaam = $post['eten_item_name'];
        $etenItemPrijs = $post['eten_item_prijs'];
        $subetenCode = $post['subeten_code'];

        if($this->addEten($etenItemNaam, $etenItemPrijs, $subetenCode))
        {
            $this->redirect('eten.php?msg=eten toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add eten
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    private function addEten($etenItemNaam, $etenItemPrijs, $subetenCode)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO eten_item(eten_item_name, eten_item_prijs, subeten_code) 
			                                             VALUES(:eten_item_name, :eten_item_prijs, :subeten_code)");
            $stmt->bindparam(":eten_item_name",$etenItemNaam);
            $stmt->bindparam(":eten_item_prijs",$etenItemPrijs);
            $stmt->bindparam(":subeten_code",$subetenCode);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage(); die;
        }
    }

    /**
     * Add SubEten Wrapper
     */
    public function addSubEtenWrapper($post){
        $subetenNaam = $post['subeten_name'];
        $etenCode = $post['eten_code'];

        if($this->addSubEten($subetenNaam, $etenCode))
        {
            $this->redirect('eten.php?msg=sub categorie eten toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add Sub eten
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    private function addSubEten($subetenNaam, $etenCode)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO subeten(subeten_name, eten_code) 
			                                             VALUES(:subeten_name, :eten_code)");
            $stmt->bindparam(":subeten_name",$subetenNaam);
            $stmt->bindparam(":eten_code",$etenCode);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage(); die;
        }
    }

    /**
     * Add Main Eten Wrapper
     */
    public function addMainEtenWrapper($post){
        $etenNaam = $post['eten_name'];

        if($this->addMainEten($etenNaam))
        {
            $this->redirect('eten.php?msg=Categorie eten toevoegd');
        }
        else{
            $this->redirect('add_product.php?msg=failed');
        }
    }

    /**
     * Add Maineten
     *
     * @return mixed
     */
    private function addMainEten($etenNaam)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO eten(eten_name) 
			                                             VALUES(:eten_name)");
            $stmt->bindparam(":eten_name",$etenNaam);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage(); die;
        }
    }

    /**
     * EDIT ETEN
     */
    /**
     * Edit eten
     * @param $post
     * @return string
     */
    public function editEten($post)
    {
        $etenId = trim($post['eten_item_id']);
        $subEtenCode = trim($post['subeten_code']);
        $etenItemNaam = trim($post['eten_item_name']);
        $etenPrijs = trim($post['eten_item_prijs']);


        //check if nothing is empty
        if(empty($etenId )) {
            $msg_intern = "Wij hebben een eten_item_id";
        }
        else if(empty($subEtenCode )) {
            $msg_intern = "Wij hebben een subeten_code";
        }
        else if(empty($etenItemNaam )) {
            $msg_intern = "Wij hebben een eten_item_name";
        }
        else if(empty($etenPrijs )) {
            $msg_intern = "Wij hebben een eten_item_prijs";
        }
        else {
            if($this->editEtenAction($etenId , $subEtenCode , $etenItemNaam , $etenPrijs )) {
                $msg_intern = "<strong>Success!</strong>  The User Information is Updated.";
                header( "Location: eten.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }

        return $msg_intern;
    }

    /**
     * Edit an eten action
     *
     * @param $full_name
     * @param $password
     * @param $user_id
     * @return mixed
     */
    public function editEtenAction($etenId , $subEtenCode , $etenItemNaam , $etenPrijs )
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `eten_item` 
                            SET 
                            `eten_item_id` = :eten_item_id,
                            `subeten_code`     = :subeten_code, 
                            `eten_item_name`  = :eten_item_name, 
                            `eten_item_prijs`  = :eten_item_prijs
                            WHERE 
                            `eten_item_id` = :eten_item_id"
            );
            $stmt_edit->bindparam(":eten_item_id",$etenId,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subeten_code",$subEtenCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":eten_item_name",$etenItemNaam,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":eten_item_prijs",$etenPrijs,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Edit main eten
     * @param $post
     * @return string
     */
    public function editEtenMain($post)
    {
        $drinkkCode = trim($post['drinkk_code']);
        $drinkkNaam = trim($post['drinkk_name']);

        if(empty($drinkkCode )) {
            $msg_intern = "Wij hebben een drinkk_code";
        }
        else if(empty($drinkkNaam )) {
            $msg_intern = "Wij hebben een drinkk naam";
        }
        else {
            if($this->editEtenMainAction($drinkkCode , $drinkkNaam )) {
                $msg_intern = "<strong>Success!</strong>  The drink Information is Updated.";
                header( "Location: eten.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }
        return $msg_intern;
    }

    /**
     * Edit an eten action
     *
     * @return mixed
     */
    public function editEtenMainAction($etenCode , $etenNaam  )
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `eten` 
                            SET 
                            `eten_code` = :eten_code,
                            `eten_name`     = :eten_name, 
                            WHERE 
                            `eten_code` = :eten_code"
            );
            $stmt_edit->bindparam(":eten_code",$etenCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":eten_name",$etenNaam,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Edit sudeten
     * @param $post
     * @return string
     */
    public function editSubEten($post)
    {
        $etenCode = trim($post['eten_code']);
        $subetenCode = trim($post['subeten_code']);
        $subetenNaam = trim($post['subeten_name']);

        //check if nothing is empty
        if(empty($etenCode )) {
            $msg_intern = "Wij hebben een eten_code";
        }
        else if(empty($subetenNaam )) {
            $msg_intern = "Wij hebben een eten naam";
        }
        else if(empty($subetenCode )) {
            $msg_intern = "Wij hebben een sub eten code nodig";
        }
        else {
            if($this->editSubEtenAction($etenCode , $subetenCode, $subetenNaam )) {
                $msg_intern = "<strong>Success!</strong>  The eten Information is Updated.";
                header( "Location: eten.php" );
            }
            else {
                $msg_intern = "sorry , Query could no execute...";
            }
        }
        return $msg_intern;
    }

    /**
     * Edit an sub eten action
     *
     * @return mixed
     */
    public function editSubEtenAction($etenCode , $subetenCode, $subetenNaam)
    {
        try
        {
            $stmt_edit = $this->conn->prepare(
                "UPDATE `eten_subcat` 
                            SET 
                            `eten_code` = :eten_code,
                            `subeten_code` = :subdrink_code,
                            `subeten_name`     = :subeten_name, 
                            WHERE 
                            `subeten_code` = :subeten_code"
            );
            $stmt_edit->bindparam(":eten_code",$etenCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subeten_code",$subetenCode,\PDO::PARAM_STR);
            $stmt_edit->bindparam(":subeten_name",$subetenNaam,\PDO::PARAM_STR);

            $stmt_edit->execute();
            return $stmt_edit;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }

    /**
     * Bestel etens
     */
    /**
     * Bestel eten Wrapper
     */
    public function bestelEtenWrapper($post){
        $etenItemId = $post['eten_item_id'];
        $etenItemAantal = $post['eten_aantal'];
        $tafelNummer = $post['tafelnummer'];

        if($this->bestelEten($etenItemId, $etenItemAantal, $tafelNummer))
        {
            $this->redirect('ober.php?msg=bestel toevoegd');
        }
        else{
            $this->redirect('ober.php?msg=failed');
        }
    }

    /**
     * Bestel eten
     *
     * @param $full_name
     * @param $password
     * @return mixed
     */
    private function bestelEten($etenItemId, $etenItemAantal, $tafelNummer)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO tafel_product(tafelnummer, eten_item_id, eten_aantal) 
			                                             VALUES(:tafelnummer, :eten_item_id, :eten_aantal)
			                                            ON DUPLICATE KEY UPDATE 
			                                            eten_item_id=:eten_item_id, eten_aantal=:eten_aantal");
            $stmt->bindparam(":eten_item_id",$etenItemId);
            $stmt->bindparam(":eten_aantal",$etenItemAantal);
            $stmt->bindparam(":tafelnummer",$tafelNummer);
            $stmt->execute();
            return $stmt;
        }
        catch(\PDOException $ex)
        {
            echo $ex->getMessage();die;
        }
    }


}