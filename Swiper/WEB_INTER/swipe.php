<?php
	session_start();

	if(empty($_SESSION)||!isset($_SESSION['userId']))
		die("accessed page without registering");

	$conn=new mysqli('localhost', 'im', 'im', 'images');

	if($conn->connect_error)
		die("failed to connect");

	if(!empty($_POST)){
		$_SESSION['count']++;
		$bool=FALSE;

		$query="INSERT INTO swipes(userid, photoid, fileName, choice) VALUES(".$_SESSION['userId'].", ".$_SESSION['photoId'].", '".mysqli_real_escape_String($conn, $_SESSION['fileName'])."', ";

		if(isset($_POST['right'])){
			$bool=TRUE;
			$_SESSION['liked']++;
			$query.="1)";
		}else{
			$_SESSION['disliked']++;
			$query.="0)";
		}

		if($conn->query($query)===FALSE)
			echo "Error: ".$conn->error;
	}
	
	//$fileName="favicon.ico";
	//$query = "INSERT INTO faces(image) VALUES('".mysql_escape_string(file_get_contents($fileName))."')";

	//if($conn->query($query)===FALSE)
	//	echo "Error: ".$conn->error;

	if($_SESSION['genderDB']==='femalefaces')
		$maxId=282;
	else
		$maxId=96;

	$select=rand(1, $maxId);

	$query = "SELECT * FROM ".$_SESSION['genderDB']." WHERE id=".$select;

	$result = $conn->query($query);

	if($result&&$result->num_rows > 0){

		while($row=$result->fetch_assoc()){
			$_SESSION['photoId']=$row['id'];
			$_SESSION['fileName']=$row['name'];
			$im=" <img class='profile' src='data:image/jpeg;base64,".base64_encode($row['image'])."'><br>";
		}
	}

	$conn->close();
?>

<html>

<style>
	html, body{
		position: absolute;
		height: 100%;
		width: 100%;
		margin: auto;
		text-align: center;
		background-color: #555555;
	}

	form{
		position: relative;
		display: table;
		margin: auto;
	}

	.profile{
		width: 100%;
		height: 100%;
	}

	.centered{
		position: relative;
		height: 500px;
		margin: auto;
		display: table;
		border: solid 1px black;
		background-color: white;
	}

	.subBut{
		background-color: #3399ff;
		padding: 8px 15px 10px;
		font-size: 21px;
		font-weight: bold;
		text-shadow: 1px 1px #3399ff;
		color: white;
		border: 1px solid #3399ff;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
	}

	.left{
		background-color: red;
	}

	.right{
		margin-left: 40px;
		background-color: green;
	}

	.checked{
		font-weight: bold;
		color: #1A75FF;
	}

	.liked{
		font-weight: bold;
		color: #00CC00;
	}

	.disliked{
		font-weight: bold;
		color: #FF1A1A;
	}

	#container{
		width: 30%;
		position: relative;
		background-color: #DEDEDE;
		margin: auto;
		margin-top: 20px;
		border: solid 2px black;
		border-radius: 10px;
	}

	#stats{
		padding-left: 5px;
		position: relative;
		display: inline-block;
	}

</style>

<body>
	<div id="container">

		<br>

		<div class="centered">
			<?php echo $im; ?>
		</div>

		<br>

		<form method="POST" action="">
			<input class="subBut left" type='submit' name='left' value='left'>
			<input class="subBut right" type='submit' name='right' value='right'>
		</form>

		<div id="stats">
			<h3 class="checked"> checked: 
				<?php echo $_SESSION['count']; ?>
			</h3>
			<h3 class="liked"> liked: 
				<?php echo $_SESSION['liked']; ?>
			</h3>
			<h3 class="disliked"> disliked: 
				<?php echo $_SESSION['disliked']; ?>
			</h3>
		</div>

	</div>
	<br>
	<a href="/web/soc/survey.php">
		<button class="subBut">Exit</button>
	</a>
</body>

</html>