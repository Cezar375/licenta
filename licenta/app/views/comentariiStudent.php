<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/comentariiPagina.css">
    <script src="https://cdn.tiny.cloud/1/4h6rh37oevzsxp4lpr6cel1rlx5z7fxoo6krskkna7oxg93n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Comentarii</title>
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
          <?php echo '<h1 class="numeleConceptuluiPagComentarii">' . $data['numeConcept'] .'</h1>';  ?>

          <div class="posteazaComentariu" id="postComment">
          <textarea  id="textAREAComentariu"></textarea>
          <button class="comentariiConceptButton" id="butonPosteazaComentariu">Posteaza!</button>
          </div>

          <div class="comentariiExistente" id="comentariiExistente">
              
          </div>        
      </div>

       <!--////////////////JS///////////////////-->
       <script>
          if(performance.navigation.type == 2)
             {
                  location.reload(true);
             }


          tinymce.init(
          {
            selector: 'textarea#textAREAComentariu' ,
            content_css: 'http://localhost:80/licenta/app/css/adaugaConcept.css',
            width:'100%',
            height:'18em',
            resize: false,
            plugins: 'bbcode code link autolink',
            menubar: 'file edit view insert table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | formatselect removeformat superscript subscript fontselect | alignleft aligncenter  alignright alignjustify | backcolor',
            branding:false,
            content_style: 'body { font-family:Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;}',
            skin_url: 'http://localhost:80/licenta/app/tinyMCETheme'       
          });

          var numeleConceptului=<?php echo "'" .$data['numeConcept']  . "'"; ?>;
          var numeleUtilizatorui=<?php echo "'" .$_SESSION['numeUtilizator']  . "'"; ?>;

          if(numeleUtilizatorui==-1)
          {
            numeleUtilizatorui='!!aaa';
          }


          $("#butonPosteazaComentariu").click(function()
          {
            var URL="http://localhost/licenta/public/api/concepte/adaugaComentariu/";
            URL=URL.concat(numeleConceptului.replaceAll(" ","_"));
            URL=URL.concat("?underscore=da");

            console.log(URL);

            fetch(URL,{method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({numeConcept:numeleConceptului, comentariu:tinyMCE.get('textAREAComentariu').getContent()    , numeUser:numeleUtilizatorui})}).
              then(response=>response.json()).then(data=>
              {

                 //console.log(URL);
                 //console.log(numeleUtilizatorui);
                 if(data['message'].substring(0,19)=="Comentariu adaugat!")  //trebuie adaugat si pe front-end
                 {
                    var commentBoxContainer=$("<div class=\"commentBoxContainer\">");
                    var idComentariuNouPostat=data['message'].substring(data['message'].lastIndexOf('=')+1);  //id-ul noului comentariu postat

                    var URL="http://localhost/licenta/public/api/concepte/getComentariuSpecific/";
                    URL=URL.concat(idComentariuNouPostat);
                    ////////////////////////////////////////////////
                    fetch(URL).
                       then(response=>response.json()).then(data=>
                       {
                         if(data['message']!="Nu exista un comentariu cu acest ID!")  
                            {
                                for(var obj of data['message'])  //va fi un singur obj de fapt, comment-ul cu id-ul acela proaspat adaugat
                                {
                                    var commentBox=$("<div class=\"commentBox\" id=\"commentBOX"  + obj['id']   +"\"/>");
                                    var nameANDcommentContent=$("<div class=\"nameANDcommentContentDIV\" id=\"nameANDcommentContent"  + obj['id']   +"\"/>");

                                    var authorDIV=$("<div class=\"authorDIV\" id=\"authorDIV"  + obj['id']   +"\"/>");
                                    var commentContentDIV=$("<div class=\"commentContentDIV\" id=\"commentContentDIV"  + obj['id']   +"\"/>");
                                    var timeDIV=$("<div class=\"timeDIV\" id=\"timeDIV"  + obj['id']   +"\"/>");

                                    nameANDcommentContent.append(authorDIV);
                                    nameANDcommentContent.append(commentContentDIV);

                                    commentBox.append(nameANDcommentContent);
                                    commentBox.append(timeDIV);

                                    var authorP = $("<p></p>").text("Autor: " + obj['nume_user']);
                                    replacebbcode=obj['comentariu'].replace(/(\[((\/?)(b|u|i|s|sub|sup))\])/gi, '<$2>');  //conversie in HTML
                                    replacebbcode=replacebbcode.replace(/\[url=([^\s\]]+)\s*\](.*(?=\[\/url\]))\[\/url\]/g, '<a href="$1">$2</a>');
                                    var comentariuTextP = $("<p></p>").html(replacebbcode);
                                    var timpP = $("<p></p>").text(obj['time']);

                                    authorDIV.append(authorP);
                                    commentContentDIV.append(comentariuTextP);
                                    timeDIV.append(timpP);

                                    commentBoxContainer.append(commentBox);
                                    $("#comentariiExistente").prepend(commentBoxContainer);  //il punem fix la inceput comentariul nou

                                }
                            }
                       })
                    ////////////////////////////////////////
                 }
                 else if(data['message']=="Numele de utilizator nu exista!")
                 {
                    Swal.fire({
                        toast: true,
                        icon: 'error',  //success va fi checkmark
                        title: 'Nu sunteti logat!',
                        animation: true,
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => 
                        {
                           //toast.addEventListener('mouseenter', Swal.stopTimer)
                           //toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                   })

                 }
              }) 
          })

          var URL="http://localhost/licenta/public/api/concepte/getToateComentariile/";
          URL=URL.concat(numeleConceptului.replaceAll(" ","_"));
          URL=URL.concat("?underscore=da");

          fetch(URL).
            then(response=>response.json()).then(data=>
            {
                /*console.log(data['message'].length);
                for (i = 0; i < Object.keys(data).length; i=i+1)
                 {console.log(data['message'][i]['id']);}*/
                 if(data['message']!="Nu exista comentarii asociate conceptului inca!")
                 for(var obj of data['message'])
                 {
                    console.log(obj['id']);
                    var commentBoxContainer=$("<div class=\"commentBoxContainer\">");
                    var commentBox=$("<div class=\"commentBox\" id=\"commentBOX"  + obj['id']   +"\"/>");
                    var nameANDcommentContent=$("<div class=\"nameANDcommentContentDIV\" id=\"nameANDcommentContent"  + obj['id']   +"\"/>");

                    var authorDIV=$("<div div class=\"authorDIV\" id=\"authorDIV"  + obj['id']   +"\"/>");
                    var commentContentDIV=$("<div class=\"commentContentDIV\" id=\"commentContentDIV"  + obj['id']   +"\"/>");
                    var timeDIV=$("<div class=\"timeDIV\" id=\"timeDIV"  + obj['id']   +"\"/>");

                    nameANDcommentContent.append(authorDIV);
                    nameANDcommentContent.append(commentContentDIV);

                    commentBox.append(nameANDcommentContent);
                    commentBox.append(timeDIV);

                    var authorP = $("<p></p>").text("Autor: " + obj['nume_user']);
                    replacebbcode=obj['comentariu'].replace(/(\[((\/?)(b|u|i|s|sub|sup))\])/gi, '<$2>');  //conversie in HTML
                    replacebbcode=replacebbcode.replace(/\[url=([^\s\]]+)\s*\](.*(?=\[\/url\]))\[\/url\]/g, '<a href="$1">$2</a>');
                    var comentariuTextP = $("<p></p>").html(replacebbcode);
                    var timpP = $("<p></p>").text(obj['time']);

                    authorDIV.append(authorP);
                    commentContentDIV.append(comentariuTextP);
                    timeDIV.append(timpP);

                    commentBoxContainer.append(commentBox);
                    $("#comentariiExistente").append(commentBoxContainer);  //il punem la final


                 }
            })


       </script>    


    </div>

    </body>
</html>