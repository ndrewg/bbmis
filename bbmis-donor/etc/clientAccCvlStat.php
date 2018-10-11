<?php
	if($varCvlStat == "Single")	{
		echo "<option value='Single' selected='selected'>Single</option>
					<option value='Married'>Married</option>
					<option value='Divorced'>Divorced</option>
					<option value='Separated'>Separated</option>
					<option value='Widowed'>Widowed</option>";
	}
	else if($varCvlStat == "Married")	{
		echo "<option value='Single'>Single</option>
					<option value='Married' selected='selected'>Married</option>
					<option value='Divorced'>Divorced</option>
					<option value='Separated'>Separated</option>
					<option value='Widowed'>Widowed</option>";
	}
	else if($varCvlStat == "Divorced")	{
		echo "<option value='Single'>Single</option>
					<option value='Married'>Married</option>
					<option value='Divorced'selected='selected'>Divorced</option>
					<option value='Separated'>Separated</option>
					<option value='Widowed'>Widowed</option>";
	}
	else if($varCvlStat == "Separated")	{
		echo "<option value='Single'>Single</option>
					<option value='Married'>Married</option>
					<option value='Divorced'>Divorced</option>
					<option value='Separated' selected='selected'>Separated</option>
					<option value='Widowed'>Widowed</option>";
	}
	else if($varCvlStat == "Widowed")	{
		echo "<option value='Single'>Single</option>
					<option value='Married'>Married</option>
					<option value='Divorced'>Divorced</option>
					<option value='Separated'>Separated</option>
					<option value='Widowed' selected='selected'>Widowed</option>";
	}
?>
