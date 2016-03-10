<?php
ob_start(); /* template body */ ?>	<div class="form">
	<form action="search.php" style="margin-top:40px; margin-bottom:10px;" class="ajax">
        <input type="text" name="q" id="q" class="q" value="<?php echo (($tmp = (isset($this->scope["q"]) ? $this->scope["q"] : null))===null||$tmp==='' ? "TAGS" : $tmp);?>" />
        <input type="text" name="a" id="a" class="a" value="<?php echo (($tmp = (isset($this->scope["a"]) ? $this->scope["a"] : null))===null||$tmp==='' ? "CORPS" : $tmp);?>" />
        
		<br /><label for="date_s" class="label_date">start date</label><label for="date_e" class="label_date">end date</label><br />
        <input type="text" name="ds" id="ds" value="<?php echo $this->scope["date_start"];?>" class="date" /><input type="text" name="de" id="de" value="<?php echo $this->scope["date_end"];?>" class="date" /><input type="submit" value="Search" class="search" />
        
    </form>
	</div><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>