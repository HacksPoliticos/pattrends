<form method="get" action="teste_form_submit">
    <input type="text" name="text" value="<?php echo $_GET['text']?>" /> <input type="submit" />
    </form>
<?php

$text = trim(strtolower($_GET['text']));

echo $text . "<hr>";

function explodeOrNot($sep, $text)
{
    if(strrpos($text, $sep) != null)
    {
        $text = explode($sep, trim($text));
        return $text;
    }
    else
    {
        return $text;
    }
}

$text = explodeOrNot(",", $text);

echo "<pre>";
print_r($text);
echo "</pre>";

if(is_array($text))
{
    foreach($text as $t)
    {
        $text_novo[] = explodeOrNot(" ", trim($t));
    }
    $text = $text_novo;
}
else
{
    $text = explodeOrNot(" ", trim($text));
}

echo "<pre>";
print_r($text);
echo "</pre>";
/*
strpos
explode
*/


?>