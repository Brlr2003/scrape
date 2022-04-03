<?php
require "Database.php" ;
include 'vendor/autoload.php';


// $end=320; for mid range

use Goutte\Client;

// getLaptop('https://www.bestbuy.com/site/asus-15-6-4k-ultra-hd-touch-screen-gaming-laptop-intel-core-i7-16gb-memory-nvidia-geforce-gtx-1050-1tb-ssd-gun-gray/6373043.p?skuId=6373043');

$oneLink = 'https://www.bestbuy.com/site/laptop-computers/all-laptops/pcmcat138500050001.c?cp=33&id=pcmcat138500050001';

$client = new Client();
// get html from URL
$crawler = $client->request('GET', $oneLink);
// get all images on laravel.com

$LINKS = [];
$PRICES = [];
$numberof = 0;
$crawler->filter('.sku-header > a')->each(function ($node) {
  global $numberof;
  global $LINKS;
  $numberof= $numberof+1;
  array_push($LINKS,"https://www.bestbuy.com". $node->attr('href'));
});

$oneDone = true;

$crawler->filter('.sku-list-item-price > div > div > .pricing-price > div > div > div > div')->each(function ($node) {
  global $oneDone;
  $oneDone = true;
  $node->filter('div > div > span')->each(function ($node) {
    global $oneDone;
    global $numberof;
    global $PRICES;
    $numberof= $numberof+1;
    if($node->attr('class')=="sr-only"){

    }else if($node->text()=="Price Match Guarantee"){

    }else if($oneDone){
      $tttt="";
      $tttt = str_replace("$", "", $node->text());
      $tttt = str_replace(".00", "", $tttt);
      $tttt = str_replace(",", "", $tttt);
      array_push($PRICES,$tttt);
      $oneDone = false;
    }
  });

  $node->filter('span')->each(function ($node) {
    global $oneDone;
    global $numberof;
    global $PRICES;
    $numberof= $numberof+1;
    if($node->attr('class')=="sr-only"){

    }else if($node->text()=="Price Match Guarantee"){

    }else if($oneDone){
      $tttt="";
      $tttt = str_replace("$", "", $node->text());
      $tttt = str_replace(".00", "", $tttt);
      $tttt = str_replace(",", "", $tttt);
      array_push($PRICES,$tttt);
      $oneDone = false;
    }
  });

});

var_dump($LINKS);
echo "<br>";
var_dump($PRICES);

// var_dump($LINKS);
// die;

