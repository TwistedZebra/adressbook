<?php
	// connects to DB
	require('config/config.php');


	// Adds contact
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];

		if (empty($name) || empty($email) || empty($phonenumber)) {
			header('Location: addContact.php?=empty');
			exit();
		}else{
			try{
				$sql =  $connection->prepare("INSERT INTO contact_data (name, email, phonenumber) VALUES ('$name', '$email','$phonenumber')");
				$sql->execute();
				header('Location: index.php?=Success');
			}catch(PDOException $e) {
        		dd($e->getMessage());
    		}
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Contacts</title>
</head>
<body>

	<div class="contactBody">
		<form action="addContact.php" method="POST">
			<h1>Contacts</h1>
			<input type="text" name="name" placeholder="John Doe">
			<input type="email" name="email" placeholder="JohnDoe@example.com">
			<input type="text" name="phonenumber" placeholder="0612345678">

			<button type="submit" name="submit">Add contact</button>
		</form>
	</div>

</body>
</html>