<?php 


controller("Wedding");
$wedding = new Wedding();

controller("Payment");
$payment = new Payment();

controller("Gallery");
$gallery = new Gallery();

function getImgURL($name){
  $gallery = new Gallery();
  $row=$gallery->getGalleryImg($_REQUEST['id'],$name);
  
  if($row['imageURL']){
    return $row['imageURL'];
  }
  else{
    return false;
  }
  
}



// define array to track progress
$hostsMissing=array();
$ourstoryMissing=array();
$basicDeatilsMissing=array();
$eventsMissing=array();
$themeMissing=array();
$paymentMissing=array();

array_push($hostsMissing,array("path"=>"hosts"));
array_push($ourstoryMissing,array("path"=>"our-story"));

array_push($basicDeatilsMissing,array("path"=>"basic-details"));
array_push($eventsMissing,array("path"=>"timeline"));
array_push($themeMissing,array("path"=>"theme"));
array_push($paymentMissing, array("path"=>"checkout"));


$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$hosts = json_decode($weddingData['hosts'], true);
$story = json_decode($weddingData['story'], true);

$isPaymentDone = $payment->checkPaymentExists($weddingData['host'],$_REQUEST['id'],$_REQUEST['lang']);

$timeline = array();
$timeline = json_decode($weddingData['timeline'], true);

if($weddingData['error'] || $weddingData['timeline'] == '' ){
  $timeline = array();
}

if(sizeof($timeline)<1){
    array_push($eventsMissing, "At least one event required!" );
}

if($weddingData['groomName']==''){
    array_push($basicDeatilsMissing,"Groom name");
}
if($weddingData['brideName']==''){
    array_push($basicDeatilsMissing,"Bride name");
}
if(!getImgURL("bride")){
  array_push($basicDeatilsMissing,"Bride Photo");
}
if(!getImgURL("groom")){
  array_push($basicDeatilsMissing,"Groom Photo");
}
if($weddingData['fromRole']==''){
    array_push($basicDeatilsMissing,"From role");
}
if($weddingData['lang']==''){
    array_push($basicDeatilsMissing,"Language");
}
if($weddingData['weddingName']==''){
    array_push($basicDeatilsMissing,"Wedding Name");
}

if($weddingData['template']==''){
    array_push($themeMissing, "Theme not selected!");
}

if($hosts['brideFather']['name']==''){
    array_push($hostsMissing,"Bride Father");
}
if($hosts['groomFather']['name']==''){
    array_push($hostsMissing,"Groom Father");
}
if($hosts['brideMother']['name']==''){
    array_push($hostsMissing,"Bride Mother");
}
if($hosts['groomMother']['name']==''){
    array_push($hostsMissing,"Groom Mother");
}
if($hosts['brideTagline']==''){
    array_push($hostsMissing,"Bride Tagline");
}
if($hosts['groomTagline']==''){
    array_push($hostsMissing,"Groom Tagline");
}


if($story['display'] == 'true'){

  if($story['howWeMet']==''){
      array_push($ourstoryMissing,"How We Met");
  }
  if($story['whenWeMet']==''){
      array_push($ourstoryMissing,"When We Met");
  }
  if($story['engagement']==''){
      array_push($ourstoryMissing,"Engagement");
  }
  if($story['engagementYear']==''){
      array_push($ourstoryMissing,"Engagement Year");
  }
  if($story['memorableMoments']==''){
      array_push($ourstoryMissing,"Memorable Moments");
  }

}

$tracks=array("Basic Details"=>$basicDeatilsMissing,"Hosts"=>$hostsMissing,"Events"=>$eventsMissing,
    "Our Story"=>$ourstoryMissing,"Theme"=>$themeMissing);


$completed=0;

foreach ($tracks as $key => $value) {

    if(count($value)==1){
        $completed++;
    }
}

// $tracks["Payment"]=$paymentMissing;

// if other tasks has been completed then only enable payment 
if($completed == (sizeof($tracks)-1) ){
  if($isPaymentDone){
    $completed++;
  }else{
    array_push($paymentMissing,"Proceed to Payment!");
  }
}else{
   array_push($paymentMissing,"Complete necessary tracks!");
}
// $tracks["Payment"]=$paymentMissing;
$trackPercent=($completed/sizeof($tracks))*100;

?>



