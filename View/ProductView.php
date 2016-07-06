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
			$(function() {
				$( "#tabs" ).tabs({
					active:<?=?>
				});
			});
			</script>
		</script>
		
	</head>
	<body>

			<!-- Профиль -->
			<section class="person">         
		    	<img id="avatarImage" class="image left" src="http://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04386283.png" height="200" weight="200"/>
			    <div class="inner">
			    	<div id="tabs">
						<ul>
							<? for ($i=0; $i<count($this->result); $i++):
								$value=$this->result[$i];?>
								<li><a href=<?="'#tabs-".($i+1)."'"?>><?=$this->result[$i]['SKU']?></a></li>
							<? endfor?>
						</ul>
							<? for ($i=0; $i<count($this->result); $i++): 
								$value=$this->result[$i];?>
								<div id=<?="'tabs-".($i+1)."'"?> >
							    	<section>
								    	<?=$this->parametersWithTranslate["CountTickets"].": "?><?=$value["CountTickets"]?> шт. <br>

								    	<?=$this->parametersWithTranslate["Speed"].": "?><?=$value["Speed"]?> мм/сек.<br>

								    	<?=$this->parametersWithTranslate["DiamSleeveTicket"].": "?><?=$value["DiamSleeveTicket"]?> мм.<br>

								    	<?=$this->parametersWithTranslate["MaxDiamRollTicket"].": "?><?=$value["MaxDiamRollTicket"]?> мм.<br>

								    	<?=$this->parametersWithTranslate["DiamSleeveRibbon"].": "?><?=$value["DiamSleeveRibbon"]?> мм.<br>

								    	<?=$this->parametersWithTranslate["MaxWoundRibbon"].": "?><?=$value["MaxWoundRibbon"]?> мм.<br>

								    	<?=$this->parametersWithTranslate["MaxPrintingWidth"].": "?><?=$value["MaxPrintingWidth"]?> мм.<br>

								    	<?=$this->parametersWithTranslate["PrinterType"].": "?><?=$this->parametersWithTranslate[$value["PrinterType"]]?> <br>

								    	<?=$this->parametersWithTranslate["DPI"].": "?><?=$value["DPI"]?> <br>

								    	<?=$this->parametersWithTranslate["PrintingType"].": "?><?=$this->parametersWithTranslate[$value["PrintingType"]]?> <br>

								    	<?=$this->parametersWithTranslate["ModelName"].": "?><?=$value["ModelName"]?> <br>

								    	<?=$this->parametersWithTranslate["VendorName"].": "?><?=$value["VendorName"]?> <br>

								    	<?=$this->parametersWithTranslate["DisplayTypeName"].": "?><?=$value["DisplayTypeName"]?> <br>

								    	<?=$this->parametersWithTranslate["UseKnife"].": "?><?=$this->parametersWithTranslate[$value["UseKnife"]]?> <br>
								    	<?=$this->parametersWithTranslate["UseSeparator"].": "?><?=$this->parametersWithTranslate[$value["UseSeparator"]]?> <br>
								    	<?=$this->parametersWithTranslate["UseEthernet"].": "?><?=$this->parametersWithTranslate[$value["UseEthernet"]]?> <br>
								    	<?=$this->parametersWithTranslate["UseWinder"].": "?><?=$this->parametersWithTranslate[$value["UseWinder"]]?> <br>
								    	<?=$this->parametersWithTranslate["Winding"].": "?><?=$this->parametersWithTranslate[$value["Winding"]]?> <br>
								    	<?=$this->parametersWithTranslate["Price"].": "?><?=$value["Price"]?> руб. <br><br><br>
									</section>
								</div>
							<? endfor?>
						</div>
				</div>
			</section>
		
	</body>
</html>	