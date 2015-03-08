<?php 
	session_start();
	require('new-connection.php');
	if(!isset($_SESSION['logged_in'])) {
		$_SESSION['errors'][] = "Oops! You have to be logged in to view this page.";
			header('location: index.php');
			die();
	}
	if(isset($_SESSION['errors'])) {
		echo "<div class='error'>{$_SESSION['errors']}</div>";
		unset($_SESSION['errors']);
	}
	if(isset($_SESSION['success_message'])) {
		echo "<div class='success'>{$_SESSION['success_message']}</div>";
		unset($_SESSION['success_message']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Wall</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<h3>Coding Dojo Wall</h3>
		<p> Welcome <?php echo $_SESSION['first_name']; ?>!</p>
		<a href='logout.php'><p>Logout</p></a>
	</div>
	<div class="body">
		<h4>Post a message</h4>
		<form action="proccess.php" method="post">
			<textarea type="text" class="message" name="message"></textarea>
			<input type="hidden" name="action" value="post_message">
			<button class="align-right" type="submit">Post a message</button>
		</form>
		<!-- Display existing messages -->
		<?php 
			$query = "SELECT CONCAT_WS(' ', users.first_name, users.last_name) AS user_name, messages.message AS message, DATE_FORMAT(messages.created_at,'%h:%i:%s %p %M %e %Y') AS created_at FROM users LEFT JOIN messages ON users.id = messages.user_id ORDER BY created_at DESC";
			$messages = fetch_all($query);
			foreach ($messages as $value) {
				echo "<div class='messages'><h4> {$value['user_name']} - {$value['created_at']} </h4>";
				echo "<p class='message'> {$value['message']} </p></div>";
			}
		?>
	</div>
</body>
</html>