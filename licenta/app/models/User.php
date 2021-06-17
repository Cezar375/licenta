<?php

class User
{

    public $username;
    public $email;
    public $password;
    public $privilegii;


    public function validareInfoLogin()
    {
      if(strlen($this->username)>100)
         return false; 

      if(strlen($this->password)>50)
         return false;
                
      if(!preg_match("/^[a-zA-Z\dăâîșțĂÂÎȘȚ]+$/",$this->username))  //daca numele nu e format doar din caractere alfanumerice(litere si cifre)
         return false;
  
      if(!preg_match("/^[a-zA-Z\dăâîșțĂÂÎȘȚ]+$/",$this->password))
         return false;     

      return true;
    }

    public function loginCorect()
    {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT * from utilizatori where nume=?");  //facem prepare la query
        $query->bind_param("s",$this->username);  //bind-uim parametrii
        $query->execute(); //executam query-ul

        $result=$query->get_result();
        $row =$result->fetch_assoc();  //va lua primul row daca returneaza mai multe row-uri
        
        if ($result->num_rows===1)  //va fi doar un singur nume asa in baza de date oricum
       {
        
          if(password_verify($this->password, $row['parola']))  //verificam parola
          {
            $_SESSION['privileges']=$row['privilegii'];  //salvam in session-uri user id-ul si privilegiile userului (student/profesor)
            $_SESSION['userID']=$row['id'];
            $_SESSION['logat']=1;
            $_SESSION['numeUtilizator']=$this->username;
            $con->close();
            return true;
        }  
       }

       $con->close();
       return false;
    }

    public function validareDateSignup()
    {
       if(strlen($this->username)>100)
          return false; 

       if(strlen($this->password)>50)
          return false; 

       if(strlen($this->email)>70)  
          return false; 

       if($this->email!='')   
       if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))  //validam emailul
          return false;   

       if(!preg_match("/^[a-zA-Z\dăâîșțĂÂÎȘȚ]+$/",$this->username))  //daca numele nu e format doar din caractere alfanumerice(litere si cifre)
          return false;
     
       if(!preg_match("/^[a-zA-Z\dăâîșțĂÂÎȘȚ]+$/",$this->password))
          return false;    
          
       return true;   
       

    }

   public function numeDisponibil()
   {
    $con=mysqli_connect("Localhost", "root" ,"", "licenta");
     
    $query = $con->prepare("SELECT * from utilizatori where nume=?");  //facem prepare la statement
    $query->bind_param("s",$this->username);  //facem bind
    
    $query->execute(); //executam query-ul

    $result=$query->get_result();
    $row =$result->fetch_assoc();  

    if ($result->num_rows===0) //numele NU este deja folosit
    {
        return true;
        $con->close();
        
    }
        return false;
        $con->close();
   } 

   public function stocheazaNoulContDB()
  {
    $con=mysqli_connect("Localhost", "root" ,"", "licenta");

    $hashParola=password_hash($this->password, PASSWORD_DEFAULT);
    $this->password=$hashParola;

    $query = $con->prepare("INSERT INTO utilizatori(nume,parola,email,privilegii) values(?,?,?,?)");  //nu dam valoare la id ca e auto_increment, pk
    $query->bind_param("ssss",$this->username,$this->password,$this->email,$this->privilegii);  //s de la String bind-uim toti parametrii


    $query->execute(); //executam query-ul

    $con->close();
    
  }



}


?>