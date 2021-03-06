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
	check_session();

?>
<div class="header">
<?php menu(); ?>
</div>

<div class="content">
<?php
	$dbc = new PDO('oci:dbname=FIT2076', 's26244608', 'monash00');
	$dbc->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

	$client = array();
	if (isset($_GET["client"])) {
		$client_id = $_GET["client"];
		$query = "select * from client where client_id = " . $client_id;

		$stmt = $dbc->prepare($query);
		$stmt->execute();

		$client = $stmt->fetch();
?>
<div class="mail">
<form method="POST" action="mailto.php?client=<?php echo $client_id; ?>" id="mail">
	<div>
		<label>To</label><br />
		<input type="text" name="email" value="<?php echo $client["client_email"]; ?>" /><br />
	</div>
	<div>
		<label>Subject</label><br />
		<input type="text" name="subject" /><br />
	</div>
	<label>Message</label><br />
	<textarea name="content" rows="10" cols="111"></textarea>
	<input type="submit" value="Send" />
</form>
</div>
<?php
	}
	if (isset($_POST["email"])) {
		//debug_array($_POST);
		$from = "From: Viet Thang Nguyen <vtngu31@student.monash.edu>";
		$to = $_POST["email"];
		$msg = $_POST["content"];
		$subject = $_POST["subject"];

		$modal_text = "";
		if (mail($to, $subject, $msg, $from)) {
?>
			<div class="modal" id="email-msg">
				<div class="modal-content">
					<p>Email Sent</p>
					<button id="okay">Okay</button>
				</div>
			</div>
<?php
		}
		else {
?>
			<div class="modal" id="email-msg">
				<div class="modal-content">
					<p>Email NOT Sent</p>
					<button id="okay">Okay</button>
				</div>
			</div>
<?php
		}
	}
?>
</div>
</body>
</html>
