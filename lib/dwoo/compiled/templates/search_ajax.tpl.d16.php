<?php
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
ob_start(); /* template body */ ?>	<?php echo Dwoo_Plugin_include($this, 'search_form.tpl', null, null, null, '_root', null);?>

	
	<div class="sep"></div>
	
	<div class="info">
		<ul>
			<li>US granted patents from <?php echo $this->scope["date_start"];?> to <?php echo $this->scope["date_end"];?></li>
			<li>Containing <?php echo (($tmp = (isset($this->scope["q"]) ? $this->scope["q"] : null))===null||$tmp==='' ? "all" : $tmp);?> tag(s)</li>
			<li>From <?php echo (($tmp = (isset($this->scope["a"]) ? $this->scope["a"] : null))===null||$tmp==='' ? "all corps" : $tmp);?> </li>
		</ul>
	</div>
	
	<div class="control">
		<a href="#close" class="close button">Close</a>
		<a href="javascript:;" class="compare button">compare</a>
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="tags">
	<?php 
$_fh0_data = (isset($this->scope["tags"]) ? $this->scope["tags"] : null);
if ($this->isArray($_fh0_data) === true)
{
	foreach ($_fh0_data as $this->scope['tag'])
	{
/* -- foreach start output */
?>
		<a class="tag" title="appears <?php echo $this->scope["tag"]["weight"];?> times" style="font-size: <?php echo $this->scope["tag"]["size"];?>px;" href="search.php?q=<?php echo $this->scope["tag"]["name"];?>"><?php echo $this->scope["tag"]["name"];?></a>
	<?php 
/* -- foreach end output */
	}
}?>

	</div>
	
	<div class="assignees">
		<ul>
	<?php 
$_fh1_data = (isset($this->scope["assignees"]) ? $this->scope["assignees"] : null);
if ($this->isArray($_fh1_data) === true)
{
	foreach ($_fh1_data as $this->scope['assignee'])
	{
/* -- foreach start output */
?>
		<li><a class="assignee" title="<?php echo $this->scope["assignee"]["weight"];?>" style="font-size: 12px;" href="search.php?a=<?php echo $this->scope["assignee"]["name"];?>"><?php echo $this->scope["assignee"]["name"];?></a></li>
	<?php 
/* -- foreach end output */
	}
}?>

		</ul>
	</div>
	
	
	<div style="clear:both;"></div>
	
	
	<!--EXPERIMENTO -->
	
	
	<?php if ((isset($this->scope["grafico"]) ? $this->scope["grafico"] : null)) {
?>
	<table class="grafico">
				<caption>From <?php echo $this->scope["date_start"];?> to <?php echo $this->scope["date_end"];?></caption>
			<thead>
				<tr>
					<td></td>
					<?php 
$_fh2_data = (isset($this->scope["grafico"]) ? $this->scope["grafico"] : null);
if ($this->isArray($_fh2_data) === true)
{
	foreach ($_fh2_data as $this->scope['g'])
	{
/* -- foreach start output */
?>
					<th><?php echo $this->scope["g"]["date"];?></th>
					<?php 
/* -- foreach end output */
	}
}?>


				</tr>
			</thead>
			<tbody>
				<tr>
					<th><?php echo $this->scope["q"];?></th>
					<?php 
$_fh3_data = (isset($this->scope["grafico"]) ? $this->scope["grafico"] : null);
if ($this->isArray($_fh3_data) === true)
{
	foreach ($_fh3_data as $this->scope['g'])
	{
/* -- foreach start output */
?>
					<td><?php echo $this->scope["g"]["qtdde"];?></td>
					<?php 
/* -- foreach end output */
	}
}?>

					
				</tr>
				
			</tbody>
		</table>
	<?php 
}?>

	<!-- FIM EXPERIMENTO -->
	<div class="sep"></div>
	
	<div class="patents">
	<?php 
$_fh4_data = (isset($this->scope["patents"]) ? $this->scope["patents"] : null);
if ($this->isArray($_fh4_data) === true)
{
	foreach ($_fh4_data as $this->scope['patent'])
	{
/* -- foreach start output */
?>
		<div class="patent">
		<h3><a href="patent.php?id=<?php echo $this->scope["patent"]["id"];?>" class="title"><?php echo $this->scope["patent"]["title"];?></a></h3>
		<!--<p class="abstract"><?php echo $this->scope["patent"]["abstract"];?></p>-->
		</div>
	<?php 
/* -- foreach end output */
	}
}?>

	</div><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>