<?php
include("../config/config.php");

$stopwords = new Stopwords();

if(@$_POST['confirma'] != "")
{
    $stopwords->create($_POST['stopword']);
    header("Location: stopwords.php");

}
?>
<?php 
    include("inc/cabecalho.php");
?>

<?php
$dados = new Dados();
$sql = "
        DELETE tags, patent_tags
        FROM patent_tags
        JOIN tags ON (patent_tags.id_tag = tags.id)
        JOIN stopwords ON (name = stopword)
        ";

$patents = $dados->update($sql);
echo "$patents tags removidas";

?>

<?php
    include("inc/rodape.php"); 
?>
