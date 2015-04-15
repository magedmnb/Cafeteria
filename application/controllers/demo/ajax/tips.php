<?php

define('INCLUDE_CHECK',1);
require "../connect.php";

if(!$_POST['img']) die("There is no such product!");

$img=(explode('/',$_POST['img']));
echo $img[2];
$row=mysql_fetch_assoc(mysql_query("SELECT * FROM product WHERE img='".$img[2]."'"));

if(!$row) die("There is no such product!");

echo '<strong>'.$row['pro_name'].'</strong>

<p class="descr">'.$row['pro_desc'].'</p>

<strong>price: $'.$row['pro_price'].'</strong>
<small>Drag it to your shopping cart to purchase it</small>';
?>
