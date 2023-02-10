<?php
require 'database/credentials.php';

$pid = '';
if ($_GET['pid'] != null) {
	$pid = $_GET['pid'];
}
$query = "DELETE FROM pay_details_college WHERE pay_rec_id='$pid'";
$record = mysqli_query($link, $query);

if ($record) { ?>
	<script>
		//alert('Delete <?php echo $sid; ?> Success');
		window.onunload = refreshParent;

		function refreshParent() {
			window.opener.location.reload();
		}
		window.close();
	</script><?php
					} else { ?>
	<script>
		alert('Delete <?php echo $pid; ?> failed');
		window.close();
	</script>
<?php
					}
?>

<!-- my Javascript-->
<script type="text/javascript" src="/myproject/js/index.js"></script>