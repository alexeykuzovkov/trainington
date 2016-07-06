<html>
<head>
	<title><?=$this->pageTitle?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/jquery-ui.min.css" />
	<link rel="stylesheet" href="css/main.css" />
</head>
<body>
	

	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.min.js"></script>

	<script type="text/javascript">
		$(function() {
			$( "#radio" ).buttonset();
		});
		$(function() {
			$( "#recepieDetailsView ul" ).menu();
		});
	</script>
</body>
</html>