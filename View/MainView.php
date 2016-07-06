<html>
<head>
	<title><?=$this->pageTitle?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/jquery-ui.min.css" />
	<link rel="stylesheet" href="css/main.css" />

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
	
</head>
<body>
	<ul class="menu">
		<li>Малый Бизнес
			<ul>
				<li>Ларёк</li>
				<li>Доставка по городу</li>
			</ul>
		</li>
		<li>Средний бизнес
			<ul>
				<li>Склад</li>
				<li>Доставка по региону</li>
			</ul>
		</li>
		<li>Предприятия
			<ul>
				<li>Промышленные предприятия</li>
				<li>Доставка по стране и миру</li>
			</ul>
		</li>
	</ul>

	<br/><br/><br/><br/><br/><br/><br/><br/><br/>


	<form action="select.php">

	<p>Обьём печати</p><br/>
	<input class="56mm" type="radio" name="tips" value="min">от 1 до 3 000 маркировок 56mm<br/>
	<input class="56mm" type="radio" name="tips" value="mid">от 3 000 до 10 000 маркировок 56mm<br/>
	<input class="56mm" type="radio" name="tips" value="max">от 10 000 маркировок и больше 56mm<br/>
	<input class="120mm" type="radio" name="tips" value="min">от 1 до 3 000 маркировок 120mm<br/>
	<input class="120mm" type="radio" name="tips" value="mid">от 3 000 до 10 000 маркировок 120mm<br/>
	<input class="120mm" type="radio" name="tips" value="max">от 10 000 маркировок и больше 120mm<br/>

	<p>Какая температура в месте исспользования принтера:</p><br/>
	<input type="radio" name="temp" value="cold">от -25 до 0<br/>
	<input type="radio" name="temp" value="mid">от -0 до 25<br/>
	<input type="radio" name="temp" value="hot">от 25 до 45<br/>
	<input type="radio" name="temp" value="shot">от 45 до 75<br/>
	<p>Доп Функционал</p><br/>
	<input type="radio" name="temp" value="cold">от -25 до 0<br/>
	<input type="radio" name="temp" value="mid">от -0 до 25<br/>
	<input type="radio" name="temp" value="hot">от 25 до 45<br/>
	<input type="radio" name="temp" value="shot">от 45 до 75<br/>
	</form>

	<div id="viewAllView">
		<a href="filter.php">Поиск по параметрам</a>
	</div>

	
</body>
</html>