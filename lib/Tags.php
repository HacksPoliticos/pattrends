<?php
class Tags
{
    var $conexao;
    var $tabela;
    
    var $id;
	var $name;
    
    public function __construct()
    {
        $this->conexao = new Dados();
        $this->tabela  = "tags";
    }
    
    public function __destruct()
    {
    }
    
    public function create($name)
    {
        $this->name = trim($name);
        
        $this->id   = $this->conexao->insert("INSERT INTO $this->tabela (name) VALUES ('$this->name')");
        return $this->id;
    }
	
	public function get_id($name, $criar=1)
    {
        $this->name   = $name;
        $resultado = $this->conexao->select("SELECT * FROM $this->tabela WHERE name = '$this->name'");
            if($resultado == 0 && $criar==1)
            {
                return $this->create($name);
                
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
