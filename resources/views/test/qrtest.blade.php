<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<img src="{!!QrCode::format('png')->generate('3')!!}"
<?php
	QrCode::size(600);
	echo('"' . QrCode::format('png')->generate('sfd'). '"');
	?>
</body>
>

</html>