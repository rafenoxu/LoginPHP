<?php
	require "header.php";
?>

<main>
    <div id="form_wrapper">
        <div id="form_left">
            <img src="img/logo.png" alt="logo">
        </div>
        <form action="includes/signup.inc.php" method="post">
            <div id="form_right">
                <h1>Sign Up</h1>
                <div class="input_container">
                    <i class="fas fa-envelope"></i>
                    <input placeholder="Email" type="email" name="username" id="field_email" class='input_field'>
                </div>
                <div class="input_container">
                    <i class="fas fa-lock"></i>
                    <input  placeholder="Password" type="password" name="pwd" id="field_password" class='input_field'>
                </div>
                <input type="submit" value="Sign up" name="signup-submit" id='input_submit' class='input_field'>
                <span id='create_account'>
                    <a href="login.php">Already have account? Log in ➡ </a>
                </span>
            </div>
        </form>
    </div>
</main>

<?php
	require "footer.php"
?>



