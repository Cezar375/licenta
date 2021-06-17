<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/aflaMateria.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/comentariiPagina.css">
    <script src="https://cdn.tiny.cloud/1/4h6rh37oevzsxp4lpr6cel1rlx5z7fxoo6krskkna7oxg93n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Afla materia corespunzatoare</title>
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
        
           <button onclick= "location.href = 'http://localhost/licenta/public/Materii'" class="homeButtonToOtherPages">
           Materii
           </button>
    </div>


    <div class="bottomDiv">

    <div class="dottedDiv">
        <h1 class="aflaMateriaHeader">Afla materia corespunzatoare unui concept!</h1>
        <select id="numeConcepte" name="NumeConcepte"></select>

        <button id="aflaMateriaCorespunzatoare" class="submitButton" type="button">Afla materia!</button>
        
    </div>

    <div id="divMaterieGasita" class="materieGasita">
        <h1 class="materieGasitaHeader">Materia corespunzatoare este: </h1>    
    </div>

    <script>
        $('#divMaterieGasita').hide();
         var URL="http://localhost/licenta/public/api/concepte/InnerSelect";
         fetch(URL).
            then(response=>response.json()).then(data=>
            {
               if(data['message']!='')
               {
                   $("#numeConcepte").html(data['message']);
               }
            })    

          $("#aflaMateriaCorespunzatoare").click(function() 
          {
            $('#divMaterieGasita').html("<h1 class=\"materieGasitaHeader\">Materia corespunzatoare este: </h1>");
            var URL="http://localhost/licenta/public/api/concepte/aflaMateria/";
            URL=URL.concat($( "#numeConcepte option:selected" ).text().replaceAll(" ","_"));

            fetch(URL).
              then(response=>response.json()).then(data=>
            {
               if(data['message']!="Este izolat sau nu exista acest concept!")
               {
                 for (var dat of data['message']){
                  var conceptHeaderButton=$("<button class=\"conceptHeaderButton\" name=\""  + dat['nume']   +"\"id=\"button" + dat['nume'] + "\"/>");
                 
                  conceptHeaderButton.text(dat['nume'].replaceAll("_"," "));  //ca "butonul" sa aiba spatii totusi

                  $('#divMaterieGasita').append(conceptHeaderButton);
                  $('#divMaterieGasita').show();

                  conceptHeaderButton.click(function()
                  {
                    var URL='http://localhost/licenta/public/Materii/concepteMaterie/';
                    URL=URL.concat(dat['nume'].replaceAll(" ","_"));
                    document.location.href=URL;
                  })

                  conceptHeaderButton.on("mouseenter", function()  //hover, mouse enter, mouse-ul e deasupra
                  {
                    document.getElementById( "button" + this.name ).style.color= '#d08df4';
                  })

                  conceptHeaderButton.on("mouseleave", function()  //hover, mouse leave, mouse-ul paraseste elementtul
                  {  
                    document.getElementById( "button" + this.name ).style.color= "white";
                  })
               }
               }
               else  //conceptul este izolat
               {
                $('#divMaterieGasita').html("<h1 class=\"materieGasitaHeader\">Conceptul este izolat! </h1>");
                $('#divMaterieGasita').show();
               }
            }) 


          })  

    </script>


</div>

