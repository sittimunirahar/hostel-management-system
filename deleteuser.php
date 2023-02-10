<?php
require 'database/credentials.php';
if ($_GET['username'] != null) {
	$user = $_GET['username'];
}
$query = "DELETE admin_acc, staff_acc, uploads FROM admin_acc INNER JOIN staff_acc INNER JOIN uploads 
		WHERE admin_acc.username=staff_acc.id AND staff_acc.id=uploads.description AND admin_acc.username='$user'";
$record = mysqli_query($link, $query);

if ($record) { ?>
	<script>
		window.onunload = refreshParent;

		function refreshParent() {
			window.opener.location.reload();
		}
		window.close();
	</script><?php
					} else { ?>
	<script>
		alert('Delete <?php echo $user; ?>fail');
		window.close();
	</script>
<?php
					}
?>

<!-- my Javascript-->
<script type="text/javascript" src="/myproject/js/index.js"></script>