<?php
foreach($query1 as $row){
	echo $row->pro_id."<br>";
	echo $row->pro_code."<br>";
	echo $row->pro_name."<br>";
	echo $row->pro_price."<br>";
	echo $row->pro_qtn."<br>";
	echo $row->pro_max."<br>";
	echo $row->pro_min."<br>";
} /*end foreach query*/
echo"<br><br>"; 
foreach($query2 as $row){
	echo $row->pro_id."<br>";
	echo $row->pro_code."<br>";
	echo $row->pro_name."<br>";
	echo $row->pro_price."<br>";
	echo $row->pro_qtn."<br>";
	echo $row->pro_max."<br>";
	echo $row->pro_min."<br>";
}
