<?php
include("../config/config.php");

if(@$_POST['stopword'] != "")
{
    $stopwords = new Stopwords();
    $stopwords->create($_POST['stopword']);
    header("Location: stopwords.php");

}
?>
<?php 
    include("inc/cabecalho.php");
?>
<form action="stopword_create.php" method="post">
    <label for="nome">Stopword</label>
    <input type="text" name="stopword" />
    <input type="submit" value="Salvar" />
</form>

<?php
    include("inc/rodape.php"); 
?>
