<?php
	require 'mysqlCompare.php';
	$mc = new MysqlCompare();
	$mc_compare = $mc->compareDatabases();
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MySQL Compare</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<p>Differences are indicated by <i class='fa fa-exclamation-triangle red'></i> areas.</p>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id='totalDiffs'>
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id='col_one'>
					
					<h1><?php echo $mc->getDBNameOne(); ?></h1>
					<?php foreach($mc_compare[0] as $key=>$var) { ?>
					<div class="tableRow <?php echo $key; ?> <?php echo $mc_compare[0][$key]['class']; ?>" data-table='<?php echo $key; ?>'>
						<span class="tableName"><?php echo $key; ?></span>
						<?php 
						if($mc_compare[0][$key]['class'] !== 'diff') { 
						foreach($var as $k=>$v) { ?>
							<?php if($mc_compare[0][$key][$k] != '') { ?>
							<div class="fieldRow <?php echo $mc_compare[0][$key][$k]['class']; ?>">
								<?php echo $mc_compare[0][$key][$k]['name']; ?>
									<?php foreach($mc_compare[0][$key][$k] as $x=>$y) { 
 											if($x != 'name' && $x != 'class' && $x != 'Field') {
 												if(isset($y['val']) && $y['val'] != '') {
 											?>
										<div class="metaRow <?php echo $y['class']; ?>">
											<?php   echo $x." = ".$y['val']; ?>
										</div>
									<?php } } } ?>
							</div>
							<?php } ?>
						<?php } } ?>
					</div>
					<?php } ?>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id='col_two'>
					
					<h1><?php echo $mc->getDBNameTwo(); ?></h1>
					<?php foreach($mc_compare[1] as $key=>$var) { ?>
					<div class="tableRow <?php echo $key; ?> <?php echo $mc_compare[1][$key]['class']; ?>" data-table='<?php echo $key; ?>'>
						<span class="tableName"><?php echo $key; ?></span>
						<?php 
						if($mc_compare[1][$key]['class'] !== 'diff') { 
						foreach($var as $k=>$v) { ?>
							<?php if($mc_compare[1][$key][$k] != '') { ?>
							<div class="fieldRow <?php echo $mc_compare[1][$key][$k]['class']; ?>">
								<?php echo $mc_compare[1][$key][$k]['name']; ?>
									<?php foreach($mc_compare[1][$key][$k] as $x=>$y) { 
 											if($x != 'name' && $x != 'class' && $x != 'Field') {
 												if(isset($y['val']) && $y['val'] != '') {
 											?>
										<div class="metaRow <?php echo $y['class']; ?>">
											<?php   echo $x." = ".$y['val']; ?>
										</div>
									<?php } } } ?>
							</div>
							<?php } ?>
						<?php } } ?>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script type='text/javascript' src='js/main.js'></script>
	</body>
</html>