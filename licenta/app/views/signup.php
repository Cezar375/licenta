<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/signupPage.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <title>Signup</title>
</head>
<body>
    <div class="upperDiv">
    <h1 class="homeHeaderH1">Knowledge Base</h1>
    </div>

    <div class="midDiv">
    <button onclick= "location.href = 'http://localhost/licenta/public/'" class="homeButtonToOtherPages"> 
           Home
           </button>

           <button onclick= "location.href = 'http://localhost/licenta/public/Signup'" name="SignupButton" class="homeButtonActive">
           Signup
           </button> 
        
           <button onclick= "location.href = 'http://localhost/licenta/public/Materii'" class="homeButtonToOtherPages">
           Materii
           </button>
    </div>

    <form action="http://localhost/licenta/public/" method="post" class="bottomDiv">
        <div class="parteaSignupDiv">

          
           <h2 class="JoinNowHeader">Join now !</h2>

           <div class="inputBoxesDiv">
              <input title="Max 100 caractere alfanumerice!" maxlength="50" pattern="[a-zA-Z\dăâîșțĂÂÎȘȚ]+" class="inputBox" name="Nume" required placeholder="Nume*" type="text">
              </input>
        
              <input title="Max 50 caractere alfanumerice!" maxlength="50" pattern="[a-zA-Z\dăâîșțĂÂÎȘȚ]+" class="inputBox" name="Parola" required placeholder="Parola*" type="password">
              </input>

              <input maxlength="320" class="inputBox" name="Email" placeholder="Email" type="email">
              </input>
           </div>

           <div class="radioButtonsDiv">

             <div>
             <input  type="radio" id="stud" name="StudentSAUProfesor" value="student" checked >
             <label for="stud" class="labelRadio">Student</label>
             </div>

             <div>
             <input  type="radio" id="prof" name="StudentSAUProfesor" value="profesor">
             <label for="prof" class="labelRadio">Profesor</label>
             </div>
          </div>

          
          <?php
           if(isset($data['message'])) 
           {
             //echo '<p class="textEroare">' . $data['message'] .'</p>';
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
           
          <button type="submit" name="SignupSubmitButton" class="signupButton">Submit
          </button>

        </div>
    
</form>


</body>
</html>