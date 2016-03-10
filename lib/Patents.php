<?php
class Patents
{
    var $conexao;
    var $tabela;
    
    var $id;
	var $title;
	var $abstract;
	var $claims;
	var $description;
	var $date;
	var $appl_type;
	var $appl_number;
	var $appl_date;
    
    var $tags;
    var $abstract_tags;
    var $claims_tags;
    var $description_tags;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "patents";
    }
    
    public function __destruct()
    {
    }
    
    public function create($id, $title ,$abstract, $claims, $description, $date, $appl_type, $appl_number, $appl_date)
    {
        $this->id          = mysql_real_escape_string($id);
        $this->title       = mysql_real_escape_string($title);
        $this->abstract    = mysql_real_escape_string($abstract);
        $this->claims      = mysql_real_escape_string($claims);
        $this->description = mysql_real_escape_string($description);
        $this->date        = mysql_real_escape_string($date);
        $this->appl_type   = mysql_real_escape_string($appl_type);
        $this->appl_number = mysql_real_escape_string($appl_number);
        $this->appl_date   = mysql_real_escape_string($appl_date);
        
        $this->conexao->insert("INSERT INTO $this->tabela (id, title ,abstract, claims, description, date, appl_type, appl_number, appl_date) VALUES ('$this->id', '$this->title' ,'$this->abstract', '$this->claims', '$this->description', '$this->date', '$this->appl_type', '$this->appl_number', '$this->appl_date')");
        return $this->id;
    }
    
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
                
                /*
                $claims_tags = new PatentTags();
                $this->claims_tags = $claims_tags->retrieve_array($this->id);
                unset($claims_tags);
                
                $description_tags = new PatentTags();
                $this->description_tags = $description_tags->retrieve_array($this->id);
                unset($description_tags);
                */
                
                
                return 1;    
            }
        
    }
    
    public function exists($id)
    {
        $this->id   = $id;
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela WHERE id = '$this->id'");
            if($resultado == 0)
            {
                return 0;
                
            }
            else
            {
                return 1;    
            }
        
    }
    
    public function update($id, $claims, $description)
    {
        $this->id     = $id;
        $this->claims      = mysql_real_escape_string($claims);
        $this->description = mysql_real_escape_string($description);
        return $this->conexao->update("UPDATE $this->tabela SET claims = '$this->claims', description = '$this->description'  WHERE id = '$this->id'");
        
    }
    
    /*
    public function delete($id)
    {
        $this->id = $id;
        return $this->conexao->delete("DELETE FROM $this->tabela WHERE id = '$this->id'");
    }
    
    public function update($id, $nome)
    {
        $this->id   = $id;
        $this->nome = $nome;
        return $this->conexao->update("UPDATE $this->tabela SET id = '$this->id', nome = '$this->nome' WHERE id = '$this->id'");
    }
    
    public function retrieve_array($pagina=1, $tamanho_pagina=10, $criterio=" 1=1 ", $ordem=" id DESC ")
    {
        return $this->conexao->retrieve_array($this->tabela, $criterio, $ordem, $pagina, $tamanho_pagina);
    }
    */
    
    
}
?>
