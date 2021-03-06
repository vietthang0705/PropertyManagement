<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script src="js/script.js"></script>
</head>
<body>

<?php
	include('includes.php');
	//echo $_GET["prop"];


?>
<div class="header">
</div>

<div class="content">
<?php
	$dbc = new PDO('oci:dbname=FIT2076', 's26244608', 'monash00');
	$dbc->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

	define("MONASH_DIR", "ldap.monash.edu.au");
	define("MONASH_FILTER", "o=Monash University, c=au");

	session_start();
	unset($_SESSION["username"]);

	if (isset($_POST["user"]) && $_POST["user"] != '') {
		$user = $_POST["user"];
		$pass = $_POST["pass"];
		$ldap_conn = @ldap_connect(MONASH_DIR);
		if ($ldap_conn) {
			$ldap_search = @ldap_search($ldap_conn, MONASH_FILTER, "uid=" . $user);
			if ($ldap_search) {
				$ldap_info = @ldap_first_entry($ldap_conn, $ldap_search);
				if ($ldap_info) {
					$ldap_res = @ldap_bind($ldap_conn, ldap_get_dn($ldap_conn, $ldap_info), $pass);
				}
				else { $ldap_res = 0; }
			}
			else { $ldap_res = 0; }
		}
		else { $ldap_res = 0; }

		if ($ldap_res) {
			// start session
			$_SESSION["username"] = $user;
			// redirect to index.php
			header('Location: http://triton.infotech.monash.edu.au/FIT2076_26244608/ass2/index.php');
		}
		else { /*ignore?*/
			echo "Wrong username or password";
		}
	}
?>

<div class="login">
<form method="post" action="login.php">
	<div>
		<label>Username</label><br />
		<input type="text" name="user" />
	</div>
	<div>
		<label>Password</label><br />
		<input type="password" name="pass" />
	</div>
	<div style="width: 80%; margin: auto;"><input type="submit" value="Log in" /></div>
</form>
</div>

</div>
</body>
</html>
