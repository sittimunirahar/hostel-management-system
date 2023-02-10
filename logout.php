<html>

<body>
	<script>
		var r = confirm("You are about to log out!");
		if (r == true) {

			window.location.href = "login.php";
		} else {
			window.history.back();
		}
	</script>
</body>

</html>