<!DOCTYPE html>
<html>
<head>
<link href='css/bootstrap.min.css' type='text/css' rel='stylesheet'>
<body>
<?php
	function f1()	{
		echo '1';
	}
	function f2()	{
		echo '2';
	}
	function f3()	{
		echo '3';
	}
	function f4()	{
		echo '4';
	}
	
	f1();
	f2();
	f3();
	f4();
	
	// for($m=1; $m<4; $m++)	{
		// f$m();
	// }
	
	echo "
		<button type='button' class='btn btn-danger' id='btn1'>Wow<button>
		<button type='button' class='btn btn-danger' id='btn1'>Yahoo<button>
		<button type='button' class='btn btn-danger' id='btn2'>Wow<button>
		<button type='button' class='btn btn-danger' id='btn2'>Yahoo<button>
	";
?>
</body>
</html>