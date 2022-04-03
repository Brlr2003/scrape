<?php
include "Database.php" ;
include "anticaptcha-php-master/anticaptcha.php";
include "anticaptcha-php-master/imagetotext.php";
include 'vendor/autoload.php';

$api = new ImageToText();

// namespace AntiCaptcha;



use AntiCaptcha\ImageToText;
use Goutte\Client;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;


$DB = new dataBase();


$ShortChecklist = (object)[
  "Brand"=>false,//+
  "Name"=>false,//
  'NameSeries'=>false,//
  "NameModelNum"=>false,//
  "ScreenRes"=>false,//
  "ScreenSize"=>false,//
  "Dimensions"=>false,//
  "Weight"=>false,//
  "GPU"=>false,
  "CPU"=>false,//
  "RAM"=>false,//
  "SSD"=>false,
  "Storage1"=>false,//
  "Storage2"=>false,//
  "Wifi"=>false,// +
  "BT"=>false,// +
  "Webcam"=>false,// +
  "OS"=>false,//
  "Ports"=>false,//
  "BatteryLife"=>false, //+
  "BatteryDetails"=>false //+
];

$SpecIDobject = (object)[
  "Name"=>"",
  "Screen"=>"",
  "Dimensions"=>"",
  "GPU"=>"",
  "CPU"=>"",
  "RAM"=>"",
  "Storage1"=>"",
  "Storage2"=>"",
  "StorageFilter"=>"",
  "Communication"=>"",
  "OS"=>"",
  "Battery"=>"",
  "Ports"=>[],
  "Misc"=>[]
];

$SpecObject = (object)[
  "ID"=>false,
  "Brand"=>false,
  "Name"=>false,
  'NameSeries'=>false,
  "NameModelNum"=>false,
  "ScreenRes"=>false,
  "ScreenSize"=>false,
  "Width"=>false,
  "Length"=>false,
  "Thickness"=>false,
  "Weight"=>false,
  "GPU"=>false,
  "CPU"=>false,
  "RAM"=>false,
  "Storage1"=>false,
  "Storage2"=>false,
  "StorageFilter"=>false,
  "Wifi"=>false,
  "BT"=>"",
  "Webcam"=>"",
  "OS"=>false,
  "BatteryLife"=>false,
  "BatteryType"=>"",
  "BatteryWH"=>"",
  "BatteryCell"=>"",
  "USBC"=>false,
  "USB3"=>false,
  "USB31"=>false,
  "USB32"=>false,
  "USB32C"=>false,
  "USB2"=>false,
  "HDMI"=>false,
  "VGA"=>false,
  "MiniDisplay"=>false,
  "SDcard"=>false
];

$priceMasterArray = [[],[]];

$OnePriceArray = (array)[
  'price'=> "",
  'condition'=> "",
  'available'=>""
];

$SpecIDMaster = [];

$data1 = [];
$data2 = [];
$data3 = [];



$CrawlList = $DB->getPricesByActive(3);



