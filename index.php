<?php
	require 'config/config.php';

	// Show contact info
	try{
		$contacts = $connection->prepare('SELECT * FROM contact_data');
		$contacts->execute([]);
		$contacts = $contacts->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		dd($e->getMessage());
	}
	

	// Delete record
	if (isset($_POST['delete'])) {

		$id = $_POST['id'];

		if (empty($id) || !is_numeric($id)) {
			header('Location: index.php?=invalidRecord');
			exit();
		} else{
			try{
				$deleteRecord = $connection->prepare('DELETE  FROM contact_data WHERE id = :id');
				$deleteRecord->execute(['id' => $id]);
				header('Location: index.php?=Deleted');
			}catch(PDOException $e){
				dd($e->getMessage());
			}
		}
	}

	// Adds contact
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];

		if (empty($name) || empty($email) || empty($phonenumber) || !is_numeric($phonenumber) || !is_string($name)) {
			header('Location: index.php?=empty');
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

<!-- Begin HTML -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="author" content="Amer Zahirovic">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/main.css">
	<title>Contacts</title>
</head>
<body>
	<h1>Contacts</h1>
	<?php foreach ($contacts as $contact) { ?>

	<div>
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>E-mail</th>
				<th>Tell</th>
			</tr>
			<tr>
				<td><?php echo $contact['id']; ?></td>
				<td><?php echo $contact['name']; ?></td>
				<td><?php echo $contact['email']; ?></td>
				<td><?php echo $contact['phonenumber']; ?></td>
			</tr>
		</table>
	</div>
	<?php } ?>

	<br>
	<form  action="index.php" method="POST">
		<input type="text" name="id" autocomplete="off">
		<button type="submit" id="danger" name="delete">Delete record</button>
	</form>
	<br>
	<hr>
	<form action="index.php" method="POST">
		<h1>Add Contact</h1>
		<input type="text" name="name" placeholder="John Doe" autocomplete="off">
		<br><br>
		<input type="email" name="email" placeholder="JohnDoe@example.com" autocomplete="off">
		<br><br>
		<input type="text" name="phonenumber" placeholder="0612345678" autocomplete="off">
		<br><br>
		<button type="submit" id="success" name="submit">Add contact</button>
	</form>
	
</body>
</html>