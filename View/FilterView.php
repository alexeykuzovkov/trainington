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
		    $( "#slider-range" ).slider({
		      range: true,
		      min: 300,
		      max: 10000,
		      step: 100,
		      values: [ 300, 10000 ],
		      slide: function( event, ui ) {
		        $( "#amount" ).val( "" + ui.values[ 0 ] + " — " + ui.values[ 1 ] );
		      }
		    });
		    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
		      " — " + $( "#slider-range" ).slider( "values", 1 ) );
		  });
	</script>
	<section class="left">
		<form method="get" action="filter.php">
			
			<p>
			  <label for="amount">Кол-во Этикеток:</label>
			  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
			</p>
			 
			<div id="slider-range"></div>
			<input type="submit" value="Показать" />
		</form>
	</section>
	<section class="main">
		<? foreach ($this->resultPrinters as $key => $value) :?>
			<div class="box post">
				<a href="#" class="image left"><img src="http://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04386283.png" alt="" height="100" width="100"/></a>
				<div class="inner">
					<h3><?=$value['ModelName']?></h3>
					<p>DPI: <?=$value['DPI']?></p>
					<p>Скорость: <?=$value['Speed']?></p>
				</div>
			</div>
		<? endforeach;?>
	</section>

</body>
</html>