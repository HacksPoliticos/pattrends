<?php
include("../config/config.php");
include("inc/cabecalho.php");
?>

<?php
$stopwords = new Stopwords();

if(@$_GET['p'] != ""){ $p = $_GET['p'];} else { $p = 1;}
$resultado = $stopwords->retrieve_array($p, 30);

echo "<a href=\"stopword_create.php\" class=\"icons create\"><span>create</span></a>";
echo "<a href=\"stopword_remove.php\" class=\"icons delete\" title=\"remover stopwords do banco de dados\"><span>create</span></a>";


if($resultado['resultados'] != 0)
{
    foreach ($resultado['resultados'] as $r)
    {
        echo "<div class=\"resultados\" />";
            echo "<div class=\"controles\" />";
                echo "<a href=\"stopword_update.php?id=".$r['id']."\" class=\"icons update\"><span>update</span></a>";
                echo "<a href=\"stopword_delete.php?id=".$r['id']."\" class=\"icons delete\"><span>delete</span></a>";
            echo "</div>";
            echo $r['stopword'];
        echo "</div>";
    }
}
else
{
    echo "<h3 class=\"erro\">Oops! nenhum resultado =/</h3>";
}

echo $resultado['paginacao'];

?>

<?php
include("inc/rodape.php");
?>
