<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/indexCSS.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/buttons.css">
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
        
           <button onclick= "location.href = 'http://localhost/licenta/public/Materii'" class="homeButtonToOtherPages">
           Materii
           </button>
        </div>   

       <form action="http://localhost/licenta/public/" method="post" class="logoutDiv">
          <h2 class="welcomeBackText">Welcome back!</h2>

          <button type="submit" type="button" name="LogoutButton" id="logout" class="logoutButton">
            Logout
          </button>

       </form>

    </div>

    <div class="bottomDiv">
      <p class="homeDescription">O aplicatie menita sa ajute studentii sa invete mai eficient pentru examenul de  licenta.
      </p>

    </div>

</body>
</html>