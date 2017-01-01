<?php
	
	$conn=new mysqli('localhost', 'im', 'im', 'images');

	if($conn->connect_error)
		die("failed to connect");

	$Mdir='Men';
	$Fdir='Women';

	$Mfiles=scandir($Mdir);
	$Ffiles=scandir($Fdir);

	//print_r($Mfiles);
	//print_r($Ffiles);
	
	/*$size=sizeof($Mfiles);
	for($i=2; $i<$size; $i++){
		$name=$Mfiles[$i];
		$image=file_get_contents($Mdir.'/'.$name);
		$query="INSERT INTO malefaces(image, name) VALUES ('".mysqli_real_escape_string($conn, $image)."', '".mysqli_real_escape_string($conn, $name)."')";
		
		if($conn->query($query)===FALSE)
			echo "Error: ".$conn->error."\n";
	}*/	
	
	$size=sizeof($Ffiles);
	for ($i=2; $i<$size; $i++){
		$name=$Ffiles[$i];
		$image=file_get_contents($Fdir.'/'.$name);
		$query="INSERT INTO femalefaces(image, name) VALUES ('".mysqli_real_escape_string($conn, $image)."', '".mysqli_real_escape_string($conn, $name)."')";

		if($conn->query($query)===FALSE)
			echo "Error: ".$conn->error."\n";	
	}

	$conn->close();
?>