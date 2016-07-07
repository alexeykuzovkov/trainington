<!DOCTYPE HTML>
<!--
	Arcana by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?=$this->pageTitle?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="css/jquery-ui.min.css" />

		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->

		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.min.js"></script>

		<script type="text/javascript">
			$(function() {
				$("#searchResults").hide();
				$("#searchField").keypress(function(event) {
				    if (event.which == 13) {
				        event.preventDefault();
				    }
				});
				$("#searchField").on('input',function(e){
					console.log($("#searchField").val());

					$.get( "index.php", 
						{ "search": $("#searchField").val()}
					).done(function(data) {
						try {
							// <li><a href="index.html">Search Result #1<br /><span>Description...</span></a></li>
							$("#searchResults").html("");
							var results = $.parseJSON(data);

							if (results.length>0) {
								$("#searchResults").show();
							}
							else {
								$("#searchResults").hide();
							}
							results.forEach(function(res) {
								var li = document.createElement("li");
								var a = document.createElement("a");
								var span = document.createElement("span");

								$(li).append(a);
								$(a).append(res["name"]);
								$(a).append("<br/>");
								$(a).append(span);
								$(a).attr("href","filter.php?"+res["link"]+"="+res["val"]);
								$(span).append(res["type"]);

								$("#searchResults").append(li);
							});
						} catch(e) {

						}
						console.log(data);
					});
				});
			});
		</script>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header">

					<!-- Logo -->
						<h1><a href="/" id="logo">Главная</em></a></h1>

					<!-- Nav -->
						<nav id="nav">
							
						</nav>

				</div>

			<!-- Main -->
				<section class="wrapper style1">
					<div class="container">
						<div id="content">

							<!-- Content -->
								<div class="mainCenterButtons">
									<h1>Подбор по виду бизнеса</h1>
									<a href="http://localhost/filter.php?CountTicketsMin=300&CountTicketsMax=2500&ModelTypes%5B%5D=1&ModelTypes%5B%5D=5&ModelTypes%5B%5D=6" class="button">Малый бизнес</a>
									<a href="http://localhost/filter.php?CountTicketsMin=2500&CountTicketsMax=5000&ModelTypes%5B%5D=4&ModelTypes%5B%5D=2" class="button">Средний бизнес</a>
									<a href="http://localhost/filter.php?CountTicketsMin=5000&CountTicketsMax=10000&ModelTypes%5B%5D=4&ModelTypes%5B%5D=3" class="button">Предприятия</a>
								</div>
								<div class="mainCenterButtons">
									<a href="/filter.php">Ручной ввод параметров</a>
								</div>
								<div class="mainCenterButtons">
									<h1>Поиск</h1>
									<form autocomplete="off" class="search" method="post" action="" >
										 <input id="searchField" type="text" name="q" placeholder="Поиск" />
										 <ul class="results" id="searchResults">
											
										 </ul>
									 </form>
								</div>

						</div>
					</div>
				</section>

			<!-- Footer -->
				<div id="footer">
					

				</div>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>