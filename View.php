<html>
<head>
	<title>Trainington</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="js/jquery-ui.min.css" />
</head>
<body>
	<form>
	  <div id="radio">
	    <input type="radio" id="radio1" name="radio"><label for="radio1">Вариант 1</label>
	    <input type="radio" id="radio2" name="radio" checked="checked"><label for="radio2">Вариант 2</label>
	    <input type="radio" id="radio3" name="radio"><label for="radio3">Вариант 3</label>
	  </div>
	</form>

	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.min.js"></script>

	<script type="text/javascript">
		$(function() {
		    $( "#radio" ).buttonset();
		  });
	</script>
</body>
</html>