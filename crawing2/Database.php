<?php
require "core.php";


class dataBase{


  var $lastProductID;
  var $errormessage = array();
  function showErrorMessages(){
    for($i=0;$i<count($this->errormessage);$i++){
      echo $this->errormessage[$i]."||||||||||". $i ."[][]";
    }
  }

  function getLastProductID(){
    return $this->lastProductID;
  }

  function newProduct($brand, $name, $productType, $author){
    global $db;
    $query = "
              INSERT INTO product (
                  Brand,
                  Name,
                  Type,
                  Author
              ) VALUES (
                  :brand,
                  :name,
                  :type,
                  :author
              )
          ";

          $query_params = array(
                    ':brand' => $brand,
                    ':name' => $name,
                    ':type' => $productType,
                    ':author' => $author
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;
  }

  function newProductwithActive($brand, $name, $productType, $author, $active){
    global $db;
    $query = "
              INSERT INTO product (
                  Brand,
                  Name,
                  Type,
                  Author,
                  Active
              ) VALUES (
                  :brand,
                  :name,
                  :type,
                  :author,
                  :active
              )
          ";

          $query_params = array(
                    ':brand' => $brand,
                    ':name' => $name,
                    ':type' => $productType,
                    ':author' => $author,
                    ':active'=>$active
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;
  }


  function newProductWithID($id, $brand, $name, $productType, $author){
    global $db;
    $query = "
              INSERT INTO product (
                  ID,
                  Brand,
                  Name,
                  Type,
                  Author
              ) VALUES (
                  :id,
                  :brand,
                  :name,
                  :type,
                  :author
              )
          ";

          $query_params = array(
                    ':id' => $id,
                    ':brand' => $brand,
                    ':name' => $name,
                    ':type' => $productType,
                    ':author' => $author
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;
  }

  function newPrice($productID, $sellerID, $price, $link, $crawlLink, $itemCondition, $moneyType){
    global $db;
    $query = "
              INSERT INTO pricetag (
                  ProductId,
                  SellerID,
                  Price,
                  Link,
                  CrawlLink,
                  ItemCondition,
                  MoneyType,
                  Active
              ) VALUES (
                  :productID,
                  :sellerID,
                  :price,
                  :link,
                  :crawlLink,
                  :itemCondition,
                  :moneyType,
                  1
              )
          ";

          $query_params = array(
                    ':productID' => $productID,
                    ':sellerID' => $sellerID,
                    ':price' => $price,
                    ':link' => $link,
                    ':crawlLink' => $crawlLink,
                    ':itemCondition' => $itemCondition,
                    ':moneyType' => $moneyType
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  //$id = $db->lastInsertId();
                  //$this -> lastCommentId = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;

  }

  function newFullPrice($productID, $sellerID, $price, $link, $crawlLink, $itemCondition, $moneyType, $active){
    global $db;
    $query = "
              INSERT INTO pricetag (
                  ProductId,
                  SellerID,
                  Price,
                  Link,
                  CrawlLink,
                  ItemCondition,
                  MoneyType,
                  Active
              ) VALUES (
                  :productID,
                  :sellerID,
                  :price,
                  :link,
                  :crawlLink,
                  :itemCondition,
                  :moneyType,
                  :active
              )
          ";

          $query_params = array(
                    ':productID' => $productID,
                    ':sellerID' => $sellerID,
                    ':price' => $price,
                    ':link' => $link,
                    ':crawlLink' => $crawlLink,
                    ':itemCondition' => $itemCondition,
                    ':moneyType' => $moneyType,
                    ':active' => $active
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  //$id = $db->lastInsertId();
                  //$this -> lastCommentId = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;

  }

  function newFakePrice($sellerID, $crawlLink, $active){
    global $db;
    $query = "
              INSERT INTO pricetag (
                  SellerID,
                  CrawlLink,
                  Active
              ) VALUES (
                  :sellerID,
                  :crawlLink,
                  :active
              )
          ";

          $query_params = array(
                    ':sellerID' => $sellerID,
                    ':crawlLink' => $crawlLink,
                    ':active' => $active
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  //$id = $db->lastInsertId();
                  //$this -> lastCommentId = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;

  }

  function newSpec($specName, $points, $brand, $family, $model, $spec1, $spec2=null, $spec3=null, $speclink=""){
    global $db;
    $specID = "";

    $query_params = array(
              ':specName' => $specName
          );
    $query1="";
    $query2="";


          if($points!=""){
            $query1 = $query1.",
            Points";
            $query2 = $query2.",
            :points";
            $query_params[':points'] = $points;
          }if($brand!=""){
            $query1 = $query1.",
            Brand";
            $query2 = $query2.",
            :brand";
            $query_params[':brand'] = $brand;
          }if($family!=""){
            $query1 = $query1.",
            Family";
            $query2 = $query2.",
            :family";
            $query_params[':family'] = $family;
          }if($model!=""){
            $query1 = $query1.",
            Model";
            $query2 = $query2.",
            :model";
            $query_params[':model'] = $model;
          }if($spec1!=""){
            $query1 = $query1.",
            Spec1";
            $query2 = $query2.",
            :spec1";
            $query_params[':spec1'] = $spec1;
          }if($spec2!=""){
            $query1 = $query1.",
            Spec2";
            $query2 = $query2.",
            :spec2";
            $query_params[':spec2'] = $spec2;
          }if($spec3!=""){
            $query1 = $query1.",
            Spec3";
            $query2 = $query2.",
            :spec3";
            $query_params[':spec3'] = $spec3;
          }if($speclink!=""){
            $query1 = $query1.",
            SpecLink";
            $query2 = $query2.",
            :SpecLink";
            $query_params[':SpecLink'] = $speclink;
          }


          $query = "
                    INSERT INTO specification (
                        SpecName".$query1."
                    ) VALUES (
                        :specName".$query2."
                    )
                ";

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  //$id = $db->lastInsertId();
                  //$this -> lastCommentId = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return $ex->getMessage();
              }


              return true;

  }

  function newSpecIfDoesntExistandGetID($specName, $points, $brand, $family, $model, $spec1, $spec2=null, $spec3=null, $speclink=""){
    global $db;


    $query_params = array(
              ':specName' => $specName
          );


    $query = "
            SELECT
                ID,
                SpecName,
                SpecLink,
                Points,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3
            FROM specification
            WHERE
            SpecName = :specName";

      if($brand!=""){
        $query = $query."
        AND
        Brand =  :brand";
        $query_params[':brand'] = $brand;
      }if($family!=""){
        $query = $query."
        AND
        Family = :family";
        $query_params[':family'] = $family;
      }if($model!=""){
        $query = $query."
        AND
        Model = :model";
        $query_params[':model'] = $model;
      }if($spec1!=""){
        $query = $query."
        AND
        Spec1 = :spec1";
        $query_params[':spec1'] = $spec1;
      }if($spec2!=""){
        $query = $query."
        AND
        Spec2 = :spec2";
        $query_params[':spec2'] = $spec2;
      }if($spec3!=""){
        $query = $query."
        AND
        Spec3 = :spec3";
        $query_params[':spec3'] = $spec3;
      }



      // return $qugery_params;


      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
          return "a";
      }
      $row = $stmt->fetch();
      if(empty($row)){
        global $db;
        $specID = "";
        $query1 = "
                  INSERT INTO specification (
                      SpecName";

              $query2 = ") VALUES (
                  :specName";

              $query3 = "
          )";

              if($brand!=""){
                $query1 = $query1.",
                Brand";
                $query2 = $query2.",
                :brand";
              }if($family!=""){
                $query1 = $query1.",
                Family";
                $query2 = $query2.",
                :family";
              }if($model!=""){
                $query1 = $query1.",
                Model";
                $query2 = $query2.",
                :model";
              }if($spec1!=""){
                $query1 = $query1.",
                Spec1";
                $query2 = $query2.",
                :spec1";
              }if($spec2!=""){
                $query1 = $query1.",
                Spec2";
                $query2 = $query2.",
                :spec2";
              }if($spec3!=""){
                $query1 = $query1.",
                Spec3";
                $query2 = $query2.",
                :spec3";
              }if($speclink!=""){
                $query1 = $query1.",
                SpecLink";
                $query2 = $query2.",
                :SpecLink";
                $query_params[':SpecLink'] = $speclink;
              }if($points!=""){
                $query1 = $query1.",
                Points";
                $query2 = $query2.",
                :Points";
                $query_params[':Points'] = $points;
              }

              if($speclink!=""){
                $query = $query."
                AND
                SpecLink = :SpecLink";
              }if($points!=""){
                $query = $query."
                AND
                Points = :Points";
              }


              $query4 = $query1 . $query2 . $query3;



                    try
                  {
                      $stmt = $db->prepare($query4);
                      $result = $stmt->execute($query_params);
                      //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return $query4;
                  }

                    try
                    {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                        return false;
                    }
                    $row = $stmt->fetch();
                    return $row;
      }else{return $row;}

      return true;
  }

  function mergeSpecs($spec1, $spec2){
    global $db;
    $query1 = "
          UPDATE productspec
          Set productspec.SpecID = :spec1
          WHERE productspec.SpecID = :spec2
          ";
    $query2 = "
          delete FROM `specification`
          WHERE specification.ID = :spec2
          ";

          $query_params = array(
                    ':spec1' => $spec1,
                    ':spec2' => $spec2
                );

          $query_params1 = array(
                    ':spec2' => $spec2
                );
                try
              {
                  $stmt = $db->prepare($query1);
                  $result = $stmt->execute($query_params);
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return "asdass";
              }

                try
              {
                  $stmt = $db->prepare($query2);
                  $result = $stmt->execute($query_params1);
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return "saf";
              }

              return true;
  }

  function newProductSpec($productID, $specID){
    global $db;
    $query = "
              INSERT INTO productspec (
                  ProductID,
                  SpecID
              ) VALUES (
                  :productID,
                  :specID
              )
          ";

          $query_params = array(
                    ':productID' => $productID,
                    ':specID' => $specID
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }


              return true;
  }

  function newPhoto($productID, $photoLink, $photoText, $type){
        global $db;
        $query = "
                  INSERT INTO photos (
                      ProductId,
                      ImageLink,
                      ImageText,
                      Type
                  ) VALUES (
                      :productID,
                      :photoLink,
                      :photoText,
                      :type
                  )
              ";

              $query_params = array(
                        ':productID' => $productID,
                        ':photoLink' => $photoLink,
                        ':photoText' => $photoText,
                        ':type' => $type
                    );

                    try
                  {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                    //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return false;
                  }


                  return true;

  }

// SellerName(Varchar100), sellercountry(varchar30), SellerVEnue(int5), webPage(varchar200)
  function newSeller($sellerName, $sellerCountry, $sellerVenue, $webPage){
        global $db;
        $query = "
                  INSERT INTO selller (
                      Name,
                      Country,
                      VenueType,
                      URL
                  ) VALUES (
                      :sellerName,
                      :sellerCountry,
                      :sellerVenue,
                      :webPage
                  )
              ";

              $query_params = array(
                        ':sellerName' => $sellerName,
                        ':sellerCountry' => $sellerCountry,
                        ':sellerVenue' => $sellerVenue,
                        ':webPage' => $webPage
                    );

                    try
                  {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                    //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return false;
                  }


                  return true;

  }

  function newReviewPhrase($reviewType, $pointMin, $pointMax, $phrase, $author){
        global $db;
        $query = "
                  INSERT INTO reviewphrase (
                      ReviewType,
                      PointMin,
                      PointMax,
                      Phrase,
                      Author
                  ) VALUES (
                      :reviewType,
                      :pointMin,
                      :pointMax,
                      :phrase,
                      :author
                  )
              ";

              $query_params = array(
                        ':reviewType' => $reviewType,
                        ':pointMin' => $pointMin,
                        ':pointMax' => $pointMax,
                        ':phrase' => $phrase,
                        ':author' => $author
                    );

                    try
                  {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                    //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return false;
                  }


                  return true;
  }

  function newReview($productID , $reviewType, $points, $author){
        global $db;
        $query = "
                  INSERT INTO review (
                      Type,
                      ProductID,
                      Points,
                      Author
                  ) VALUES (
                      :reviewType,
                      :productid,
                      :points,
                      :author
                  )
              ";

              $query_params = array(
                        ':productid' => $productID,
                        ':reviewType' => $reviewType,
                        ':points' => $points,
                        ':author' => $author
                    );

                    try
                  {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                    //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return false;
                  }


                  return true;
  }

  function newSpecImage($specID, $specImageLink){
        global $db;
        $query = "
                  INSERT INTO specimage (
                      Spec,
                      Link
                  ) VALUES (
                      :specID,
                      :specImageLink
                  )
              ";

              $query_params = array(
                        ':specID' => $specID,
                        ':specImageLink' => $specImageLink
                    );

                    try
                  {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                    //$id = $db->lastInsertId();
                      //$this -> lastCommentId = $id;
                  }
                  catch(PDOException $ex)
                  {
                      array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                      return false;
                  }


                  return true;
  }

  function newUser($username, $usertype,  $email, $firstname, $lastname, $password, $sex, $dob){
    global $db;
    // Double Check if Username is in use
    $query = "
              SELECT
                  1
              FROM user
              WHERE
                  UserName = :username
          ";
    $query_params = array(
                ':username' => $username
            );

            try{
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch(PDOException $ex)
                    {
                        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                        return false;
                    }

                    $row = $stmt->fetch();

                    if($row)
                    {
                        array_push($this-> errormessage, "This username is already in use");
                        return false;
                    }
    // Insert new row into database
    $query = "
              INSERT INTO user (
                  UserName,
                  UserType,
                  Email,
                  FirstName,
                  LastName,
                  Hash,
                  Salt,
                  Gender,
                  DOB
              ) VALUES (
                  :username,
                  :usertype,
                  :email,
                  :firstname,
                  :lastname,
                  :password,
                  :salt,
                  :sex,
                  :dateofbirth
              )
          ";
          //generate salt
    $salt = dechex(mt_rand(0, 2147483347)) . dechex(mt_rand(0, 2147483347));

    $password = hash('sha256', $password . $salt);

    for($round = 0; $round < 65829; $round++)
          {
              $password = hash('sha256', $password . $salt);
          }
          // set tokens

    $query_params = array(
              ':username' => $username,
              ':usertype' => $usertype,
              ':email' => $email,
              ':password' => $password,
              ':firstname' => $firstname,
              ':lastname' => $lastname,
              ':salt' => $salt,
              ':sex' => $sex,
              ':dateofbirth' => $dob
          );

          //submit the query

          try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            $id = $db->lastInsertId();
            $this -> lastUserId = $id;
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }

        return true;

  }

//-----------------------------------------GetByProductID-------------------------------------------------------

  function getPriceByProductID($productID){
      global $db;
      $query = "
              SELECT
                  ID,
                  SellerID,
                  Price,
                  Link,
                  ItemCondition,
                  MoneyType
              FROM pricetag
              WHERE
                  ProductID = :productID
              AND
                  Active = '1'
              ORDER BY Price ASC
          ";


          $query_params = array(
            ':productID' => $productID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
            return false;
        }
        $rows = $stmt->fetchAll();
        return $rows;
  }

  function getPricesByActive($active){
      global $db;
      $query = "
              SELECT
                  ID,
                  ProductID,
                  SellerID,
                  Price,
                  Link,
                  CrawlLink,
                  ItemCondition,
                  MoneyType
              FROM pricetag
              WHERE
                  Active = :active
              AND
                  SellerID = '1'
              ORDER BY ID DESC
          ";


          $query_params = array(
            ':active' => $active
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
            return false;
        }
        $rows = $stmt->fetchAll();
        return $rows;
  }

  function getPriceByPriceID($priceID){
      global $db;
      $query = "
              SELECT
                  ID,
                  SellerID,
                  ProductID,
                  Price,
                  CrawlLink,
                  Link,
                  ItemCondition,
                  MoneyType
              FROM pricetag
              WHERE
                  ID = :priceID
          ";


          $query_params = array(
            ':priceID' => $priceID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;
  }

  function getPriceByCrawlink($crawLink){
      global $db;
      $query = "
              SELECT
                  ID,
                  SellerID,
                  ProductID,
                  Price,
                  CrawlLink,
                  Link,
                  Active,
                  ItemCondition,
                  MoneyType
              FROM pricetag
              WHERE
                  CrawlLink = :crawLink
          ";


          $query_params = array(
            ':crawLink' => $crawLink
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;
  }

  function getAllPriceByProductID($productID){
      global $db;
      $query = "
              SELECT
                  ID,
                  SellerID,
                  Price,
                  Link,
                  CrawlLink,
                  Active,
                  ItemCondition,
                  MoneyType
              FROM pricetag
              WHERE
                  ProductID = :productID
          ";


          $query_params = array(
            ':productID' => $productID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
            return false;
        }
        $rows = $stmt->fetchAll();
        return $rows;
  }

  function getProductByProductID($productID){
    global $db;
      $query = "
              SELECT
                  ID,
                  Brand,
                  Name,
                  Type,
                  Author
              FROM product
              WHERE
                  ID = :productID
          ";


          $query_params = array(
            ':productID' => $productID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return $ex->getMessage();
        }
        $row = $stmt->fetch();
        return $row;
  }

  function getProductByProductName($brand, $name){
    global $db;
      $query = "
              SELECT
                  ID,
                  Brand,
                  Name,
                  Type,
                  Author
              FROM product
              WHERE
                  Brand = :brand
              AND
                  REPLACE(Name,'-',' ') = :name
          ";

        $query_params = array(
            ':brand' => $brand,
            ':name'  => $name
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;
  }

  function getProductsByProductName($brand, $name){
    global $db;
      $query = "
              SELECT
                  ID,
                  Brand,
                  Name,
                  Type,
                  Author
              FROM product
              WHERE
                  Brand = :brand
              AND
                  REPLACE(Name,'-',' ') = :name
          ";

        $query_params = array(
            ':brand' => $brand,
            ':name' => $name
        );



      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getSpecByID($id){
    global $db;
    $query = "
            SELECT
                ID,
                SpecName,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3,
                SpecLink,
                Points
            FROM specification
            WHERE
                ID = :id

        ";

        $query_params = array(
              ':id' => $id
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
          return false;
      }
      $row = $stmt->fetch();
      return $row;
  }  //new after 0.2 update (database update)

  function getSpecListByProductID($productID){  //new after 0.2 update (database update)
    global $db;
    $query = "
            SELECT
                SpecID
            FROM productspec
            WHERE
                ProductID = :productID

        ";

        $query_params = array(
              ':productID' => $productID
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getProductIDsBySpecID($specID){  //new after 0.2 update (database update)
    global $db;
    $query = "
            SELECT
                ProductID
            FROM productspec
            WHERE
                SpecID = :specID

        ";

        $query_params = array(
              ':specID' => $specID
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getSpecsByProductID($productID){
    global $db;
    $query = "
            SELECT
                ID,
                SpecName,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3,
                SpecLink,
                Points
            FROM specification
            WHERE
                ProductID = :productID

        ";

        $query_params = array(
              ':productID' => $productID
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getSpecsByProductIDandType($productID, $type){
    global $db;
    $query = "
            SELECT
                ID,
                SpecName,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3,
                SpecLink,
                Points
            FROM specification
            WHERE
                ProductID = '$productID'
            AND
                SpecName = '$type'
        ";

        $query_params = array(
              ':productID' => $productID,
              ':type' => $type
      );

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getSpecByProductIDandType($productID, $type){
    global $db;
    $query = "
            SELECT
                ID,
                SpecName,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3,
                SpecLink,
                Points
            FROM specification
            WHERE
                ProductID = :productID
            AND
                SpecName = :type

        ";

        $query_params = array(
              ':productID' => $productID,
              ':type' => $type
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
          return false;
      }
      $row = $stmt->fetch();
      return $row;
  }

  function getSpecsByType($type){
    global $db;
    $query = "
            SELECT
                ID,
                SpecName,
                Brand,
                Family,
                Model,
                Spec1,
                Spec2,
                Spec3,
                SpecLink,
                Points
            FROM specification
            WHERE
                SpecName = '$type'
            ORDER BY Brand, Model, Spec1 ASC
        ";

        $query_params = array(
              ':type' => $type
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getSpecsByAll($specName, $brand, $family, $model, $spec1, $spec2=null, $spec3=null){
    global $db;


        $query_params = array(
                  ':specName' => $specName
              );


        $query = "
                SELECT
                    ID,
                    SpecName,
                    SpecLink,
                    Points,
                    Brand,
                    Family,
                    Model,
                    Spec1,
                    Spec2,
                    Spec3
                FROM specification
                WHERE
                SpecName = :specName";

          if($brand!=""){
            $query = $query."
            AND
            Brand like :brand";
            $query_params[':brand'] = '%'.$brand.'%';
          }if($family!=""){
            $query = $query."
            AND
            Family like :family";
            $query_params[':family'] = '%'.$family.'%';
          }if($model!=""){
            $query = $query."
            AND
            Model like :model";
            $query_params[':model'] = '%'.$model.'%';
          }if($spec1!=""){
            $query = $query."
            AND
            Spec1 like :spec1";
            $query_params[':spec1'] = '%'.$spec1.'%';
          }if($spec2!=""){
            $query = $query."
            AND
            Spec2 like :spec2";
            $query_params[':spec2'] = '%'.$spec2.'%';
          }if($spec3!=""){
            $query = $query."
            AND
            Spec3 like :spec3";
            $query_params[':spec3'] = '%'.$spec3.'%';
          }

          $query = $query."
          ORDER BY Model";

          try
          {
              $stmt = $db->prepare($query);
              $result = $stmt->execute($query_params);
          }
          catch(PDOException $ex)
          {
              array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
              return $ex->getMessage();
          }
          $rows = $stmt->fetchAll();
          return $rows;
  }

  function getReviewByProductIDandType($productID, $type){
    global $db;
    $query = "
            SELECT
                ID,
                Type,
                Points
            FROM review
            WHERE
                ProductID = :productID
            AND
                Type = :type

        ";

        $query_params = array(
              ':productID' => $productID,
              ':type' => $type
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
          return false;
      }
      $row = $stmt->fetch();
      return $row;
  }

  function getPhotosByProductID($productID){
    global $db;
    $query = "
            SELECT
                ID,
                ImageLink,
                ImageText,
                Type
            FROM photos
            WHERE
                ProductID = $productID
        ";

        $query_params = array(
              ':productID' => $productID
      );

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;
  }

  function getUserById($userid){
    global $db;
      $query = "
              SELECT
                ID,
                UserName,
                UserType,
                Email,
                FirstName,
                LastName,
                Hash,
                Salt,
                Gender,
                DOB
              FROM user
              WHERE
                  ID = :userID
          ";


          $query_params = array(
            ':userID' => $userid
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;
  }
//--------------------------------------getByID-----------------------------------------------------------------

  function getSpecImageByID($ID){
    global $db;
      $query = "
              SELECT
                  Name,
                  Type,
                  Author
              FROM specimage
              WHERE
                  ID = :id
          ";


          $query_params = array(
            ':id' => $ID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;

  }

  function getSellerByID($ID){
    global $db;
      $query = "
              SELECT
                  Name,
                  Country,
                  VenueType,
                  URL,
                  Img
              FROM seller
              WHERE
                  ID = :id
          ";


          $query_params = array(
            ':id' => $ID
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;

  }

//------------------------------------filterQuery-------------------------------------------------------------


//get product IDs by filter query
  function filterQuery($Query){
    global $db;
      $query = $Query;

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;

  }

  function getLaptopIDs(){
    global $db;
    $query = "
            SELECT
                ID
            FROM product
            WHERE Type = 'Laptop'
        ";

        $query_params = array(
              ':type' => "Laptop"
      );

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;

  }

  function getLaptopIDsByWorth(){
    global $db;
    $query = "
            SELECT
                ProductID AS 'ID'
            FROM review
            WHERE Type = 'Worth'
            ORDER BY
                Points
            DESC
        ";



      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;

  }

// ---------------------------------Extra----------------------------------
  function getReviewPhrases($type, $point){
    global $db;
      $query = "
              SELECT
                  Phrase,
                  Description
              FROM reviewphrase
              WHERE
                  ReviewType = :type
              AND
                  PointMin <= :point
              AND
                  PointMax >= :point
          ";


          $query_params = array(
            ':type' => $type,
            ':point' => $point
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }
        $row = $stmt->fetch();
        return $row;
  }

  function getInventoryItemList(){
    global $db;
    $query = "
    SELECT
    t1.ID,
    t1.Brand,
    t1.Name,
    t1.Type,
    t1.PhotoCount,
    t2.PriceCount
        FROM
            (SELECT
              product.ID,
              product.Brand,
              product.Name,
              product.Type,
              Count(photos.ID) AS PhotoCount
            FROM
              product
              LEFT JOIN photos ON photos.ProductID = product.ID
            GROUP BY
              product.ID) t1
          LEFT JOIN (SELECT
              product.ID,
              product.Brand,
              product.Name,
              product.Type,
              Count(pricetag.ID) AS PriceCount
            FROM
              product
              LEFT JOIN pricetag ON pricetag.ProductID = product.ID
            GROUP BY
              product.ID) t2 ON t1.ID = t2.ID
        GROUP BY
          t1.ID
        ";

        $query_params = array(
              ':type' => "Laptop"
      );

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;

  }

  function changePriceActiveByPriceID($ID, $active){
    global $db;
    $query = "
      UPDATE pricetag
      SET Active = :active
      WHERE ID = :ID
          ";

          $query_params = array(
                    ':ID' => $ID,
                    ':active' => $active
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }

              return true;
  }

  function changeFullPriceByPriceID($ID, $productID, $sellerID, $price, $link, $crawlLink, $itemCondition, $moneyType, $active){
    global $db;
    $query = "
      UPDATE pricetag
      SET
        ProductId = :productID,
        SellerID = :sellerID,
        Price = :price,
        Link = :link,
        ItemCondition = :itemCondition,
        MoneyType = :moneyType,
        Active = :active
      WHERE ID = :ID
          ";

          $query_params = array(
                    ':ID' => $ID,
                    ':productID' => $productID,
                    ':sellerID' => $sellerID,
                    ':price' => $price,
                    ':link' => $link,
                    ':itemCondition' => $itemCondition,
                    ':moneyType' => $moneyType,
                    ':active' => $active
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }

              return true;
  }

  function changePriceByPriceID($ID, $price){
    global $db;
    $query = "
      UPDATE pricetag
      SET Price = :price
      WHERE ID = :ID
          ";

          $query_params = array(
                    ':ID' => $ID,
                    ':price' => $price
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }

              return true;
  }

  function changePhotoDescription($ID, $desc){
    global $db;
    $query = "
      UPDATE photos
      SET ImageText = :desc
      WHERE ID = :ID
          ";

          $query_params = array(
                    ':ID' => $ID,
                    ':desc' => $desc
                );

                try
              {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
                  $id = $db->lastInsertId();
                  $this -> lastProductID = $id;
              }
              catch(PDOException $ex)
              {
                  array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
                  return false;
              }

              return true;
  }


  function getInventoryLaptopList(){
    global $db;
    $query = "
    SELECT
      ID,
      Brand,
      Name
    FROM product

    WHERE Type = 'Laptop'
        ";

        $query_params = array(
              ':type' => 'Laptop'
      );

      try
      {
          $stmt = $db->prepare($query);
          $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }
      $rows = $stmt->fetchAll();
      return $rows;

  }

  //Logs in user: in $_SESSION['user'] and saves information as rows from database
  //UserID, UserName, FirstName, MiddleName, LastName, sex, DateOfBirth.
  function Login($username, $password){
    global $db;

      $submitted_username = '';

      $query = "
              SELECT
                  ID,
                  UserName,
                  UserType,
                  FirstName,
                  LastName,
                  Hash,
                  salt
              FROM user
              WHERE
                  UserName = :username
          ";


          $query_params = array(
            ':username' => $username
        );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
            return false;
        }

        $login_ok = false;


        $row = $stmt->fetch();
          if($row)
          {

              $check_password = hash('sha256', $password . $row['salt']);
              for($round = 0; $round < 65829; $round++)
              {
                  $check_password = hash('sha256', $check_password . $row['salt']);
              }

              if($check_password === $row['Hash'])
              {
                  $login_ok = true;
              }
          }


          if($login_ok)
          {
              unset($row['salt']);
              unset($row['password']);
              $_SESSION['user'] = $row;

              return true;
          }
          else
          {

              return false;


              $this->submittedUsername = htmlentities($username, ENT_QUOTES, 'UTF-8');
          }
      }

  function Logout(){

        unset($_SESSION['user']);

      return true;
  }

  function checkLogin(){
    if(isset($_SESSION['user'])){
      $userid = $_SESSION['user']['ID'];
      $username = $_SESSION['user']['UserName'];

      $user = $this->getUserById($userid);


      if($user["UserName"] === $username){
        return true;
      }else {
        array_push($this-> errormessage, "Session exists but wrong information");
        return false;
      }

    }else {
      return false;
    }
  }

  //  --------------------------------Delete------------------------------------------

  function deleteReviewByProductIDandType($productID, $reviewType){
    global $db;
    $query = "
      DELETE FROM
        review
      WHERE review.ProductID = $productID AND review.Type = '".$reviewType."'
        ";

        $query_params = array(
              ':type' => "Laptop"
      );

      try
      {
          $stmt = $db->prepare($query);
          $stmt->execute();
      }
      catch(PDOException $ex)
      {
          array_push($this-> errormessage, ("Failed to run query: " . $ex->getMessage()));
          return false;
      }

      return true;
  }

  function deleteProductByID($productID){
    global $db;
    $query = "
              DELETE FROM product
               WHERE
                ID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deleteProductSpecByProductID($productID){
    global $db;
    $query = "
              DELETE FROM productspec
               WHERE
                ProductID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deletePriceByID($ID){
    global $db;
    $query = "
              DELETE FROM pricetag
               WHERE
                ID = :ID
          ";
      $query_params = array(
        ':ID' => $ID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deletePriceByCrawlLink($CrawlLink){
    global $db;
    $query = "
              DELETE FROM pricetag
               WHERE
                CrawlLink = :crawlLink
          ";
      $query_params = array(
        ':crawlLink' => $CrawlLink
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }


  function deletePriceByProductByID($productID){
    global $db;
    $query = "
              DELETE FROM pricetag
               WHERE
                ProductID = :productID
              AND
                Active = 'NULL'
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deleteAllPriceByProductByID($productID){
    global $db;
    $query = "
              DELETE FROM pricetag
               WHERE
                ProductID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }


  function deletePhotoByProductByID($productID){
    global $db;
    $query = "
              DELETE FROM photos
               WHERE
                ProductID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deletePhotoByID($ID){
    global $db;
    $query = "
              DELETE FROM photos
               WHERE
                ID = :ID
          ";
      $query_params = array(
        ':ID' => $ID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deletePriceByProductByIDandSellerID($productID, $sellerID){
    global $db;
    $query = "
              DELETE FROM pricetag
               WHERE
                ProductID = :productID
               AND
                SellerID =  :sellerID
          ";
      $query_params = array(
        ':productID' => $productID,
        ':sellerID' => $sellerID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }


  function deleteSpecsByProductByID($productID){
    global $db;
    $query = "
              DELETE FROM specification
               WHERE
                ProductID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }

  function deleteReviewsByProductByID($productID){
    global $db;
    $query = "
              DELETE FROM review
               WHERE
                ProductID = :productID
          ";
      $query_params = array(
        ':productID' => $productID
      );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        array_push($this-> errormessage, "Failed to run query: " . $ex->getMessage());
        return false;
    }

    return true;
  }


  }
