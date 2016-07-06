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

			<!-- Профиль -->
			<section class="person">         
		    	<img id="avatarImage" class="image left" src="http://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04386283.png" height="200" weight="200"/>
			    <div class="inner">
			    	<section>
				    	<?=$this->parametersWithTranslate["CountTickets"].": "?><?=$this->result["CountTickets"]?> шт. <br>

				    	<?=$this->parametersWithTranslate["Speed"].": "?><?=$this->result["Speed"]?> мм/сек<br>

				    	<?=$this->parametersWithTranslate["DiamSleeveTicket"].": "?><?=$this->result["DiamSleeveTicket"]?> ХУЙ Знаект <br>

				    	<?=$this->parametersWithTranslate["MaxDiamRollTicket"].": "?><?=$this->result["MaxDiamRollTicket"]?> Но молчит<br>

				    	<?=$this->parametersWithTranslate["DiamSleeveRibbon"].": "?><?=$this->result["DiamSleeveRibbon"]?> Bitch<br>

				    	<?=$this->parametersWithTranslate["MaxWoundRibbon"].": "?><?=$this->result["MaxWoundRibbon"]?> Это вообще ересь<br>

				    	<?=$this->parametersWithTranslate["MaxPrintingWidth"].": "?><?=$this->result["MaxPrintingWidth"]?> Ширина<br>

				    	<?=$this->parametersWithTranslate["PrinterType"].": "?><?=$this->parametersWithTranslate[$this->result["PrinterType"]]?> <br>

				    	<?=$this->parametersWithTranslate["DPI"].": "?><?=$this->result["DPI"]?> <br>

				    	<?=$this->parametersWithTranslate["PrintingType"].": "?><?=$this->parametersWithTranslate[$this->result["PrintingType"]]?> <br>

				    	<?=$this->parametersWithTranslate["ModelName"].": "?><?=$this->result["ModelName"]?> <br>

				    	<?=$this->parametersWithTranslate["VendorName"].": "?><?=$this->result["VendorName"]?> <br>

				    	<?=$this->parametersWithTranslate["DisplayTypeName"].": "?><?=$this->result["DisplayTypeName"]?> <br>

				    	<?=$this->parametersWithTranslate["UseKnife"].": "?><?=$this->parametersWithTranslate[$this->result["UseKnife"]]?> <br>
				    	<?=$this->parametersWithTranslate["UseSeparator"].": "?><?=$this->parametersWithTranslate[$this->result["UseSeparator"]]?> <br>
				    	<?=$this->parametersWithTranslate["UseEthernet"].": "?><?=$this->parametersWithTranslate[$this->result["UseEthernet"]]?> <br>
				    	<?=$this->parametersWithTranslate["UseWinder"].": "?><?=$this->parametersWithTranslate[$this->result["UseWinder"]]?> <br>
				    	<?=$this->parametersWithTranslate["Winding"].": "?><?=$this->parametersWithTranslate[$this->result["Winding"]]?> <br>
					</section>
				</div>
			</section>
		
	</body>
</html>	