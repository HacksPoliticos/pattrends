<?php

function criatags($text, $lang="en")
{
    $text = strtolower($text);
    
    //pesquisa stopwords em ingles
    //$ignore_words = array("nao", "era", "ao", "na", "em", "de", "para", "as", "no", "do", "da");
    //$ignore_words = array('a','able','about','across','after','all','almost','also','am','among','an','and','any','are','as','at','be','because','been','but','by','can','cannot','could','dear','did','do','does','either','else','ever','every','for','from','get','got','had','has','have','he','her','hers','him','his','how','however','i','if','in','into','is','it','its','just','least','let','like','likely','may','me','might','most','must','my','neither','no','nor','not','of','off','often','on','only','or','other','our','own','rather','said','say','says','she','should','since','so','some','than','that','the','their','them','then','there','these','they','this','tis','to','too','twas','us','wants','was','we','were','what','when','where','which','while','who','whom','why','will','with','would','yet','you','your');
    
    
        $stopwords = new Stopwords();
        $resultado = $stopwords->retrieve_array(1, -1);
        foreach($resultado['resultados'] as $r)
        {
            $stopwords_array[] = $r['stopword'];
        }
        unset($resultado);
        $ignore_words = $stopwords_array;
        unset($stopwords_array);
    
    $ignore_chars = array(".", "'", '"', ",", "(", ")", "\n", "“", "”", ":", ";", "%");
    
    //remove os caracteres inuteis
    $text = str_ireplace($ignore_chars, "", $text);
    
    $text_array = explode(" ", $text);

    $word_count = array();
    
    foreach ($text_array as $word)
    {
        $word = trim($word);
        @$word_count[$word]++;
        
        if($word_count[$word] == 1)
        {
            $words[] = $word;
        }
    }
    
    $total_words = count($word_count);
    $nota_de_corte = 0.03 * $total_words;
    
    
    $max = 0;
    $min = 1;
    for($x = 0; $x < $total_words; $x++)
    {
        $palavra    = $words[$x];
        $quantidade = $word_count[$words[$x]];
        
        if($quantidade >= $nota_de_corte && !array_search(strtolower($palavra), $ignore_words) && strlen($palavra) > 1 && !is_numeric($palavra))
        {
            $results[] = array($palavra, $quantidade);
            
            if($quantidade > $max)
            {
                $max = $quantidade;
            }
            elseif
            ($quantidade < $min)
            {
                $min = $quantidade;
            }
            else
            {
                $min = $quantidade;
            }
        }
        
    }
    
    return $results;


}


/*
echo $max . " - " . $min;
echo "<hr>";

$css_max = 35;
$css_min = 11;

foreach($results as $r)
{
    $tamanho = $r[1] * $css_max / $max;
    if($tamanho < $css_min){$tamanho = $css_min;}
    
    echo "<div style=\"float:left; font-size:" . $tamanho . "px\">";
    echo "<a href=\"#\" title=\"" . $r[1] . "\">";
    echo $r[0];
    echo "</a>";
    echo "</div>";
}

echo "</pre>";
 */


//EXEMPLO USANDO O tagthe
        /*
        if($xml->abstract->p != "")
        {
            echo "\nTAGS\n";
            $tags = simplexml_load_file("http://tagthe.net/api/?text=" . urlencode($xml->abstract->p));
            foreach($tags->children()->meme->dim->item as $tag)
            {
                echo ($tag . " ");
            }
        }
        */
        
        
?>