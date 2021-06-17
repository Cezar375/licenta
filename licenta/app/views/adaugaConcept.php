<!DOCTYPE html>
<html lang="en" class='htmlBODY' id="html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/adaugaConcept.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4h6rh37oevzsxp4lpr6cel1rlx5z7fxoo6krskkna7oxg93n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    <title>Adauga Concept</title>
</head>
<body class='htmlBODY' id="body">
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



<?php if($_SESSION['privileges']==='profesor') : ?>
   <form id="formPtAdaugareNouConcept" action="http://localhost/licenta/public/Materii/AdaugareConcept" method="post" class="bottomDiv">
        <div class="parteaConcept">
        <h1 class="adaugaConceptText">Adauga un concept!</h1>
        <input title="Max 100 caractere alfanumerice!" maxlength="100" class="numeConceptInput" required name="NumeConcept" pattern="[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+" placeholder="Nume concept">
        

           <!--Nume concept, materii asociate , concepte asociate , denumire relatii(ce scriem pe arce adica), descriere,resurse -->    

                <!--   Dynamic choose relatie si concepte related ------------------------------------------------------>
                <fieldset id="buildyourform">
                <legend class="labelH">Adaugare relatii</legend>
                </fieldset>
                <button type="button"  class="addAFieldButton" class="add" id="add" />Adauga relatie</button>

                <fieldset id="buildyourformTAG">
                <legend class="labelH">Adaugare tag-uri</legend>
                </fieldset>
                <button type="button"  class="addAFieldButton" class="add" id="addTAG" />Adauga tag</button>

                <script >
                    $(document).ready(function() 
                    {
                      $("#add").click(function() 
                      {
    		                 var lastField = $("#buildyourform div:last");
                          var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
                          var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
                          fieldWrapper.data("idx", intId);
                          var numeConceptSauMaterie = $("<input title=\"Max 150 caractere alfanumerice si spatii!\" maxlength=\"150\" name=\"numeConceptMaterie[]\" type=\"text\" pattern=\"[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+\" required class=\"fieldname\" placeholder=\"Nume concept/materie\" />");
                          var relatieCuEa = $("<input title=\"Max 150 caractere alfanumerice si _,incepep cu litere!\" maxlength=\"150\" name=\"relatieCuEa[]\" type=\"text\" pattern=\"[a-zA-ZăâîșțĂÂÎȘȚ]+[a-zA-ZăâîșțĂÂÎȘȚ0-9_]*\" required class=\"fieldname\" placeholder=\"Relatie\" />");
                          
                          var removeButton = $("<input class=\"removeButton\" type=\"button\" class=\"remove\" value=\"Remove\" />");
                          removeButton.click(function() 
                          {
                             $(this).parent().remove();
                          });

                       fieldWrapper.append(numeConceptSauMaterie);
                       fieldWrapper.append(relatieCuEa);
                       fieldWrapper.append(removeButton);
                       $("#buildyourform").append(fieldWrapper);
                     });

                   

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                   
                      $("#addTAG").click(function() 
                      {
    		                  var lastField = $("#buildyourformTAG div:last");
                          var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
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

                          var sel = $('<select name="unTag[]">');
                          sel.html(optionsCSV);

                          var removeButton = $("<input class=\"removeButton\" type=\"button\" class=\"remove\" value=\"Remove\" />");
                          removeButton.click(function() 
                          {
                             $(this).parent().remove();
                          });

                       fieldWrapper.append(sel);
                       fieldWrapper.append(removeButton);
                       $("#buildyourformTAG").append(fieldWrapper);
                     });

                    });      
             
                </script>    

            <!---------------------------------------------------------------------------------------------------->
                <!--<textarea title="Max 1500 caractere alfanumerice si punctuatie!" maxlength="1500" name="DescriereaConceptului" class="descriereConceptAdaugat" pattern="[a-zA-Z0-9 ăâîșțĂÂÎȘȚ.,?!~;:'-+)(]+" placeholder="Descriere, linkuri, resurse "></textarea>-->
                <textarea  rows=9 placeholder="Descriere, linkuri, resurse " id="bbcode" maxlength="1500" name="DescriereaConceptului" class="descriereConceptAdaugat" >
                
                </textarea>

                <script>
                
                tinymce.init({
                selector: 'textarea#bbcode',
                width:'100%',
                resize: false,
                plugins: 'bbcode code link autolink',
                menubar: 'file edit view insert table tc help',
                toolbar: 'undo redo | bold italic underline strikethrough | formatselect removeformat superscript subscript fontselect | alignleft aligncenter  alignright alignjustify | backcolor',
                branding:false,
                content_style: 'body { font-family:Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;}',
                skin_url: 'http://localhost:80/licenta/app/tinyMCETheme',
                content_css: 'http://localhost:80/licenta/app/css/adaugaConcept.css'
                

                
               });
               </script>

                <button name="ButonAdaugareConcept" class="submitButton" type="submit">Submit</button>

          <?php
           if(isset($data['message']))
            if($data['message']=="Concept adaugat!") 
              //echo '<p class="textEroare">' . $data['message'] .'</p>';
             {
               echo '<script>';
               echo "Swal.fire({
                       toast: true,
                       icon: 'success',  //success va fi checkmark
                       title: '";
               echo $data['message'];
               echo "',
                       animation: true,
                       showConfirmButton: false,
                       timer: 1000,
                       timerProgressBar: true,
                       didOpen: (toast) => 
                       {
                         //toast.addEventListener('mouseenter', Swal.stopTimer)
                        //toast.addEventListener('mouseleave', Swal.resumeTimer)
                       }
                   })";
               echo '</script>';
             }
             else
             {
              echo '<script>';
              echo "Swal.fire({
                      toast: true,
                      icon: 'error',  //success va fi checkmark
                      title: '";
              echo $data['message'];
              echo "',
                      animation: true,
                      showConfirmButton: false,
                      timer: 1000,
                      timerProgressBar: true,
                      didOpen: (toast) => 
                      {
                        //toast.addEventListener('mouseenter', Swal.stopTimer)
                       //toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                  })";
              echo '</script>';
             }
           ?>
           
         

        </div>
    
</form>

<?php else : ?>
    <div class="bottomDivAccessDenied">
       <script>
          var htmlTAG=document.getElementById("html");
          htmlTAG.classList.add("htmlBODYAccessDenied");
          htmlTAG.classList.remove("htmlBODY");

          var bodyTAG=document.getElementById("body");
          bodyTAG.classList.add("htmlBODYAccessDenied");
          bodyTAG.classList.remove("htmlBODY");
          </script>

          
          
 
        <h3 class="accessDeniedText">Nu sunteti profesor!</h3>
    </div>
<?php endif; ?>


</body>
</html>