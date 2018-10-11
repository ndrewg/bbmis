<!DOCTYPE html>
<html>
	<body>
	<style>
		
	</style>
	<script>
		function imgEnlarge()	{
			document.getElementById("dude").style.display = "none";
		}
		
		function imgShrink()	{
			document.getElementById("dude").style.width = "300px";
		}
	</script>
	<?php
		$br = "<br>";
		$varFt = round(155 / 30.48);
		echo $varFt;
		echo $br;
		$varIn = round((155 - ($varFt * 30.48)), 0);
		echo $varIn;
		echo $br;
		$varDec = "1.1.9";
		echo ++$varDec;
	?>
	<img src='../images/profileImg/chandler.png' id='dude' onmouseover="imgEnlarge()" onmouseout="imgShrink()"/>
	</body>
</html>

echo "<script type='text/javascript'>window.location.href = 'home.php'</script>";