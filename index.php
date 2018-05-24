<?php
	require 'config/config.php';

	// Show user info
	$contacts = $connection->prepare('SELECT * FROM contact_data');
	$contacts->execute([]);
	$contacts = $contacts->fetchAll(PDO::FETCH_ASSOC);

	// Delete record
	if (isset($_POST['delete'])) {

		$id = $_POST['id'];

		if (empty($id)) {
			header('Location: index.php?=invalidRecord');
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

	// search records
	if (isset($_POST['search'])) {

		$searchfield = $_POST['searchfield'];

		$searchQuery = $connection->prepare('SELECT * FROM contact_data WHERE name LIKE = :searchfield');
		$searchQuery->execute(['searchfield' => $searchfield]);
		$searchQuery = $searchQuery->fetchAll(PDO::FETCH_ASSOC);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/main.css">
	<title>Contacts</title>
</head>
<body>
	<h1>Contacts</h1>
	<?php foreach ($contacts as $contact) { ?>

	<div class="contactBody">
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

	<hr>
	<form  action="index.php" method="POST">
		<input type="text" name="id">
		<button type="submit" name="delete">Delete record</button>
	</form>
	<br>
	<form action="index.php" method="POST">
		<input type="text" name="searchfield">
		<button type="submit" name="search">Search</button>
	</form>
	<br>
	<a href="addContact.php"><button>Add Contact</button></a>
</body>
</html>