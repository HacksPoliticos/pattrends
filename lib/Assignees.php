<?php
class Assignees
{
    var $conexao;
    var $tabela;
    
    var $id;
	var $orgname;
	var $alias;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "assignees";
    }
    
    public function __destruct()
    {
    }
    
    public function create($orgname)
    {
        $this->orgname = trim($orgname);
        
        $this->id   = $this->conexao->insert("INSERT INTO $this->tabela (orgname) VALUES ('$this->orgname')");
        return $this->id;
    }
	
	public function get_id($orgname, $criar=1)
    {
        $this->orgname   = $orgname;
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela WHERE orgname = '$this->orgname'");
            if($resultado == 0 && $criar==1)
            {
                return $this->create($orgname);
                
            }
            else
            {
                return $resultado[0]['id'];
            }
        
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
