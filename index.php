<?php
include 'base.php';

$user = $facebook->getUser();


function online_friends_all(){
  global  $facebook,$user;
  
 $fql = "SELECT name,uid,online_presence FROM user WHERE online_presence IN ('active', 'idle') AND uid IN ( SELECT uid2 FROM friend WHERE uid1 = $user)";
   
 $result = $facebook->api(array(
          'method' => 'fql.query',
          'query' => $fql,
      ));

return $result;
}


function online_friends_active(){
  global  $facebook,$user;
  
 $fql = "SELECT name,uid,online_presence FROM user WHERE online_presence IN ('active') AND uid IN ( SELECT uid2 FROM friend WHERE uid1 = $user)";
   
 $result = $facebook->api(array(
          'method' => 'fql.query',
          'query' => $fql,
      ));

return $result;
}


function online_friends_idle(){
  global  $facebook,$user;
  
 $fql = "SELECT name,uid,online_presence FROM user WHERE online_presence IN ('idle') AND uid IN ( SELECT uid2 FROM friend WHERE uid1 = $user)";
   
 $result = $facebook->api(array(
          'method' => 'fql.query',
          'query' => $fql,
      ));

return $result;
}


//$a = online_friends_idle();

//var_dump($a);
//var_dump($friends);

$user_profile = $facebook->api('/me');

?>

<!doctype html>
 
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Online Arkadaşlarım</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
  <!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
  font-family: verdana,arial,sans-serif;
  font-size:11px;
  color:#333333;
  border-width: 1px;
  border-color: #666666;
  border-collapse: collapse;
}
table.gridtable th {
  border-width: 1px;
  padding: 8px;
  border-style: solid;
  border-color: #666666;
  background-color: #dedede;
}
table.gridtable td {
  border-width: 1px;
  padding: 8px;
  border-style: solid;
  border-color: #666666;
  background-color: #ffffff;
}
</style>
</head>
<body>

<div style="width:700px">
  <div style="width:180px; float:left;">
    <img src="http://graph.facebook.com/<?php echo $user; ?>/picture?type=large" />
    <br>
    <div style="width:180px;">
    <font style="color:red; font-size:13px;">Naber la</font> 
    <font style="font-size:14px;" ><?php echo $user_profile['first_name']; ?> ?</font>
    </div>
  </div>
<div style="width:515px; float:right;">
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Online Olanlar</a></li>
    <li><a href="#tabs-2">Çevrimdışı Görünenler</a></li>
    <li><a href="#tabs-3">Hepsi</a></li>
  </ul>
  <div id="tabs-1">

    <!-- Table goes in the document BODY -->
  <table class="gridtable" style="width:100%">
    <tr>
      <th>Foto</th><th>Ad / Soyad</th><th>Durum</th>
    </tr>
    <?php
    $hepsi = online_friends_active();
    foreach ($hepsi as $uye) {
    //var_dump($hepsi);
    ?>
    <tr>
      <td><img src="http://graph.facebook.com/<?php echo $uye['uid']; ?>/picture" /></td>
      <td><a href="http://facebook.com/<?php echo $uye['uid']; ?>"><?php echo $uye['name']; ?></a></td>
      <td><?php echo $uye['online_presence']; ?></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  <div id="tabs-2">
   <!-- Table goes in the document BODY -->
  <table class="gridtable" style="width:100%">
    <tr>
      <th>Foto</th><th>Ad / Soyad</th><th>Durum</th>
    </tr>
    <?php
    $hepsi = online_friends_idle();
    foreach ($hepsi as $uye) {
    //var_dump($hepsi);
    ?>
    <tr>
      <td><img src="http://graph.facebook.com/<?php echo $uye['uid']; ?>/picture" /></td>
      <td><a href="http://facebook.com/<?php echo $uye['uid']; ?>"><?php echo $uye['name']; ?></a></td>
      <td><?php echo $uye['online_presence']; ?></td>
    </tr>
    <?php } ?>
  </table>
   </div>
  <div id="tabs-3">
  <!-- Table goes in the document BODY -->
  <table class="gridtable" style="width:100%">
    <tr>
      <th>Foto</th><th>Ad / Soyad</th><th>Durum</th>
    </tr>
    <?php
    $hepsi = online_friends_all();
    foreach ($hepsi as $uye) {
    //var_dump($hepsi);
    ?>
    <tr>
      <td><img src="http://graph.facebook.com/<?php echo $uye['uid']; ?>/picture" /></td>
      <td><a href="http://facebook.com/<?php echo $uye['uid']; ?>"><?php echo $uye['name']; ?></a></td>
      <td><?php echo $uye['online_presence']; ?></td>
    </tr>
    <?php } ?>
  </table>
</div>
</div>
<p>Sorun mu var? <a href="http://www.facebook.com/messages/100003014333692">Hemen mesaj yaz!</a></p> 
</div>

</div> 

</body>
</html>
