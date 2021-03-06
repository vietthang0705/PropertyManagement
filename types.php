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

	if (isset($_GET["action"])) {
		switch ($_GET["action"]) {
		case "add":
			if (isset($_POST["type"]) && $_POST["type"] != "") {
				$type_name = $_POST["type"];
				$add_query = "insert into property_type values (type_seq.nextVal, '" . $type_name . "')";
				$add_stmt = $dbc->prepare($add_query);
				$add_stmt->execute();
			}
			break;
		case "delete":
			$type_id = $_GET["delType"];
			$del_query = "delete from property_type where type_id = " . $type_id;
			$del_stmt = $dbc->prepare($del_query);
			$del_stmt->execute();

			break;
		}
	}

// get types from dB
	$free_type = array();
	$occd_type = array();

// types with no property attached
	$free_type_query = "select * from property_type where type_id not in (select distinct prop_type from property)";
	$free_type_stmt = $dbc->prepare($free_type_query);
	if ($free_type_stmt->execute()) {
		while ($type_r = $free_type_stmt->fetch()) {
			$free_type[$type_r["type_id"]] = $type_r["type_name"];
		}
	}

// types with property attached
	$occd_type_query = "select * from property_type where type_id in (select distinct prop_type from property)";
	$occd_type_stmt = $dbc->prepare($occd_type_query);
	if ($occd_type_stmt->execute()) {
		while ($type_r = $occd_type_stmt->fetch()) {
			$occd_type[$type_r["type_id"]] = $type_r["type_name"];
		}
	}

	/*
	echo "<pre>";
		print_r($free_type);
		print_r($occd_type);
	echo "</pre>";
	 */

// form to add more types
?>

<div class="add-type">
	<p>Add More Types</p>
	<form action="types.php?action=add" method="POST">
	<div class="parent">
		<div class="child-left">
			<label>Type Name</label><br />
			<input type="text" name="type" value="" /><br />
		</div>
		<div class="child-right">
			<input class="full-width" type="submit" value="Add" />
		</div>
	</div>
	</form>
</div>

<?php
// current types
//
?>
<div class="type-list">
	<p>Current Types List</p>
<?php
	//debug_array($free_type);
	foreach ($free_type as $type_id => $type_name) {
		free_type_disp($type_id, $type_name);
	}

	foreach ($occd_type as $type_id => $type_name) {
		occd_type_disp($type_id, $type_name);
	}
?>
</div>
<div style="overlay: hidden;">
	<button class="display-code"><a href="display.php?page=types">Type</a></button>
</div>
</div>
</body>
</html>
