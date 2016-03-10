<?php
include("config/config.php");
include("function.criatagclouds.php");
include("function.printtagclouds.php");

?>
<html>
<head>
    <title>Pattrends</title>
    
    <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
    
    <link type="text/css" rel="stylesheet" href="css/visualize.jQuery.css"/>
    <link type="text/css" rel="stylesheet" href="css/demopage.css"/>
    <!--[if IE]><script type="text/javascript" src="js/excanvas.compiled.js"></script><![endif]-->
	<script type="text/javascript" src="js/visualize.jQuery.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    
    <script src="js/index.js" type="text/javascript"></script>
    
    <link rel="stylesheet" type="text/css" href="js/ui/css/ui-darkness/jquery-ui-1.7.2.custom.css" />
    <script type="text/javascript" src="js/ui/js/jquery-ui-1.7.2.custom.min.js"></script>
    
    

</head>
<body>
   <div id="loading"><div><img src="img/ajax.gif" alt="Loading" /> Loading </div></div>
   <div id="logo"><img src="img/logo_pattrends.png" alt="Pattrends" /></div>
   <!--<a href="javascript:;" id="reset" class="button">reset</a>-->
   
   <div id="resultados"></div>
</body>
</html>