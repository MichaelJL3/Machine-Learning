<?php
	session_start();
	
	if(!isset($_SESSION['count'])){
		$_SESSION['count']=0;
		$_SESSION['liked']=0;
		$_SESSION['disliked']=0;
	}

	$err="";

	if(!empty($_POST)){
		if(sizeof($_POST)===5){
			$conn=new mysqli('localhost', 'im', 'im', 'images');

			if($conn->connect_error)
				die("failed to connect");

			$first=mysqli_escape_string($conn, $_POST['first']);
			$last=mysqli_escape_string($conn, $_POST['last']);
			$gender=$_POST['gender'];
			$age=$_POST['age'];

			if($age>15&&$age<50){
				$query="INSERT INTO users(first, last, age, gender) VALUES('".$first."', '".$last."', ".$age.", ".$gender.")";

				if($conn->query($query)===FALSE){
					$err="Error: ".$conn->error;
					$conn->close();
				}
				else{
					$_SESSION['userId']=$conn->insert_id;
					$_SESSION['genderDB']=($gender? "malefaces": "femalefaces");
					$conn->close();
					header("Location: /web/soc/swipe.php");
					exit();
				}
			}
			else
				$err="ERR: Age must be between 15-50";
		}

		else
			$err="ERR: Not all fields entered";
	}
?>

<!DOCTYPE html>

<style>
	html, body{
		width: 100%;
		height: 100%;
		text-align: center;
		background-color: #454545;
	}

	h1{
		color: #3399ff;
		font-size: 50px;
	}

	h2{
		color: #11EE11;
		font-size: 30px;
	}

	h4{
		color: red;
	}

	ul{
		list-style-position: inside;
	}

	.inp{
		margin-top: 10px;
		padding: 10px;
	}

	.numText{
		margin-top: 10px;
		padding: 10px;
	}

	.radBut{
		color: #00FF00;
	}

	.subBut{
		width: 150px;
		background-color: #3399ff;
		padding: 8px 15px 10px;
		font-size: 21px;
		font-weight: bold;
		text-shadow: 1px 1px #3399ff;
		color: white;
		border: 1px solid #3399ff;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
	}

	#container{
		margin-top: 100px;
		height: 100%;
	}
</style>

<html>
	<body>
		<div id="container">
			<h1>
				Machine Trainer
			</h1>
			<h2>
				register
			</h2>
			<h4>
				<?php if($err) echo $err; ?>
			</h4>
			<br>
			<form method="POST" action="">
				<input class="inp" type="text" name="first" placeholder="first name">
				<br>
				<input class="inp" type="text" name="last" placeholder="last name">
				<br>
				<input class="numText" type="number" name="age" placeholder="age">
				<br>
				<input class="inp" type="radio" name="gender" value="0">
					<but class="radBut">Male</but>
				<input class="inp" type="radio" name="gender" value="1">
					<but class="radBut">Female</but>
				<br>
				<br>
				<input class="subBut inp" type="submit" name="submit" value="submit">
			</form>
		</div>
	</body>
</html>