for($c=0;$c<300;$c++){

  if(rand(1,100)>90){
    sleep(rand(60,180));
  }

  sleep(rand(5,15));


  $ShortChecklist = (object)[
    "Brand"=>false,//+
    "Name"=>false,//
    'NameSeries'=>false,//
    "NameModelNum"=>false,//
    "ScreenRes"=>false,//
    "ScreenSize"=>false,//
    "Dimensions"=>false,//
    "Weight"=>false,//
    "GPU"=>false,
    "CPU"=>false,//
    "RAM"=>false,//
    "SSD"=>false,
    "Storage1"=>false,//
    "Storage2"=>false,//
    "Wifi"=>false,// +
    "BT"=>false,// +
    "Webcam"=>false,// +
    "OS"=>false,//
    "Ports"=>false,//
    "BatteryLife"=>false, //+
    "BatteryDetails"=>false //+
  ];

  $SpecIDobject = (object)[
    "Name"=>"",
    "Screen"=>"",
    "Dimensions"=>"",
    "GPU"=>"",
    "CPU"=>"",
    "RAM"=>"",
    "Storage1"=>"",
    "Storage2"=>"",
    "StorageFilter"=>"",
    "Communication"=>"",
    "OS"=>"",
    "Battery"=>"",
    "Ports"=>[],
    "Misc"=>[]
  ];

  $SpecObject = (object)[
    "ID"=>false,
    "Brand"=>false,
    "Name"=>false,
    'NameSeries'=>false,
    "NameModelNum"=>false,
    "ScreenRes"=>false,
    "ScreenSize"=>false,
    "Width"=>false,
    "Length"=>false,
    "Thickness"=>false,
    "Weight"=>false,
    "GPU"=>false,
    "CPU"=>false,
    "RAM"=>false,
    "Storage1"=>false,
    "Storage2"=>false,
    "StorageFilter"=>false,
    "Wifi"=>false,
    "BT"=>"",
    "Webcam"=>"",
    "OS"=>false,
    "BatteryLife"=>false,
    "BatteryType"=>"",
    "BatteryWH"=>"",
    "BatteryCell"=>"",
    "USBC"=>false,
    "USB3"=>false,
    "USB31"=>false,
    "USB32"=>false,
    "USB32C"=>false,
    "USB2"=>false,
    "HDMI"=>false,
    "VGA"=>false,
    "MiniDisplay"=>false,
    "SDcard"=>false
  ];
  $priceMasterArray = [[],[]];

  $OnePriceArray = (object)[
    'price'=> "",
    'condition'=> "",
    'available'=>""
  ];

  $SpecIDMaster = [];

  $data1 = [];
  $data2 = [];
  $data3 = [];
  $asin = $CrawlList[$c]['CrawlLink'];
  // $asin = 'B0891W21W8';
  $PriceID = $CrawlList[$c]['ID'];
  echo $asin. "<br>";

  $select = rand(1,2);

  switch ($select) {
    case 1:$firstLink = 'https://www.amazon.com/s?k='. $asin . '&ref=nb_sb_noss';break;
    case 2:$firstLink = 'https://www.amazon.com/s?k='. $asin;break;
    // case 3:$firstLink = 'https://www.amazon.com/s?k='. $asin . '&i=electronics&ref=nb_sb_noss';break;

    default:
      // code...
      break;
  }

  // $client = new Client();
  // get html from URL\
  $browser = new HttpBrowser(HttpClient::create());


  $crawler = $browser->request('GET', $firstLink);
  $body = "";
  $body =  $crawler->filter('body')->html();

  $wrong = false;

  $counterx=0;

  for($k=0;$k<1;$k++){
    $counterx = $counterx +1;
    if($counterx>4){
      echo "Too Many Captchas";
      die;
    }
    if(strpos($body,"Something went wrong on our end.") && true){
      $wrong = true;
      $amalink = $crawler->filter('#g > div > a')->link();
      sleep(1);
      $crawler = $browser->click($amalink);

      sleep(2);

    }

    $body =  $crawler->filter('body')->html();

    if(strpos($body,"Enter the characters you see below") && true){

      $api->setKey("f15478375d0134aa8fbdec65e693b611");

      $captcha="";
      $captcha = $crawler->filter('div > img')->eq(0)->attr('src');
      // echo $captcha;
      file_put_contents("capcha.jpg",file_get_contents($captcha));
      //setting file
      $api->setFile("capcha.jpg");

      //create task in API
      if (!$api->createTask()) {
          echo "API v2 send failed - ".$api->getErrorMessage()."\n";
          echo $body;
          exit;
      }

      $taskId = $api->getTaskId();

      if (!$api->waitForResult()) {
          echo "could not solve captcha\n";
          echo $api->getErrorMessage()."\n";
      } else {
          $captchaText    =   $api->getTaskSolution();
          echo "\ncatcha text: $captchaText\n\n";
      }

      $form = $crawler->selectButton('Continue shopping')->form();
      $form['field-keywords'] = $captchaText;

      $crawler = $browser->submit($form);
      $k=$k-1;
    }

    if($wrong){

      sleep(rand(1,4));
      $form = $crawler->selectButton('Go')->form();
      $form['field-keywords'] = $asin;

      $crawler = $browser->submit($form);

    }

  }






  // echo $crawler->filter('body')->html();

  // die;
  // try {
  //   $testx = $crawler->filter('.s-main-slot > div');
  // } catch (Exception $e) {
  //     echo 'Caught exceptionX: ',  $e->getMessage(), "\n";
  //     echo $crawler->filter('body')->html();
  //     $captcha = $crawler->filter('div > img')->attr('src');
  //
  //     $_img_to_text = new ImageToText();
  //     $_img_to_text->setKey('anticaptcha_key');
  //     $_img_to_text->setFile($captcha);
  //     $_task = 0;
  //     $_result = 0;
  //
  //     while (!$_img_to_text->createTask()) {
  //         $_img_to_text->createTask();
  //     }
  //
  //     $_task = $_img_to_text->getTaskId();
  //
  //     while (!$_img_to_text->waitForResult()) {
  //         $_img_to_text->waitForResult();
  //     }
  //
  //     $_result = $_img_to_text->getTaskSolution();
  //
  //     dump("TaskID : {$_task} : {$_result}");
  // }
  // $oneLink = 'https://www.amazon.com/HP-A9-9425-Graphic-Bluetooth-Windows/dp/B084HLTZSG/ref=sr_1_1?dchild=1&keywords=laptop&qid=1593263948&refinements=p_n_feature_seven_browse-bin%3A18107809011&rnid=3012494011&s=pc&sr=1-1';

  // echo file_get_contents($firstLink);
  $ActualLink= [];
  $test1 = false;
  $test2 = false;
  // echo $crawler->filter('body')->text();
  $crawler->filter('.s-main-slot > div')->each(function ($node) {
    echo $node->attr('data-asin');
    global $asin;
    global $ActualLink;
    global $OnePriceArray;
    global $test1;
    global $test2;
    $test1=true;
    if($node->attr('data-asin')==$asin){
      $test2=true;
      $ActualLink = $node->filter('.a-link-normal')->link();
      $OnePriceArray->link ="https://www.amazon.com". $node->filter('.a-link-normal')->attr('href');
      try {
        $newNode = $node->filter('.a-price-whole');
        $OnePriceArray->price =str_replace(',','',$newNode->text());
      } catch (Exception $e) {
          echo 'Caught exceptionX: ',  $e->getMessage(), "\n";
      }


    }

  });


  // echo $crawler->filter('body')->text();

  if($test1 == false){
    echo "BOTSTUCK";
    echo $crawler->filter('body')->html();
    die;
  }

  if($test2 == false){
    $DB->deletePriceByCrawlLink($asin);
    continue;
  }
  sleep(rand(3,12));


  $crawler = $browser->click($ActualLink);


  $body =  $crawler->filter('body')->html();

  if(strpos($body,"Enter the characters you see below") && true){

    $api->setKey("f15478375d0134aa8fbdec65e693b611");

    $captcha="";
    $captcha = $crawler->filter('div > img')->eq(0)->attr('src');
    // echo $captcha;
    file_put_contents("capcha.jpg",file_get_contents($captcha));
    //setting file
    $api->setFile("capcha.jpg");

    //create task in API
    if (!$api->createTask()) {
        echo "API v2 send failed - ".$api->getErrorMessage()."\n";
        echo $body;
        exit;
    }

    $taskId = $api->getTaskId();

    if (!$api->waitForResult()) {
        echo "could not solve captcha\n";
        echo $api->getErrorMessage()."\n";
    } else {
        $captchaText    =   $api->getTaskSolution();
        echo "\ncatcha text: $captchaText\n\n";
    }

    $form = $crawler->selectButton('Continue shopping')->form();
    $form['field-keywords'] = $captchaText;

    $crawler = $browser->submit($form);
    $k=$k-1;

    sleep(rand(1,4));
  }

  echo $OnePriceArray->link . "<br>";

  try {
    $title = $crawler->filter('#productTitle')->text();
  } catch (Exception $e) {
      echo 'Caught exceptionY: ',  $e->getMessage(), "\n";
      echo $crawler->filter('body')->html();
      die;
  }





  $crawler->filter('#feature-bullets > ul > li')->each(function ($node) {
    global $data1;
    array_push($data1, $node->text());
  });

  $crawler->filter('#productDescription > p')->each(function ($node) {
    global $data2;
    array_push($data2, $node->text());
  });

  $crawler->filter('#productDetails_techSpec_section_1 > tr')->each(function ($node) {
    global $data3;
    array_push($data3, $node->text());
    // var_dump($node);
  });


  $crawler->filter('#productDetails_techSpec_section_2 > tr')->each(function ($node) {
    global $data3;
    array_push($data3, $node->text());
  });

  $Images = $crawler->filter('#imageBlock_feature_div > script')->text();

  $AmazonImageLinks =[];
  preg_match_all('/"hiRes":"([a-zA-z\/\:\.\-_0-9%]*)/', $Images, $AmazonImageLinks);

  if(count($AmazonImageLinks)==0 || empty($AmazonImageLinks)){
    preg_match_all('/"large":"([a-zA-z\/\:\.\-_0-9%]*)/', $Images, $AmazonImageLinks);
  }else if($AmazonImageLinks[1][0]=='null'){
    preg_match_all('/"large":"([a-zA-z\/\:\.\-_0-9%]*)/', $Images, $AmazonImageLinks);
  }

  // parseWithParts($data3);

  ParseLaptop();

  echo $title . "<br><br>";

  for($i=0;$i<count($data1);$i++){
    echo $data1[$i]. "<br>";
  }

  for($i=0;$i<count($data2);$i++){
    echo $data2[$i]. "<br>";
  }

  for($i=0;$i<count($data3);$i++){
    echo $data3[$i]. "<br>";
  }
  $AmazonImageLinks = $AmazonImageLinks[1];
  var_dump($AmazonImageLinks);


  echo "<br><br><br><br>";

  var_dump($ShortChecklist);
  echo "<br><br>";
  var_dump($SpecObject);
  echo "<br><br>";
  var_dump($SpecIDobject);
  echo "<br><br>";

  $SpecObject->Name = str_replace("/","-",$SpecObject->Name);

  $product = $DB->getProductByProductName($SpecObject->Brand,$SpecObject->Name);

  if($product==false){
    $itemName = str_replace(" ", "_", $SpecObject->Name);

    $imageName = $SpecObject->Brand . "_". $itemName;
  }else{
    $itemName = str_replace(" ", "_", $SpecObject->Name);

    $rand = rand(1,1000);
    $imageName = $SpecObject->Brand . "_". $itemName."_".$rand;
  }

  if($SpecObject->Name=="" || $SpecObject->Name==false){
    $SpecObject->Name==$PriceID;
  }

  $DB->newProductwithActive($SpecObject->Brand, $SpecObject->Name, "Laptop", "MrBot", 3);
  $SpecObject->ID = $DB->getLastProductID();
  for($i=0;$i<count($SpecIDMaster);$i++){
    $DB->newProductSpec($SpecObject->ID,$SpecIDMaster[$i]);
  }

  $DB->changeFullPriceByPriceID($PriceID, $SpecObject->ID, 1, $OnePriceArray->price, $OnePriceArray->link, $asin, $OnePriceArray->condition, "dollar", 1);

  $vrainlink=[];
  for($i=0;$i<count($AmazonImageLinks);$i++){
    if(isset($AmazonImageLinks[$i])){
      // echo $ImageLink[$i][0] . "<br>";
      $url_to_image = $AmazonImageLinks[$i];
      $my_save_dir = 'images/laptop/';
      $filename = $imageName."_".$i;
      $complete_save_loc = $my_save_dir.$filename.'.jpg';
      $vrainlink[$i] = 'https://vrain.io/images/laptop/'.$filename.'.jpg';
      // fopen($complete_save_loc, "w");
     file_put_contents($complete_save_loc,file_get_contents($url_to_image));
     if($i==1){
       $DB->newPhoto($SpecObject->ID, $vrainlink[$i], "Hero", 0);
     }else{
       $DB->newPhoto($SpecObject->ID, $vrainlink[$i], "", 0);
     }
    }
  }

}


