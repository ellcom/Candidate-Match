Q{$questionID}: {$questionText}
<br><br>
	<input type="radio" name="A{$questionID}" value="1" onclick="document.getElementById('radio_info').innerHTML = '1';">Strongly Disagree
	<input type="radio" name="A{$questionID}" value="2" onclick="document.getElementById('radio_info').innerHTML = '2';">Disagree
	<input type="radio" name="A{$questionID}" value="3" onclick="document.getElementById('radio_info').innerHTML = '3';">No Opinion
	<input type="radio" name="A{$questionID}" value="4" onclick="document.getElementById('radio_info').innerHTML = '4';">Agree
	<input type="radio" name="A{$questionID}" value="5" onclick="document.getElementById('radio_info').innerHTML = '5';">Strongly Agree<br>
	<span style=color:red ID="radio_info"></span>
<br><br>