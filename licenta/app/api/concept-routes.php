<?php

include_once '../models/Concept.php';  //model
include_once '../models/Relatie.php';  //model
include_once '../config/Response.php';

require_once 'C:\xampp\htdocs\licenta\vendor\autoload.php';   #conexiune Neo4J
use GraphAware\Neo4j\Client\ClientBuilder;


$conceptRoutes=
[

      [                                                           //underscore=da _ va fi transf in spatiu, underscore=nu nu va fi
        "route" => "concepte/legaturi/:numeConcept",  //va returna toate nodurile conectate cu nodul ce are acest nume
        "method" => "GET",
        "handler" => function ($req)
        {
            $unConcept=new Concept();

            $numeConcept=$req['params']['numeConcept'];

            $returnedArray = array();

            if(isset($req['query']['underscore']))
                   {
                     $returnedArray=$unConcept->getRelatiiConcept($numeConcept,'inlocuieste_cuSpatiu');
                   }
            else
                   {
                     $returnedArray=$unConcept->getRelatiiConcept($numeConcept);
                   }       

            if(!$returnedArray)
              {
                Response::status(200);  
                Response::text("Conceptul dat nu are relatii asociate lui");
                
              }
            else
            {
                Response::status(200);
                Response::json($returnedArray);
            }
           
        }

      ],

      [
        "route" => "concepte/noduriLegate/:numeConcept",
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $numeConcept=$req['params']['numeConcept'];
 
          $returnedArray = array();

          if(isset($req['query']['underscore']))
                   {
                    
                     if(isset($req['query']['nivel']))
                     {
                       
                       $returnedArray=$unConcept->getToateNodurileConectate($numeConcept,'inlocuieste_cuSpatiu',$req['query']['nivel']);
                     }
                     else
                       $returnedArray=$unConcept->getToateNodurileConectate($numeConcept,'inlocuieste_cuSpatiu');
                   }
            else
                   {
                    if(isset($req['query']['nivel']))
                    {
                      $returnedArray=$unConcept->getToateNodurileConectate($numeConcept,null,$req['query']['nivel']);
                    }
                     $returnedArray=$unConcept->getToateNodurileConectate($numeConcept);
                   } 

          if(!$returnedArray)
              {
                Response::status(200);  
                Response::text("Conceptul dat este izolat");
                
              }
             else if($returnedArray==="ID-ul nu este numar")
             {
              Response::status(404);  
              Response::text("ID-ul specificat nu este numar natural");
             }
            else
            {
                Response::status(200);
                Response::json($returnedArray);
            }

        }
      ],

      [
        "route" => "concepte/infoNod/:numeConcept",
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $numeConcept=$req['params']['numeConcept'];
 
          $returnedArray = array();

          if(isset($req['query']['underscore']))
                   {
                     $returnedArray=$unConcept->getInfoNod($numeConcept,'inlocuieste_cuSpatiu');
                   }
            else
                   {
                     $returnedArray=$unConcept->getInfoNod($numeConcept);
                   } 

          if(!$returnedArray)
              {
                Response::status(200);  
                Response::text("Conceptul cu numele dat nu exista");
                
              }
            else 
            {
                Response::status(200);
                Response::json($returnedArray);
            }

        }
      ],


      [
        "route" => "concepte/stergeNod/:numeConcept",
        "method" => "DELETE",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $numeConcept=$req['params']['numeConcept'];

          $ok=0;
          if(isset($req['query']['underscore']))
                   {
                     $ok=$unConcept->stergeNod($numeConcept,'inlocuieste_cuSpatiu');
                   }
            else
                   {
                     $ok=$unConcept->stergeNod($numeConcept);
                   } 

          if($ok==true)  //a fost sters
              {
                Response::status(200);  
                Response::text("Conceptul a fost sters");
                
              }
            else 
            {
                Response::status(200);
                Response::text("Conceptul cu numele dat nu exista");
            }

        }
      ],

      [
        "route" => "concepte/modificaDescrierea/:numeConcept",
        "method" => "POST",
        "handler" => function ($req)
        {
          $unConcept=new Concept();
          $unConcept->denumire=$req['params']['numeConcept'];

          if(isset($req['query']['underscore']))  //daca e setat vom inlocui _ cu spatiu
          {
            $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
          }

          
          //$query ="MATCH (nod:Concept) WHERE nod.nume='". $unConcept->denumire . "' SET nod.descriere='" . $req['payload']['nouaDescriere'] . "'";
          //var_dump($query);

          if(isset($req['payload']['nouaDescriere']))  //parametrul in care vom stoca continutul noii descrieri
          {
            $returnedArray=$unConcept->modificaDescrierea($req['payload']['nouaDescriere']);

            if($returnedArray==="Descrierea modificata cu succes!")
            {
              Response::status(200);  
              Response::text("Descriere modificata cu succes!");
              
            }
            else
            {
              
              Response::status(404); 
              Response::text($returnedArray);
            }
          }
          else
          {
            Response::status(404);  
            Response::text("Trebuie oferit ca body param, JSON data,  continutul noii descrieri, key:nouaDescriere");
            
          }

        }
      ],   
      
      [
        "route" => "concepte/modificaNumele/:numeConcept",
        "method" => "POST",
        "handler" => function ($req)
        {
          $unConcept=new Concept();
          $unConcept->denumire=$req['params']['numeConcept'];

          if(isset($req['query']['underscore']))  //daca e setat vom inlocui _ cu spatiu
          {
            $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
          }

          if(isset($req['query']['nouNume']))  //parametrul in care vom stoca continutul noului nume
          {
            $returnedArray=$unConcept->modificaNume($req['query']['nouNume']);

            if($returnedArray==="Nume modificat cu succes!")
            {
              Response::status(200);  
              Response::text("Nume modificat cu succes");
            }
            else
            {
              Response::status(404);  
              Response::text($returnedArray);
            }
          }
          else
          {
            Response::status(404);  
            Response::text("Trebuie oferit ca query param noul nume");
          }

        }
      ],
      
      [
        "route" => "concepte/stergeRelatie/:numeRelatie",  //numele de relatii nu pot avea spatii in nume
        "method" => "DELETE",
        "handler" => function ($req)
        {
          $oRelatie=new Relatie();
          $oRelatie->nume=$req['params']['numeRelatie'];

          if(isset($req['query']['nod1Nume']))
          {
             $oRelatie->nod1Nume=$req['query']['nod1Nume'];
             //echo $oRelatie->nod1Nume;
          }

          if(isset($req['query']['nod2Nume']))
          {
            $oRelatie->nod2Nume=$req['query']['nod2Nume'];
            //echo $oRelatie->nod2Nume;
          }

          if(  !(isset($oRelatie->nod1Nume))  ||  !(isset($oRelatie->nod1Nume)) )
          {
            Response::status(404);  
            Response::text("Trebuie specificate numele nodurilor intre care exista relatia!");
          }

          //trebuie sa verificam daca relatia exista, stiind acum ca avem toti param. necesari
          //RETURN EXISTS( (:Person {userId: {0}})-[:KNOWS]-(:Person {userId: {1}}) )

          $returnedArray=$oRelatie->stergeRelatie();
          if ($returnedArray==="Nu exista relatia!")
          {
            Response::status(404);  
            Response::text("Relatia data nu exista!");
          }
          else if($returnedArray==="Relatie stearsa!")
          {
            Response::status(200);  
            Response::text("Relatie stearsa cu succes!");
          }
          else
          {
            Response::status(404);  
            Response::text($returnedArray);
          }


        }

      ],


      [
        "route" => "concepte/adaugaRelatie/:numeRelatie",  //numele de relatii nu pot avea spatii in nume
        "method" => "POST",
        "handler" => function ($req)
        {
          $oRelatie=new Relatie();
          $oRelatie->nume=$req['params']['numeRelatie'];

          if(isset($req['query']['nod1Nume']))
          {
             $oRelatie->nod1Nume=$req['query']['nod1Nume'];
             //echo $oRelatie->nod1Nume;
          }

          if(isset($req['query']['nod2Nume']))
          {
            $oRelatie->nod2Nume=$req['query']['nod2Nume'];
            //echo $oRelatie->nod2Nume;
          }

          if(  !(isset($oRelatie->nod1Nume))  ||  !(isset($oRelatie->nod1Nume)) )
          {
            Response::status(404);  
            Response::text("Trebuie specificate numele nodurilor intre care exista relatia(query params, nod1Nume,nod2Nume)!");
          }

          $returnedArray=$oRelatie->adaugaRelatie();
          if($returnedArray==="Relatie adaugata intre cele 2 noduri specificate!")
          {
            Response::status(200);  
            Response::text("Relatie creata cu succes intre cele 2 noduri specificate!");
          }
          else
          {
            Response::status(404);  
            Response::text($returnedArray);
          }

        }

      ],

      [
        "route" => "concepte/adaugaComentariu/:numeConcept",  //2 body params, 1 query param optional(underscore) si un param: numele conceptului
        "method" => "POST",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului caruia i se adauga comentariul!");
          }

          else if (!isset($req['payload']['comentariu']))
          {
            Response::status(404);
            Response::text("Trebuie specificat continutul comentariului!");
          }

          else if(!isset($req['payload']['numeUser']))
          {
            Response::status(200);
            Response::text("Trebuie specificat numele utilizatorului care a postat comentariul!");
          }
          else
          {
          $unConcept->denumire=$req['params']['numeConcept'];
          $continutComentariu=$req['payload']['comentariu'];
          $nume=$req['payload']['numeUser'];


          if(isset($req['query']['underscore']))
          {
            $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
          }

          
          $returnedArray=$unConcept->adaugaComentariu($continutComentariu,$nume);

          if(substr($returnedArray,0,19)==="Comentariu adaugat!")
          {
            Response::status(200);
            Response::text($returnedArray);
          }
          else if ($returnedArray=="Numele de utilizator nu exista!")
          {
            Response::status(200);
            Response::text("Numele de utilizator nu exista!");
          }
          else
          {
            Response::status(404);
            Response::text($returnedArray);
          }
          
        }
          
        }

      ],

      [
        "route" => "concepte/getToateComentariile/:numeConcept",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului pentru care se doresc comentariile!");
          }
         else
         {
            $unConcept->denumire=$req['params']['numeConcept'];
            if(isset($req['query']['underscore']))
            {
              $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
            }

            $returnedArray=$unConcept->getToateComentariile();
         
            if($returnedArray==="Niciun comentariu!")
            {
              Response::status(200);
              Response::text("Nu exista comentarii asociate conceptului inca!");
            }
            else if($returnedArray==="Conceptul nu exista!")
            {
              Response::status(404);
              Response::text("Nu exista un concept cu acest nume!");
            }
            else  //exista si are comentarii
            {
              Response::status(200);
              Response::text($returnedArray);
            }
          
          }

        }

      ],

      [
        "route" => "concepte/getComentariuSpecific/:ID",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['ID']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat ID-ul comentariului!");
          }
          else
          {
            $id=$req['params']['ID'];
            $returnedArray=$unConcept->getComentariuSpecific($id);

            if($returnedArray==="Nu exista un comentariu cu acest ID!")
            {
              Response::status(404);
              Response::text("Nu exista un comentariu cu acest ID!");
            }
            else
            {
              Response::status(200);
              Response::text($returnedArray);
            }
          }
        }
      ],

      [
        "route" => "concepte/stergeUnComentariu/:ID",  
        "method" => "DELETE",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['ID']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat ID-ul comentariului ce se doreste a fi sters!");
          }
          else
          {
            $id=$req['params']['ID'];
            $returnedArray=$unConcept->stergeUnComentariu($id);

            if($returnedArray==="Nu exista un comentariu cu acest ID, nu s-a efectuat o stergere!")
            {
              Response::status(404);
              Response::text("Nu exista un comentariu cu acest ID, nu s-a efectuat o stergere!");
            }
            else
            {
              Response::status(200);
              Response::text($returnedArray);
            }
          }
        }
      ],

      [
        "route" => "concepte/filtreazaDupaTaguri/",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['query']['tag1']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat macar un tag dupa care sa se filtreze(tag1)!");
          }
          else
          {
             $arrayTaguri=array();
             foreach($req['query'] as $tag)
             {
                 $tag = str_replace('%20', ' ', $tag);
                 $arrayTaguri[]=$tag;
             }

             $returnedArray=$unConcept->filtreazaDupaTagurileDate($arrayTaguri);


             Response::status(200); 
             Response::text($returnedArray);
          }
        }
      ],

      [
        "route" => "concepte/getToateTagurile/:numeConcept",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului pentru care se doresc comentariile!");
          }
          else
          {
            $unConcept->denumire=$req['params']['numeConcept'];
            $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
            $returnedArray=$unConcept->getToateTagurileExistente();

            if($returnedArray==="Conceptul nu are taguri asociate!")
            {
              Response::status(200);  
              Response::text("Nu exista taguri pt conceptul specificat!");
            }
            else
            {
              Response::status(200);  
              Response::text($returnedArray);
            }
          }
        }
      ],

      [
        "route" => "concepte/stergeTag/:numeConcept",  
        "method" => "DELETE",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului caruia se doreste a i se sterge un tag!");
          }
          else
          {
             if(!isset($req['query']['tag']))
             {
              Response::status(404);  
              Response::text("Trebuie specificat numele tagului care se doreste a fi sters!");
             }
             else
            {
              $unConcept->denumire=$req['params']['numeConcept'];
              $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
              $tagDeSters=$req['query']['tag'];

              $returnedArray=$unConcept->stergeUnTag($tagDeSters);

              if($returnedArray==="Tag sters!")
              {
                Response::status(200);  
                Response::text("Tag sters cu succes!");
              }
              else
              {
                Response::status(404);  
                Response::text($returnedArray);
              }
            }
          }
        }
      ],

      [
        "route" => "concepte/adaugaTag/:numeConcept",  
        "method" => "POST",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului caruia se doreste a i se adauga un tag!");
          }
          else
          {
            if(!isset($req['query']['tag']))
            {
             Response::status(404);  
             Response::text("Trebuie specificat numele tagului care se doreste a fi sters!");
            }
            else
            {
              $unConcept->denumire=$req['params']['numeConcept'];
              $unConcept->denumire=str_replace("_"," ",$unConcept->denumire);
              $tagDeAdaugat=$req['query']['tag'];
  
              $returnedArray=$unConcept->adaugaUnTag($tagDeAdaugat);
  
              if($returnedArray==="Tag adaugat!")
              {
                Response::status(200);  
                Response::text("Tag adaugat cu succes!");
              }
              else
              {
                Response::status(404);  
                Response::text($returnedArray);
              }
            }
            
          }  
        }
      ],

      [
        "route" => "concepte/InnerSelect",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();
          $returnedArray=$unConcept->getToateConcepteleInnerSelect();

          if($returnedArray)
          {
              Response::status(200);
              Response::text($returnedArray);
          }
          else
          {
            Response::status(404);
            Response::text("Eroare");
          }

        }
      ],

      [
        "route" => "concepte/aflaMateria/:numeConcept",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          if(!isset($req['params']['numeConcept']))
          {
            Response::status(404);  
            Response::text("Trebuie specificat numele conceptului caruia se doreste a i se determina materia asociata!");
          }
          else
          {
            $unConcept->denumire=$req['params']['numeConcept'];
            $unConcept->denumire=str_replace('_', ' ', $unConcept->denumire);
            $returnedArray=$unConcept->aflaMateriaCorespunzatoareConceptului();

            if($returnedArray=="Eroare!")  //este izolat conceptul, nu are relatii
            {
              Response::status(404);  
              Response::text("Este izolat sau nu exista acest concept!");
            }
            else  //nu este izolat, are relatii
            {
              Response::status(200);  
              Response::text($returnedArray);
            }

          }
        }
      ],

      [
        "route" => "concepte/numarareTaguriPerConcept",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $returnedArray=$unConcept->numaraTagurilePerConcept();

          if($returnedArray==="Eroare!")
          {
            Response::status(404);  
            Response::text("Eroare!");
          }

          Response::status(200);  
          Response::text($returnedArray);
          
        }
      ],

      [
        "route" => "concepte/numarareTaguri",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $returnedArray=$unConcept->numaraTagurile();

          if($returnedArray==="Eroare!")
          {
            Response::status(404);  
            Response::text("Eroare!");
          }

          Response::status(200);  
          Response::text($returnedArray);
          
        }
      ],

      [
        "route" => "concepte/numarareComentariiPerConcept",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $returnedArray=$unConcept->numaraComentariiPerConcept();

          if($returnedArray==="Eroare!")
          {
            Response::status(404);  
            Response::text("Eroare!");
          }

          Response::status(200);  
          Response::text($returnedArray);
          
        }
      ],

      [
        "route" => "concepte/numarareComentarii",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $returnedArray=$unConcept->numaraComentarii();

          if($returnedArray==="Eroare!")
          {
            Response::status(404);  
            Response::text("Eroare!");
          }

          Response::status(200);  
          Response::text($returnedArray);
          
        }
      ],

      [
        "route" => "concepte/numarareRelatii",  
        "method" => "GET",
        "handler" => function ($req)
        {
          $unConcept=new Concept();

          $returnedArray=$unConcept->numaraRelatii();

          if($returnedArray==="Eroare!")
          {
            Response::status(404);  
            Response::text("Eroare!");
          }

          Response::status(200);  
          Response::text($returnedArray);
          
        }
      ],

      

      
     


];


?>