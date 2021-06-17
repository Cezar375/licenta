<?php

    require_once '../vendor/autoload.php';   #conexiune Neo4J
    use GraphAware\Neo4j\Client\ClientBuilder;

class Materii extends Controller
{

    public function index()
    {
 
        $unConcept=$this->model('Concept');

        if (isset($_GET['adaugaConcept']))
        {
            $this->view('adaugaConcept');
        }
        else if(isset($_GET['filtreazaDupaTag']) && $_SESSION['privileges']==='profesor')
        {
            $this->view('filtrareProfesor');
        }
        else if (isset($_GET['filtreazaDupaTag']))
        {
            $this->view('filtrareStudent');
        }
        else if(isset($_GET['Graf']))
        {
            $this->view('graf');
        }
        else if(isset($_GET['aflaMateria']))
        {
            $this->view('aflaMateria');
        }
        else if(isset($_GET['Statistici']))
        {
            $this->view('statistici');
        }
        else
        {
            $this->view('materiiProfesor');
        }
        
    }

    public function concepteMaterie($numeMaterie='')  //pt view-ul cu acelasi nume, procesarea in sine e facuta de API
    {
        $unConcept=$this->model('Concept');

        //$_SESSION['privileges']
        if (isset($_POST['materieSelectata']) && $_SESSION['privileges']==='profesor' )  //profesor
        {
            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

        
            $this->view('concepteleUneiMaterii',['numeMaterie'=>$numeMaterieCuSpatii]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if (isset($_POST['materieSelectata']) )  // student/ne-autentificat
        {
            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            //echo 'testS';
            $this->view('concepteleUneiMateriiStudent',['numeMaterie'=>$numeMaterieCuSpatii]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if ($numeMaterie!=''  && $_SESSION['privileges']==='profesor') // PROFESOR , ajungem din URL cu numele materiei ca parametru in URL
        {
            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

        
            $this->view('concepteleUneiMaterii',['numeMaterie'=>$numeMaterieCuSpatii]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if ($numeMaterie!='') //ajungem din URL cu numele materiei ca parametru in URL
        {
            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

        
            $this->view('concepteleUneiMateriiStudent',['numeMaterie'=>$numeMaterieCuSpatii]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else
        {
            $this->view('concepteleUneiMateriiStudent');
        }
    }


    public function AdaugareConcept()
    {
        $unConcept=$this->model('Concept');

        if (isset($_POST['ButonAdaugareConcept']))
        {
            #$this->view('materiiProfesor');  //In PHP se concateneaza siruri cu . , in JS cu +
            #var_dump($_POST);
            $unConcept->denumire=$_POST['NumeConcept'];
            $unConcept->descriere=$_POST['DescriereaConceptului'];

            if(isset($_POST['numeConceptMaterie']))
            {
                for($i = 0; $i < count($_POST['numeConceptMaterie']); $i++)
                 {
                     $unConcept->concepteCuCareAreRelatii[$i]=$_POST['numeConceptMaterie'][$i];
                     $unConcept->relatii[$i]=$_POST['relatieCuEa'][$i];
                 }

                 if(count($_POST['numeConceptMaterie'])!=count($_POST['relatieCuEa']) || count($unConcept->concepteCuCareAreRelatii)!=count($unConcept->relatii))
                 {
                   $this->view('adaugaConcept',['message'=>"Relatii date incorect!"]);
                 }   
            }

            if(isset($_POST['unTag']))
            {
                for($i = 0; $i < count($_POST['unTag']); $i++)
                 {
                     $unConcept->taguri[$i]=$_POST['unTag'][$i];
                 }

            }

            if($unConcept->validareInfoAdaugareConcept())
            {
                  if($unConcept->NUexistaConceptulDeja())
                  {
                    $unConcept->adaugaConceptBD();
                    $this->view('adaugaConcept',['message'=>"Concept adaugat!"]);
                  }
                  else
                  {
                    $this->view('adaugaConcept',['message'=>"Concept existent deja!"]);
                  }  

            }
            else
            {
                $this->view('adaugaConcept',['message'=>"Formatul datelor este invalid!"]);
            }
        }
    }

    public function viewComentarii($numeConcept='')
    {

        if(isset($_GET['viewComentariiConcept']))
        {
            if(isset($numeConcept))
            {
                $cuvinteComponente = explode("_", $numeConcept);
                $numeConceptCuSpatii='';

                foreach ($cuvinteComponente as $cuvant)
               {
                $numeConceptCuSpatii=$numeConceptCuSpatii . ' ' . $cuvant;
               }

                $numeConceptCuSpatii = substr($numeConceptCuSpatii, 1); //avem un spatiu la inceput pus de foreach

                if($_SESSION['privileges']==='profesor')
                  $this->view('comentarii', ['numeConcept'=>$numeConceptCuSpatii]);
                else
                {
                    $this->view('comentariiStudent', ['numeConcept'=>$numeConceptCuSpatii]);
                }  
                
            }    
        }
    }

    public function setareNivelCautare($materie='', $nivelCautare='')
    {
        $unConcept=$this->model('Concept');


        if(isset($_POST['Nivel'])   &&   $_SESSION['privileges']==='profesor')
        {
            $nivel=$_POST['Nivel'];
            $numeMaterie=$_POST['Materie'];

            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

        
            $this->view('concepteleUneiMaterii',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivel]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if($materie!='' && $nivelCautare!=''  &&  $_SESSION['privileges']==='profesor')
        { 
            $cuvinteComponente = explode("_", $materie);
            
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            $this->view('concepteleUneiMaterii',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivelCautare]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if(isset($_POST['Nivel']))
        {
            $nivel=$_POST['Nivel'];
            $numeMaterie=$_POST['Materie'];

            $cuvinteComponente = explode("_", $numeMaterie);
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            $this->view('concepteleUneiMateriiStudent',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivel]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if($materie!='' && $nivelCautare!='')
        {
            $cuvinteComponente = explode("_", $materie);
            
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            $this->view('concepteleUneiMateriiStudent',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivelCautare]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if($materie!='' &&  $_SESSION['privileges']==='profesor')  //aratam pagina default, nivel=2 fara setare nivel
        {
            $cuvinteComponente = explode("_", $materie);
            
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            $nivelCautare=2;
            $this->view('concepteleUneiMaterii',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivelCautare]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else if($materie!='')  //la fel ca mai sus dar pt student
        {
            $cuvinteComponente = explode("_", $materie);
            
            $numeMaterieCuSpatii='';
            foreach ($cuvinteComponente as $cuvant)
            {
                $numeMaterieCuSpatii=$numeMaterieCuSpatii . ' ' . $cuvant;
            }

            $numeMaterieCuSpatii = substr($numeMaterieCuSpatii, 1); //avem un spatiu la inceput pus de foreach

            $nivelCautare=2;
            $this->view('concepteleUneiMateriiStudent',['numeMaterie'=>$numeMaterieCuSpatii, 'nivelMaxim'=>$nivelCautare]);  #aici vom da denumirea materiei care a fost selectata ca sa stim pt ce materie sa construim pagina
        }
        else  //aratam 404
        {
             echo '404';
        }
    }

}
?>