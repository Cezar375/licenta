<?php

require_once 'C:\xampp\htdocs\licenta\vendor\autoload.php';   #conexiune Neo4J
use GraphAware\Neo4j\Client\ClientBuilder;


class Relatie
{

   public $nume;
   public $nod1Nume;
   public $nod2Nume;

   public function stergeRelatie()
   {
     
     $this->nod1Nume=str_replace("%20"," ",$this->nod1Nume);   //sa scoatem spatiile (%20) din numele nodurilor
     $this->nod2Nume=str_replace("%20"," ",$this->nod2Nume);

     $this->nod1Nume=str_replace("_"," ",$this->nod1Nume);  //in caz ca avem _
     $this->nod2Nume=str_replace("_"," ",$this->nod2Nume);

     //trebuie sa verificam daca relatia exista, stiind acum ca avem toti param. necesari
      
      $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

      $query ='RETURN EXISTS( (:Concept {nume:"' . $this->nod1Nume . '"})-[:' . $this->nume . ']->(:Concept {nume: "' . $this->nod2Nume . '" }) ) as mesaj';  //ca sa vedem daca exista
      $result = $client->run($query);

      foreach ($result->records() as $record)
      {
           if ($record->get('mesaj')==1)  //exista relatia, deci doar o vom sterge acum
           {
            $query='MATCH (:Concept {nume:"' . $this->nod1Nume . '"})-[r:' . $this->nume . ']->(:Concept {nume: "' . $this->nod2Nume . '"}) DELETE r' ;
            $result = $client->run($query);

            return "Relatie stearsa!";
           } 
           else
           {
               return "Nu exista relatia!";
           }
      }  


   }

   //  CREATE (node1)-[:RelationshipType]->(node2)
   public function adaugaRelatie()
   {
    $this->nod1Nume=str_replace("%20"," ",$this->nod1Nume);   //sa scoatem spatiile (%20) din numele nodurilor
    $this->nod2Nume=str_replace("%20"," ",$this->nod2Nume);

    $this->nod1Nume=str_replace("_"," ",$this->nod1Nume);  //in caz ca avem _
    $this->nod2Nume=str_replace("_"," ",$this->nod2Nume);

    $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

    //trebuie verificat daca exista cele 2 noduri
    
    //////////////nodul 1/////////////////////////////////
    $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->nod1Nume . '" RETURN nod';  //ca sa vedem daca exista
    $result = $client->run($query);
    $rezultatFinal=array();

    foreach ($result->records() as $record) 
        $nodul1Gasit=$record->get('nod')->get('nume');

    ////////////////////nodul 2///////////////////////////
    $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->nod2Nume . '" RETURN nod';  //ca sa vedem daca exista
    $result = $client->run($query);
    $rezultatFinal=array();

    foreach ($result->records() as $record) 
        $nodul2Gasit=$record->get('nod')->get('nume');
    
    //////////////////////////////////////////////////////

    if(!isset($nodul1Gasit))
    {
        return "Nodul 1 nu exista";
    }

    if(!isset($nodul2Gasit))
    {
       return "Nodul 2 nu exista!";
    }

   ////////////////////////////////////////////////////////

   $query ='RETURN EXISTS( (:Concept {nume:"' . $this->nod1Nume . '"})-[:' . $this->nume . ']->(:Concept {nume: "' . $this->nod2Nume . '" }) ) as mesaj';  //ca sa vedem daca exista
   $result = $client->run($query);

   foreach ($result->records() as $record)
   {
        if ($record->get('mesaj')==1)  //exista relatia, deci nu o mai adaugam
        {
            return "Relatia exista deja!";
        
        }
        else  //nu exista deci o adaugam
        {
            $query='
            MATCH (nod1:Concept) WHERE nod1.nume="'. $this->nod1Nume . '"
            MATCH (nod2:Concept) WHERE nod2.nume="'. $this->nod2Nume . '" 
            MERGE (nod1)-[:' . $this->nume . ']->(nod2)';  //cream relatia

            $result = $client->run($query);
            return "Relatie adaugata intre cele 2 noduri specificate!";

        }
   }


   }

}

?>    