<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/statistici.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/filtrareDupaTAG.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@next"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    <title>Statistici</title>
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
        <div class="statisticiHeaderContainer">
           <h1 class="numeleMateriei">Statistici</h1>
        </div>
        <canvas class="canvasStats" id="TAGURIbar-chart" ></canvas>

        <canvas class="canvasStats" id="TAGURIperCONCEPTbar-chart" ></canvas>

        <canvas class="canvasStats" id="COMENTARIIperCONCEPTbar-chart" ></canvas>

        <canvas class="canvasStats" id="COMENTARIIbar-chart" ></canvas>
      
        <canvas class="canvasStats" id="nrRELATIICONCEPTEbar-chart" ></canvas>
      
       <script>
        
       /////////////// nr taguri in total //////////////////////////////////////////////////////////////////// 
       var URL='http://localhost/licenta/public/api/concepte/numarareTaguri';
       var taguri = new Array();
       var aparitiiTaguri=new Array();

       fetch(URL).
        then(response=>response.json()).then(data=>
        {
             if(data['message']!='Eroare!')
             {
              for (var dat of data['message'])
              {
                taguri.push(dat['tag']);
                aparitiiTaguri.push(dat['aparitii']);
              }

             new Chart(document.getElementById("TAGURIbar-chart"), 
            {
              type: 'bar',
              data: 
              {
               labels: taguri,
               datasets: 
               [
              {
                label: "Frecventa taguri",
                backgroundColor: ["#665191","#a05195", "#d45087","#ff7c43","#ffa600",  "#f95d6a", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: aparitiiTaguri
              }
               ]
              },
              options: 
              {
                pan: {
                    enabled: true
                    
                },
                zoom: {
                    enabled: true
                    
                },
               
               maintainAspectRatio : false
               

              }

              
              
             
           });

             }
        })
        ////////////////////////////////// nr taguri pe concept ////////////////////////////////////////////////////
       var URL='http://localhost/licenta/public/api/concepte/numarareTaguriPerConcept';
       var numeConcepte = new Array();
       var nrTaguri=new Array();

       fetch(URL).
        then(response=>response.json()).then(data=>
        {
             if(data['message']!='Eroare!')
             {
              for (var dat of data['message'])
              {
                numeConcepte.push(dat['nume_concept']);
                nrTaguri.push(dat['nr_taguri']);
              }

             new Chart(document.getElementById("TAGURIperCONCEPTbar-chart"), 
            {
              type: 'bar',
              data: 
              {
               labels: numeConcepte,
               datasets: 
               [
              {
                label: "Nr. de taguri per concept",
                backgroundColor: ["#a05195","#665191", "#d45087","#ff7c43","#ffa600",  "#f95d6a", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: nrTaguri
              }
               ]
              },
              options: 
              {
                pan: {
                    enabled: true
                    
                },
                zoom: {
                    enabled: true
                    
                },
               
               maintainAspectRatio : false
               

              }

              
              
             
           });

             }
        })
        /////////////////////////////////// nr comentarii per concept ///////////////////////////////////////////////
        var URL='http://localhost/licenta/public/api/concepte/numarareComentariiPerConcept';
        var concepte = new Array();
        var nrComentarii=new Array();

        fetch(URL).
        then(response=>response.json()).then(data=>
        {
             if(data['message']!='Eroare!')
             {
              for (var dat of data['message'])
              {
                concepte.push(dat['nume_concept']);
                nrComentarii.push(dat['nr_comentarii']);
              }

              new Chart(document.getElementById("COMENTARIIperCONCEPTbar-chart"), 
             {
              type: 'bar',
              data: 
              {
               labels: concepte,
               datasets: 
               [
              {
                label: "Nr. de comentarii per concept",
                backgroundColor: [ "#d45087","#ff7c43","#665191","#a05195", "#ffa600",  "#f95d6a", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: nrComentarii
              }
               ]
              },
              options: 
              {pan: {
                    enabled: true,
                    mode: 'x',
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                },
               
               maintainAspectRatio : false
               
              }
         
           });

             }
        })

        ///////////////////////////  nr comentarii pe user  /////////////////////////////////////////////////////////
        var URL='http://localhost/licenta/public/api/concepte/numarareComentarii';
        var useri = new Array();
        var aparitiiUseri=new Array();

        fetch(URL).
        then(response=>response.json()).then(data=>
        {
             if(data['message']!='Eroare!')
             {
              for (var dat of data['message'])
              {
                useri.push(dat['nume_user']);
                aparitiiUseri.push(dat['aparitii']);
              }

              new Chart(document.getElementById("COMENTARIIbar-chart"), 
             {
              type: 'bar',
              data: 
              {
               labels: useri,
               datasets: 
               [
              {
                label: "Nr. de comentarii per utilizator",
                backgroundColor: ["#ff7c43","#665191","#a05195", "#d45087", "#ffa600",  "#f95d6a", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: aparitiiUseri
              }
               ]
              },
              options: 
              {pan: {
                    enabled: true,
                    mode: 'x',
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                },
               
               maintainAspectRatio : false
               
              }
         
           });

             }
        })

        ///////////////////////// nr relatii pe concept////////////////////////////////////////////////////////////
        var URL='http://localhost/licenta/public/api/concepte/numarareRelatii';
        var concepte2 = [];
        var nrRelatiiConcepte=new Array();
        console.log(concepte2);

        fetch(URL).
        then(response=>response.json()).then(data=>
        {
             if(data['message']!='Eroare!')
             {
              for (var dat of data['message'])
              {
                concepte2.push(dat[0]);
                nrRelatiiConcepte.push(dat[1]);
              }
              new Chart(document.getElementById("nrRELATIICONCEPTEbar-chart"), 
             {
              type: 'bar',
              data: 
              {
               labels: concepte2,
               datasets: 
               [
              {
                label: "Nr. de relatii per concept",
                backgroundColor: ["#ffa600", "#665191","#a05195", "#d45087","#ff7c43", "#f95d6a", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: nrRelatiiConcepte
              }
               ]
              },
              options: 
              {
                pan: {
                    enabled: true,
                    mode: 'x',
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                },
               maintainAspectRatio : false
               
              }
     
           });

             }
        })

        console.log(concepte2);

        /////////////////////////////////////////////////////////////////////////////////////////////////////////



       </script>


      </div>
    </div>

</body>
</html>