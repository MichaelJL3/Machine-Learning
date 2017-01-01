<?php
session_start();

if(empty($_SESSION)||!isset($_SESSION['userId']))
	die("accessed page without registering");

$conn=new mysqli('localhost', 'im', 'im', 'images');

if(!empty($_POST)){
	$query="INSERT INTO survey(`userId`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`) VALUES('".$_SESSION['userId']."', '".mysqli_real_escape_string($conn, $_POST['1'])."', '".mysqli_real_escape_string($conn, $_POST['2'])."', '".mysqli_real_escape_string($conn, $_POST['3'])."', '".mysqli_real_escape_string($conn, $_POST['4'])."', '".mysqli_real_escape_string($conn, $_POST['5'])."', '".mysqli_real_escape_string($conn, $_POST['6'])."', '".mysqli_real_escape_string($conn, $_POST['7'])."', '".mysqli_real_escape_string($conn, $_POST['8'])."')";

	if($conn->query($query)===FALSE)
		echo "Error: ".$conn->error;

	header('Location: destroy.php');
}
?>

<html>

<style>
	html, body{
		position: absolute;
		height: 100%;
		width: 100%;
		margin: auto;
		background-color: #555555;
	}

	form{
		position: relative;
		display: table;
		text-align: left;
	}

	.subBut{
		margin-top: 15px;
		background-color: #3399ff;
		padding: 8px 15px 10px;
		font-size: 21px;
		font-weight: bold;
		text-shadow: 1px 1px #3399ff;
		color: white;
		border: 1px solid #3399ff;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
	}

	.txtBox{
		height: 100px;
		width: 90%;
	}

	input{
		margin-top: 5px;
		margin-bottom: 5px;
	}

	#container{
		width: 50%;
		position: relative;
		background-color: #DEDEDE;
		margin: auto;
		margin-top: 20px;
		border: solid 2px black;
		border-radius: 10px;
	}

	h1{
		text-align: center;
		color: #3399FF;
	}

</style>

<body>
	<div id="container">
		<h1>EXIT SURVEY</h1>
		<form method="POST" action="survey.php">
			<ol>
			
			<li>Have you used tinder before?</li>
			<input type="radio" name="1" value="1" checked="checked"> Y
  			<input type="radio" name="1" value="0"> N <br>
			
			<li>Do you still use tinder?</li>
			<input type="radio" name="2" value="1" checked="checked"> Y
  			<input type="radio" name="2" value="0"> N <br>
			
			<li>When was the last time you used it?</li><br>
			<input class="txtBox" type="text" name="3"><br>
			
			<li>On average how long do you use the app?</li><br>
			<input class="txtBox" type="text" name="4"><br>
			
			<li>If you stopped using the app why did you stop?</li><br>
			<input class="txtBox" type="text" name="5"><br>
			
			<li>Would you prefer a system designed to set you up with more right swipes?</li>
			<input type="radio" name="6" value="1" checked="checked"> Y
  			<input type="radio" name="6" value="0"> N <br>
			
			<li>Do you get bored using the app from frequent left swiping?</li>
			<input type="radio" name="7" value="1" checked="checked"> Y
  			<input type="radio" name="7" value="0"> N <br>
			
			<li>Would a system like this encourage you to use it more often?</li>
			<input type="radio" name="8" value="1" checked="checked"> Y
  			<input type="radio" name="8" value="0"> N <br>

			<input class="subBut" name="sub" type="submit" value="Submit Survey">
			</ol>
		</form>
	</div>
</body>

</html>