function SpecIdToMaster(){
  global $SpecIDMaster;
  global $SpecIDobject;
  global $SpecObject;
  global $ShortChecklist;
  global $DB;

  if($ShortChecklist->Storage2){
    $SpecObject->StorageFilter = (int)$SpecObject->Storage1 + (int)$SpecObject->Storage2;
    if($ShortChecklist->SSD){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage_Filter", "", "", "", "", "SSD", $SpecObject->StorageFilter, "");
      $SpecIDobject->StorageFilter = $tempRow['ID'];
    }else{
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage_Filter", "", "", "", "", "", $SpecObject->StorageFilter, "");
      $SpecIDobject->StorageFilter = $tempRow['ID'];
    }
  }else if($ShortChecklist->Storage1){
    $SpecObject->StorageFilter = (int)$SpecObject->Storage1;
    if($ShortChecklist->SSD){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage_Filter", "", "", "", "", "SSD", $SpecObject->StorageFilter, "");
      $SpecIDobject->StorageFilter = $tempRow['ID'];
    }else{
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage_Filter", "", "", "", "", "", $SpecObject->StorageFilter, "");
      $SpecIDobject->StorageFilter = $tempRow['ID'];
    }
  }

  if($SpecIDobject->Screen!=""){
    array_push($SpecIDMaster,$SpecIDobject->Screen);
  }
  if($SpecIDobject->Dimensions!=""){
    array_push($SpecIDMaster,$SpecIDobject->Dimensions);
  }
  if($SpecIDobject->GPU!=""){
    array_push($SpecIDMaster,$SpecIDobject->GPU);
  }
  if($SpecIDobject->CPU!=""){
    array_push($SpecIDMaster,$SpecIDobject->CPU);
  }
  if($SpecIDobject->RAM!=""){
    array_push($SpecIDMaster,$SpecIDobject->RAM);
  }
  if($SpecIDobject->Storage1!=""){
    array_push($SpecIDMaster,$SpecIDobject->Storage1);
  }
  if($SpecIDobject->Storage2!=""){
    array_push($SpecIDMaster,$SpecIDobject->Storage2);
  }
  if($SpecIDobject->StorageFilter!=""){
    array_push($SpecIDMaster,$SpecIDobject->StorageFilter);
  }
  if($SpecIDobject->Communication!=""){
    array_push($SpecIDMaster,$SpecIDobject->Communication);
  }
  if($SpecIDobject->OS!=""){
    array_push($SpecIDMaster,$SpecIDobject->OS);
  }
  if($SpecIDobject->Battery!=""){
    array_push($SpecIDMaster,$SpecIDobject->Battery);
  }

  for($i=0;$i<count($SpecIDobject->Ports);$i++){
    array_push($SpecIDMaster,$SpecIDobject->Ports[$i]);
  }
  for($i=0;$i<count($SpecIDobject->Misc);$i++){
    array_push($SpecIDMaster,$SpecIDobject->Misc[$i]);
  }

}

function matchRam($data){
  $size = false;
  $mhz = false;
  $ddr = false;
  $ramSize = "";
  $ramDDR = "";
  $ramMHZ = "";
  $temp = [];
  if(strpos($data, "Memory RAM:")!== false){
    $data= str_replace("Memory RAM:", "", $data);

    if(preg_match('/(\d{1,2}) ?GB/', $data, $temp)){
      $ramSize = $temp[1];
      $size = true;
    }

    if(preg_match('/(DDR\d)/', $data, $temp)){
      $ramDDR = $temp[1];
      $ddr = true;
    }

    if(preg_match('/(\d{4}) ?(MHz|mhz)/', $data, $temp)){
      $ramMHZ = $temp[1];
      $mhz = true;
    }
  }

  if(!$size){
    if(preg_match('/(\d{1,2}) ?GB ?-?(DDR\d) ?-?(\d{4}) (MHz|mhz)/', $data, $temp)){
      $ramSize = $temp[1];
      $ramDDR = $temp[2];
      $ramMHZ = $temp[3];
      $size= true;
      $ddr= true;
      $mhz = true;
    }
  }

  if(!$size){
    if(preg_match('/(\d{1,2}) ?GB (DDR\d)/', $data, $temp)){
      $ramSize = $temp[1];
      $ramDDR = $temp[2];
      $size= true;
      $ddr= true;
    }
  }

  if(strpos($data, "RAM")!== false && !$size){
    if(preg_match('/(\d{1,2}) ?GB/', $data, $temp)){
      $ramSize = $temp[1];
      $size= true;
    }
  }
  if(strpos($data, "RAM")!== false && !$ddr){
    if(preg_match('/(DDR\d)/', $data, $temp)){
      $ramDDR = $temp[1];
      $ddr= true;
    }
  }
  if(!$ddr){
    if(preg_match('/(DDR\d)/', $data, $temp)){
      $ramDDR = $temp[1];
      $ddr= true;
    }
  }
  if(!$mhz){
    if(preg_match('/(\d{4}) ?(MHz|mhz)/', $data, $temp)){
      $ramMHZ = $temp[1];
      $mhz= true;
    }
  }

  if(strpos($data, "MHz")!== false && !$size){
    if(preg_match('/(\d{1,2}) ?GB/', $data, $temp)){
      $ramSize = $temp[1];
      $size= true;
    }
  }

  if(strpos($data, "GB Memory")!== false && !$size){
    if(preg_match('/(\d{1,2}) ?GB Memory/', $data, $temp)){
      $ramSize = $temp[1];
      $size= true;
    }
  }

  if(strpos($data, "Memory")!== false && !$size){
    if(preg_match('/Memory (\d{1,2}) ?GB/', $data, $temp)){
      $ramSize = $temp[1];
      $size= true;
    }
  }

  // if(!$size){
  //   if(preg_match('/(\d{1,2}) ?GB/', $data, $temp)){
  //     $ramSize = $temp[1];
  //     $size= true;
  //   }
  // }

  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;


  if($size && (int)$ramSize < 65){
    $tempRow=[];
    $tempRow = $DB->newSpecIfDoesntExistandGetID("Laptop_RAM", "", "", "", "", $ramSize, $ramDDR, $ramMHZ);
    $SpecIDobject->RAM = $tempRow['ID'];
    $ShortChecklist->RAM = true;
    $SpecObject->RAM = $ramSize;
    return true;
  }
  return false;
}

