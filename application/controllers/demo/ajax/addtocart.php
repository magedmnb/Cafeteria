<?php

define('INCLUDE_CHECK',1);
require "../connect.php";

if(!$_POST['img']) die("There is no such product!");

$img=(explode('/',$_POST['img']));
$row=mysql_fetch_assoc(mysql_query("SELECT * FROM product WHERE img='".$img[2]."'"));

echo json_encode(array(
	'status' => 1,
	'id' => $row['pro_id'],
	'price' => (float)$row['pro_price'],
	'txt' => '<table width="100%" id="table_'.$row['pro_id'].'">
  <tr>
    <td width="60%">'.$row['pro_name'].'</td>
    <td width="10%">$'.$row['pro_price'].'</td>
    <td width="15%"><select name="'.$row['pro_id'].'_cnt" id="'.$row['pro_id'].'_cnt" onchange="change('.$row['pro_id'].');">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option></slect>
	
	</td>
	<td width="15%"><a href="#" onclick="window.remove('.$row['pro_id'].');return false;" class="remove">remove</a></td>
  </tr>
</table>'
));

?>
