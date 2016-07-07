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
		<?
			$activeTab = 0;
			if (isset($_GET['mode'])) {
				for ($i=0; $i<count($this->result); $i++) {
					$value=$this->result[$i];
					if ((int)$value['RowID']==(int)$_GET['mode']) {
						$activeTab = $i;
					}
				}
			}
		?>
		<script type="text/javascript">
			$(function() {
				$( "#radio" ).buttonset();
			});
			$(function() {
				$( "#recepieDetailsView ul" ).menu();
			});
			$(function() {
				$( "#tabs" ).tabs({
					active:<?=$activeTab?>
				});
			});
			function goBack() {
			    window.history.back();
			}
		</script>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header">

					<!-- Logo -->
						<h1><a href="/" id="logo"><em>На главную</em></a></h1>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li onclick="goBack()" style="white-space: nowrap;"> 
									<a>Назад</a>
								</li>
							</ul>
						</nav>

				</div>

			<!-- Main -->
				<section class="wrapper style1">
					<div class="container">
						<div class="row 200%">
							<div class="4u 12u(narrower)">
								<!-- Sidebar -->
								<img class="image left" src="http://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04386283.png" height="200" weight="200"/>
							</div>
							<div class="8u  12u(narrower) important(narrower)">
								<div id="content">
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
												    	<?=$this->parametersWithTranslate["Price"].": "?><?=$value["Price"]?> уе.
													</section>
												</div>
											<? endfor?>
										</div>
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