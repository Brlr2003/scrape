<?php
require "Database.php" ;
include 'vendor/autoload.php';


// $end=320; for mid range


$DB = new dataBase();

use Goutte\Client;
$client = new Client();
// get html from URL
$crawler = $client->request('GET', 'https://www.amazon.com/s?k=laptop&i=electronics&s=price-desc-rank&qid=1592328313&ref=sr_pg_1');
// get all images on laravel.com
$asins = [];
$maxPage=0;
echo $maxPage = $crawler->filter('li.a-disabled')->eq(1)->text();
$maxPage = (int)$maxPage-1;
$all = $crawler->filter('.s-result-list > div')->each(function ($node, $i) {
  global $asins;
  echo $asin = $node->attr('data-asin');
  echo ("<br>");
  if($node->attr('data-asin')!="" && $node->attr('data-asin')!=" "){
    array_push($asins,$node->attr('data-asin'));
  }

    // global $num;
    // addtoInfo($node->text(), $num);
    // echo $node->text();
    // echo ("<br>");
});

$next=true;
// echo count($all);
$ii=0;

$ClickList = [];
for($i=0;$i<$maxPage;$i++){

  sleep(rand(5,10));

  echo("Page: ".$i);
  $link = $crawler->filter('.a-last > a')->link();

  $crawler = $client->click($link);

  $all = $crawler->filter('.s-result-list > div')->each(function ($node, $i) {
    global $asins;
    global $LinkList;
    echo $node->attr('data-asin');
    echo ("<br>");
    if($node->attr('data-asin')!="" && $node->attr('data-asin')!=" "){
      array_push($LinkList,"https://www.amazon.com" . $node->filter('.a-link-normal')->attr('href'));
      array_push($asins,$node->attr('data-asin'));
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
    echo $DB->newFakePrice(1, $asins[$i], 3);
  }else{
    echo $DB->changeFullPriceByPriceID($res['ID'], $res['ProductID'], $res['SellerID'], $res['Price'], $LinkList[$i], $asins[$i], $res['ItemCondition'], 'dollar', 4);
  }

}



 ?>
