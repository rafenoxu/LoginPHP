<?php
	require "header.php";
?>

<main>
	<?php
		if (isset($_SESSION['userId'])) {
			echo '<p>You are logged in</p>';

			require 'includes/dbh.inc.php';
			$sql = "SELECT id, email, lastaccess FROM users WHERE lastaccess > logout";
			$statement = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($statement, $sql)) {
				header("Location: ../index.php?error=sqlerror");
				exit();
			} else {
				mysqli_stmt_execute($statement);
				$result = mysqli_stmt_get_result($statement);
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<p>".$row['id'].", ".$row['email'].", ".$row['lastaccess']."</p>";
				}
			}
		} else {
			echo '<p>You are logged out</p>';
		}
	?>

	<?php
		
	?>
</main>

<?php
	require "footer.php"
?>