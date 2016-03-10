<?php
function printTagCloud($tags) {
        $max_size = 60;
        $min_size = 12;
       
        $max_qty = $tags[0]["weight"];
        $min_qty = $tags[count($tags) - 1]["weight"];
        
        //DA UMA EMBARALHADA NOS TRECO
        //shuffle($tags);
        
        $spread = $max_qty - $min_qty;
        if ($spread == 0) {
                $spread = 1;
        }
       
        $step = ($max_size - $min_size) / ($spread);
       
        
        foreach ($tags as $tag) {
                $size = round($min_size + (($tag["weight"] - $min_qty) * $step));
                echo '<a href="search.php?q=' . $tag["name"] . '" class="tag" style="font-size: ' . $size . 'px"
                title="' . $tag["weight"] . ' things tagged with ' . $tag["name"] . '">' . $tag["name"] . '</a><span class="qtd">(' . $tag["weight"] . ')</span> ';
        }
}
?>