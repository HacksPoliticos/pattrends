<?php
class PatentAssignees
{
    var $conexao;
    var $tabela;
    
    var $id_patent;
	var $id_assignees;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "patent_assignees";
    }
    
    public function __destruct()
    {
    }
    
    public function create($id_patent, $id_assignees)
    {
        $this->id_patent    = $id_patent;
		$this->id_assignees = $id_assignees;
        
        $this->id   = $this->conexao->insert("INSERT INTO $this->tabela (id_patent, id_assignee) VALUES ('$this->id_patent', '$this->id_assignees')");
		echo mysql_error();
        return $this->id;
    }
	
	public function retrieve_array($id_patent)
    {
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela JOIN assignees on (id = id_assignee) WHERE id_patent = '$id_patent' ORDER BY weight DESC, orgname");
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
