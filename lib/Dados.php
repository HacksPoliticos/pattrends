<?php
class Dados
{
    /*
     constantes que eu uso nessa classe
     BD_ENDERECO
     BD_BANCO
     BD_USUARIO
     BD_SENHA
    */
    
    var $conexao;
    
    public function __construct()
    {
        $this->conexao = mysql_connect(BD_ENDERECO, BD_USUARIO, BD_SENHA);
        mysql_select_db(BD_BANCO, $this->conexao);
    }
    
    public function __destruct()
    {
        //mysql_close($this->conexao);
    }
    
    /*
     retona uma array associativa, caso nao tenha nenhum resultado retorna 0
    */
    public function select($sql)
    {
        //$sql = mysql_real_escape_string($sql);
        $resultado = mysql_query($sql);
        //echo mysql_error();
        
        $linhas = mysql_numrows($resultado);
        
        if($linhas > 0)
        {
            for($x = 0; $x < $linhas; $x++)
            {
                $retorno[] = mysql_fetch_assoc($resultado);
            }

            return($retorno);
        }
        else
        {
            return 0;
        }
    }
    
    public function insert($sql)
    {
        mysql_query($sql);
        return mysql_insert_id();
    }
    
    public function update($sql)
    {
        mysql_query($sql);
        return mysql_affected_rows();
    }
    
    /*
     Chama o edit pra reciclar o codigo
    */
    public function delete($sql)
    {
        $this->update($sql);
    }
    
    // retrieve_list é mais legal pra nome
    public function retrieve_array($tabela, $criterio=" 1=1 ", $ordem=" id DESC ", $pagina=1, $tamanho_pagina=10)
    {
        $total = $this->select("SELECT * FROM $tabela WHERE $criterio");
        $total = count($total);
        
        if($total <= $tamanho_pagina || $tamanho_pagina == -1)
        {
            $retorno['paginacao'] = null;
            $retorno['resultados'] = $this->select("SELECT * FROM $tabela WHERE $criterio ORDER BY $ordem");
        }
        else
        {
            $quantidade_paginas = ceil($total / $tamanho_pagina);
            
            $limite = " " . (($pagina - 1) * $tamanho_pagina) . ",$tamanho_pagina ";
            
            
            $paginacao = "<div class=\"paginacao\">";
            
            for($p = 1; $p <= $quantidade_paginas; $p++)
            {
                $paginacao .= "<a href=\"?p=$p\"";
                    if($pagina == $p)
                    {
                        $paginacao .= " class=\"atual\" ";
                    }
                $paginacao .= ">$p</a>";    
            }
            
            $paginacao .= "</div>";
           
            
            $retorno['paginacao'] = $paginacao;
            $retorno['paginas'] = $quantidade_paginas;
            $retorno['pagina_atual'] = $pagina;
            $retorno['resultados'] = $this->select("SELECT * FROM $tabela WHERE $criterio ORDER BY $ordem LIMIT $limite");
            
        }
        
        return $retorno;
        
    }
    
}
?>