for($k=0;$k<$numberof;$k++){
  $DB = new dataBase();

  $client = new Client();

  $crawler = $client->request('GET', $oneLink);

  $asd = $crawler->filter('.sku-header > a')->eq($k)->link();
  $link = $LINKS[$k];
  $crawler = $client->click($asd);
  // get all images on laravel.com

  $prices= (object)[
    'price'=> [],
    'condition'=> [],
    'available'=>[]
  ];

  $laptopSpecs = [];


  $crawler->filter('.category-wrapper > .specs-table > ul > li')->each(function ($node) {
    global $laptopSpecs;
    array_push($laptopSpecs,$node->text());

  });



  $x =0;


  $tempImg = [];
  $ImageLink = [[],[]];

  $tempPrice = [];
  // $Prices = [[],[]];

  $crawler->filter('script')->each(function ($node) {
    global $x;
    global $tempImg;
    global $ImageLink;
    global $tempPrice;
    global $prices;
    if($node->attr('type')=="application/ld+json"){

      if($x==1){
        $tempImg = explode("thumbnailUrl",$node->text());
        for($i=0;$i<count($tempImg);$i++){
          preg_match('/https:\/\/pisces.bbystatic.com\/image2\/BestBuy_US\/images\/products\/(.+).jpg/', $tempImg[$i], $ImageLink[$i]);

        }
      }

      if($x==10){
        // echo $node->text();
        $tempPrice = explode("\"Offer\"", $node->text());
        for($i=1;$i<count($tempPrice);$i++){
          preg_match('/\"price\":\"(.+)\",\"availability\"/', $tempPrice[$i], $prices->price[$i]);
          preg_match('/\"availability\":\"http:\/\/schema.org\/(.+)\",\"item/', $tempPrice[$i], $prices->available[$i]);
          preg_match('/\"description\":\"(.+)\"},/', $tempPrice[$i], $prices->condition[$i]);
        }
        // $tempImg = explode("thumbnailUrl",$node->text());
        // for($i=0;$i<count($tempImg);$i++){
        //   preg_match('/https:\/\/pisces.bbystatic.com\/image2\/BestBuy_US\/images\/products\/(.+).jpg/', $tempImg[$i], $ImageLink[$i]);
        //
        // }
      }
      $x=$x+1;
    }


  });



  $MODE;

  $Name= (object) [
    'brand'=>false,
    'name'=>false
  ];

  $RAM = (object) [
    'size'=>false,
    'DDR'=>false,
    'MHZ'=> false
  ];

  $Processor= (object)[
    'model'=>false,
    'family'=>false,
    'brand'=>false,
    'speed'=>false
  ];

  $Graphics= (object)[
    'model'=>false,
    'brand'=>false,
    'spec1'=>false,
    'spec2'=>false,
    'spec3'=>false,
    'family'=>false
  ];

  $Storage = (object) [
    'sizeTotal'=>false,
    'SSD'=>false,
    'Type1'=>false,
    'Size1'=> false,
    'RPM1'=> false,
    'Type2'=>false,
    'Size2'=> false,
    'RPM2'=> false
  ];
  $Screen = (object)[
    'touchScreen'=>false,
    'glossy'=>false,
    'size'=>false,
    'resolution'=>false,
    'type'=>false
  ];

  $Dimensions = (object)[
    'thickness'=>false,
    'width'=>false,
    'length'=>false,
    'weight'=>false
  ];

  $OS = (object)[
    'brand'=>false,
    'model'=>false
  ];

  $Ports = (object)[
    'thunderbolt1'=>false,
    'thunderbolt2'=>false,
    'thunderbolt3'=>false,
    'USB2'=>false,
    'USB3'=>false,
    'USBC'=>false,
    'HDMI'=>false,
    'MiniHDMI'=>false,
    'MicroHDMI'=>false,
    'VGA'=>false,
    'DisplayPort'=>false,
    'MiniDisplay'=>false,
    'SeperateMic'=>false,
    'SDcard'=>false,
    'DVD'=>false,
    'BlueRay'=>false,
    'Ethernet'=>false
  ];

  $Network = (object)[
    'wireless'=>false,
    'bluetooth'=>false,
    'webcam'=>false
  ];

  $Battery = (object)[
    'life'=>false,
    'wh'=>false,
    'cells'=>false,
    'type'=>false
  ];
  $Backlight =false;
  $Fingerprint= false;
  $Touchbar= false;


  $temp1=[];
  $temp2=[];
  $nameBefore=true;
  $before=true;
  $b=false;
  $b2=false;
  $dual=false;
  $isBrand=false;
  $graphicsOnce=true;
  $HDDonce= true;
  $osOnce=true;
  $brandOnce=true;


  for($i=0;$i<count($laptopSpecs);$i++){

    if(strpos($laptopSpecs[$i], "System Memory (RAM)Info")!== false){
      preg_match('/System Memory \(RAM\)Info(\d+) gigabytes/', $laptopSpecs[$i], $temp1);
      $RAM->size = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Type of Memory (RAM)Info")!== false){
      if(preg_match('/Type of Memory \(RAM\)Info(.+) /', $laptopSpecs[$i], $temp1)){
        $RAM->DDR = $temp1[1];
      }else if(preg_match('/Type of Memory \(RAM\)Info(.+)/', $laptopSpecs[$i], $temp1)){
        $RAM->DDR = $temp1[1];
      }

    }
    else if(strpos($laptopSpecs[$i], "System Memory RAM SpeedInfo")!== false){
      preg_match('/System Memory RAM SpeedInfo(.{4}) /', $laptopSpecs[$i], $temp1);
      $RAM->MHZ = $temp1[1];
    }
    // else if(strpos($laptopSpecs[$i], "Total Storage Capacity")!== false){
    //   preg_match('/Total Storage Capacity (\d+) /', $laptopSpecs[$i], $temp1);
    //   $Storage->sizeTotal = $temp1[1];
    // }
    else if(strpos($laptopSpecs[$i], "Solid State Drive CapacityInfo")!== false && $HDDonce){
      $HDDonce=false;
      preg_match('/Solid State Drive CapacityInfo(\d+) /', $laptopSpecs[$i], $temp1);
      if($Storage->Type1 == false){
        $Storage->Type1 = "SSD";
        $Storage->Size1 = $temp1[1];
        $Storage->SSD= true;
        if($Storage->Size1==1000){
          $Storage->Size1=1024;
        }else if($Storage->Size1==500){
          $Storage->Size1=512;
        }
        $Storage->sizeTotal = $Storage->Size1;
      }else{
        $Storage->Type2 = "SSD";
        $Storage->Size2 = $temp1[1];
        $Storage->SSD= true;
        if($Storage->Size2==1000){
          $Storage->Size2=1024;
        }else if($Storage->Size2==500){
          $Storage->Size2=512;
        }
        $Storage->sizeTotal = $Storage->Size1 + $Storage->Size2;
      }
    }
    else if(strpos($laptopSpecs[$i], "Touch ScreenInfoYes")!== false || $laptopSpecs[$i]== "Touch ScreenInfoYes"){
      $Screen->touchScreen = true;
    }
    else if(strpos($laptopSpecs[$i], "Screen SizeInfo")!== false){
      preg_match('/Screen SizeInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Screen->size = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Screen ResolutionInfo")!== false){
      preg_match('/Screen ResolutionInfo(\d+) x (\d+)/', $laptopSpecs[$i], $temp1);
      if($temp1[1]=="1920" && $temp1[2]=="1080"){
        $Screen->resolution = "1080p";
      }else if($temp1[1]=="3840" && $temp1[2]=="2160"){
        $Screen->resolution = "4K";
      }else if($temp1[1]=="2560" && $temp1[2]=="1440"){
        $Screen->resolution = "2K";
      }else if($temp1[1]=="1280" && $temp1[2]=="720"){
        $Screen->resolution = "720p";
      }
      else{
        $Screen->resolution = $temp1[1] . "x" . $temp1[2];
      }

    }
    else if(strpos($laptopSpecs[$i], "Display Type")!== false){
      if(strpos($laptopSpecs[$i], "WLED")!== false){
        $Screen->type= "WLED";
      }else if(strpos($laptopSpecs[$i], "LED")!== false){
        $Screen->type="LED";
      }

    }
    else if(strpos($laptopSpecs[$i], "Product HeightInfo")!== false){
      preg_match('/Product HeightInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Dimensions->thickness = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Product WidthInfo")!== false){
      preg_match('/Product WidthInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Dimensions->width = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Product DepthInfo")!== false){
      preg_match('/Product DepthInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Dimensions->length = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Product WeightInfo")!== false){
      preg_match('/Product WeightInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Dimensions->weight = $temp1[1];
    }

    else if(strpos($laptopSpecs[$i], "Operating SystemInfo")!== false && $osOnce){
      $osOnce = false;
      preg_match('/Operating SystemInfo(.+)/', $laptopSpecs[$i], $temp1);
      $temp2 = explode(" ",$temp1[1]);
      foreach($temp2 as $word){
        if($word=="Windows"){
          $OS->brand = $word;
        }else if($word=="Chrome"){
          $OS->brand = "Chrome OS";
        }else if(strpos($word, "Mac")!== false){
          $OS->brand = $word;
        }else{
          if($OS->model==false){
            $OS->model = $word;
          }else{
            $OS->model =  $OS->model . " ". $word;
          }

        }
      }
    }

    else if(strpos($laptopSpecs[$i], "Processor Brand")!== false){
      preg_match('/Processor Brand (.+)/', $laptopSpecs[$i], $temp1);
      $Processor->brand = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Processor Model Number")!== false){
      preg_match('/Processor Model Number (.+)/', $laptopSpecs[$i], $temp1);
      $temp2 = explode("-",$temp1[1]);
      if(count($temp2)>1){
        $Processor->family = $temp2[0];
        $Processor->model = $temp2[1];
      }
      else{
        $Processor->model = $temp2[0];
      }
    }
    else if(strpos($laptopSpecs[$i], "Processor Speed (Base)Info")!== false){
      preg_match('/Processor Speed \(Base\)Info(.+) /', $laptopSpecs[$i], $temp1);
      $Processor->speed = $temp1[1];
    }

    else if(strpos($laptopSpecs[$i], "Brand")!== false && $brandOnce){
      $brandOnce=false;
      preg_match('/Brand (.+)/', $laptopSpecs[$i], $temp1);
      $Name->brand = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Product Name")!== false){
      $tempName;
      preg_match('/Product Name (.+)/', $laptopSpecs[$i], $temp1);
      // if($Name->brand!=false){
      //   $tempName =
      // }
      $temp2 = explode(" ",$temp1[1]);
      for($j=0;$j<count($temp2);$j++){
        if(strpos($temp2[$j], "\"")!== false){
          $nameBefore=false;
        }else if(strpos($temp2[$j], "2-in-1")!== false || $temp2[$j] == "2-in-1"){
          $nameBefore=false;
        }else if(strpos($temp2[$j], "-")!== false || $temp2[$j] == "-"){
          $nameBefore=false;
        }
        else if($nameBefore){
          if($Name->name==false){
            $Name->name = $temp2[$j];
          }else{
            $Name->name = $Name->name . " " . $temp2[$j];
          }
        }
      }
    }
    else if(strpos($laptopSpecs[$i], "Model Number")!== false){
      preg_match('/Model Number (.+)/', $laptopSpecs[$i], $temp1);
      if($Name->name==false){
        $Name->name = $temp1[1];
      }else{
        $Name->name = $Name->name . " ". $temp1[1];
      }

    }

    else if(strpos($laptopSpecs[$i], "GPU Brand")!== false){
      preg_match('/GPU Brand (.+)/', $laptopSpecs[$i], $temp1);
      $Graphics->brand = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "GraphicsInfo")!== false && $graphicsOnce){
      $graphicsOnce = false;
      preg_match('/GraphicsInfo(.+)/', $laptopSpecs[$i], $temp1);
      $temp2= explode(" ",$temp1[1]);
      foreach($temp2 as $word){
        if(strpos($word, "NVIDIA")!== false || $word=='NVIDIA'){
          $Graphics->family = 'Dedicated';
          $Graphics->brand = 'Nvidia';
          $isBrand=true;
        }
        else if(strpos($word, "Intel")!== false|| $word=='Intel'){
          $Graphics->family = 'Integrated';
          $Graphics->brand = 'Intel';
          $isBrand=true;
        }
        else if(strpos($word, "AMD")!== false|| $word=='AMD'){
          $Graphics->family = 'Dedicated';
          $Graphics->brand = 'AMD';
          $isBrand=true;
        }
        else if(strpos($word, "ATI")!== false|| $word=='ATI'){
          $Graphics->family = 'Dedicated';
          $Graphics->brand = 'ATI';
          $isBrand=true;
        }
        else if(preg_match('/(\d{3,}\w?)/', $word, $temp3)){
          if($before){
            $Graphics->model = $temp3[1];
          }else{
            $dual=true;
          }
          $before=false;
        }
        else if(strpos($word, 'GeForce')!== false|| $word=='GeForce'){
          $Graphics->specLink = $word;
        }
        else if(strpos($word, 'Dual')!== false|| $word=='Dual'){
          $dual=true;
        }
        else{
          if($before){
            if($b){
              $Graphics->spec1 = $Graphics->spec1." ";
            }
            $Graphics->spec1 = $Graphics->spec1.$word;
            $b=true;
          }else{
            if($b2){
              $Graphics->spec2 = $Graphics->spec2." ";
            }
            $Graphics->spec2 = $Graphics->spec2 . $word;
            $b2=true;
          }
        }
        if(strpos($word, 'HD')!== false|| $word=='HD'){
          $Graphics->family = 'Integrated';
        }

        if(strpos($word, 'Radeon')!== false|| $word=='Radeon'){
          $Graphics->brand = 'AMD';
          $isBrand=true;
        }
      }
    }
    else if(strpos($laptopSpecs[$i], "Battery Life")!== false){
      preg_match('/Battery LifeInfo(.+) /', $laptopSpecs[$i], $temp1);
      $Battery->life = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Battery Type")!== false){
      preg_match('/Battery Type (.+)/', $laptopSpecs[$i], $temp1);
      $Battery->type = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Battery Cells")!== false){
      preg_match('/Battery Cells (.+)-cell/', $laptopSpecs[$i], $temp1);
      $Battery->cells = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Power Supply Maximum Wattage")!== false){
      preg_match('/Power Supply Maximum Wattage (.+) /', $laptopSpecs[$i], $temp1);
      $Battery->wh = $temp1[1];
    }

    else if(strpos($laptopSpecs[$i], "Number of USB 2.0 Type A Ports")!== false){
      preg_match('/Number of USB 2.0 Type A Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->USB2 = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of USB 3.0 Type A Ports")!== false){
      preg_match('/Number of USB 3.0 Type A Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->USB3 = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of USB 3.1 Type C Ports")!== false){
      preg_match('/Number of USB 3.1 Type C Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->USBC = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of Thunderbolt 1 Ports")!== false){
      preg_match('/Number of Thunderbolt 1 Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->thunderbolt1 = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of Thunderbolt 2 Ports")!== false){
      preg_match('/Number of Thunderbolt 2 Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->thunderbolt2 = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of Thunderbolt 3 Ports")!== false){
      preg_match('/Number of Thunderbolt 3 Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->thunderbolt3 = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of HDMI Outputs")!== false){
      preg_match('/Number of HDMI Outputs \(Total\) (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->HDMI = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number of VGA PortsInfo")!== false){
      preg_match('/Number of VGA PortsInfo(.+)/', $laptopSpecs[$i], $temp1);
      $Ports->VGA = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Number Of Ethernet Ports")!== false){
      preg_match('/Number Of Ethernet Ports (.+)/', $laptopSpecs[$i], $temp1);
      $Ports->Ethernet = $temp1[1];
    }
    else if(strpos($laptopSpecs[$i], "Media Card ReaderInfo")!== false){
      preg_match('/Media Card ReaderInfo(.+)/', $laptopSpecs[$i], $temp1);
      $Ports->SDcard = $temp1[1];
    }

    else if(strpos($laptopSpecs[$i], "Backlit KeyboardInfoYes")!== false || $laptopSpecs[$i] == "Backlit KeyboardInfoYes"){
      $Backlight = "Backlit Keyboard";
    }

    else if(strpos($laptopSpecs[$i], "Wireless NetworkingInfo")!== false){
      if(strpos($laptopSpecs[$i], "Wireless-AX")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 AX";
        }
      }else if(strpos($laptopSpecs[$i], "Wireless-AC")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 AC";
        }else{ $Network->wireless =  $Network->wireless ." AC"; }
      }else if(strpos($laptopSpecs[$i], "Wireless-A")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 A";
        }else{ $Network->wireless =  $Network->wireless ." A"; }
      }if(strpos($laptopSpecs[$i], "Wireless-B")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 B";
        }else{ $Network->wireless =  $Network->wireless ." B"; }
      }if(strpos($laptopSpecs[$i], "Wireless-G")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 G";
        }else{ $Network->wireless =  $Network->wireless ."G"; }
      }if(strpos($laptopSpecs[$i], "Wireless-N")){
        if($Network->wireless == false){
          $Network->wireless = "802.11 N";
        }else{ $Network->wireless =  $Network->wireless ."N"; }
      }
    }

    else if(strpos($laptopSpecs[$i], "Bluetooth EnabledInfoYes")!== false){
      $Network->bluetooth = "4.0";
    }
    else if(strpos($laptopSpecs[$i], "Front-Facing Camera Yes")!== false){
      if($Network->webcam==false){
        $Network->webcam = "Webcam";
      }
    }
    else if(strpos($laptopSpecs[$i], "Front Facing Camera Video ResolutionInfo")!== false){
      preg_match('/Front Facing Camera Video ResolutionInfo(.+)/', $laptopSpecs[$i], $temp1);
      $Network->webcam = $temp1[1] . " Webcam";
    }
  }



  $tempRow=[];


  $currentProduct  = (object) [
    'ID'=>"",
    'brand'=>"",
    'name'=>"",
    'IDs'=>[]
  ];

  if($RAM->size!= false){
    $tempRow=[];
    $tempRow = $DB->newSpecIfDoesntExistandGetID("Laptop_RAM", "", "", "", "", $RAM->size, ifFalseThenNull($RAM->DDR), ifFalseThenNull($RAM->MHZ));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Processor->model!= false && $Processor->brand!=false){
    $tempRow=[];
    $tempRow = $DB->getSpecsByAll("Laptop_CPU", $Processor->brand, ifFalseThenNull($Processor->family), $Processor->model, "", "", "");
    if(!empty($tempRow)){
      array_push($currentProduct->IDs,$tempRow[0]['ID']);
    }
  }

  if($Graphics->brand!=false){
    $tempRow=[];
    $tempRow = $DB->getSpecsByAll("Laptop_Graphics", $Graphics->brand,"", ifFalseThenNull($Graphics->model), ifFalseThenNull($Graphics->spec1), ifFalseThenNull($Graphics->spec2), "");
    if(!empty($tempRow)){
      array_push($currentProduct->IDs,$tempRow[0]['ID']);
    }else{
      $tempRow = $DB->getSpecsByAll("Laptop_Graphics", $Graphics->brand,"", ifFalseThenNull($Graphics->model), ifFalseThenNull($Graphics->spec1), "", "");
      if(!empty($tempRow)){
        array_push($currentProduct->IDs,$tempRow[0]['ID']);
      }else{
        $tempRow = $DB->getSpecsByAll("Laptop_Graphics", $Graphics->brand,"", ifFalseThenNull($Graphics->model), "", "", "");
        if(!empty($tempRow)){
          array_push($currentProduct->IDs,$tempRow[0]['ID']);
        }
      }
    }
  }

  if($Screen->size!= false && $Screen->resolution!= false){
    $tempRow=[];
    $tempRow = $DB->newSpecIfDoesntExistandGetID("Laptop_Screen", "", "", "", "", $Screen->size, $Screen->resolution, ifFalseThenNull($Screen->type));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Screen->touchScreen!= false){
    array_push($currentProduct->IDs,2);
  }

  if($Screen->glossy!= false){
    array_push($currentProduct->IDs,3);
  }

  if($Dimensions->weight!= false && $Dimensions->thickness!= false && $Dimensions->length!= false && $Dimensions->width!= false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Dimensions", "", "", "", $Dimensions->weight, $Dimensions->width, $Dimensions->length, $Dimensions->thickness);
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($OS->brand!= false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_OS", "", $OS->brand, "", ifFalseThenNull($OS->model), "", "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Network->wireless!= false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $Network->wireless, ifFalseThenNull($Network->bluetooth), ifFalseThenNull($Network->webcam));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Battery->life!= false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Battery", "", ifFalseThenNull($Battery->type), "", "", $Battery->life, ifFalseThenNull($Battery->wh), ifFalseThenNull($Battery->cells));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Backlight!= false){
    array_push($currentProduct->IDs,599);
  }

  if($Fingerprint!= false){
    array_push($currentProduct->IDs,600);
  }

  if($Touchbar!= false){
    array_push($currentProduct->IDs,601);
  }

  if($Storage->Size1!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", $Storage->Type1, $Storage->Size1, ifFalseThenUnknown($Storage->RPM1));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Storage->Size2!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", $Storage->Type2, $Storage->Size2, ifFalseThenUnknown($Storage->RPM2));
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Storage->sizeTotal!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage_Filter", "", "", "", "", $Storage->sizeTotal, ifThenSSD($Storage->SSD), "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  if($Ports->thunderbolt1!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 1", $Ports->thunderbolt1, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->thunderbolt2!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 2", $Ports->thunderbolt2, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->thunderbolt3!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 3", $Ports->thunderbolt3, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->USB2!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 2.0", $Ports->USB2, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->USB3!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.0", $Ports->USB3, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->USBC!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB C", $Ports->USBC, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->HDMI!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "HDMI", $Ports->HDMI, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->VGA!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "VGA", $Ports->VGA, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->SDcard!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "SD Card Reader", $Ports->SDcard, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }
  if($Ports->Ethernet!=false){
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Ethernet", $Ports->Ethernet, "", "");
    array_push($currentProduct->IDs,$tempRow['ID']);
  }

  var_dump($Name);
  echo ("<br>");
  var_dump($RAM);
  echo ("<br>");
  var_dump($Processor);
  echo ("<br>");
  var_dump($Graphics);
  echo ("<br>");
  var_dump($Storage);
  echo ("<br>");
  var_dump($Screen);
  echo ("<br>");
  var_dump($Dimensions);
  echo ("<br>");
  var_dump($OS);
  echo ("<br>");
  var_dump($Ports);
  echo ("<br>");
  var_dump($Network);
  echo ("<br>");
  var_dump($Battery);
  echo ("<br>");
  var_dump($Backlight);
  echo ("<br>");
  var_dump($prices);

  $currentProduct->brand = $Name->brand;
  $currentProduct->name = $Name->name;
  $currentProduct->name = str_replace("/","-",$currentProduct->name);



  $ProductIDlist = [[],[]];
  $tempList = [];
  $IDandPoints = [[],[]];
  $fitProducts = [];
  $fitProducts2 = [];

  for($i=0;$i<count($currentProduct->IDs);$i++){
    $tempList= $DB->getProductIDsBySpecID($currentProduct->IDs[$i]);
    for($j=0;$j<count($tempList);$j++){
      $ProductIDlist[$i][$j]=$tempList[$j]['ProductID'];
    }
  }

  $tempKey=0;

  for($i=0;$i<count($ProductIDlist);$i++){
    if(!empty($ProductIDlist[$i])){
      for($j=0;$j<count($ProductIDlist[$i]);$j++){
        if(in_array($ProductIDlist[$i][$j], $IDandPoints[0])){
          $tempKey =  array_search($ProductIDlist[$i][$j], $IDandPoints[0]);
          $IDandPoints[1][$tempKey] = $IDandPoints[1][$tempKey] +1;
        }else{
          array_push($IDandPoints[0], $ProductIDlist[$i][$j]);
          array_push($IDandPoints[1], 1);
        }
      }
    }
  }

  for($i=0;$i<count($IDandPoints[1]);$i++){
    if(count($currentProduct->IDs) == $IDandPoints[1][$i]) {
      array_push($fitProducts, $IDandPoints[0][$i]);
    }
    else if(count($currentProduct->IDs)-1 == $IDandPoints[1][$i]) {
      array_push($fitProducts2, $IDandPoints[0][$i]);
    }
  }

  $tempProduct= [];

  $c = count($fitProducts);

  for($i=0;$i<$c;$i++){
    echo "<br>".$fitProducts[$i];
    $tempProduct = $DB->getProductByProductID($fitProducts[$i]);
    echo "<br><br>";
    var_dump($tempProduct);
    if($tempProduct != false){
      if($tempProduct['Brand']==$Name->brand){
      }else{
        unset($fitProducts[$i]);
      }
    }else{
      unset($fitProducts[$i]);
    }
  }

  if(count($fitProducts)==1){
    $currentProduct->ID = $fitProducts[0];
    $MODE="KNOWNLINK";
  }else if(count($fitProducts)==0){
    $MODE="NEWLAPTOP";
  }else{
    $MODE="UNKNOWNLINK";
  }


  echo $MODE;
  echo "<br><br>";
  var_dump($currentProduct);
  echo "<br>";
  var_dump($prices);

  echo "<br><br>";

  if($MODE=="NEWLAPTOP"){
    $DB->newProductwithActive($currentProduct->brand, $currentProduct->name, "Laptop", "MrBot", 3);
    $currentProduct->ID = $DB->getLastProductID();
    for($i=0;$i<count($currentProduct->IDs);$i++){
      $DB->newProductSpec($currentProduct->ID,$currentProduct->IDs[$i]);
    }
  }
  if($MODE=="UNKNOWNLINK" || $MODE== "KNOWNLINK"){
    echo "dieing!!";
    // die;
  }else{


      $vrainlink=[];
      $itemName = str_replace(" ", "_", $Name->name);

      $imageName = $Name->brand . "_". $itemName;
      $imageName = str_replace("/","-",$imageName);

      for($i=0;$i<count($ImageLink);$i++){
        if(isset($ImageLink[$i][0])){
          // echo $ImageLink[$i][0] . "<br>";
          $url_to_image = $ImageLink[$i][0];
          $my_save_dir = 'images/laptop/';
          $filename = $imageName."_".$i;
          $complete_save_loc = $my_save_dir.$filename.'.jpg';
          $vrainlink[$i] = 'https://vrain.io/images/laptop/'.$filename.'.jpg';
          // fopen($complete_save_loc, "w");
         file_put_contents($complete_save_loc,file_get_contents($url_to_image));
         if($i==1){
           $DB->newPhoto($currentProduct->ID, $vrainlink[$i], "Hero", 0);
         }else{
           $DB->newPhoto($currentProduct->ID, $vrainlink[$i], "", 0);
         }
        }
      }

      $condition=0;

      $priceDo = true;

      for($i=0;$i<count($prices->price);$i++){
        if($prices->available[$i][1]=="InStock"){
          $priceDo = false;
          if(strpos($prices->condition[$i][1], "New")!== false){
            $condition=0;
          }else if(strpos($prices->condition[$i][1], "Open-Box")!== false){
            $condition=1;
          }else if(strpos($prices->condition[$i][1], "Refurbished")!== false){
            $condition=2;
          }else if(strpos($prices->condition[$i][1], "Used")!== false){
            $condition=3;
          }
          $DB->newPrice($currentProduct->ID, 3, $prices->price[$i][1], $link, $link, $condition, "dollar");
        }
      }

      if($priceDo){
        $DB->newPrice($currentProduct->ID, 3, $PRICES[$k], $link, $link, 0, "dollar");
      }


  }


}

function ifFalseThenNull($data){
  if($data==false){
    return "";
  }else{
    return $data;
  }
}


function ifFalseThenUnknown($data){
  if($data==false){
    return "Unknown";
  }else{
    return $data;
  }
}

function ifThenSSD($data){
  if($data){
    return "SSD";
  }else{
    return "";
  }
}

 ?>
