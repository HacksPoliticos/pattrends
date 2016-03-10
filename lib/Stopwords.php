<?php
class Stopwords
{
    var $conexao;
    var $tabela;
    
    var $id;
	var $stopword;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "stopwords";
    }
    
    public function __destruct()
    {
    }
    
    public function create($stopword)
    {
        $this->stopword    = mysql_real_escape_string(strtolower($stopword));
        
        $this->conexao->insert("INSERT INTO $this->tabela (stopword) VALUES ('$this->stopword')");
        return $this->id;
    }
	
	public function delete($id)
    {
        $this->id = $id;
        return $this->conexao->delete("DELETE FROM $this->tabela WHERE id = '$this->id'");
    }
	
	public function retrieve_array($pagina=1, $tamanho_pagina=10, $criterio=" 1=1 ", $ordem=" stopword ASC ")
    {
        return $this->conexao->retrieve_array($this->tabela, $criterio, $ordem, $pagina, $tamanho_pagina);
    }
    
    /*
	
    public function retrieve($id)
    {
        $this->id   = $id;
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela WHERE id = '$this->id'");
            if($resultado == 0)
            {
                return 0;
                
            }
            else
            {
                $this->title       = $resultado[0]['title'];
                $this->abstract    = $resultado[0]['abstract'];
                $this->claims      = $resultado[0]['claims'];
                $this->description = $resultado[0]['description'];
                $this->date        = $resultado[0]['date'];
                $this->appl_type   = $resultado[0]['appl_type'];
                $this->appl_number = $resultado[0]['appl_number'];
                $this->appl_date   = $resultado[0]['appl_date'];
                
                $tags = new PatentTags();
                $this->tags = $tags->retrieve_array($this->id);
                unset($tags);
                
                
                return 1;    
            }
        
    }
    
    public function update($id, $claims, $description)
    {
        $this->id     = $id;
        $this->claims = mysql_real_escape_string($claims);
        $this->description = mysql_real_escape_string($description);
        return $this->conexao->update("UPDATE $this->tabela SET claims = '$this->claims', description = '$this->description'  WHERE id = '$this->id'");
        
    }
	 
    
    
    public function update($id, $nome)
    {
        $this->id   = $id;
        $this->nome = $nome;
        return $this->conexao->update("UPDATE $this->tabela SET id = '$this->id', nome = '$this->nome' WHERE id = '$this->id'");
    }
    */
    
    
}
?>
