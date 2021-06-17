<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/filtrareDupaTAG.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    <title>Filtreaza dupa tag</title>
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
      <form id="selectareTaguri" class="dottedDiv">
        <h1 class="filtreazaDupaTagHeader">Filtreaza dupa tag-uri!</h1>   
        <fieldset id="buildyourformTAG">
        <legend class="labelH">Adaugare tag-uri</legend>
        </fieldset>
        <button type="button"  class="addAFieldButton" class="add" id="addTAG">Adauga tag </button>
        
        <button class="submitButton" id="filterByTagsButton" type="submit">Filtreaza</button>
        
    <script>
    $(document).ready(function()
    {
        var intId=1;
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        fieldWrapper.data("idx", intId);
        var numeConceptSauMaterie = $("<input title=\"Max 150 caractere alfanumerice si spatii!\" maxlength=\"150\" name=\"numeConceptMaterie[]\" type=\"text\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+\" required class=\"fieldname\" placeholder=\"Nume concept/materie\" />");
        var relatieCuEa = $("<input title=\"Max 150 caractere alfanumerice si _,incepep cu litere!\" maxlength=\"150\" name=\"relatieCuEa[]\" type=\"text\" pattern=\"[a-zA-ZăâîșțĂÂÎȘȚ]+[a-zA-ZăâîșțĂÂÎȘȚ0-9_]*\" required class=\"fieldname\" placeholder=\"Relatie\" />");
                          
        <?php
               if(isset($_SESSION['optionsCSV']))
               {
             ?>               
              var optionsCSV=<?php echo "'" .$_SESSION['optionsCSV']  . "'"; ?>;
             <?php
               }
             ?>

        var sel = $('<select id="selectTAG1" name="unTag[]">');
        sel.html(optionsCSV);

        fieldWrapper.append(sel);
        $("#buildyourformTAG").append(fieldWrapper);
        /////////////////////// ADD TAG ////////////////////////////////

        var nrApasari=new Array();
        $("#buildyourform").hide();


        ////////////////////////////////////////////////////////////////
        $("#addTAG").click(function() 
        {
    	    var lastField = $("#buildyourformTAG div:last");
          var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
          var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
          fieldWrapper.data("idx", intId);
          var numeConceptSauMaterie = $("<input title=\"Max 150 caractere alfanumerice si spatii!\" maxlength=\"150\" name=\"numeConceptMaterie[]\" type=\"text\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+\" required class=\"fieldname\" placeholder=\"Nume concept/materie\" />");
          var relatieCuEa = $("<input title=\"Max 150 caractere alfanumerice si _,incepep cu litere!\" maxlength=\"150\" name=\"relatieCuEa[]\" type=\"text\" pattern=\"[a-zA-ZăâîșțĂÂÎȘȚ]+[a-zA-ZăâîșțĂÂÎȘȚ0-9_]*\" required class=\"fieldname\" placeholder=\"Relatie\" />");
                             
          var sel = $('<select  id="selectTAG' + intId + '" name="unTag[]">');
          sel.html(optionsCSV);
          console.log(optionsCSV);                

          var removeButton = $("<input class=\"removeButton\" type=\"button\" class=\"remove\" value=\"Remove\" />");
          removeButton.click(function() 
          {
            $(this).parent().remove();
          });

          fieldWrapper.append(sel);
          fieldWrapper.append(removeButton);
          $("#buildyourformTAG").append(fieldWrapper);
        });
        /////////////// SUBMIT BUTTON FUNCTION ///////////////////////
        $("#filterByTagsButton").click(function(buton)
        {
           buton.preventDefault();
           $("#buildyourform").html("");
           $("#buildyourform").show();
           var lastField = $("#buildyourformTAG div:last");
           var lastId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
           lastId=lastId-1; //altfel va da +1, imi trebuie doar cele existente in momentul apasarii butonului, nu si cele viitoare
           //console.log('test buton subkit filtering');

           var URL="http://localhost/licenta/public/api/concepte/filtreazaDupaTaguri";
           for(i=1;i<=lastId;i++)
            {
                var unTag = $('#selectTAG' + i).find(":selected").text();
                if(i==1)
                {
                    URL=URL.concat("?tag"+i);
                    URL=URL.concat('=' + unTag);
                }
                else
                {
                    URL=URL.concat("&tag"+i);
                    URL=URL.concat('=' + unTag); 
                }
            }    

            fetch(URL,{method: 'GET'}).then(Response=>Response.json().then(data=>
            {
                if(data['message']=="Nu exista concepte cu toate aceste taguri!")
                {
                  $("#buildyourform").html('<h3 class="noConceptsFound">Niciun concept gasit!</h3>');
                }
                else  //exista cel putin 1 concept cu TOATE aceste taguri
                {
                    for(var unConcept of data['message'])  //toate conceptele cu acele taguri setate
                       {
                           //console.log(unConcept['nume_concept']);

                          unConcept['nume_concept']=unConcept['nume_concept'].replaceAll(" ", "_");  //daca conceptul contine spatii id-urile si restul nu vor fi ok

                          var fieldWrapper = $("<div class=\"Fieldwrapper\" id=\"field" + unConcept['nume_concept'] + "\"/>");  //in asta vom pune butonul cu numele conceptului, dupa la click pe buton afisam descrierea, relatii, etc
                          var deUmplut=$("<form method=\"get\"  action=\"http://localhost/licenta/public/Materii/viewComentarii/" + unConcept['nume_concept']   + " \"class=\"deUmplut\"  id=\"U"  + unConcept['nume_concept']   +"\"/>");
                          deUmplut.hide();
                          var conceptHeaderButton=$("<button class=\"conceptHeaderButton\" name=\""  + unConcept['nume_concept']   +"\"id=\"button" + unConcept['nume_concept'] + "\"/>");
                 
                          conceptHeaderButton.text("🖋️ "+unConcept['nume_concept'].replaceAll("_"," "));  //ca "butonul" sa aiba spatii totusi

                          fieldWrapper.append(conceptHeaderButton);
                          fieldWrapper.append(deUmplut);
                          $("#buildyourform").append(fieldWrapper);

                          nrApasari[unConcept['nume_concept']]=0; //initializam nr de apasari ale butonului cu 0

  
                          conceptHeaderButton.click(function() 
                          {

                             var deUmplut = document.getElementById("U"+ this.name);
                             deUmplut.style.display="flex";

                             if (nrApasari[this.name]==0)   //dam show   daca e prima oara cand afisam construim propriu zis
                             {
                              document.getElementById( "button" + this.name ).style.color = '#7b46b3';  //"butonul" e apasat
                             
                             ////////////taguri//////////
                             var url="http://localhost/licenta/public/api/concepte/getToateTagurile/";
                          url=url.concat(this.name);

                          var numeleConceptului=this.name;
           
                          var containerTaguri=$('<div class="tags">');
                          fetch(url,{method: 'GET'}).then(Response=>Response.json().then(data=>
                          {

                            if(data['message']!="Nu exista taguri pt conceptul specificat!") 
                            {

                              for(var obj of data['message'])  //toate tagurile unui concept pe rand
                              {
                                var containerTagIndividual=$('<div class="individualTagContainer">');
                                var anchorTag=$('<a>');
                                var removeTagButton=$('<button class="removeTAGButton">');
                                removeTagButton.attr('id',obj['tag']); //setam id-ul butonului de stergere=numele tagului caruia ii corespunde
                                removeTagButton.text("❌");

                                anchorTag.html(obj['tag']);

                                containerTagIndividual.append(anchorTag);
                                containerTagIndividual.append(removeTagButton);

                                removeTagButton.click(function(e) 
                                {
                                    e.preventDefault();  //ca sa nu dea submit la form/refresh la pagina
                                    //this.id e numele tagului
                                    //numeleConceptului e numele conceptului caruia ii apartine tagul
                                    var url='http://localhost/licenta/public/api/concepte/stergeTag/';
                                    url=url.concat(numeleConceptului);
                                    url=url.concat('?tag=');
                                    url=url.concat(this.id);

                                    fetch(url,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                                    {
                                        
                                        if(data['message']=='Tag sters cu succes!')
                                        {
                                          $(this).parent().remove();
                                        }
                                    }))
                                })  

                                containerTaguri.append(containerTagIndividual);
                              }

                              $('#U'  + this.name).prepend(containerTaguri);  //punem inaintea butonului de comentarii
                           }

                          })) 
                          /////////////////////////////////////////////////////////////////

                          ///////////////////////////ADAUGARE TAGURI////////////////////

                          var fieldsetADDTaguri = $("<fieldset name=\"fieldsetADDTaguri" + numeleConceptului + "\"class=\"fieldsetADDRelatii\" id=\"fieldsetADDTaguri" + numeleConceptului + "\"/>");
                          var legendFieldset=$('<legend class="labelH">Adaugare tag-uri</legend>');
                          fieldsetADDTaguri.append(legendFieldset);
                          $("#U"+numeleConceptului).append(fieldsetADDTaguri);

                          var adaugaTaguriButon=$("<button type=\"button\" value=\"Adauga taguri\" class=\"adaugaUnTagNou\"  id=\"add" + numeleConceptului + "\"/>");
                          adaugaTaguriButon.text("Adauga taguri");
                          $("#U"+numeleConceptului).append(adaugaTaguriButon);

                          $("#add" + numeleConceptului).click(function() //doar pt idul asta
                          {
                            var fieldWrapper = $("<form name=\"formAdaugareTaguri" + numeleConceptului + "\"class=\"containerTaguriDeAdaugat\" id=\"containerTaguriDeAdaugat" + numeleConceptului + "\"/>");

                            var removeButton = $("<button class=\"removeButtonPtUnTagInputField\" type=\"button\"  value=\"Remove\" />");
                            removeButton.text("Remove");
                            var submitTagButton = $("<button class=\"submitNouTagButton\" type=\"button\"  />");
                            submitTagButton.text("Submit");

                            removeButton.click(function() //e doar front-end, nu necesita call la API, scoate campurile din pagina doar
                            {
                              $(this).parent().remove();
                            });

                            var newSel=sel.clone();
                            fieldWrapper.append(newSel);
                            fieldWrapper.append(removeButton);
                            fieldWrapper.append(submitTagButton);
                            fieldsetADDTaguri.append(fieldWrapper);

                            submitTagButton.click(function(buton) //+ call la API cu form data
                            {

                              var url='http://localhost/licenta/public/api/concepte/adaugaTag/';
                              url=url.concat(numeleConceptului);
                              url=url.concat('?tag=');
                              url=url.concat(newSel.find(":selected").text());

                              fetch(url,{method: 'POST'}).then(Response=>Response.json().then(data=>
                              {
                                   if(data['message']=="Tag adaugat cu succes!")
                                   {
                                      var selectieFacuta=newSel.find(":selected").text();
                                      var containerTagIndividual=$('<div class="individualTagContainer">');
                                      var anchorTag=$('<a>');
                                      var removeTagButton=$('<button class="removeTAGButton">');
                                      removeTagButton.attr('id',selectieFacuta); //setam id-ul butonului de stergere=numele tagului caruia ii corespunde
                                      removeTagButton.text("❌");

                                      anchorTag.html(selectieFacuta);

                                      containerTagIndividual.append(anchorTag);
                                      containerTagIndividual.append(removeTagButton);

                                      removeTagButton.click(function(e) 
                                     {
                                       e.preventDefault();  //ca sa nu dea submit la form/refresh la pagina
                                       //this.id e numele tagului
                                       //numeleConceptului e numele conceptului caruia ii apartine tagul
                                       var url='http://localhost/licenta/public/api/concepte/stergeTag/';
                                       url=url.concat(numeleConceptului);
                                       url=url.concat('?tag=');
                                       url=url.concat(this.id);

                                       fetch(url,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                                       {
                                        
                                         if(data['message']=='Tag sters cu succes!')
                                         {
                                           $(this).parent().remove();
                                         }

                                       }))
                                      })  

                                    containerTaguri.append(containerTagIndividual);
                                   }
                                   else if(data['message']=="Exista deja tagul specificat pentru conceptul dat!")
                                   {
                                      Swal.fire
                                      ({
                                      toast: true,
                                      icon: 'error',  //success va fi checkmark
                                      title: "Conceptul are acest tag deja!",
                                      animation: true,
                                      showConfirmButton: false,
                                      timer: 1000,
                                      timerProgressBar: true,
                                      didOpen: (toast) => 
                                      {
                                       //toast.addEventListener('mouseenter', Swal.stopTimer)
                                       //toast.addEventListener('mouseleave', Swal.resumeTimer)
                                      }
                                      });

                                   }
                              }))

                              
                            })

                          }) 


                          /////////////////////////////

                             var url='http://localhost/licenta/public/api/concepte/infoNod/'
                             url=url.concat(this.name);  //concatenam numele butonului adica a conceptului
                             url=url.concat("?underscore=da");  //underscore nu e permis in nume, deci il vom scoate pt ca daca e e pus in loc de spatiu

                             var comentariiButton = $("<button name=\"viewComentariiConcept\" class=\"comentariiConceptButtonFiltrareProfesor\" id=\"comentariiBUTON"  + this.name   +"\"type=\"submit\" class=\"remove\" value=\"Get comentarii concept\" />");
                             comentariiButton.text("Comentarii");
                             $("#U"+ this.name).append(comentariiButton);

                              fetch(url).
                              then(Response=>Response.json()).then(date=>
                                {
                                  
                                     deUmplut.style.border="1px solid white";
                                     deUmplut.style.margin="1%";

                                     /////////////////////////////////////////
                                     //aflam relatiile directe ale conceptului, ar trebui o ruta la api si sa afli materia careia apartine un concept
                                     var URL='http://localhost/licenta/public/api/concepte/legaturi/'
                                     URL=URL.concat(this.name);  //concatenam numele butonului adica a conceptului, this.name va avea deja _ inauntru daca conceptul avea spatii
                                     URL=URL.concat("?underscore=da");

                                     arrayRelatii=[];
                                     fetch(URL).
                                     then(Response=>Response.json()).then(dat=>
                                     { 
                                      var relatiiExistenteText=document.createElement("h3");
                                      relatiiExistenteText.classList.add("relatiiExistenteText");
                                      relatiiExistenteText.innerHTML="Relatii existente:";

                                      var containerRelatiiExistente=document.createElement("div");
                                      containerRelatiiExistente.classList.add("containerRelatiiExistenteStudent");
                                      containerRelatiiExistente.id="containerRelatiiExistente" + numeleConceptului;
                                      containerRelatiiExistente.appendChild(relatiiExistenteText);

                                       if( dat["message"] != "Conceptul dat nu are relatii asociate lui" )
                                           for (var n of dat)
                                           {
                                            
                                            
                                            var oRelatie = document. createElement("div");
                                            var node=document.createElement("p");
                                            node.innerHTML="Nume relatie : " + n['relatie'].replaceAll("_"," ") + " cu : " +n['nume'];
                                            node.classList.add("relatieInText");

                                            n['nume']=n['nume'].replaceAll(" ","_"); //replace la spatiu cu _

                                            oRelatie.id="-stergeREL-" + n['relatie'] + '-CU-' + n['nume'] + '-APARTINAND-' + numeleConceptului;  //setam id-ul individual
                                            oRelatie.classList.add("divORelatieExistenta");
                                            

                                            oRelatie. appendChild(node);
                                            ///
                                            containerRelatiiExistente.appendChild(oRelatie);
                                            ///

                                           }
                                           deUmplut. appendChild(containerRelatiiExistente);
               
                                     })

                                     /////////////////////////////////////////
                                    
                                      var descText=document.createTextNode('Descriere : ');
                                      var paraDesc=document.createElement('p');

                                      var replacebbcode=date[0]['descriere'].replace(/(\[((\/?)(b|u|i|s|sub|sup))\])/gi, '<$2>');  //conversie in HTML
                                      replacebbcode=replacebbcode.replace(/\[url=([^\s\]]+)\s*\](.*(?=\[\/url\]))\[\/url\]/g, '<a href="$1">$2</a>');
                                      var newContent = document.createTextNode(date[0]['descriere']);
                                         
                                      var paranewContent=document.createElement('p');
                                      paranewContent.classList.add("continutBoxDescriereActuala");
                                      var descriereDiv=document.createElement("div");
                                      descriereDiv.classList.add("boxDescriereFiltrare");

                                      paraDesc.appendChild(descText);   //textul "Descriere"
                                      paraDesc.id="paraDesc" + this.name;
                                      paraDesc.classList.add("descriereText");

                                      paranewContent.appendChild(newContent);  //descrierea in sine
                                      paranewContent.id="newContent" + this.name;
                                      paranewContent.classList.add("continutDescriere");

                                      paranewContent.innerHTML=replacebbcode;
                                      console.log(replacebbcode);

                                         
                                      descriereDiv.appendChild(paranewContent);

                                      deUmplut.appendChild(descriereDiv);

                                      if(date[0]['descriere']=='')
                                          descriereDiv.style.display="none";   //ii dam hide daca nu are desc
                                        else
                                          descriereDiv.style.display="block";
                                         

                                })


                             }
                             else if (nrApasari[this.name]%2==0)  //altfel doar dam unhide, ca sa nu se mai incarce
                             {
                              var deUmplut = document.getElementById("U"+ this.name); 
                              deUmplut.style.display="flex";  //flex nu block ca sa se pastreze aliniamentul elemnetelor dinauntrul sau 
                             }
                             else  //ca sa dam hide
                             {
                              
                              var deUmplut = document.getElementById("U"+ this.name);
                              

                              deUmplut.style.display="none";
                             }

                             nrApasari[this.name]=nrApasari[this.name]+1;

                             })

                             conceptHeaderButton.on("mouseenter", function()  //hover, mouse enter, mouse-ul e deasupra
                             {
                              document.getElementById( "button" + this.name ).style.color= '#7b46b3';

                             })

                             conceptHeaderButton.on("mouseleave", function()  //hover, mouse leave, mouse-ul paraseste elementtul
                             {
                              if(nrApasari[this.name]%2==0)  //ca sa ramana roz atunci cand e "apasat"
                                  document.getElementById( "button" + this.name ).style.color= "white";

                             })
          

                       }    
                    
                }
            }))    



        });

    });


    </script>
           
         

        
    </form>
    <div class="conceptsFound" id="buildyourform">
   </div>


</body>
</html>