function matchStorage($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  $size1 = false;
  $size2 = false;
  $rpm = false;
  $SSD = false;
  $HDD = false;
  $Ssize1 = "";
  $Ssize2 = "";
  $Srpm = "";
  $temp = [];


  if(preg_match_all('/(\d{3,4}) ?GB/', $data, $temp)){
    for($i=0;$i<count($temp[1]);$i++){
      if(!$size1){
        $Ssize1 = $temp[1][$i];
        $size1 = true;
      }else if(!$size2 && $Ssize1 != $temp[1][$i]){
        $Ssize2 = $temp[1][$i];
        $size2 = true;
      }
    }
  }

  if(preg_match('/2 ?x ?(\d{3,4}) ?GB/', $data, $temp)){
      if(!$size1){
        $Ssize1 = $temp[1];
        $size1 = true;
      }
      if(!$size2){
        $Ssize2 = $temp[1];
        $size2 = true;
      }
  }

  if(preg_match('/2 ?x ?(\d{3,4}) ?TB/', $data, $temp)){
      if(!$size1){
        $Ssize1 = $temp[1];
        $size1 = true;
      }
      if(!$size2){
        $Ssize2 = $temp[1];
        $size2 = true;
      }
  }

  if(preg_match_all('/(\d) ?TB/', $data, $temp)){
    for($i=0;$i<count($temp[1]);$i++){
      if(!$size1){
        $Ssize1 = $temp[1][$i];
        $size1 = true;
      }else if(!$size2 && $Ssize1 != $temp[1][$i]){
        $Ssize2 = $temp[1][$i];
        $size2 = true;
      }
    }
  }

  if(strpos($data, "SSD")){
    $SSD=true;
    $ShortChecklist->SSD=true;
  }

  if(strpos($data, "HDD")){
    $HDD=true;
  }

  if(preg_match('/(\d{4}) ?[RPMrpm]{3}/', $data, $temp)){
    $rpm=true;
    $Srpm = $temp[1];
  }

  if(!$size1){
    if(preg_match('/(\d{2}) ?GB ?(EMMC|SSD|HDD|Storage|hard)/', $data, $temp)){
      $Ssize1 = $temp[1];
      $size1 = true;
    }
  }


  if($Ssize1==1000){
    $Ssize1 = 1024;
  }
  if($Ssize1==500){
    $Ssize1 = 512;
  }
  if($Ssize1==1){
    $Ssize1 = 1024;
  }
  if($Ssize1==2){
    $Ssize1 = 2048;
  }
  if($Ssize2==4){
    $Ssize2 = 4096;
  }
  if($Ssize2==1000){
    $Ssize2 = 1024;
  }
  if($Ssize2==500){
    $Ssize2 = 512;
  }
  if($Ssize2==1){
    $Ssize2 = 1024;
  }
  if($Ssize2==2){
    $Ssize2 = 2048;
  }
  if($Ssize2==4){
    $Ssize2 = 4096;
  }



  if($size2){
    if($Ssize1 > $Ssize2){
      $tempRow=[];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", "HDD", $Ssize1, $Srpm);
      $SpecIDobject->Storage1 = $tempRow['ID'];
      $ShortChecklist->Storage1 = true;
      $SpecObject->Storage1 = $Ssize1;

      $tempRow=[];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", "SSD", $Ssize2, "");
      $SpecIDobject->Storage2 = $tempRow['ID'];
      $ShortChecklist->Storage2 = true;
      $SpecObject->Storage2 = $Ssize2;
      return true;
    }else{
      $tempRow=[];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", "HDD", $Ssize2, $Srpm);
      $SpecIDobject->Storage2 = $tempRow['ID'];
      $ShortChecklist->Storage2 = true;
      $SpecObject->Storage2 = $Ssize2;

      $tempRow=[];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", "SSD", $Ssize1, "");
      $SpecIDobject->Storage1 = $tempRow['ID'];
      $ShortChecklist->Storage1 = true;
      $SpecObject->Storage1 = $Ssize1;
      return true;
    }
  }else if($size1){
    $type="HDD";
    if($SSD){
      $type="SSD";
    }
    $tempRow=[];
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Storage", "", "", "", "", $type, $Ssize1, $Srpm);
    $SpecIDobject->Storage1 = $tempRow['ID'];
    $ShortChecklist->Storage1 = true;
    $SpecObject->Storage1 = $Ssize1;
    return true;
  }
  return false;
}

function matchScreenRes($data){
  $temp=[];
  $res = false;
  $Rres = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d{3,4})-? ?x?-? ?(\d{3,4})/', $data, $temp)){
    $Rres = $temp[1]."x".$temp[2];
    $res = true;
  }

  if(!$res){
    if(strpos($data, "1080p")){
      $Rres = "1080p";
      $res = true;
    }else if(strpos($data, "2K")){
      $Rres = "2K";
      $res = true;
    }else if(strpos($data, "4K")){
      $Rres = "4K";
      $res = true;
    }
  }

  if($res){
    $ShortChecklist->ScreenRes = true;
    $SpecObject->ScreenRes = $Rres;

    if($ShortChecklist->ScreenSize){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Screen", "", "", "", "", $SpecObject->ScreenSize, $Rres, "");
      $SpecIDobject->Screen = $tempRow['ID'];
    }
    return true;
  }
  return false;
}

function matchScreenSize($data){
  $temp=[];
  $size = false;
  $Ssize = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d{2}\.?\d?) ?(inches|")/', $data, $temp)){
    $Ssize = $temp[1];
    $size = true;
  }


  if($size){
    $ShortChecklist->ScreenSize = true;
    $SpecObject->ScreenSize = $Ssize;
    if($ShortChecklist->ScreenRes){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Screen", "", "", "", "", $Ssize, $SpecObject->ScreenRes, "");
      $SpecIDobject->Screen = $tempRow['ID'];
    }
    return true;
  }
  return false;
}

function matchDimensions($data){
  $temp=[];
  $dimensions = false;
  $Width = "";
  $Height = "";
  $Thickness = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d{1,2}\.?\d*) x?-? ?(\d{1,2}\.?\d*) x?-? ?(\d\.?\d*)/', $data, $temp)){
    if((int)$temp[1]>(int)$temp[2] && (int)$temp[2]>(int)$temp[3]){
      $Width = $temp[1];
      $Height = $temp[2];
      $Thickness = $temp[3];
    }
    else if((int)$temp[2]>(int)$temp[3] && (int)$temp[3]>(int)$temp[1]){
      $Width = $temp[2];
      $Height = $temp[3];
      $Thickness = $temp[1];
    }
    else if((int)$temp[3]>(int)$temp[1] && (int)$temp[1]>(int)$temp[2]){
      $Width = $temp[3];
      $Height = $temp[1];
      $Thickness = $temp[2];
    }
    else if((int)$temp[1]>(int)$temp[3] && (int)$temp[3]>(int)$temp[2]){
      $Width = $temp[1];
      $Height = $temp[3];
      $Thickness = $temp[2];
    }
    else if((int)$temp[2]>(int)$temp[1] && (int)$temp[1]>(int)$temp[3]){
      $Width = $temp[2];
      $Height = $temp[1];
      $Thickness = $temp[3];
    }
    else if((int)$temp[3]>(int)$temp[2] && (int)$temp[2]>(int)$temp[1]){
      $Width = $temp[3];
      $Height = $temp[2];
      $Thickness = $temp[1];
    }

    if((int)$Thickness>3){

    }else{
      $ShortChecklist->Dimensions = true;
      $SpecObject->Width = $Width;
      $SpecObject->Length = $Height;
      $SpecObject->Thickness = $Thickness;
      if($ShortChecklist->Weight){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Dimensions", "", "", "", $SpecObject->Weight, $Width, $Height, $Thickness);
        $SpecIDobject->Dimensions = $tempRow['ID'];
      }
      return true;
    }
  }
  return false;
}

function matchWeight($data){
  $temp=[];
  $Weight = false;
  $Wweight = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d{1,2}\.?\d{0,2}) (pounds|lb|Pounds|LB)/', $data, $temp)){

    $Wweight =$temp[1];
      $ShortChecklist->Weight = true;
      $SpecObject->Weight = $Wweight;
      if($ShortChecklist->Dimensions){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Dimensions", "", "", "", $SpecObject->Weight, $SpecObject->Width, $SpecObject->Length, $SpecObject->Thickness);
        $SpecIDobject->Dimensions = $tempRow['ID'];
      }
      return true;
  }
  return false;
}

