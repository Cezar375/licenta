<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/indexCSS.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/buttons.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <title>Home</title>
</head>
<body>

    <div class="upperDiv">
          <h1 class="homeHeaderH1">Knowledge Base</h1>
    </div>

    <div class="midDiv">

       <div class="buttonsDiv">
           <button class="homeButtonActive"> 
           Home
           </button>

           <button onclick= "location.href = 'Signup'" name="SignupButton" class="homeButtonToOtherPages">
           Signup
           </button> 
        
           <button onclick= "location.href = 'Materii'" class="homeButtonToOtherPages">
           Materii
           </button>
        </div>   

       <form action="http://localhost/licenta/public/" method="post" class="loginDiv">
          <input required title="Max 100 caractere alfanumerice!" maxlength="100" pattern="[a-zA-Z\dăâîșțăâîșțĂÂÎȘȚ]+" class="homeInput" name="Nume" placeholder=Nume* type="text">
            
          </input>

          <input required title="Max 50 caractere alfanumerice!" maxlength="50" pattern="[a-zA-Z\dăâîșțăâîșțĂÂÎȘȚ]+" class="homeInput" name="Parola" placeholder=Parola* type="password">

          </input>


          <button type="submit" type="button" name="LoginButton" id="login" class="homeLoginButton">
            Login
          </button>

       </form>
       <?php
           if(isset($data['message']))
           if($data['message']==="Parola sau username gresit!"  || $data['message']==="Format invalid al datelor!") 
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
           else if ($data['message']==="Cont creat cu succes!")
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
          ?>

    </div>

    <div class="bottomDiv">
      <p class="homeDescription">O aplicatie menita sa ajute studentii sa invete mai eficient pentru examenul de  licenta.
      </p>

    </div>

</body>
</html>