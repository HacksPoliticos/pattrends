	{include('search_form.tpl')}
	
	<div class="sep"></div>
	
	<div class="info">
		<ul>
			<li>US granted patents from {$date_start} to {$date_end}</li>
			<li>Containing {$q|default:"all"} tag(s)</li>
			<li>From {$a|default:"all corps"} </li>
		</ul>
	</div>
	
	<div class="control">
		<a href="#close" class="close button">Close</a>
		<a href="javascript:;" class="compare button">compare</a>
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="tags">
	{foreach $tags tag}
		<a class="tag" title="appears {$tag.weight} times" style="font-size: {$tag.size}px;" href="search.php?q={$tag.name}">{$tag.name}</a>
	{/foreach}
	</div>
	
	<div class="assignees">
		<ul>
	{foreach $assignees assignee}
		<li><a class="assignee" title="{$assignee.weight}" style="font-size: 12px;" href="search.php?a={$assignee.name}">{$assignee.name}</a></li>
	{/foreach}
		</ul>
	</div>
	
	
	<div style="clear:both;"></div>
	
	
	<!--EXPERIMENTO -->
	
	
	{if $grafico}
	<table class="grafico">
				<caption>From {$date_start} to {$date_end}</caption>
			<thead>
				<tr>
					<td></td>
					{foreach $grafico g}
					<th>{$g.date}</th>
					{/foreach}

				</tr>
			</thead>
			<tbody>
				<tr>
					<th>{$q}</th>
					{foreach $grafico g}
					<td>{$g.qtdde}</td>
					{/foreach}
					
				</tr>
				
			</tbody>
		</table>
	{/if}
	<!-- FIM EXPERIMENTO -->
	<div class="sep"></div>
	
	<div class="patents">
	{foreach $patents patent}
		<div class="patent">
		<h3><a href="patent.php?id={$patent.id}" class="title">{$patent.title}</a></h3>
		<!--<p class="abstract">{$patent.abstract}</p>-->
		</div>
	{/foreach}
	</div>