function matchWifi($data){
  $temp=[];
  $wifi = false;
  $Wwifi = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/802. ?11([ACBGNacbgn\/ ]+)/', $data, $temp)){

      $Wwifi ="802.11 ".$temp[1];
      $ShortChecklist->Wifi = true;
      $SpecObject->Wifi = $Wwifi;
      if($ShortChecklist->BT && $ShortChecklist->Webcam){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
        $SpecIDobject->Communication = $tempRow['ID'];
      }
      return true;
  }
  return false;
}

function matchBT($data){
  $temp=[];
  $BT = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/Bluetooth (\d\.?\d?)/', $data, $temp)){

      $BT =$temp[1];
      $ShortChecklist->BT = true;
      $SpecObject->BT = $BT;
      if($ShortChecklist->Wifi && $ShortChecklist->Webcam){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
        $SpecIDobject->Communication = $tempRow['ID'];
      }
      return true;
  }else if(strpos($data, "Bluetooth")){
    $BT ="4.0";
    $ShortChecklist->BT = true;
    $SpecObject->BT = $BT;
    if($ShortChecklist->Wifi && $ShortChecklist->Webcam){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
      $SpecIDobject->Communication = $tempRow['ID'];
    }
    return true;
  }
  return false;
}

function matchWebcam($data){
  $temp=[];
  $Webcam = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(strpos($data, "HD Webcam")){

      $Webcam ="HD Webcam";
      $ShortChecklist->Webcam = true;
      $SpecObject->Webcam = $Webcam;
      if($ShortChecklist->Wifi && $ShortChecklist->BT){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
        $SpecIDobject->Communication = $tempRow['ID'];
      }
      return true;
  }else if(strpos($data, "VGA Webcam")){
    $Webcam ="VGA Webcam";
    $ShortChecklist->Webcam = true;
    $SpecObject->Webcam = $Webcam;
    if($ShortChecklist->Wifi && $ShortChecklist->BT){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
      $SpecIDobject->Communication = $tempRow['ID'];
    }
    return true;
  }else if(strpos($data, "Webcam")){
    $Webcam ="Webcam";
    $ShortChecklist->Webcam = true;
    $SpecObject->Webcam = $Webcam;
    if($ShortChecklist->Wifi && $ShortChecklist->BT){
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
      $SpecIDobject->Communication = $tempRow['ID'];
    }
    return true;
  }
  return false;
}

function matchOS($data){
  $temp=[];
  $OS1 = "";
  $OS2 = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/[Ww]indows (\d{1,2}\.?\d?) ?([HomeSPro]*)/', $data, $temp)){

    $OS1 =$temp[1];
    $OS2 =$temp[2];
      $ShortChecklist->OS = true;
      $SpecObject->OS = $OS1;
      if($OS2!=""&&$OS2!=null){
        $SpecObject->OS = $OS1." ".$OS2;
      }

        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_OS", "", "Windows", "", $SpecObject->OS, "", "", "");
        $SpecIDobject->OS = $tempRow['ID'];
      return true;
  }else if(preg_match('/Mac ?(OS) ?([X])/', $data, $temp)){
    $OS1 =$temp[1];
    $OS2 =$temp[2];
      $ShortChecklist->OS = true;
      $SpecObject->OS = $OS1;
      if($OS2!=""&&$OS2!=null){
        $SpecObject->OS = $OS1." ".$OS2;
      }

        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_OS", "", "Mac", "", $SpecObject->OS, "", "", "");
        $SpecIDobject->OS = $tempRow['ID'];
      return true;
  }else if(preg_match('/(Chrome OS|ChromeOS|Chrome)/', $data, $temp)){
    $OS1 =$temp[1];
      $ShortChecklist->OS = true;
      $SpecObject->OS = $OS1;

        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_OS", "", "Chrome", "", "OS", "", "", "");
        $SpecIDobject->OS = $tempRow['ID'];
      return true;
  }
  return false;
}

function matchBatteryLife($data){
  $temp=[];
  $Life = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d{1,2}.?\d*)[ -][hH]ours/', $data, $temp)){

    $Life =$temp[1];
      $ShortChecklist->BatteryLife = true;
      $SpecObject->BatteryLife = $Life;
      if($ShortChecklist->BatteryDetails){
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Battery", "", $SpecObject->BatteryType, "", "", $SpecObject->BatteryLife, $SpecObject->BatteryWH, $SpecObject->BatteryCell);
        $SpecIDobject->Battery = $tempRow['ID'];
      }
      return true;
  }
  return false;
}

function matchBatteryDetails($data){
  $temp=[];
  $Type = "";
  $WH = "";
  $Cells = "";
  $t=false;
  $w=false;
  $c=false;
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(\d)[- ][Cc]ell/', $data, $temp)){
      $c=true;
      $Cells =$temp[1];
      $ShortChecklist->BatteryCell = true;
      $SpecObject->BatteryCell = $Cells;
  }

  if(preg_match('/(\d+)[- ][WwHhRr]{3}/', $data, $temp)){
      $w=true;
      $WH =$temp[1];
      $ShortChecklist->BatteryWH = true;
      $SpecObject->BatteryWH = $WH;
  }

  if(preg_match('/(Lithium-ion|Li-ion|Li-polymer|Lithium-ion polymer)/', $data, $temp)){
      $t=true;
      $Type =$temp[1];
      $ShortChecklist->BatteryType = true;
      $SpecObject->BatteryType = $Type;
  }



  if($ShortChecklist->BatteryLife && ($t || $w || $c)){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Battery", "", $SpecObject->BatteryType, "", "", $SpecObject->BatteryLife, $SpecObject->BatteryWH, $SpecObject->BatteryCell);
    $SpecIDobject->Battery = $tempRow['ID'];
  }
  if($t || $w || $c){
    return true;
  }
  return false;
}

function matchBrand($data){
  $temp=[];
  $brand = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;


  if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI)/', $data, $temp)){

      $brand =$temp[1];
      $ShortChecklist->Brand = true;
      $SpecObject->Brand = $brand;
      return true;
  }
  return false;
}

function matchName1($data){
  $temp=[];
  $temp1=[];
  $N1 = "";
  $N2 ="";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;

  if(preg_match('/(Series|Item model number) ?(.*)/', $data, $temp)){
      $N1 =$temp[2];
      if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) ?(.*)/', $N1, $temp1)){
          $N1 =$temp1[2];
          $N1 = str_replace("\"","",$N1);
      }

      if($temp[1]=="Series" && $N1!=""){
        $ShortChecklist->NameSeries=true;
        $SpecObject->NameSeries = $N1;
      }else if($temp[1]=="Item model number" && $N1!=""){
        $ShortChecklist->NameModelNum=true;
        $SpecObject->NameModelNum = $N1;
      }
      return true;
  }
  return false;
}

