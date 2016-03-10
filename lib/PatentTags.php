<?php
class PatentTags
{
    var $conexao;
    var $tabela;
    
    var $id_patent;
	var $id_tag;
	var $date;
	var $weight;
	var $tag_from;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "patent_tags";
    }
    
    public function __destruct()
    {
    }
    
    public function create($id_patent, $id_tag, $date, $weight, $tag_from)
    {
        $this->id_patent = $id_patent;
		$this->id_tag    = $id_tag;
		$this->date      = $date;
		$this->weight    = $weight;
		$this->tag_from  = $tag_from;
        
        $this->id   = $this->conexao->insert("INSERT INTO $this->tabela (id_patent, id_tag, date, weight, tag_from) VALUES ('$this->id_patent', '$this->id_tag', '$this->date', '$this->weight', '$this->tag_from')");
        return $this->id;
    }
	
	public function retrieve_array($id_patent)
    {
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela JOIN tags on (id = id_tag) WHERE id_patent = '$id_patent' ORDER BY weight DESC, name");
		return $resultado;        
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
    
    public function retrieve($id)
    {
        $this->id   = $id;
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela WHERE id = $this->id");
            if($resultado == 0)
            {
                return $resultado;
                
            }
            else
            {
                $this->id = $resultado[0]['id'];
                $this->nome = $resultado[0]['nome'];
                return 1;    
            }
        
    }
    
    public function retrieve_array($pagina=1, $tamanho_pagina=10, $criterio=" 1=1 ", $ordem=" id DESC ")
    {
        return $this->conexao->retrieve_array($this->tabela, $criterio, $ordem, $pagina, $tamanho_pagina);
    }
    */
    
    
}
?>
