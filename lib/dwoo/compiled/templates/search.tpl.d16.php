<?php
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
ob_start(); /* template body */ ?><html>
<head>
    <title>Pattrends</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
    <script src="js/search.js" type="text/javascript"></script>
</head>
<body>
	<div id="logo"><a href="index.php"><img src="img/logo_pattrends.png" alt="Pattrends" /></a></div>
<div class="resultado">
	
	<?php echo Dwoo_Plugin_include($this, 'search_ajax.tpl', null, null, null, '_root', null);?>

	
</div>
</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>