function matchName2($data){
  $temp=[];
  $name = false;
  $nameBB= false;
  $fullName = [];
  $FullName = "";
  $NameSeries="";
  $NameModelNum="";
  $nameB =false;
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  $tempName ="";


  if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?(Gaming)/', $data, $temp)){

      $name =$temp[2];
      $nameBB=true;
  }if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?(Slim|Thin)/', $data, $temp)){

      if($nameBB===false){
        $name =$temp[2];
        $nameBB=true;
      }else if(strlen($temp[2])<strlen($name)){
        $name =$temp[2];
        $nameBB=true;
      }


      echo $temp[2] ."<br>";
  }if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?(Laptop)/', $data, $temp)){
    if($nameBB===false){
      $name =$temp[2];
      $nameBB=true;
    }else if((int)strlen($temp[2])<(int)strlen($name)){
      $name =$temp[2];
      $nameBB=true;
    }
    echo $name . strlen($name)."<br>";
  }if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?(\d{2}\.?\d?[ -]?[Ii"”])/', $data, $temp)){
    if($nameBB===false){
      $name =$temp[2];
      $nameBB=true;
    }else if((int)strlen($temp[2])<(int)strlen($name)){
      $name =$temp[2];
      $nameBB=true;
    }
    echo $name . strlen($name)."XXXXs<br>";
  }if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?(Netbook)/', $data, $temp)){
    if($nameBB===false){
      $name =$temp[2];
      $nameBB=true;
    }else if((int)strlen($temp[2])<(int)strlen($name)){
      $name =$temp[2];
      $nameBB=true;
    }
    echo $name ."<br>";
  }if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*) ?\(/', $data, $temp)){
    if($nameBB===false){
      $name =$temp[2];
      $nameBB=true;
    }else if((int)strlen($temp[2])<(int)strlen($name)){
      $name =$temp[2];
      $nameBB=true;
    }
    echo $name ."<br>";
  }
  if(preg_match('/(Asus|ASUS|HP|Lenovo|LENOVO|Samsung|Dell|DELL|Alienware|Apple|APPLE|Acer|ACER|Microsoft|Google|Winnovo|MSI) (.*)/', $data, $temp)){
    if($nameBB===false){
      $name =$temp[2];
      $nameBB=true;
    }else if((int)strlen($temp[2])<(int)strlen($name)){
      $name =$temp[2];
      $nameBB=true;
    }
    echo $name .strlen($name)."<br>";
  }

  if($name!="" && $name!=false){
    $temp = explode(" ",$name);
    for($i=0;$i<count($temp);$i++){
      if($temp[$i]=="Flagship"){
      }else if($ShortChecklist->NameSeries && $SpecObject->NameSeries==$temp[$i]){
        $NameSeries = $temp[$i];
      }else if($ShortChecklist->NameModelNum && $SpecObject->NameModelNum==$temp[$i]){
        array_push($fullName,$temp[$i]);
      }else{
        array_push($fullName,$temp[$i]);
      }
    }


    for($i=0;$i<count($fullName);$i++){
      if($i<3){
        if($nameB==true){
          $FullName = $FullName ." ";
        }
        $FullName = $FullName . $fullName[$i];
        $nameB =true;
      }
    }

    if($NameSeries!=""){
      if($nameB==true){
        $FullName = $FullName ." ";
      }
      $FullName = $FullName.$NameSeries;
      $nameB =true;
    }else if($ShortChecklist->NameSeries!=false){
      if($nameB==true){
        $FullName = $FullName ." ";
      }
      $FullName = $FullName.$SpecObject->NameSeries;
      $nameB =true;
    }

    $ModelNumisdone = false;
    $space=false;
    $temp4 = [];
    $temp4 = explode(" ",$FullName);
    $FullName = "";
    for($q=0;$q<count($temp4);$q++){
      if(strpos($SpecObject->NameModelNum,$temp4[$q])!==false){
        $ModelNumisdone = true;
        if($space==true){
          $FullName = $FullName ." ";
        }
        $FullName = $FullName.$SpecObject->NameModelNum;
        $space=true;
      }else{
        if($space==true){
          $FullName = $FullName ." ";
        }
        $FullName = $FullName.$temp4[$q];
        $space=true;
      }
    }

    if(!$ModelNumisdone){
      if($NameModelNum!=""){
        if($nameB==true){
          $FullName = $FullName ." ";
        }
        $FullName = $FullName.$NameModelNum;
        $nameB =true;
      }else if($ShortChecklist->NameModelNum!=false){
        if($nameB==true){
          $FullName = $FullName ." ";
        }
        $FullName = $FullName.$SpecObject->NameModelNum;
        $nameB =true;
      }
    }

  }else{

        if($ShortChecklist->NameSeries!=false){
          if($nameB==true){
            $FullName = $FullName ." ";
          }
          $FullName = $FullName.$SpecObject->NameSeries;
          $nameB =true;
        }

        $ModelNumisdone = false;
        $space=false;
        $temp4 = [];
        $temp4 = explode(" ",$FullName);
        $FullName = "";
        for($q=0;$q<count($temp4);$q++){
          if(strpos($SpecObject->NameModelNum,$temp4[$q])!==false){
            $ModelNumisdone = true;
            if($space==true){
              $FullName = $FullName ." ";
            }
            $FullName = $FullName.$SpecObject->NameModelNum;
            $space=true;
          }else{
            if($space==true){
              $FullName = $FullName ." ";
            }
            $FullName = $FullName.$temp4[$q];
            $space=true;
          }
        }

        if(strtolower($SpecObject->NameModelNum)==strtolower($SpecObject->NameSeries)){
          $ModelNumisdone=true;
        }


        if(!$ModelNumisdone){
          if($ShortChecklist->NameModelNum!=false){
            if($nameB==true){
              $FullName = $FullName ." ";
            }
            $FullName = $FullName.$SpecObject->NameModelNum;
            $nameB =true;
          }
        }
  }

  $explodedName = [];
  $explodedName = explode(" ",$FullName);
  $dublicateArray = [];
  $space= false;
  $FullName ="";

  for($i=0;$i<count($explodedName);$i++){
    for($j=$i+1;$j<count($explodedName);$j++){
      if($explodedName[$i]==$explodedName[$j]){
        array_push($dublicateArray,$j);
      }
    }
    if(in_array($i,$dublicateArray)){

    }else{
      if($space==true){
        $FullName = $FullName ." ";
      }
      $FullName = $FullName.$explodedName[$i];
      $space =true;
    }
  }

  $ShortChecklist->Name=true;
  $SpecObject->Name=$FullName;
  return true;

}

function matchCPU($data){
  $temp=[];
  $tempRow=[];
  $CPU = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;


  if(preg_match('/(i[3579]|Intel|AMD|[AR]\d{1,2}|PRO|Athlon|X\d|Silver|FX|Threadripper|Ryzen \d{1,2})[- ]([a-zA-Z]?\d{3,4}[a-zA-Z]{0,2}\d?)/', $data, $temp)){
      $CPU =$temp[2];
      $tempRow= $DB->getSpecsByAll("Laptop_CPU", "", "", $CPU, "", "", "");
      $SpecIDobject->CPU = $tempRow[0]['ID'];
      $ShortChecklist->CPU = true;
      $SpecObject->CPU = $CPU;
      return true;
  }
  return false;
}

function matchGPU($data){
  $temp=[];
  $tempRow=[];
  $Graphics = "";
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;


  if(preg_match('/(Graphics|GTX|RTX|Radeon|Radeon ?-?RX)[- ]?([a-zA-Z]?\d{3,4}[a-zA-Z]{0,2}\d?) ?(Ti|MAX-Q|M)?/', $data, $temp)){
      $Graphics =$temp[2];
      if(count($temp)==4){
        $tempRow= $DB->getSpecsByAll("Laptop_Graphics", "", "", $Graphics, $temp[1], $temp[3], "");
        if(empty($tempRow)){
          $tempRow= $DB->getSpecsByAll("Laptop_Graphics", "", "", $Graphics, "", $temp[3], "");
        }
        if(empty($tempRow)){
          $tempRow= $DB->getSpecsByAll("Laptop_Graphics", "", "", $Graphics, "", "", "");
        }
        $SpecIDobject->GPU = $tempRow[0]['ID'];
        $ShortChecklist->GPU = true;
        $SpecObject->GPU = $Graphics;
        if(count($tempRow)>3){
          $ShortChecklist->GPU = false;
        }
      }else{
          $tempRow= $DB->getSpecsByAll("Laptop_Graphics", "", "", $Graphics, $temp[1], "", "");
        if(empty($tempRow)){
          $tempRow= $DB->getSpecsByAll("Laptop_Graphics", "", "", $Graphics, "", "", "");
        }

        $SpecIDobject->GPU = $tempRow[0]['ID'];
        $ShortChecklist->GPU = true;
        $SpecObject->GPU = $Graphics;
        if(count($tempRow)>3){
          $ShortChecklist->GPU = false;
        }
      }
      return true;
  }
  return false;
}

