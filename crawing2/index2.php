<?php
require "Database.php" ;
include 'vendor/autoload.php';


// $end=320; for mid range


$DB = new dataBase();

use Goutte\Client;
$client = new Client();
// get html from URL
$crawler = $client->request('GET', 'https://www.videocardbenchmark.net/midlow_range_gpus.html');
// get all images on laravel.com


$all = $crawler->filter('.chartlist > li');

echo count($all);

$info=[];
$points=[];

$num=0;
$end=1026;
// die;
for($i=700;$i<$end;$i++){
  // sleep(rand(5,15));
  global $info;
  $info[$num]=[];
  $crawler = $client->request('GET', 'https://www.videocardbenchmark.net/midlow_range_gpus.html');

  $link = $crawler->filter('.chartlist > li > a')->eq($i)->link();

  $crawler = $client->click($link);


  $crawler->filter('.bg-table-row')->each(function ($node, $i) {
      global $num;
      addtoInfo($node->text(), $num);
      echo $num;
  });

  $crawler->filter('div.right-desc > span')->each(function ($node) {
      addtoPoints($node->text());
  });
  global $num;
  $num=$num+1;
  if($i==$end-1){
    enterDB();
  }
}

function addtoInfo($add,$i){
  global $info;
  array_push($info[$i],$add);
}

function addtoPoints($add){
  global $points;
  array_push($points,$add);
}

function enterDB(){
  global $num;
  global $info;
  global $points;
  global $DB;

  $spec = (object) [
    'specName'=>"",
    'points'=>"",
    'brand'=> "",
    'family'=> "",
    'model'=> "",
    'spec1'=> "",
    'spec2'=>"",
    'spec3'=> ""
  ];

  $specs=[];

  $temp=[];
  $temp1=[];
  $temp2=[];
  $temp3="";

  echo $num."is The Num   ";


  for($i=0;$i<$num;$i++){
    $dual=false;
    $isBrand=false;

    $spec = (object) [
      'specName'=>"Laptop_Graphics",
      'points'=>"",
      'brand'=> "",
      'family'=> "",
      'model'=> "",
      'spec1'=> "",
      'spec2'=>"",
      'spec3'=> "",
      'specLink'=> ""
    ];

    foreach($info[$i] as $specinfo){
      // echo ($specinfo."<br>");
      $before=true;
      $b=false;
      $b2=false;
      if(strpos($specinfo, 'Memory Size')!== false){
        preg_match('/Memory Size: (\d*) MB/', $specinfo, $temp);
        $spec->spec3 = floor($temp[1]/1000);
      }else if(strpos($specinfo, 'names')){
        preg_match('/Other names: (.*)/', $specinfo, $temp);
        $temp1= explode(",",$temp[1]);
        $temp2= explode(" ",$temp1[0]);
        foreach($temp2 as $word){
          if(strpos($word, "NVIDIA")!== false || $word=='NVIDIA'){
            $spec->family = 'Dedicated';
            $spec->brand = 'Nvidia';
            $isBrand=true;
          }
          else if(strpos($word, "Intel")!== false|| $word=='Intel'){
            $spec->family = 'Integrated';
            $spec->brand = 'Intel';
            $isBrand=true;
          }
          else if(strpos($word, "AMD")!== false|| $word=='AMD'){
            $spec->family = 'Dedicated';
            $spec->brand = 'AMD';
            $isBrand=true;
          }
          else if(strpos($word, "ATI")!== false|| $word=='ATI'){
            $spec->family = 'Dedicated';
            $spec->brand = 'ATI';
            $isBrand=true;
          }
          else if(preg_match('/(\d{3,}\w?)/', $word, $temp3)){
            if($before){
              $spec->model = $temp3[1];
            }else{
              $dual=true;
            }
            $before=false;
          }
          else if(strpos($word, 'GeForce')!== false|| $word=='GeForce'){
            $spec->specLink = $word;
          }
          else if(strpos($word, 'Dual')!== false|| $word=='Dual'){
            $dual=true;
          }
          else{
            if($before){
              if($b){
                $spec->spec1 = $spec->spec1." ";
              }
              $spec->spec1 = $spec->spec1.$word;
              $b=true;
            }else{
              if($b2){
                $spec->spec2 = $spec->spec2." ";
              }
              $spec->spec2 = $spec->spec2.$word;
              $b2=true;
            }
          }
          if(strpos($word, 'HD')!== false|| $word=='HD'){
            $spec->family = 'Integrated';
          }

          if(strpos($word, 'Radeon')!== false|| $word=='Radeon'){
            $spec->brand = 'AMD';
            $isBrand=true;
          }
        }
      }else if(strpos($specinfo, 'Integrated')!== false){
        $spec->brand = 'AMD';
        $isBrand=true;
      }
    }
    $spec->points=$points[$i];

    $spec->spec1 = str_replace(" (TM)","",$spec->spec1);
    $spec->spec1 = str_replace(" (tm)","",$spec->spec1);
    $spec->spec1 = str_replace("(TM)","",$spec->spec1);
    $spec->spec1 = str_replace("(tm)","",$spec->spec1);

    $specs[$i]=$spec;

    // var_dump($spec);
    // echo("<br>");

    if($dual){echo("Dual<br>");}
    else if(!$isBrand){echo("NoBrand<br>");}

    if(!$dual && $isBrand){
      echo $DB->newSpecIfDoesntExistandGetID($spec->specName, $spec->points, $spec->brand, $spec->family, $spec->model, $spec->spec1, $spec->spec2, $spec->spec3, $spec->specLink);
      echo("$i<br>");
    }

  }

}



 ?>
