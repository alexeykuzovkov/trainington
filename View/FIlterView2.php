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
	</head>
	<body>
		

		<script src="js/jquery.sticky-kit.min.js"></script>
		<script type="text/javascript">

			// $("html").click(function() {
			// 	$("#tooltip").hide();
			// });
			var ajaxGetCount = function() {
				$.ajax({
					type: "GET",
					url: "filter.php",
					data: $("#searchForm").serialize(), // serializes the form's elements.
					success: function(data)
					{
						console.log(data);
					   $("#tooltip a").html("Показать: "+data);
					   $("#tooltip").show();
					}
				});
			}
			<? foreach ($this->minMaxRows as $key => $value) :?>
				$(function() {
					var range = <?=json_encode($value)."\r"?>
				    $( <?="'#".$key."Slider-range'"?> ).slider({
				      range: true,
				      min: 0,
				      max: range.length-1,
				      values: [ 
					      range.indexOf(parseFloat(<?=$this->allGet[$key."Min"]!=-1?$this->allGet[$key."Min"]:$value[0]; ?>)), 
					      range.indexOf(parseFloat(<?=$this->allGet[$key."Max"]!=-1?$this->allGet[$key."Max"]:end($value); ?>))
				      ],
				      slide: function( event, ui ) {
				        $( <?="'#".$key."Min'"?>).val( "" + range[ui.values[ 0 ]]);
				    	$( <?="'#".$key."Max'"?> ).val( "" + range[ui.values[ 1 ]]);
				      },
				      stop: function() {
				      	ajaxGetCount();
				      }
				    });
				    $( <?="'#".$key."Min'"?> ).val( "" + range[$(  <?="'#".$key."Slider-range'"?> ).slider( "values", 0 )]);
			    	$( <?="'#".$key."Max'"?> ).val( "" + range[$(  <?="'#".$key."Slider-range'"?> ).slider( "values", 1 )]);
				});
			<? endforeach; ?>	

			$(function() {
				$( "input[type=submit], button" ).button();

				$(":checkbox").change(function() {
				    ajaxGetCount();
				});

				$("#tooltip").click(function() {
					$("#searchForm").submit();
				});
			});
		</script>
		<div id="tooltip" style="display:none"><a href="#" id="ajaxShow">Показать: 3</a></div>
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header">

					<!-- Logo -->
						<h1><a href="/" id="logo"><em>На главную</em></a></h1>

					<!-- Nav -->
						<nav id="nav">
						</nav>

				</div>

			<!-- Main -->
				<section class="wrapper style1">
					<div class="container">
						<div class="row 200%">
							<div class="4u 12u(narrower)">
								<div id="sidebar">

									<!-- Sidebar -->

										<section>
											<a href="filter.php">Сбросить</a>
											<form method="get" id="searchForm" action="filter.php">
												
												<p>
												  <h3>Кол-во Этикеток:</h3>
												  <p>От: <input type="text" id="CountTicketsMin" name="CountTicketsMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="CountTicketsMax" name="CountTicketsMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="CountTicketsSlider-range"></div>

												<hr/>

												<p>
												  <h3 for="SpeedMin">Скорость:</h3>
												  <p>От: <input type="text" id="SpeedMin" name="SpeedMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="SpeedMax" name="SpeedMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="SpeedSlider-range"></div>

												<hr/>
												
												<p>
													<h3 for="ModelTypes">Класс устройства:</h3>
													<? foreach ($this->ModelTypes as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['ModelTypes']!=-1) && in_array($value["id"],$this->allGet['ModelTypes']))?'checked="checked"':""?>
															name='ModelTypes[]' value=<?=$value["id"]?> /> <label for="ModelTypes"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>		

												<hr/>

												
												<p>
													<h3 for="Vendors">Производители:</h3>
													<? foreach ($this->Vendors as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['Vendors']!=-1) && in_array($value["id"],$this->allGet['Vendors']))?'checked="checked"':""?>
															name='Vendors[]' value=<?=$value["id"]?> /> <label for="Vendors"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>		

												<hr/>

												<p>
													<h3 for="DPI">DPI:</h3>
													<? foreach ($this->Dpis as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['DPI']!=-1) && in_array($value["id"],$this->allGet['DPI']))?'checked="checked"':""?> 
															name='DPI[]' value=<?=$value["id"]?> /> <label for="DPI"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>

												<hr/>
												<p>
													<h3 for="DisplayTypes">Дисплеи:</h3>
													<? foreach ($this->Displaytypes as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['DisplayTypes']!=-1) && in_array($value["id"],$this->allGet['DisplayTypes']))?'checked="checked"':""?>
															name='DisplayTypes[]' value=<?=$value["id"]?> /> <label for="DisplayTypes"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>
												
												<hr/>
												<p>
													<h3 for="PrintingTypes">Типы печати:</h3>
													<? foreach ($this->PrintingTypes as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['PrintingTypes']!=-1) && in_array($value["id"],$this->allGet['PrintingTypes']))?'checked="checked"':""?>
															name='PrintingTypes[]' value=<?=$value["id"]?> /> <label for="PrintingTypes"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>

												<hr/>

												<p>
												  <h3 for="DiamSleeveTicketMin">Диаметр втулки этикетки:</h3>
												  <p>От: <input type="text" id="DiamSleeveTicketMin" name="DiamSleeveTicketMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="DiamSleeveTicketMax" name="DiamSleeveTicketMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="DiamSleeveTicketSlider-range"></div>

												<hr/>

												<p>
												  <h3 for="MaxDiamRollTicketMin">Максимальный диаметр рулона этикетки:</h3>
												  <p>От: <input type="text" id="MaxDiamRollTicketMin" name="MaxDiamRollTicketMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="MaxDiamRollTicketMax" name="MaxDiamRollTicketMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="MaxDiamRollTicketSlider-range"></div>

												<hr/>

												<p>
												  <h3 for="DiamSleeveRibbonMin">Диаметр втулки риббона:</h3>
												  <p>От: <input type="text" id="DiamSleeveRibbonMin" name="DiamSleeveRibbonMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="DiamSleeveRibbonMax" name="DiamSleeveRibbonMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="DiamSleeveRibbonSlider-range"></div>

												<hr/>

												<p>
												  <h3 for="MaxWoundRibbonMin">Максимальная намотка риббона:</h3>
												  <p>От: <input type="text" id="MaxWoundRibbonMin" name="MaxWoundRibbonMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="MaxWoundRibbonMax" name="MaxWoundRibbonMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="MaxWoundRibbonSlider-range"></div>

												<hr/>

												<p>
												  <h3 for="MaxPrintingWidthMin">Максимальная ширина печати:</h3>
												  <p>От: <input type="text" id="MaxPrintingWidthMin" name="MaxPrintingWidthMin" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												  <p>До: <input type="text" id="MaxPrintingWidthMax" name="MaxPrintingWidthMax" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
												</p>
												<div id="MaxPrintingWidthSlider-range"></div>

												<hr/>

												<p>				
													<input type="checkbox" <?=$this->allGet["UseKnife"]!=-1?'checked="checked"':""?> id="UseKnife" name="UseKnife" />
													<label for="UseKnife">Наличие ножа</label>
												</p>

												<hr/>

												<p>				
													<input type="checkbox" <?=$this->allGet["UseSeparator"]!=-1?'checked="checked"':""?> id="UseSeparator" name="UseSeparator" />
													<label for="UseSeparator">Наличие отделителя</label>
												</p>

												<hr/>

												<p>				
													<input type="checkbox" <?=$this->allGet["UseWinder"]!=-1?'checked="checked"':""?> id="UseWinder" name="UseWinder" />
													<label for="UseWinder">Наличие смотчика</label>
												</p>

												<hr/>

												<p>
													<input type="checkbox" <?=$this->allGet["UseEthernet"]!=-1?'checked="checked"':""?> id="UseEthernet" name="UseEthernet" />
													<label for="UseEthernet">Наличие Ethernet</label>
												</p>

												<hr/>

												

												

												<!-- <p>
													<label for="PrinterTypes">Типы принтеров:</label>
													<? foreach ($this->PrinterTypes as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['PrinterTypes']!=-1) && in_array($value["id"],$this->allGet['PrinterTypes']))?'checked="checked"':""?>
															name='PrinterTypes[]' value=<?=$value["id"]?> /> <label for="PrinterTypes"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p> -->

												<hr/>

												

												<p>
													<h3 for="Windings">Намотки:</h3>
													<? foreach ($this->Windings as $key => $value): ?>
														<p><input type='checkbox' 
															<?=(($this->allGet['Windings']!=-1) && in_array($value["id"],$this->allGet['Windings']))?'checked="checked"':""?>
															name='Windings[]' value=<?=$value["id"]?> /> <label for="Windings"><?=$value["name"]?></label> </p>
													<? endforeach; ?>
												</p>


												<input type="submit" id="submitSearch" value="Найти" />
											</form>
										</section>

										

								</div>
							</div>
							<div class="8u  12u(narrower) important(narrower)">
								<div id="content">

									<!-- Content -->

										<article>
											<? foreach ($this->resultPrinters as $key => $value) :?>
												<div class="box post">
													<img class="image left" src="http://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04386283.png" alt="" height="100" width="100"/>
													<?
														$modelId = $value["Model_ID"];
														$RowID = $value["RowID"];
													?>
													<a href=<?="'/product.php?id=$modelId&mode=$RowID'"?>>
													<div class="inner">
														<h3><?=$value['ModelName']?></h3>
													</div>
													</a>
												</div>
											<? endforeach;?>
										</article>

								</div>
							</div>
						</div>
					</div>
				</section>

			<!-- Footer -->
				<div id="footer">
					<div class="container">
						
					</div>


				</div>

		</div>

		
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>