function matchPorts($data){
  $temp=[];
  $temp2=[];
  $tempRow=[];

  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;


  if(preg_match_all('/(\d)? ?(x |- |)USB (\d\.\ ?\d|C) (Type[ -][CA])?/', $data, $temp)){
    for($i=0;$i<count($temp[0]);$i++){
      if($temp[4][$i]!=""){
        if($temp[4][$i]=="Type-A" || $temp[4][$i]=="Type A"){
          if($temp[3][$i]=="3.0"||$temp[3][$i]=="3. 0"){
            $SpecObject->USB3 = $temp[1][$i];
            if($SpecObject->USB3==""){
              $SpecObject->USB3='1';
            }
            $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.0", $SpecObject->USB3, "", "");
            if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
              array_push($SpecIDobject->Ports,$tempRow['ID']);
            }
          }else if($temp[3][$i]=="3.1"||$temp[3][$i]=="3. 1"){
            $SpecObject->USB31 = $temp[1][$i];
            if($SpecObject->USB31==""){
              $SpecObject->USB31='1';
            }
            $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.1", $SpecObject->USB31, "", "");
            if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
              array_push($SpecIDobject->Ports,$tempRow['ID']);
            }
          }else if($temp[3][$i]=="3.2"||$temp[3][$i]=="3. 2"){
            $SpecObject->USB32 = $temp[1][$i];
            if($SpecObject->USB32==""){
              $SpecObject->USB32='1';
            }
            $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.2", $SpecObject->USB32, "", "");
            if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
              array_push($SpecIDobject->Ports,$tempRow['ID']);
            }
          }
        }else{
          if($temp[3][$i]=="3.1"||$temp[3][$i]=="3. 1"){
            $SpecObject->USBC = $temp[1][$i];
            if($SpecObject->USBC==""){
              $SpecObject->USBC='1';
            }
            $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB C", $SpecObject->USBC, "", "");
            if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
              array_push($SpecIDobject->Ports,$tempRow['ID']);
            }
          }else if($temp[3][$i]=="3.2"||$temp[3][$i]=="3. 2"){
            $SpecObject->USB32C = $temp[1][$i];
            if($SpecObject->USB32C==""){
              $SpecObject->USB32C='1';
            }
            $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.2 C", $SpecObject->USB32C, "", "");
            if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
              array_push($SpecIDobject->Ports,$tempRow['ID']);
            }
          }
        }
      }else if($temp[3][$i]=="2.0"||$temp[3][$i]=="2. 0"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB2 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 2.0", $SpecObject->USB2, "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="3.0"||$temp[3][$i]=="3. 0"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB3 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.0", $SpecObject->USB3, "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="3.1"||$temp[3][$i]=="3. 1"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB31 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.1", $SpecObject->USB31, "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="3.2"||$temp[3][$i]=="3. 2"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB32C = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.2 C", $SpecObject->USB32C, "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="C"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USBC = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB C", $SpecObject->USBC, "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else{
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB2 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 2.0", $temp[2], "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }
    }
  }

  if(preg_match_all('/(\d)? ?(x |- |)[tT]hunderbolt (\d)/', $data, $temp)){
    for($i=0;$i<count($temp[0]);$i++){
      if($temp[3][$i]=="3"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USBC = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 3", $temp[1][$i], "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="2"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB3 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 2", $temp[1][$i], "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="1"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB3 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 1", $temp[1][$i], "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }else if($temp[3][$i]=="4"){
        if($temp[1][$i]==""){
          $temp[1][$i]='1';}
        $SpecObject->USB3 = $temp[1][$i];
        $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 4", $temp[1][$i], "", "");
        if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
          array_push($SpecIDobject->Ports,$tempRow['ID']);
        }
      }
    }
  }

  if(preg_match('/Number of USB (\d\. ?\d|C) Ports (\d)/', $data, $temp)){
    if($temp[1]=="2.0"||$temp[1]=="2. 0"){
      $SpecObject->USB2 = $temp[2];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 2.0", $temp[2], "", "");
      if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
        array_push($SpecIDobject->Ports,$tempRow['ID']);
      }
    }else if($temp[1]=="3.0"||$temp[1]=="3. 0"){
      $SpecObject->USB3 = $temp[2];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 3.0", $temp[2], "", "");
      if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
        array_push($SpecIDobject->Ports,$tempRow['ID']);
      }
    }else if($temp[1]=="3.1"||$temp[1]=="3. 1"){
      $SpecObject->USBC = $temp[2];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Thunderbolt 3", $temp[2], "", "");
      if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
        array_push($SpecIDobject->Ports,$tempRow['ID']);
      }
    }else if($temp[1]=="C"){
      $SpecObject->USBC = $temp[2];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB C", $temp[2], "", "");
      if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
        array_push($SpecIDobject->Ports,$tempRow['ID']);
      }
    }else{
      $SpecObject->USB2 = $temp[2];
      $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "USB 2.0", $temp[2], "", "");
      if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
        array_push($SpecIDobject->Ports,$tempRow['ID']);
      }
    }
  }

  if(preg_match('/HDMI/', $data, $temp)){
    $SpecObject->HDMI = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "HDMI", $SpecObject->HDMI, "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/VGA/', $data, $temp)){
    $SpecObject->VGA = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "VGA", $SpecObject->HDMI, "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/[mM]ini ?[Dd]isplay/', $data, $temp)){
    $SpecObject->MiniDisplay = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "MiniDisplay", $SpecObject->HDMI, "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/SD ([Mm]edia)? [Cc]ard/', $data, $temp)){
    $SpecObject->SDcard = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "SD Card Reader", $SpecObject->HDMI, "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/[mM][iI][nN][Ii] ?HDMI/', $data, $temp)){
    $SpecObject->SDcard = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "MiniHDMI", "1", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/[mM][iI][cC][Rr][oO] ?HDMI/', $data, $temp)){
    $SpecObject->SDcard = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "MicroHDMI", "1", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/Ethernet/', $data, $temp)){
    $SpecObject->SDcard = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "Ethernet", "1", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }

  if(preg_match('/[Dd]isplay ?[Pp]ort/', $data, $temp)){
    $SpecObject->SDcard = 1;
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Ports", "", "", "", "DisplayPort", "1", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Ports)){
      array_push($SpecIDobject->Ports,$tempRow['ID']);
    }
  }
  return false;
}

function matchKeyboard($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  if(preg_match('/[bB]acklit|[bB]acklight/', $data, $temp)){
    $tempRow = $DB->newSpecIfDoesntExistandGetID("Laptop_Keyboard", "", "", "", "", "Backlit Keyboard", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Misc)){
      array_push($SpecIDobject->Misc,$tempRow['ID']);
    }
    return true;
  }
  return false;
}

function matchFingerprint($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  if(preg_match('/[fF]ingerprint/', $data, $temp)){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Fingerprint", "", "", "", "","Fingerprint Censor", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Misc)){
      array_push($SpecIDobject->Misc,$tempRow['ID']);
    }
    return true;
  }
  return false;
}

function matchTouchScreen($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  if(preg_match('/[Tt]ouch ?[sS]creen/', $data, $temp)){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Screen_Misc", "", "", "", "","Touchscreen", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Misc)){
      array_push($SpecIDobject->Misc,$tempRow['ID']);
    }
    return true;
  }
  return false;
}

function matchTouchbar($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  if(preg_match('/[Tt]ouch ?[Bb]ar/', $data, $temp)){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Touchbar", "", "", "", "", "Presicion Touchbar", "", "");
    if(!in_array($tempRow['ID'],$SpecIDobject->Misc)){
      array_push($SpecIDobject->Misc,$tempRow['ID']);
    }
    return true;
  }
  return false;
}

