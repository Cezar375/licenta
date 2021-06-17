<?php
class Home extends Controller
{

    public function index()  //if-uri si else if-uri pt a decide ce view arat pt ca altfel o sa puna unul dupa altul view-urile si sa dai scroll in jos
    {
        $anUser=$this->model('User');

        if(isset($_POST['LoginButton']))
        {
           $anUser->password=$_POST['Parola'];
           $anUser->username=$_POST['Nume'];
           
           if($anUser->validareInfoLogin()) //validarea datelor sv side, sa nu fie introduse scripturi samd
            {
               if($anUser->loginCorect())  //daca numele si parola sunt corecte
               {
                   //echo '<script>alert("Corect!")</script>'; 
                   $_SESSION['logat']=1;
                   $this->view('indexLogat');
               }
               else  //parola sau username gresite
               {
                //echo '<script>alert("Parola sau username gresite!")</script>'; 
                $this->view('index',['message'=>"Parola sau username gresit!"]);
               }
            }
           else  //datele introduse nu respecta formatul
           {
            //echo '<script>alert("format incorect!")</script>';    
            $this->view('index',['message'=>"Format invalid al datelor!"]);
           }   
        }
        else if (isset($_POST['SignupSubmitButton']))
        { 

           //echo '<script>alert("Parola sau username gresite!")</script>'; 
           $anUser->username=$_POST['Nume'];
           $anUser->password=$_POST['Parola'];
           $anUser->email=$_POST['Email'];
           $anUser->privilegii=$_POST['StudentSAUProfesor'];

           //echo var_dump($anUser);

           if ($anUser->validareDateSignup())
           {
            if($anUser->numeDisponibil())
            {
                $anUser->stocheazaNoulContDB();

                $_SESSION['logat']=-1;
                $_SESSION['userID']=-1;
                $_SESSION['privileges']="student";
                $this->view('index',['message'=>"Cont creat cu succes!"]); //daca eram logat si fac alt cont voi da logout
                /////////////////////////////////////////////////////////////
                /*$to = "exemplu@gmail.com";
                $subject = "This is subject";
         
                $message = "<b>This is HTML message.</b>";
                $message .= "<h1>This is headline.</h1>";
         
                $header = "From:abc@somedomain.com \r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html\r\n";
         
                $retval = mail ($to,$subject,$message,$header);
         
                if( $retval == true ) {
                   echo "Message sent successfully...";
                }else {
                echo "Message could not be sent...";
                      }*/
                ///////////////////////////////////////////////////////////////      

            }
            else
            {
                $this->view('signup',['message'=>"Alegeti alt nume!"]);
            }
           }
           else
           {
               $this->view('signup',['message'=>"Format invalid al datelor!"]);
           }

        }
        else if (isset($_POST['SignupButton']))
        {
            $this->view('signup');
        }
        else if (isset($_POST['LogoutButton']))
        {
            $_SESSION['logat']=-1;
            $_SESSION['userID']=-1;
            $_SESSION['privileges']="student";
            $_SESSION['numeUtilizator']=-1;
            $this->view('index');
        }
        else if ($_SESSION['logat']==1)
        {
            $this->view('indexLogat');
        }
        else if ($_SESSION['logat']!=1)
        {
            $this->view('index');
        }

    }
    
} 

?>