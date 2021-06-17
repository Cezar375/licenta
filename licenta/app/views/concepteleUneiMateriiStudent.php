<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Conceptele materiei</title>
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

      <div class="dottedContainer">
      <div class="containerTOPInputNumeMaterie">
          <?php echo '<h1 class="numeleMateriei">' . $data['numeMaterie'] .'</h1>';  ?>
          <form action="" class="formNivel" id="formSpecificareNivel" method="post">
             <input title="Numere naturale, >=1" required type="number" min="1" step="1" id="nivelSpecificat" name="Nivel" placeholder="Max nivel" class="nivelInput">
             <input name="Materie" value=<?php echo '' . str_replace(" ","_",$data['numeMaterie']) .'';  ?> type="hidden">
             <button class="butonSubmitNivel" type="submit">Go</button>
         </form>
      </div>

      <div class="formBuilder" id="buildyourform">

</div>

<script>

              var numeMaterie=<?php echo "'" .$data['numeMaterie']  . "'"; ?>;

              var nivelMaxim=-1;
              <?php
              if(isset($data['nivelMaxim']))
              {
              ?>               
              var nivelMaxim=<?php echo "'" .$data['nivelMaxim']  . "'"; ?>;
              <?php
              }
              ?>

              $( "#formSpecificareNivel" ).submit(function( event ) 
             {
               document.getElementById('formSpecificareNivel').action = 'http://localhost/licenta/public/Materii/setareNivelCautare/' + numeMaterie.replaceAll(" ","_") + '/' + $('#nivelSpecificat').val();
             });
//////////////////////////////////////////////////////////////////////////////////////////////////////

                var nrApasari=new Array();
                var nrApasariDescriere=new Array();
                function getAllConceptsFunction(concept) //JS dinamic, va genera toate conceptele
                {
                  URL='http://localhost/licenta/public/api/concepte/noduriLegate/'
                  concept=concept.replaceAll(" ", "_");
                  URL=URL.concat(concept);
                  URL=URL.concat('?underscore=da');


                  if(nivelMaxim!=-1)
                  {
                    URL=URL.concat('&nivel=');
                    URL=URL.concat(nivelMaxim);
                  }

                  console.log(URL);

                  
                  fetch(URL).
                    then(response=>response.json()).then(data=>
                    {    
                        if(data["message"] == "Conceptul dat este izolat")
                        {
                          $('#formSpecificareNivel').hide();
                          console.log("Nu exista concepte asociate!");

                          var noConceptsFoundText=$("<h3 class=\"conceptHeaderButton\">");
                          noConceptsFoundText.text("Nu exista concepte asociate."); 
                          $(".dottedContainer").append(noConceptsFoundText);

                        }
                        else
                        for (var unConcept of data) 
                        {
                          if(!unConcept['labels'].includes("Materie")) 
                          {//important
                          unConcept['nume']=unConcept['nume'].replaceAll(" ", "_");  //daca conceptul contine spatii id-urile si restul nu vor fi ok

                          var fieldWrapper = $("<div class=\"Fieldwrapper\" id=\"field" + unConcept['nume'] + "\"/>");  //in asta vom pune butonul cu numele conceptului, dupa la click pe buton afisam descrierea, relatii, etc
                          var deUmplut=$("<form method=\"get\"  action=\"http://localhost/licenta/public/Materii/viewComentarii/" + unConcept['nume']   + " \"class=\"deUmplut\"  id=\"U"  + unConcept['nume']   +"\"/>");
                          deUmplut.hide();
                          var conceptHeaderButton=$("<button class=\"conceptHeaderButton\" name=\""  + unConcept['nume']   +"\"id=\"button" + unConcept['nume'] + "\"/>");
                 
                          conceptHeaderButton.text("📚 "+unConcept['nume'].replaceAll("_"," "));  //ca "butonul" sa aiba spatii totusi

                          fieldWrapper.append(conceptHeaderButton);
                          fieldWrapper.append(deUmplut);
                          $("#buildyourform").append(fieldWrapper);

                          nrApasari[unConcept['nume']]=0; //initializam nr de apasari ale butonului cu 0
  
                          conceptHeaderButton.click(function() 
                          {
                             var url='http://localhost/licenta/public/api/concepte/infoNod/'
                             url=url.concat(this.name);  //concatenam numele butonului adica a conceptului
                             url=url.concat("?underscore=da");  //underscore nu e permis in nume, deci il vom scoate pt ca daca e e pus in loc de spatiu

                             var deUmplut = document.getElementById("U"+ this.name);
                             deUmplut.style.display="flex";

                             if (nrApasari[this.name]==0)   //dam show   daca e prima oara cand afisam construim propriu zis
                             {
                              document.getElementById( "button" + this.name ).style.color = '#7b46b3';  //"butonul" e apasat

                             
                             var comentariiButton = $("<button name=\"viewComentariiConcept\" class=\"comentariiConceptButtonStudent\" id=\"comentariiBUTON"  + this.name   +"\"type=\"submit\" class=\"remove\" value=\"Get comentarii concept\" />");
                             comentariiButton.text("Comentarii");
                             $("#U"+ this.name).append(comentariiButton);


                             var numeleConceptului=this.name;

                              fetch(url).
                              then(Response=>Response.json()).then(date=>
                                {
                                  
                                     deUmplut.style.border="1px solid #d08df4";
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
                                      descriereDiv.classList.add("boxDescriereStudent");

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
       

                        }//end if care evrifica daca conceptul nu are Materie ca label

                          }



                        });

                    }

               getAllConceptsFunction(numeMaterie); 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


          </script>
      
      <script>  //ca sa mearga back fara confirm form re-submission
        if ( window.history.replaceState ) {
           window.history.replaceState( null, null, window.location.href );
         }
      </script>

      </div>
    
    </div>


</body>
</html>