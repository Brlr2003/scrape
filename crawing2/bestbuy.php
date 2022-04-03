<?php
require "Database.php" ;
include 'vendor/autoload.php';


// $end=320; for mid range


$DB = new dataBase();

use Goutte\Client;
$client = new Client();
// get html from URL
$crawler = $client->request('GET', 'https://www.bestbuy.com/site/laptop-computers/all-laptops/pcmcat138500050001.c?id=pcmcat138500050001');
// get all images on laravel.com
$skus = [];
$maxPage=40;
$maxPage = (int)$maxPage-1;
$all = $crawler->filter('li.sku-item')->each(function ($node, $i) {
  global $skus;
  echo $asin = $node->attr('data-sku-id');
  echo ("<br>");
  $ActualLink = $node->filter('.a-link-normal')->link();
  if($node->attr('data-sku-id')!="" && $node->attr('data-sku-id')!=" "){
    array_push($skus,$node->attr('data-sku-id'));
  }

    // global $num;
    // addtoInfo($node->text(), $num);
    // echo $node->text();
    // echo ("<br>");
});

$next=true;
// echo count($all);
$ii=0;
for($i=0;$i<$maxPage;$i++){

  sleep(rand(5,10));

  echo("Page: ".$i);
  $link = $crawler->filter('.sku-list-page-next')->link();

  $crawler = $client->click($link);

  $all = $crawler->filter('li.sku-item')->each(function ($node, $i) {
    global $skus;
    echo $asin = $node->attr('data-sku-id');
    echo ("<br>");
    if($node->attr('data-sku-id')!="" && $node->attr('data-sku-id')!=" "){
      array_push($skus,$node->attr('data-sku-id'));
    }

      // global $num;
      // addtoInfo($node->text(), $num);
      // echo $node->text();
      // echo ("<br>");
  });

}


for($i=0;$i<count($asins);$i++){
  $res = $DB->getPriceByCrawlink($asins[$i]);
  if($res == false || count($res)==0){
    echo $DB->newFakePrice(3, $skus[$i], 3);
  }

}



 ?>
