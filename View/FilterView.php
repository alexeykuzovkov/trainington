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
		<? foreach ($this->minMaxRows as $key => $value) :?>
			$(function() {
				var range = <?=json_encode($value)."\r"?>
			    $( <?="'#".$key."Slider-range'"?> ).slider({
			      range: true,
			      min: 0,
			      max: range.length-1,
			      values: [ 0, range[range.length-1] ],
			      slide: function( event, ui ) {
			        $( <?="'#".$key."Min'"?>).val( "" + range[ui.values[ 0 ]]);
			    	$( <?="'#".$key."Max'"?> ).val( "" + range[ui.values[ 1 ]]);
			      }
			    });
			    $( <?="'#".$key."Min'"?> ).val( "" + range[0]);
		    	$( <?="'#".$key."Max'"?> ).val( "" + range[range.length-1]);
			  });
		<? endforeach; ?>	

		$(function() {
		    $( "#DPI" ).selectmenu();
		});
			
	</script>
	<section class="left">
		<form method="get" action="filter.php">
			
			<p>
			  <label for="CountTicketsMin">Кол-во Этикеток:</label>
			  <p>От: <input type="text" id="CountTicketsMin" name="CountTicketsMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="CountTicketsMax" name="CountTicketsMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="CountTicketsSlider-range"></div>

			<p>
			  <label for="SpeedMin">Скорость:</label>
			  <p>От: <input type="text" id="SpeedMin" name="SpeedMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="SpeedMax" name="SpeedMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="SpeedSlider-range"></div>

			<p>
				<label for="UseKnife">Наличие ножа</label>
				<input type="checkbox" id="UseKnife" name="UseKnife" />
			</p>

			<p>
				<label for="UseSeparator">Наличие отделителя</label>
				<input type="checkbox" id="UseSeparator" name="UseSeparator" />
			</p>

			<p>
				<label for="UseWinder">Наличие смотчика</label>
				<input type="checkbox" id="UseWinder" name="UseWinder" />
			</p>

			<p>
				<label for="UseEthernet">Наличие Ethernet</label>
				<input type="checkbox" id="UseEthernet" name="UseEthernet" />
			</p>

			<p>
			  <label for="DiamSleeveTicketMin">Диаметр втулки этикетки:</label>
			  <p>От: <input type="text" id="DiamSleeveTicketMin" name="DiamSleeveTicketMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="DiamSleeveTicketMax" name="DiamSleeveTicketMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="DiamSleeveTicketSlider-range"></div>

			<p>
			  <label for="MaxDiamRollTicketMin">Максимальный диаметр рулона этикетки:</label>
			  <p>От: <input type="text" id="MaxDiamRollTicketMin" name="MaxDiamRollTicketMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="MaxDiamRollTicketMax" name="MaxDiamRollTicketMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="MaxDiamRollTicketSlider-range"></div>

			<p>
			  <label for="DiamSleeveRibbonMin">Диаметр втулки риббона:</label>
			  <p>От: <input type="text" id="DiamSleeveRibbonMin" name="DiamSleeveRibbonMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="DiamSleeveRibbonMax" name="DiamSleeveRibbonMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="DiamSleeveRibbonSlider-range"></div>


			<p>
			  <label for="MaxWoundRibbonMin">Максимальная намотка риббона:</label>
			  <p>От: <input type="text" id="MaxWoundRibbonMin" name="MaxWoundRibbonMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="MaxWoundRibbonMax" name="MaxWoundRibbonMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="MaxWoundRibbonSlider-range"></div>


			<p>
			  <label for="MaxPrintingWidthMin">Максимальная ширина печати:</label>
			  <p>От: <input type="text" id="MaxPrintingWidthMin" name="MaxPrintingWidthMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			  <p>До: <input type="text" id="MaxPrintingWidthMax" name="MaxPrintingWidthMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
			</p>
			<div id="MaxPrintingWidthSlider-range"></div>

			<p>
				<label for="DPI">DPI:</label>
				<? foreach ($this->Dpis as $key => $value): ?>
					<p><input type='checkbox' name='DPI[]' value=<?=$value["id"]?> /> <label for="DPI"><?=$value["name"]?></label> </p>
				<? endforeach; ?>
			</p>

			<p>
				<label for="DisplayTypes">Дисплеи:</label>
				<? foreach ($this->Displaytypes as $key => $value): ?>
					<p><input type='checkbox' name='DisplayTypes[]' value=<?=$value["id"]?> /> <label for="DisplayTypes"><?=$value["name"]?></label> </p>
				<? endforeach; ?>
			</p>

			<p>
				<label for="PrinterTypes">Типы принтеров:</label>
				<? foreach ($this->PrinterTypes as $key => $value): ?>
					<p><input type='checkbox' name='PrinterTypes[]' value=<?=$value["id"]?> /> <label for="PrinterTypes"><?=$value["name"]?></label> </p>
				<? endforeach; ?>
			</p>

			<p>
				<label for="PrintingTypes">Типы печати:</label>
				<? foreach ($this->PrintingTypes as $key => $value): ?>
					<p><input type='checkbox' name='PrintingTypes[]' value=<?=$value["id"]?> /> <label for="PrintingTypes"><?=$value["name"]?></label> </p>
				<? endforeach; ?>
			</p>

			<p>
				<label for="Windings">Намотки:</label>
				<? foreach ($this->Windings as $key => $value): ?>
					<p><input type='checkbox' name='Windings[]' value=<?=$value["id"]?> /> <label for="Windings"><?=$value["name"]?></label> </p>
				<? endforeach; ?>
			</p>





			

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