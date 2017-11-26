<?php
$msg ="";
//if upload button pressed
if (isset($_POST['upload'])) {

	$target = "images/".basename($_FILES['image']['name']);

	//connect to db
	$db = mysqli_connect("localhost", "root", "root", "photos");

	//get all submitted data from form 
	$image = $_FILES['image']['name'];
	$text = $_POST['text'];

	$sql = "INSERT INTO images (image, text) VALUES ('$image', '$text')";
	mysqli_query($db, $sql); //stores the submitted data into db table

	//move uploaded images into folder -- images
	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Image uploaded successfully";
	} else { 
		$msg = "Problem uploading image!";
	}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel='stylesheet' href='style.css'>
	<title>Document</title>
</head>
<body>
	<div id='content'>
		<?php
			$db = mysqli_connect("localhost", "root", "root", "photos");
			$sql = "SELECT * FROM images";
			$result = mysqli_query($db, $sql);
			while ($row = mysqli_fetch_array($result)) {
				echo "<div id = 'img_div'>";
				echo "<img src = 'images/" . $row['image'] . "' >";
				echo "<p>" . $row['text'] . "</p>";
				echo "</div>";
			}


		?>
		<form method ='post' action='index.php' enctype='multipart/form-data'>
			<input type='hidden' name='size' value='10000000'>
			<div>
				<input type='file' name='image'>
			</div>
			<div>
				<textarea name ='text' cols = '40' rows = '4' placeholder = "say something about this image..."></textarea>
			</div>
			<div>
				<input type='submit' name = 'upload' value = 'upload Image'>
			</div>
		</form>


	</div>
	
</body>
</html>