function parseWithPartsOneByOne($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  $continue = false;
  if(!$continue){
    if($ShortChecklist->NameSeries ==false || $ShortChecklist->NameModelNum ==false){
        $continue =  matchName1($data);
    }
  }
  if(!$continue && !$ShortChecklist->RAM){
  $continue =  matchRam($data);
  }
  if(!$continue && !$ShortChecklist->Storage2){
  $continue =  matchStorage($data);
  }
  if(!$continue && !$ShortChecklist->ScreenRes){
  $continue =  matchScreenRes($data);
  }
  if(!$continue && !$ShortChecklist->ScreenSize){
  $continue =  matchScreenSize($data);
  }
  if(!$continue && !$ShortChecklist->Dimensions){
  $continue =  matchDimensions($data);
  }
  if(!$continue && !$ShortChecklist->Weight){
  $continue =  matchWeight($data);
  }
  if(!$continue && !$ShortChecklist->Wifi){
  $continue =  matchWifi($data);
  }
  if(!$continue && !$ShortChecklist->BT){
  $continue =  matchBT($data);
  }
  if(!$continue && !$ShortChecklist->Webcam){
  $continue =  matchWebcam($data);
  }
  if(!$continue && !$ShortChecklist->OS){
  $continue =  matchOS($data);
  }
  if(!$continue && !$ShortChecklist->BatteryLife){
  $continue =  matchBatteryLife($data);
  }
  if(!$continue && !$ShortChecklist->BatteryDetails){
  $continue =  matchBatteryDetails($data);
  }
  if(!$continue && !$ShortChecklist->CPU){
  $continue =  matchCPU($data);
  }
  if(!$continue && !$ShortChecklist->GPU){
  $continue =  matchGPU($data);
  }
  if(!$continue){
  $continue =  matchPorts($data);
  }
  if(!$continue){
  $continue =  matchKeyboard($data);
  }
  if(!$continue){
  $continue =  matchFingerprint($data);
  }
  if(!$continue){
  $continue =  matchTouchbar($data);
  }
  if(!$continue){
  $continue =  matchTouchScreen($data);
  }
  if(!$continue && !$ShortChecklist->Brand){
  $continue =  matchBrand($data);
  }
}

function parseWithPartsTitle($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  $continue = false;
  if(!$ShortChecklist->Brand){
  $continue =  matchBrand($data);
  }
  if(!$ShortChecklist->Name){
  $continue =  matchName2($data);
  }
  if(!$ShortChecklist->RAM){
  $continue =  matchRam($data);
  }
  if(!$ShortChecklist->Storage2){
  $continue =  matchStorage($data);
  }
  if(!$ShortChecklist->ScreenRes){
  $continue =  matchScreenRes($data);
  }
  if(!$ShortChecklist->ScreenSize){
  $continue =  matchScreenSize($data);
  }
  if(!$ShortChecklist->Dimensions){
  $continue =  matchDimensions($data);
  }
  if(!$ShortChecklist->Weight){
  $continue =  matchWeight($data);
  }
  if(!$ShortChecklist->Wifi){
  $continue =  matchWifi($data);
  }
  if(!$ShortChecklist->BT){
  $continue =  matchBT($data);
  }
  if(!$ShortChecklist->Webcam){
  $continue =  matchWebcam($data);
  }
  if(!$ShortChecklist->OS){
  $continue =  matchOS($data);
  }
  if(!$ShortChecklist->BatteryLife){
  $continue =  matchBatteryLife($data);
  }
  if(!$ShortChecklist->BatteryDetails){
  $continue =  matchBatteryDetails($data);
  }
  if(!$ShortChecklist->CPU){
  $continue =  matchCPU($data);
  }
  if(!$ShortChecklist->GPU){
  $continue =  matchGPU($data);
  }
  if(true){
  $continue =  matchPorts($data);
  }
  if(true){
  $continue =  matchKeyboard($data);
  }
  if(true){
  $continue =  matchFingerprint($data);
  }
  if(true){
  $continue =  matchTouchbar($data);
  }
  if(true){
  $continue =  matchTouchScreen($data);
  }
}

function parseWithPartsTogether($data){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  $continue = false;
  if(!$ShortChecklist->RAM){
  $continue =  matchRam($data);
  }
  if(!$ShortChecklist->Storage2){
  $continue =  matchStorage($data);
  }
  if(!$ShortChecklist->ScreenRes){
  $continue =  matchScreenRes($data);
  }
  if(!$ShortChecklist->ScreenSize){
  $continue =  matchScreenSize($data);
  }
  if(!$ShortChecklist->Dimensions){
  $continue =  matchDimensions($data);
  }
  if(!$ShortChecklist->Weight){
  $continue =  matchWeight($data);
  }
  if(!$ShortChecklist->Wifi){
  $continue =  matchWifi($data);
  }
  if(!$ShortChecklist->BT){
  $continue =  matchBT($data);
  }
  if(!$ShortChecklist->Webcam){
  $continue =  matchWebcam($data);
  }
  if(!$ShortChecklist->OS){
  $continue =  matchOS($data);
  }
  if(!$ShortChecklist->BatteryLife){
  $continue =  matchBatteryLife($data);
  }
  if(!$ShortChecklist->BatteryDetails){
  $continue =  matchBatteryDetails($data);
  }
  if(!$ShortChecklist->CPU){
  $continue =  matchCPU($data);
  }
  if(!$ShortChecklist->GPU){
  $continue =  matchGPU($data);
  }
  if(true){
  $continue =  matchPorts($data);
  }
  if(true){
  $continue =  matchKeyboard($data);
  }
  if(true){
  $continue =  matchFingerprint($data);
  }
  if(true){
  $continue =  matchTouchbar($data);
  }
  if(true){
  $continue =  matchTouchScreen($data);
  }
}


function ParseLaptop(){
  global $DB;
  global $SpecIDobject;
  global $ShortChecklist;
  global $SpecObject;
  global $title;
  global $data1;
  global $data2;
  global $data3;


  $titleExplode = [];
  for($i=0;$i<count($data3);$i++){
    parseWithPartsOneByOne($data3[$i]);
  }
  if(count($data2)>2){
    for($i=0;$i<count($data2);$i++){
      parseWithPartsOneByOne($data2[$i]);
    }

    $titleExplode = explode(",",$title);
    for($i=0;$i<count($titleExplode);$i++){
      parseWithPartsTitle($titleExplode[$i]);
    }

    for($i=0;$i<count($data1);$i++){
      parseWithPartsTogether($data1[$i]);
    }
  }else{
    $titleExplode = explode(",",$title);
    for($i=0;$i<count($titleExplode);$i++){
      parseWithPartsTitle($titleExplode[$i]);
    }

    for($i=0;$i<count($data1);$i++){
      parseWithPartsTogether($data1[$i]);
    }

    for($i=0;$i<count($data2);$i++){
      parseWithPartsTogether($data2[$i]);
    }
  }


  if($ShortChecklist->Wifi==true && $SpecIDobject->Communication == ""){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", $SpecObject->Wifi, $SpecObject->BT, $SpecObject->Webcam);
    $SpecIDobject->Communication = $tempRow['ID'];
  }else if($ShortChecklist->Wifi==false && $SpecIDobject->Communication == ""){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Communication", "", "", "", "", "802.11 AC", $SpecObject->BT, $SpecObject->Webcam);
    $SpecIDobject->Communication = $tempRow['ID'];
  }

  if($ShortChecklist->BatteryLife==true && $SpecIDobject->Battery == ""){
    $tempRow =$DB->newSpecIfDoesntExistandGetID("Laptop_Battery", "", $SpecObject->BatteryType, "", "", $SpecObject->BatteryLife, $SpecObject->BatteryWH, $SpecObject->BatteryCell);
    $SpecIDobject->Battery = $tempRow['ID'];
  }


  SpecIdToMaster();


}






?>
