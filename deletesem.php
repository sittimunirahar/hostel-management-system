<?php
require 'database/credentials.php';

$sid = '';
if ($_GET['sid'] != null) {
	$sid = $_GET['sid'];
}
$query = "DELETE FROM sem_list WHERE sem_id='$sid'";
$record = mysqli_query($link, $query);

$query = "DELETE FROM sem_duration WHERE sem_id='$sid'";
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
		alert('Delete <?php echo $sid; ?>failed');
		window.close();
	</script>
<?php
					}
?>

<!-- my Javascript-->
<script type="text/javascript" src="/myproject/js/index.js"></script>