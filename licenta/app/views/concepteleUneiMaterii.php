<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <script src="https://cdn.tiny.cloud/1/4h6rh37oevzsxp4lpr6cel1rlx5z7fxoo6krskkna7oxg93n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
             if(performance.navigation.type == 2)
             {
                  location.reload(true);
             }


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
                          //$('#formSpecificareNivel').hide();
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

                          var conceptHeaderButton=$("<button class=\"conceptHeaderButton\" name=\""  + unConcept['nume']   +"\"id=\"button" + unConcept['nume'] + "\"/>");
                 
                          conceptHeaderButton.text("🖋️ "+unConcept['nume'].replaceAll("_"," "));  //ca "butonul" sa aiba spatii totusi

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

                             if (nrApasari[this.name]==0)   //dam show   daca e prima oara cand afisam construim propriu zis
                             {
                              document.getElementById( "button" + this.name ).style.color = '#7b46b3';  //"butonul" e apasat

                             var comentariiButton = $("<button name=\"viewComentariiConcept\" class=\"comentariiConceptButton\" id=\"comentariiBUTON"  + this.name   +"\"type=\"submit\" class=\"remove\" value=\"Get comentarii concept\" />");
                             comentariiButton.text("Comentarii");
                             $("#U"+ this.name).append(comentariiButton);

                             var removeButton = $("<button class=\"removeConceptButton\" id=\"DELETE"  + this.name   +"\"type=\"button\" class=\"remove\" value=\"Sterge concept\" />");
                             removeButton.text("Sterge Concept");
                             $("#U"+ this.name).append(removeButton);

                             
                             var numeleConceptului=this.name;
                             $("#DELETE"+this.name).click(function()    //de asemenea call la API sa scoata nodul
                             { 
                               //console.log(this.id);
                               //$("#field"+numeleConceptului).remove();

                               var urlAPI='http://localhost/licenta/public/api/concepte/stergeNod/';
                               urlAPI=urlAPI.concat(numeleConceptului);
                               urlAPI=urlAPI.concat("?underscore=da");

                               fetch(urlAPI,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                               {
                                    if(data['message']=="Conceptul a fost sters")
                                        $("#field"+numeleConceptului).remove();
                               }))

                             });

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
                                      containerRelatiiExistente.classList.add("containerRelatiiExistente");
                                      containerRelatiiExistente.id="containerRelatiiExistente" + numeleConceptului;
                                      containerRelatiiExistente.appendChild(relatiiExistenteText);

                                       if( dat["message"] != "Conceptul dat nu are relatii asociate lui" )
                                           for (var n of dat)
                                           {
                                            
                                            var stergeRelatieButon=document.createElement("button");
                                            var oRelatie = document. createElement("div");
                                            var node=document.createElement("p");
                                            node.innerHTML="Nume relatie : " + n['relatie'].replaceAll("_"," ") + " cu : " +n['nume'];
                                            node.classList.add("relatieInText");
                                            stergeRelatieButon.textContent="Sterge relatie";

                                            n['nume']=n['nume'].replaceAll(" ","_"); //replace la spatiu cu _

                                            stergeRelatieButon.id="-stergeRel-" + n['relatie'] + '-CU-' + n['nume']+ '-APARTINAND-' + numeleConceptului;  //setam id-ul individual
                                            stergeRelatieButon.classList.add("stergeRelatieExistentaButon");
                                            oRelatie.id="-stergeREL-" + n['relatie'] + '-CU-' + n['nume'] + '-APARTINAND-' + numeleConceptului;  //setam id-ul individual
                                            oRelatie.classList.add("divORelatieExistenta");
                                            


                                            arrayRelatii.push("-stergeRel-" + n['relatie'] + '-CU-' + n['nume']+ '-APARTINAND-' + numeleConceptului); //dupa vom itera asta si vom face listenere pt fiecare buton de remove

                                            oRelatie. appendChild(node);
                                            oRelatie. appendChild(stergeRelatieButon);
                                            ///
                                            containerRelatiiExistente.appendChild(oRelatie);
                                            ///
                                            //deUmplut. appendChild(oRelatie);

                                           }
                                           deUmplut. appendChild(containerRelatiiExistente);


                                           for (relatie of arrayRelatii) //construim handlere pt onclick pt buttonul de stergere a relatiei
                                               {   
                                                 
                                                  $("#"+relatie).click(function(e)  // + call la API sa stearga relatia
                                                  {
                                                     e.preventDefault();
                                                     //trebuie this.id pt ca nu merge bine array-ul
                                                     relatie=this.id.replace("-stergeRel-","-stergeREL-")  // Rel e in ID-ul butonului , REL e in ID-ului "relatiei" in sine, si vrem sa stergem "relatia" adica "containerul" cu tot
                                                     //console.log(this.id);
                                                     //$("#"+relatie).remove();  //stergem "containerul" adica intreaga relatie
                                                     //console.log(relatie);

                                                     var splitat=relatie.split("-stergeREL-");
                                                     splitat=splitat[1].split("-CU-");
                                                     var numeRelatie=splitat[0];

                                                     splitat=relatie.split("-CU-");
                                                     splitat=splitat[1].split("-APARTINAND-");
                                                     var nod1=splitat[1];
                                                     var nod2=splitat[0];

                                                     relatieInversa="-stergeREL-" + numeRelatie + '-CU-' + nod1+ '-APARTINAND-' + nod2;  //sa o stergem si din GUI-ul celuilalt elemenet DACA exista desigur

                                                     var urlAPI='http://localhost/licenta/public/api/concepte/stergeRelatie/';
                                                     urlAPI=urlAPI.concat(numeRelatie);
                                                     urlAPI=urlAPI.concat("?nod1Nume=");
                                                     urlAPI=urlAPI.concat(nod1);
                                                     urlAPI=urlAPI.concat("&nod2Nume=");
                                                     urlAPI=urlAPI.concat(nod2);

                                                     fetch(urlAPI,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                                                     {
                                                         if(data['message']=="Relatie stearsa cu succes!")
                                                           {
                                                             $("#"+relatie).remove();  //stergem "containerul" adica intreaga relatie
                                                             //$("#"+relatieInversa).remove();
                                                           }
                                                     }))
                                                     
                                                     
                                                  })

                                               }   
                                           
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
                                         descriereDiv.classList.add("boxDescriere");

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
                                         
                                        
                                       ////////////////////////////////////SCHIMBA CONTINUT DESCRIERE///////////////////////////////////////////////////////
                                       var schimbaDescriereButton = $("<button class=\"toggleModificaDescriere\" id=\"afiseazaModificaDescriere" + numeleConceptului + "\"type=\"button\"  />");
                                       schimbaDescriereButton.text("Modifica descrierea");
                                       var containerSchimbaDescrierea=$("<form method=\"post\" name=\"formSchimbaDescrierea" + numeleConceptului + "\"class=\"formSchimbaDescrierea\" id=\"formSchimbaDescrierea" + numeleConceptului + "\"/>");

                                       $("#U"+numeleConceptului).append(schimbaDescriereButton);

                                       nrApasariDescriere[numeleConceptului]=0;
                                        
                                       schimbaDescriereButton.click(function()
                                       {
                                         //o sa am toggle on/off la toate astea deci :
                                         if(nrApasariDescriere[numeleConceptului]==0)  //prima oara cand apas, trebuie construite/generate
                                         {
                                           var textareaNouaDescriere=$("<textarea  id=\"textAREA" + numeleConceptului +  "\" title=\"Max 1500 caractere alfanumerice si punctuatie!\" maxlength=\"1500\" name=\"DescriereaConceptului\" class=\"nouaDescriereConcept\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ.,?!~;:'-+)(]+\" placeholder=\"Descriere, linkuri, resurse \">");
                                           
                                           var submitDescriereNouaButton=$("<button id=\"submitDescriereNouaButon" + numeleConceptului + "\" class=\"submitNouaDescriereConcept\" type=\"button\"  />");
                                           submitDescriereNouaButton.text("Actualizeaza");

                                           containerSchimbaDescrierea.append(textareaNouaDescriere);
                                          
                                           containerSchimbaDescrierea.append(submitDescriereNouaButton);


                                           containerSchimbaDescrierea.insertAfter($("[id=\"afiseazaModificaDescriere" + numeleConceptului + "\"]"));
                                                                                 //($("[id=\"add" + numeleConceptului +"\"]").last())

                                          tinymce.init({
                   
                   selector: 'textarea#textAREA' + numeleConceptului,
                   content_css: 'http://localhost:80/licenta/app/css/adaugaConcept.css',
                   width:'100%',
                   resize: false,
                   plugins: 'bbcode code link autolink',
                   menubar: 'file edit view insert table tc help',
                   toolbar: 'undo redo | bold italic underline strikethrough | formatselect removeformat superscript subscript fontselect | alignleft aligncenter  alignright alignjustify | backcolor',
                   branding:false,
                   content_style: 'body { font-family:Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;}',
                   skin_url: 'http://localhost:80/licenta/app/tinyMCETheme'
   
                   
                  });


                                            //console.log(numeleConceptului);
                                            $("#submitDescriereNouaButon"+numeleConceptului).click(function(buton)
                                           {
                                              //console.log(numeleConceptului);
                                              buton.preventDefault();
                                              var urlAPI='http://localhost/licenta/public/api/concepte/modificaDescrierea/';
                                              urlAPI=urlAPI.concat(numeleConceptului);
                                              urlAPI=urlAPI.concat('?underscore=da');
                                              //console.log(tinyMCE.get('textAREA' + numeleConceptului).getContent());               
                                              //console.log(urlAPI);
                                              fetch(urlAPI,{method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({nouaDescriere:tinyMCE.get('textAREA' + numeleConceptului).getContent()})}).then(Response=>Response.json().then(data=>
                                              {

                                                if(data['message']=="Descriere modificata cu succes!")  //modificam descrierea doar daca noua descriere e ok, call-ul la API e cu succes
                                                {   
                                                    var replacebbcode=tinyMCE.get('textAREA' + numeleConceptului).getContent();
                                                    replacebbcode=replacebbcode.replace(/(\[((\/?)(b|u|i|s|sub|sup))\])/gi, '<$2>');  //conversie in HTML
                                                    replacebbcode=replacebbcode.replace(/\[url=([^\s\]]+)\s*\](.*(?=\[\/url\]))\[\/url\]/g, '<a href="$1">$2</a>');
                                                    
                                                    //console.log(replacebbcode);
                                                    $("#newContent" + numeleConceptului).html(replacebbcode);  //pt a schimba continutul descrierii fara refresh

                                                    
                                                    

                                                    if(tinyMCE.get('textAREA' + numeleConceptului).getContent()!="")  //daca nu e ""
                                                        descriereDiv.style.display="block";
                                                    else
                                                        descriereDiv.style.display="none";    // daca e "" inseamna ca vrem sa 'scoatem' descrierea
                                                }

                                              }))

                                             

                                           })    

                                           
                                           console.log("0");                                  
                                         }
                                         else if(nrApasariDescriere[numeleConceptului]%2==0)
                                         {
                                             containerSchimbaDescrierea.show();
                                             console.log("%2==0");
                                         }
                                         else
                                         {
                                          containerSchimbaDescrierea.hide();
                                          console.log("%2==1");
                                         }

                                         nrApasariDescriere[numeleConceptului]=nrApasariDescriere[numeleConceptului]+1; //actualizam contorul acesta

                                       })

                                       ////////////////////////////SCHIMBARE NUME CONCEPT///////////////////////////////////////
                                        var schimbaNumeleConceptului=$("<h3 class=\"schimbaNumeleConceptuluiH\">");
                                        schimbaNumeleConceptului.text("Schimba numele conceptului!");

                                        var nouNumeConceptInput = $("<input id=\"nouNumeConceptInput" + numeleConceptului + "\"title=\"Max 100 caractere alfanumerice si spatii\" maxlength=\"100\" name=\"nouNumeConcept\" type=\"text\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+\" required class=\"inputNouNume\" placeholder=\"Nume concept/materie\" />");
                                        var submitNouNumeButton = $("<button id=\"submitNouNumeButton" + numeleConceptului +"\"class=\"submitNouNumeButton\" type=\"button\"  />");
                                        submitNouNumeButton.text("Schimba numele!");
                                        var formNouNume=$("<form method=\"post\" name=\"formNouNume" + numeleConceptului + "\"class=\"formNouNume\" id=\"formNouNume" + numeleConceptului + "\"/>");
                                         

                                        $(formNouNume).append(schimbaNumeleConceptului);
                                        formNouNume.append(nouNumeConceptInput);
                                        formNouNume.append(submitNouNumeButton);

                                        $("#U"+numeleConceptului).append(formNouNume);

                                        $("#submitNouNumeButton" + numeleConceptului).click(function(buton)  //call la API sa schimbe numele, se va face refresh deoarece totul de pe pagina depinde de numele conceptelor
                                        {
                                          //console.log($("#nouNumeConceptInput" + numeleConceptului).val());  //pt a lua numele introdus in input
                                          //window.location.reload(true);

                                          buton.preventDefault();  //ca sa nu dea refresh automat la pagina la apasarea butonului

                                          var formNouNumeVerificat=document.getElementById('formNouNume' + numeleConceptului);
                                          formNouNumeVerificat.checkValidity();
                                          formNouNumeVerificat.reportValidity();

                                          var urlAPI="http://localhost/licenta/public/api/concepte/modificaNumele/";
                                          urlAPI=urlAPI.concat(numeleConceptului);
                                          urlAPI=urlAPI.concat("?underscore=da");
                                          urlAPI=urlAPI.concat("&nouNume=");
                                          urlAPI=urlAPI.concat($("#nouNumeConceptInput" + numeleConceptului).val()); //textul din input box


                                          var noulNumeIntrodus=$("#nouNumeConceptInput" + numeleConceptului).val();
                                          noulNumeIntrodus=noulNumeIntrodus.replaceAll(" ","_");

                                          fetch(urlAPI,{method: 'POST'}).then(Response=>Response.json().then(data=>  //facem fetch-ul la API propriu zis
                                          {
                                            if(data['message']=="Nume modificat cu succes")
                                            {
                                              //window.location.reload(true);  //sa dea refresh dupa fetch
                                              var all = document.getElementsByTagName("*");

                                              for (var i=0, max=all.length; i < max; i++) 
                                              {
                                                // ar trebui *PROBABIL* sa punem _ in loc de spatii in noul nume ca sa nu avem probleme cu id-urile
                                                all[i].id=all[i].id.replace(numeleConceptului,noulNumeIntrodus);  //va schimba ID-ul doar a elementelor vizibile de pe pagina atunci
                                                                                                                 //dar trebuie schimbat si ID-ul elementelor ce nu sunt vizibile atunci pe pagina
                                                
                                                if (typeof all[i].name !== 'undefined')                                                                  
                                                {
                                                  all[i].name=all[i].name.replace(numeleConceptului,noulNumeIntrodus);
                                                  //console.log(all[i].name);
                                                }  

                                                ///!!!!   cand fac replace-urile astea ar trebui sa am separatori ca sa nu dau replace aiurea si sa stric totul                                                                  
                                              }

                                              deUmplut.action= "http://localhost/licenta/public/Materii/viewComentarii/" + noulNumeIntrodus;
                                              nrApasari[noulNumeIntrodus]=1; //avem deja apasat cand schimbam numele

                                              nrApasariDescriere[noulNumeIntrodus]=nrApasariDescriere[numeleConceptului];

                                              $('.relatieInText').each(function(i, obj) 
                                              {
                                                 var sir=obj.innerHTML; //preluam continutul textului ce descrie relatia
                                                 var ultimIndexDouaPuncte=sir.lastIndexOf(':');  //gaseste indexul ultimului :
                                                 var numeConceptDeVerificat=sir.substring(ultimIndexDouaPuncte+2,sir.length);  //+2 ca sa treaca de : si spatiul de dupa
                                                 
                                                 //console.log(obj.innerHTML);

                                                 if(numeConceptDeVerificat==numeleConceptului.replaceAll("_"," "))
                                                 {
                                                   sir=sir.substring(0,ultimIndexDouaPuncte+2) + noulNumeIntrodus.replaceAll("_"," ");
                                                   obj.innerHTML=sir;  //actualizam
                                                   
                                                 }
                                              });


                                              numeleConceptului=noulNumeIntrodus;
                                              $("#button" + noulNumeIntrodus).text("🖋️ " + noulNumeIntrodus.replaceAll("_"," "));
                                              //console.log($("#button" + noulNumeIntrodus));

                                            }
                                            else if(data['message']=="Alegeti alt nume, cel dat este deja folosit!")
                                            {

                                             Swal.fire({
                                              toast: true,
                                              icon: 'error',  //success va fi checkmark
                                              title: "Exista un concept cu acest nume!",
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

                                       /////////////ADAUGARE RELATII NOI/////////////////////////////////
                                       var adaugaRelatieButon=$("<button type=\"button\" value=\"Adauga relatie\" class=\"adaugaORelatieNouaCamp\"  id=\"add" + numeleConceptului + "\"/>");
                                       adaugaRelatieButon.text("Adauga relatie");
                                       

                                       var fieldsetADDRelatii = $("<fieldset name=\"fieldsetADDRelatii" + numeleConceptului + "\"class=\"fieldsetADDRelatii\" id=\"fieldsetADDRelatii" + numeleConceptului + "\"/>");
                                       var legendFieldset=$('<legend class="labelH">Adaugare relatii</legend>');

                                       fieldsetADDRelatii.append(legendFieldset);
                                       
                                       $("#U"+numeleConceptului).append(fieldsetADDRelatii);
                                       $("#U"+numeleConceptului).append(adaugaRelatieButon);
                                       $("#add" + numeleConceptului).click(function() //doar pt idul asta
                                      {
                                        var fieldWrapper = $("<form name=\"formAdaugareRelatii" + numeleConceptului + "\"class=\"containerRelatiiDeAdaugat\" id=\"containerRelatiiDeAdaugat" + numeleConceptului + "\"/>");

                                        var numeConceptSauMaterie = $("<input title=\"Max 150 caractere alfanumerice si spatii!\" maxlength=\"150\" name=\"numeConceptMaterie[]\" type=\"text\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+\" required class=\"inputBoxNouaRelatie\" placeholder=\"Nume concept/materie\" />");
                                        var relatieCuEa = $("<input  title=\"Max 150 caractere alfanumerice si _,incepep cu litere!\" maxlength=\"150\" name=\"relatieCuEa[]\" type=\"text\" pattern=\"[a-zA-ZăâîșțĂÂÎȘȚ]+[a-zA-ZăâîșțĂÂÎȘȚ0-9_]*\" required class=\"inputBoxNouaRelatie\" placeholder=\"Relatie\" />");
                          
                                        var removeButton = $("<button class=\"removeButtonPtORelatieInputField\" type=\"button\"  value=\"Remove\" />");
                                        removeButton.text("Remove");
                                        var submitRelatieButton = $("<button class=\"submitNouaRelatieButton\" type=\"button\"  />");
                                        submitRelatieButton.text("Submit");

                                        removeButton.click(function() //e doar front-end, nu necesita call la API, scoate campurile din pagina doar
                                        {
                                           $(this).parent().remove();
                                        });

                                        submitRelatieButton.click(function(buton) //+ call la API cu form data
                                        {
                                           buton.preventDefault();
                                           var formNouNumeVerificat=document.getElementById('containerRelatiiDeAdaugat' + numeleConceptului);
                                           formNouNumeVerificat.checkValidity();
                                           formNouNumeVerificat.reportValidity();


                                           var nod1=numeleConceptului;
                                           var nod2=numeConceptSauMaterie.val()  ;
                                           var numeleRelatiei=relatieCuEa.val()  ;

                                           //console.log(nod2);
                                           //console.log(numeleRelatiei);
 
                                           var urlAPI='http://localhost/licenta/public/api/concepte/adaugaRelatie/'  ;
                                           urlAPI=urlAPI.concat(numeleRelatiei);
                                           urlAPI=urlAPI.concat('?nod1Nume=');
                                           urlAPI=urlAPI.concat(nod1);
                                           urlAPI=urlAPI.concat('&nod2Nume=');
                                           urlAPI=urlAPI.concat(nod2);

                                           fetch(urlAPI,{method: 'POST'}).then(Response=>Response.json().then(data=>   //trebuie modificat a.i sa adauge toate astea DOAR daca relatia e adaugata si e totul valid
                                           {

                                            if(data['message']=="Relatie creata cu succes intre cele 2 noduri specificate!") 
                                            {var stergeRelatieButon=document.createElement("button");
                                            //console.log(urlAPI);
                                            var oRelatie = document. createElement("div");
                                            var node=document.createElement("p");
                                            node.innerHTML="Nume relatie : " + numeleRelatiei.replaceAll("_"," ") + " cu : " +nod2;
                                            console.log(node.innerHTML);
                                            node.classList.add("relatieInText");
                                            stergeRelatieButon.textContent="Sterge relatie";

                                            nod2=nod2.replaceAll(" ","_"); //replace la spatiu cu _

                                            stergeRelatieButon.id="-stergeRel-" + numeleRelatiei + '-CU-' + nod2+ '-APARTINAND-' + nod1;  //setam id-ul individual
                                            relatie="-stergeRel-" + numeleRelatiei + '-CU-' + nod2+ '-APARTINAND-' + nod1;
                                            stergeRelatieButon.classList.add("stergeRelatieExistentaButon");
                                            oRelatie.id="-stergeREL-" + numeleRelatiei + '-CU-' + nod2 + '-APARTINAND-' + nod1;  //setam id-ul individual
                                            oRelatie.classList.add("divORelatieExistenta");
                                            


                                            //arrayRelatii.push("-stergeRel-" + n['relatie'] + '-CU-' + n['nume']+ '-APARTINAND-' + numeleConceptului); //dupa vom itera asta si vom face listenere pt fiecare buton de remove

                                            oRelatie. appendChild(node);
                                            oRelatie. appendChild(stergeRelatieButon);
                                            ///
                                            var containerRelatiiActuale=document.getElementById("containerRelatiiExistente"+nod1);
                                            containerRelatiiActuale.appendChild(oRelatie);

                                            $("#"+relatie).click(function(e)  //pt a o sterge
                                            {
                                              e.preventDefault();
                                              relatie=this.id.replace("-stergeRel-","-stergeREL-")  // Rel e in ID-ul butonului , REL e in ID-ului "relatiei" in sine, si vrem sa stergem "relatia" adica "containerul" cu tot
                                              //console.log(this.id);
                                              $("#"+relatie).remove();  //stergem "containerul" adica intreaga relatie
                                              //console.log(relatie);

                                              var splitat=relatie.split("-stergeREL-");
                                              splitat=splitat[1].split("-CU-");
                                              var numeRelatie=splitat[0];

                                              splitat=relatie.split("-CU-");
                                              splitat=splitat[1].split("-APARTINAND-");
                                              var nod1=splitat[1];
                                              var nod2=splitat[0];

                                              relatieInversa="-stergeREL-" + numeleRelatiei + '-CU-' + nod1+ '-APARTINAND-' + nod2;  //sa o stergem si din GUI-ul celuilalt elemenet DACA exista desigur
                                              //console.log(relatieInversa);
                                              //$("#"+relatieInversa).remove();

                                              var urlAPI='http://localhost/licenta/public/api/concepte/stergeRelatie/';
                                              urlAPI=urlAPI.concat(numeRelatie);
                                              urlAPI=urlAPI.concat("?nod1Nume=");
                                              urlAPI=urlAPI.concat(nod1);
                                              urlAPI=urlAPI.concat("&nod2Nume=");
                                              urlAPI=urlAPI.concat(nod2);

                                              fetch(urlAPI,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                                              {
                                                      if(data['message']=="Relatie stearsa cu succes!")
                                                         $(this).parent().remove();
                                              }))
                                            })

                                              


                                            ///////////in caz ca adaugam o relatie la un buton deja existent pe pagina ar trebui si el sa aiba relatia la relatii existente/////////////////////

                                           if(0==1)
                                           try{ 
                                           var aux;     //interschimbare
                                           aux=nod1;
                                           nod1=nod2;
                                           nod2=aux;

                                         
                                            var stergeRelatieButon=document.createElement("button");
                                            var oRelatie = document. createElement("div");
                                            var node=document.createElement("p");
                                            node.innerHTML="Nume relatie : " + numeleRelatiei.replaceAll("_"," ") + " cu : " +nod2;
                                            console.log(node.innerHTML);
                                            node.classList.add("relatieInText");
                                            stergeRelatieButon.textContent="Sterge relatie";

                                            nod2=nod2.replaceAll(" ","_"); //replace la spatiu cu _

                                            stergeRelatieButon.id="-stergeRel-" + numeleRelatiei + '-CU-' + nod2+ '-APARTINAND-' + nod1;  //setam id-ul individual
                                            relatie="-stergeRel-" + numeleRelatiei + '-CU-' + nod2+ '-APARTINAND-' + nod1;
                                            stergeRelatieButon.classList.add("stergeRelatieExistentaButon");
                                            oRelatie.id="-stergeREL-" + numeleRelatiei + '-CU-' + nod2 + '-APARTINAND-' + nod1;  //setam id-ul individual
                                            oRelatie.classList.add("divORelatieExistenta");
                                            


                                            //arrayRelatii.push("-stergeRel-" + n['relatie'] + '-CU-' + n['nume']+ '-APARTINAND-' + numeleConceptului); //dupa vom itera asta si vom face listenere pt fiecare buton de remove

                                            oRelatie. appendChild(node);
                                            oRelatie. appendChild(stergeRelatieButon);
                                            ///
                                            var containerRelatiiActuale=document.getElementById("containerRelatiiExistente"+nod1);
                                            containerRelatiiActuale.appendChild(oRelatie);

                                            $("#"+relatie).click(function(e)  //pt a o sterge
                                            {
                                              e.preventDefault();
                                              relatie=this.id.replace("-stergeRel-","-stergeREL-")  // Rel e in ID-ul butonului , REL e in ID-ului "relatiei" in sine, si vrem sa stergem "relatia" adica "containerul" cu tot
                                              //console.log(this.id);
                                              //$("#"+relatie).remove();  //stergem "containerul" adica intreaga relatie
                                              //console.log(relatie);

                                              var splitat=relatie.split("-stergeREL-");
                                              splitat=splitat[1].split("-CU-");
                                              var numeRelatie=splitat[0];

                                              splitat=relatie.split("-CU-");
                                              splitat=splitat[1].split("-APARTINAND-");
                                              var nod1=splitat[1];
                                              var nod2=splitat[0];

                                              relatieInversa="-stergeREL-" + numeleRelatiei + '-CU-' + nod1+ '-APARTINAND-' + nod2;  //sa o stergem si din GUI-ul celuilalt elemenet DACA exista desigur
                                              //console.log(relatieInversa);
                                              //$("#"+relatieInversa).remove();

                                              var urlAPI='http://localhost/licenta/public/api/concepte/stergeRelatie/';
                                              urlAPI=urlAPI.concat(numeRelatie);
                                              urlAPI=urlAPI.concat("?nod1Nume=");
                                              urlAPI=urlAPI.concat(nod1);
                                              urlAPI=urlAPI.concat("&nod2Nume=");
                                              urlAPI=urlAPI.concat(nod2);

                                              fetch(urlAPI,{method: 'DELETE'}).then(Response=>Response.json().then(data=>
                                              {
                                                  if(data['message']=="Relatie stearsa cu succes!")
                                                    {
                                                      $("#"+relatie).remove();  //stergem "containerul" adica intreaga relatie
                                                      $("#"+relatieInversa).remove();
                                                    }  
                                              }))
                                            })

                                           }
                                           catch(err)
                                           {
                                                console.log("Nu s-a generat inca divul necesar");
                                           }
                                           

                                           }
                                           else if (data['message']=="Nodul 2 nu exista!")
                                           {
                                            Swal.fire({
                                              toast: true,
                                              icon: 'error',  //success va fi checkmark
                                              title: "Conceptul cu numele dat nu exista!",
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
                                           else if(data['message']=="Relatia exista deja!")
                                           {
                                            Swal.fire({
                                              toast: true,
                                              icon: 'error',  //success va fi checkmark
                                              title: "Relatia exista deja!",
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


                                           
                                        });

                                       
                                        fieldWrapper.append(numeConceptSauMaterie);
                                        fieldWrapper.append(relatieCuEa);
                                        fieldWrapper.append(removeButton);
                                        fieldWrapper.append(submitRelatieButton);
                                        fieldsetADDRelatii.append(fieldWrapper);  //last nu functioneaza, pt ca butonul cu id-ul ala e unul singur pe concept, ar trebui dupa last  id=\"containerRelatiiDeAdaugat" + numeleConceptului
                                      })  
                                       
                                       ////////////////////////////////////////////////////////////////////

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