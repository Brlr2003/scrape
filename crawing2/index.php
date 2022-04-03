<?php
require "Database.php" ;
include 'vendor/autoload.php';


// $end=320; for mid range


$DB = new dataBase();

use Goutte\Client;
$client = new Client();
// get html from URL
$crawler = $client->request('GET', 'https://www.cpubenchmark.net/laptop.html');
// get all images on laravel.com

echo "HI";
die;
$all = $crawler->filter('.chartlist > li');

echo count($all);

$info=[];
$points=[];

$num=0;
$end=573;
// die;
for($i=500;$i<$end;$i++){
  global $info;
  $info[$num]=[];
  $crawler = $client->request('GET', 'https://www.cpubenchmark.net/laptop.html');

  $link = $crawler->filter('.chartlist > li > a')->eq($i)->link();

  $crawler = $client->click($link);


  $crawler->filter('.left-desc-cpu > p')->each(function ($node, $i) {
      global $num;
      addtoInfo($node->text(), $num);
      // echo $node->text();
      // echo ("<br>");
  });

  $crawler->filter('.desc-foot > p')->each(function ($node, $i) {
      global $num;
      addtoInfo($node->text(), $num);
      // echo $node->text();
      // echo ("<br>");
  });

  $pointA = $crawler->filter('div.right-desc > span')->eq(0)->text();
  addtoPoints($pointA);

  // $crawler->filter('div.right-desc > span')->each(function ($node) {
  //     addtoPoints($node->text());
  //     echo $node->text();
  //     echo ("<br>");
  // });
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
      'specName'=>"Laptop_CPU",
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


      if(strpos($specinfo, 'Class')!== false){
        if(strpos($specinfo, 'Server')!== false){
          $dual=true;
        }
      }
      else if(strpos($specinfo, 'Turbo Speed')!== false){
        preg_match('/Turbo Speed: (.*) GHz/', $specinfo, $temp);
        $spec->spec3 = $temp[1];
      }
      else if(strpos($specinfo, 'Clockspeed')!== false){
        preg_match('/Clockspeed: (.*) GHz/', $specinfo, $temp);
        $spec->spec1 = $temp[1];
      }
      else if(strpos($specinfo, 'Cores:')!== false){
        preg_match('/Cores: (\d+)/', $specinfo, $temp);
        // echo (" " . $specinfo);
        $spec->spec2 = $temp[1];
      }
      if(strpos($specinfo, 'names:')){
        preg_match('/Other names: (.*)/', $specinfo, $temp);
        $temp1= explode(",",$temp[1]);
        $temp2= explode(" ",$temp1[0]);
        foreach($temp2 as $word){
          if(strpos($word, "Intel")!== false|| $word=='Intel'){
            $spec->brand = 'Intel';
            $isBrand=true;
          }
          else if(strpos($word, "AMD")!== false|| $word=='AMD'){
            $spec->brand = 'AMD';
            $isBrand=true;
          }
          else if(preg_match('/(.*)-(\d{3,}\w*)/', $word, $temp3)){
            if($before){
              $spec->model = $temp3[2];
              if($b){
                $spec->family = $spec->family." ";
              }
              $spec->family = $spec->family.$temp3[1];
            }else{
              $dual=true;
            }
            $before=false;
          }
          else if(preg_match('/(\d{3,}\w*)/', $word, $temp3)){
            if($before){
              $spec->model = $temp3[1];
            }else{
              $dual=true;
            }
            $before=false;
          }else if(strpos($word, "CPU")!== false|| $word=='CPU'){

          }
          else{
            if($before){
              if($b){
                $spec->family = $spec->family." ";
              }
              $word = preg_replace('/\((.*)\)/', '$3', $word);
              $spec->family = $spec->family.$word;
              $b=true;
            }
          }
        }
      }
    }
    $spec->points=$points[$i];


      $specs[$i]=$spec;

      // var_dump($spec);
      // echo("<br>");

      if($dual){echo("Dual or Server<br>");}
      else if(!$isBrand){echo("NoBrand<br>");}

      if(!$dual && $isBrand){
        // var_dump($spec);
        // echo("<br>");
        echo $DB->newSpecIfDoesntExistandGetID($spec->specName, $spec->points, $spec->brand, $spec->family, $spec->model, $spec->spec1, $spec->spec2, $spec->spec3, $spec->specLink);
        echo("$i<br>");
      }

    }

  }



 ?>
