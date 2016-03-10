<?php

function criatagclouds($array, $texto, $css_max="50", $css_min="10", $quantidade="30")
{
    
    $quantidade_tags = count($array);
    
    if($quantidade_tags > $quantidade)
    {
        $quantidade_tags = $quantidade;
    }
    
    for($x = 0; $x < $quantidade_tags; $x++)
    {
        $tags[$x]['id']     = $array[$x]['id'];
        $tags[$x]['name']   = $array[$x]['name'];
        $tags[$x]['weight'] = $array[$x]['weight'];
    }
    
    $weight_min = $tags[0]['weight'];
    $weight_max = $tags[($quantidade_tags - 1)]['weight'];
    
    $razao_css    =  $weight_min / $weight_max;
    $razao_weight =  $css_min / $css_max;
    
    foreach($tags as $tag)
    {
        /*
        $size    -> $tag['weight']
        $css_max -> $weight_max
        
        $size = $tag['weight'] * $css_max / $weight_max;
        $css_min -> $weight_min
        */
        
        $size = $razao_css * $tag['weight'] / $razao_weight;
        
        /*
         

            function random_color(){
                mt_srand((double)microtime()*1000000);
                $c = '';
                while(strlen($c)<6){
                    $c .= sprintf("%02X", mt_rand(0, 255));
                }
                return $c;
            }


        */
        
                mt_srand((double)microtime()*1000000);
                $color = '';
                while(strlen($color)<6){
                    $color .= sprintf("%02X", mt_rand(0, 255));
                }
        
        $search = $tag['name'];
        $replace = "<span style=\"font-size:30px; color:" . $color . ";\"> " . $tag['name'] . " </span>";
        
        if (rand(0,1) == 1)
        {
            $posicao = strpos($texto, $search);    
        }
        else
        {
            $posicao = strripos($texto, $search);    
        }
        
        
        
        $trecho_texto_1 = substr($texto, 0, $posicao);
        $trecho_texto_2 = substr($texto, ($posicao + strlen($search)));
        
        $texto = $trecho_texto_1 . $replace . $trecho_texto_2;
        //SUBSTITUI TODOS
        //$texto = str_ireplace($search, $replace, $texto, $count);
    }
    
    return $texto;    
}
?>