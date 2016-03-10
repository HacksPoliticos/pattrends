<?php
ob_start(); /* template body */ ?><html>
<head>
    <title>Pattrends</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/patent.js" type="text/javascript"></script>
</head>
<body>
   <div id="logo"><a href="index.php"><img src="img/logo_pattrends.png" alt="Pattrends" /></a></div>
<div id="resultados">
	<div style="min-height:75px;"></div>
	
	<div class="sep"></div>
	<div id="patent">
	
	<h1><?php echo $this->scope["title"];?> <a href="<?php echo $this->scope["link"];?>" target="_blank" style="color:#EEEEEE;">@patft.uspto.gov</a> </h1>
		
	<div class="info" style="margin-right:10px;">
		<ul>
			<li>Patent number: <?php echo $this->scope["id"];?></li>
			<li>Date: <?php echo $this->scope["date"];?></li>
			<li>Corp.: </li>
		</ul>
	</div>
	
	<div class="info">
		<ul>
			<li>Application date: <?php echo $this->scope["appl_date"];?></li>
			<li>Application type: <?php echo $this->scope["appl_type"];?></li>
			<li>Application number: <?php echo $this->scope["appl_number"];?></li>
		</ul>	
	</div>
	
	<div style="clear:both;"></div>
	
	<p class="abstract"><?php echo $this->scope["abstract"];?></p>
	
	<div class="description">
		<h2>DESCRIPTION</h2>
		<p><?php echo $this->scope["description"];?></p>
	</div>
	<div class="claims">
		<h2>CLAIMS</h2>
		<p><?php echo $this->scope["claims"];?></p>
	</div>
		
	</div>
</div>
</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>