	<div class="form">
	<form action="search.php" style="margin-top:40px; margin-bottom:10px;" class="ajax">
        <input type="text" name="q" id="q" class="q" value="{$q|default:"TAGS"}" />
        <input type="text" name="a" id="a" class="a" value="{$a|default:"CORPS"}" />
        
		<br /><label for="date_s" class="label_date">start date</label><label for="date_e" class="label_date">end date</label><br />
        <input type="text" name="ds" id="ds" value="{$date_start}" class="date" /><input type="text" name="de" id="de" value="{$date_end}" class="date" /><input type="submit" value="Search" class="search" />
        
    </form>
	</div>