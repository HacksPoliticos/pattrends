<?php
include("../config/config.php");
include("function.consomepatentes.php");

if($_GET["file"] == "")
{
    die("morri!");
}

$time_start = microtime(true);

$path = XML_PATH;
$file = $_GET["file"];
//$file = "ipgb20090721_compacto.xml";

$texto_separador = "</us-patent-grant>";

#############################################################################################################

    //TEXTO DO XML QUE SERA LIDO
    $text = file_get_contents($path . $file);
    
    //PRECISA FAZER ISSO PORQUE TEM VARIOS XMLs CONCATENADOS DENTRO DO ARQUIVO
    $patentes = explode($texto_separador, $text);
    
    //SEMPRE SOBRA ALGUM LIXO NO FINAL
    array_pop($patentes);
    
    $total_patentes = count($patentes); 
    //echo "achei: " . $total_patentes . " patentes <br>";
    
    //GUARDO AS PATENTES AQUI
    $array_patentes = array();
    
    foreach($patentes as $p)
    {
        //TRANSFORMA O TEXTO EM UM OBJETO SIMPLEXML
        $xml = simplexml_load_string(trim($p . $texto_separador));
        
        /*
        echo "<pre>";
        print_r($xml);
        echo "</pre>";
        */
        
        //TO COM UM PROBLEMA SERIO COM AS PATENTES DE DESIGN ENTAO VOU TIRAR ELAS DA 'EQUACAO' POR ENQUANTO        
        if($xml->{"us-bibliographic-data-grant"}->{"application-reference"}->attributes()->{"appl-type"} != "design000000")
        {
            $array_patente = array();
            
            //NUMERO DA PATENTE
            $numero_patente = $xml->{"us-bibliographic-data-grant"}->{"publication-reference"}->{"document-id"}->{"doc-number"};
            $array_patente['patent_number'] = $numero_patente;
            
            //DATA
            $array_patente['date'] = $xml->attributes()->{"date-publ"};            
            
            //TITULO
            $array_patente['title'] = $xml->{"us-bibliographic-data-grant"}->{"invention-title"};
            
            //REFERENCIAS
            $references = array();
            foreach($xml->{"us-bibliographic-data-grant"}->{"references-cited"}->children() as $referencias)
                {                    
                    if(@$referencias->{"patcit"}->{"document-id"}->{"doc-number"} != "")
                    {
                        $docnumber = $referencias->{"patcit"}->{"document-id"}->{"doc-number"};
                        $name      = $referencias->{"patcit"}->{"document-id"}->{"name"};
                        $date      = $referencias->{"patcit"}->{"document-id"}->{"date"};
                        $country   = $referencias->{"patcit"}->{"document-id"}->{"country"};
                        
                        $references[] = array($docnumber, $name, $date, $country);
                        
                        unset($docnumber);
                        unset($name);
                        unset($date);
                        unset($country);
                    }
                }
                
            $array_patente['references'] = $references;
            
            //OUTRAS REFERENCIAS
            $references_other = array();
            foreach($xml->{"us-bibliographic-data-grant"}->{"references-cited"}->children() as $referencias)
                {
                    if(@$othercit = $referencias->{"nplcit"}->{"othercit"} != "")
                    {
                        $othercit = $referencias->{"nplcit"}->{"othercit"};
                        $category = $referencias->{"nplcit"}->{"category"};
                        
                        $references_other[] = array($othercit, $category);
                        
                        unset($othercit);
                        unset($category);
                    }
                }
            $array_patente['references_other'] = $references_other;
            
            //ABSTRACT
            $array_patente['abstract'] = $xml->abstract->p;            
            
            //APPL INFO
            $array_patente['appl-type'] = $xml->{"us-bibliographic-data-grant"}->{"application-reference"}->attributes()->{"appl-type"};
            $array_patente['appl-doc-number'] = $xml->{"us-bibliographic-data-grant"}->{"application-reference"}->{"document-id"}->{"doc-number"};
            $array_patente['appl-date'] = $xml->{"us-bibliographic-data-grant"}->{"application-reference"}->{"document-id"}->{"date"};
            
            //PARITES - INVENTORES
            $parties = array();
            foreach($xml->{"us-bibliographic-data-grant"}->{"parties"}->applicants->children() as $p)
            {                
                $lastname  = $p->addressbook->{"last-name"};
                $firstname = $p->addressbook->{"first-name"};
                $country   = $p->addressbook->address->country;
                
                $parties[] = array($lastname, $firstname, $country);
                
                unset($lastname);
                unset($firstname);
                unset($country);
                
            }
            $array_patente['parties'] = $parties;
            
            //ASSIGNEES - EMPRESAS
            $assignees = array();
            foreach($xml->{"us-bibliographic-data-grant"}->{"assignees"}->children() as $a)
            {
                /*
                echo $a->{"addressbook"}->{"orgname"};
                echo $a->{"addressbook"}->address->country;
                */
                $orgname = $a->{"addressbook"}->{"orgname"};
                $country = $a->{"addressbook"}->address->country;
                
                $assignees[] = array($orgname, $country);
                
                unset($orgname);
                unset($country);
                
            }
            $array_patente['assignees'] = $assignees;
            
            /*FIGURES
            echo "\n\nFiguras e drawings\n";
            echo(@$xml->{"us-bibliographic-data-grant"}->{"figures"}->{"number-of-drawing-sheets"});
            echo "\n";
            echo(@$xml->{"us-bibliographic-data-grant"}->{"figures"}->{"number-of-figures"});
            */
            
            ####################################################################
            #SALVANDO NO BANCO DE DADOS
            
            
            
            
            $id          = $array_patente["patent_number"];
            $title       = $array_patente["title"];
            $abstract    = $array_patente["abstract"];
            $claims      = null;
            $description = null;
            $date        = $array_patente["date"];
            $appl_type   = $array_patente["appl-type"];
            $appl_number = $array_patente["appl-doc-number"];
            $appl_date   = $array_patente["appl-date"];
            
            $patent = new Patents();
            
            //TRANSFORMO O OBJETO NO NUMERO DA PATENTE (DEPOIS DE CRIAR A PATENTE)
            $patent = $patent->create($id, $title ,$abstract, $claims, $description, $date, $appl_type, $appl_number, $appl_date);
            //echo mysql_error();
            
            $parties   = $array_patente["parties"];
            $assignees = $array_patente["assignees"];
                foreach($assignees as $a)
                {
                    $assignee = new Assignees();
                    $id_assignee  = $assignee->get_id($a[0]);
        
                        $patent_assignees = new PatentAssignees();
                        $patent_assignees->create($patent, $id_assignee);
                        unset($patent_assignees);
                        
                    unset($assignee);
                }
            
            $references       = $array_patente["references"];
            $references_other = $array_patente["references_other"];
            
            //TAGS
            /*
            $description_tags = $array_patente["description_tags"];
                foreach($description_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
        
                        $description_tags = new PatentTags();
                        $description_tags->create($patent, $id_tag, $weight, "description");
                        unset($description_tags);
                        
                    unset($tag);
                }
            
            $claims_tags      = $array_patente["claims_tags"];
                foreach($claims_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
                    
                        $claims_tags = new PatentTags();
                        $claims_tags->create($patent, $id_tag, $weight, "claims");
                        unset($claims_tags);
                        
                    unset($tag);
                }
            
                
            $abstract_tags    = $array_patente["abstract_tags"];
                foreach($abstract_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
                    
                        $abstract_tags = new PatentTags();
                        $abstract_tags->create($patent, $id_tag, $weight, "abstract");
                        unset($abstract_tags);
                        
                    unset($tag);
                }
            */
            
            //LIMPEZA
            unset($patent);
            
            
            #
            ####################################################################
            
            //LIMPEZA
            unset($array_patente);
            
        
        }
    
    }

#############################################################################################################

echo "Foram inseridas $total_patentes patetes no banco de dados <br>";
echo "ainda precisa pegar os claims e a description e processar as tags";
$time_end = microtime(true);
$time = ceil(($time_end - $time_start));


echo "<hr />";
echo "time: $time seconds<br />";
echo "memory_get_usage: " . round((memory_get_usage() / 1024 / 1024),2) . " Mbytes <br />";
echo "memory_get_peak_usage: " . round((memory_get_peak_usage() / 1024 / 1024),2) . " Mbytes <br />";

echo "finished! <a href='?'>refresh</a>";
?>