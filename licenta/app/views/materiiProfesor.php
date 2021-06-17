<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Lista Materii</title>
</head>
<body>
    <div class="upperDiv">
    <h1 class="homeHeaderH1">Knowledge Base</h1>
    </div>

    <div class="midDiv">
    <button onclick= "location.href = 'http://localhost/licenta/public/'" class="homeButtonToOtherPages"> 
           Home
           </button>

           <button onclick= "location.href = 'http://localhost/licenta/public/Signup'" name="SignupButton" class="homeButtonToOtherPages">
           Signup
           </button> 
        
           <button class="homeButtonActive">
           Materii
           </button>

           
    </div>

    <div class="bottomDiv">
        <form class="formAdaugaConceptButtonSiHeader" id="formAdaugaConcept" action="http://localhost/licenta/public/Materii/" method="get">
            <button class="grafButton" name="Graf" type="submit">Vizualizare graf</button>
            <button class="adaugaConceptButton" name="filtreazaDupaTag" type="submit">Filtreaza dupa tag</button>
               
         </form>
        <div class="parteaMaterii">

           <form class="headerSIButon" action="http://localhost/licenta/public/Materii/" method="get">
            <h3 class="listaMateriiHeader">Lista materii</h3>
            <button class="aflaMateriaButton" name="aflaMateria" type="submit">Afla materia corespunzatoare</button> 
        </form>  
            

           <script>  // ca sa adaugam butonul doar pt profesori
              var privilegii=<?php echo "'" .$_SESSION['privileges']  . "'"; ?>;
              if( privilegii=='profesor')
              {
                 var adaugaConceptButton=$("<button class=\"adaugaConceptButton\" name=\"adaugaConcept\" type=\"submit\">");
                 adaugaConceptButton.html('Adauga un concept');  //ca "butonul" sa aiba spatii totusi
                 $("#formAdaugaConcept").append(adaugaConceptButton);
              }

              var butonStatistici=$("<button class=\"statisticiButton\" name=\"Statistici\" type=\"submit\">");
              butonStatistici.html('📊');
              $("#formAdaugaConcept").append(butonStatistici);


           </script>


           

           <form id="materieForm"  enctype="multipart/form-data" autocomplete="off" method="post">  <!-- generam dinamic locatia action-ului ca dupa sa avem numele materiei in controller -->
             
             <ul class="lista">
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Algoritmica_Grafurilor'; materieForm.submit();" class="numeMaterie">Algoritmica Grafurilor</li></button>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Arhitectura_Calculatoarelor_si_Sisteme_de_Operare'; materieForm.submit();" class="numeMaterie">Arhitectura Calculatoarelor și Sisteme de Operare</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Baze_de_Date'; materieForm.submit();" class="numeMaterie">Baze de Date</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Calcul_Numeric'; materieForm.submit();" class="numeMaterie">Calcul Numeric</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Fundamentele_Algebrice_ale_Informaticii'; materieForm.submit();" class="numeMaterie">Fundamentele Algebrice ale Informaticii</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Grafica_pe_Calculator'; materieForm.submit();" class="numeMaterie">Grafică pe Calculator</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Ingineria_Programarii'; materieForm.submit();" class="numeMaterie">Ingineria Programării</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Inteligenta_Artificiala'; materieForm.submit();" class="numeMaterie">Inteligența Artificială</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Invatare_Automata'; materieForm.submit();" class="numeMaterie">Învățare Automată</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Limbaje_Formale,_Automate_si_Compilatoare'; materieForm.submit();" class="numeMaterie">Limbaje Formale, Automate și Compilatoare</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Logica_pentru_Informatica'; materieForm.submit();" class="numeMaterie">Logică pentru Informatică</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Probabilitati_si_Statistica'; materieForm.submit();" class="numeMaterie">Probabilități și Statistică</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Programare_Avansata'; materieForm.submit();" class="numeMaterie">Programare Avansată</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Programare_Orientată-Obiect'; materieForm.submit();" class="numeMaterie">Programare Orientată-Obiect</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Proiectarea_Algoritmilor'; materieForm.submit();" class="numeMaterie">Proiectarea Algoritmilor</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Retele_de_Calculatoare'; materieForm.submit();" class="numeMaterie">Rețele de Calculatoare</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Securitatea_Informatiei'; materieForm.submit();" class="numeMaterie">Securitatea Informației</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Sisteme_de_Operare'; materieForm.submit();" class="numeMaterie">Sisteme de Operare</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Structuri_de_Date'; materieForm.submit();" class="numeMaterie">Structuri de Date</li>
              <input name="materieSelectata" type="hidden" value="" id="numeMaterie" /><li onclick="materieForm.action='http://localhost/licenta/public/Materii/concepteMaterie/Tehnologii_Web'; materieForm.submit();" class="numeMaterie">Tehnologii Web</li>
             </ul>
           </form> 
                   


          <?php
           if(isset($data['message'])) 
              echo '<p class="textEroare">' . $data['message'] .'</p>';
           ?>

           
           
         

        </div>
    
    </div>


</body>
</html>