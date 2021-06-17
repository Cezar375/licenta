<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/materii.css">
    <link rel="stylesheet" href="http://localhost:80/licenta/app/css/concepteleUneiMaterii.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4h6rh37oevzsxp4lpr6cel1rlx5z7fxoo6krskkna7oxg93n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script type = "text/javascript" src = "http://localhost:80/licenta/app/js/neovis.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js" charset="utf-8"></script>
    

    <title>Graf</title>
</head>
<body onload="displayGraph()">
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

    <div class="bottomDivGRAF">

    <input id="protocolinput" type="hidden" value="http">
    <input type="hidden" id="hostinput" type="text" value="localhost">
    <input type="hidden" id="portinput" type="number" value="7474" min="0" max="65535">
    <input type="hidden" id="userinput" type="text" value="neo4j">
    <input type="hidden" id="passinput" value="parola" type="password">


    <div class="containerGRAF">
        <h1 class="numeleMateriei">Graful actual</h1>
    <div id="vis">
    </div>  
</div>
    
    <script>
       
    var AUTHORIZATION = "Basic " + btoa("neo4j:password");

/**
 * Uses JQuery to post an ajax request on Neo4j REST API
 */
function restPost(data) {
    var strData = JSON.stringify(data);
    return $.ajax({
        type: "POST",
        beforeSend: function (request) {
            if (AUTHORIZATION != undefined) {
                request.setRequestHeader("Authorization", AUTHORIZATION);
            }
        },
        url: $("#protocolinput").val() + "://" + $("#hostinput").val() + ":" + $("#portinput").val() + "/db/data/transaction/commit",
        contentType: "application/json",
        data: strData
    });
}

/**
 * Function to call to display a new graph.
 */
function displayGraph() {
    // Create the authorization header for the ajax request.
    AUTHORIZATION = "Basic " + btoa($("#userinput").val() + ":" + $("#passinput").val());

    // Post Cypher query to return node and relations and return results as graph.
    restPost({
        "statements": [
            {
                "statement": "match (n),()-[r]-() return n,r  ",
                "resultDataContents": ["graph"]
            }
        ]
    }).done(function (data) {

        // Parse results and convert it to vis.js compatible data.
        var graphData = parseGraphResultData(data);
        var nodes = convertNodes(graphData.nodes);
        var edges = convertEdges(graphData.edges);
        var visData = {
            nodes: nodes,
            edges: edges
        };

        displayVisJsData(visData);
    });
}

function displayVisJsData(data) {
    var container = document.getElementById('vis');

    var options = {
        nodes: {
            shape: 'box'
        },
        edges: {
            arrows: 'to'
            
        }
    };

    // initialize the network!
    var network = new vis.Network(container, data, options);

    network.on("stabilizationProgress", function (params) {
        var maxWidth = 496;
        var minWidth = 20;
        var widthFactor = params.iterations / params.total;
        var width = Math.max(minWidth, maxWidth * widthFactor);

    });

    
       

    
}

function parseGraphResultData(data) {
    var nodes = {}, edges = {};
    

    data.results[0].data.forEach(function (row) {
        row.graph.nodes.forEach(function (n) {
            if (!nodes.hasOwnProperty(n.id)) {
                nodes[n.id] = n;
            }


        });

        

        row.graph.relationships.forEach(function (r) {
            if (!edges.hasOwnProperty(r.id)) {
                edges[r.id] = r;
            }
        });
    });

    var nodesArray = [], edgesArray = [];

    for (var p in nodes) {
        if (nodes.hasOwnProperty(p)) {
            nodesArray.push(nodes[p]);
        }
    }

    for (var q in edges) {
        if (edges.hasOwnProperty(q)) {
            edgesArray.push(edges[q])
        }
    }



    return {nodes: nodesArray, edges: edgesArray};
}



        




function convertNodes(nodes) {
    var convertedNodes = [];

    nodes.forEach(function (node) {
        var nodeLabel = node.labels[0];
        var displayedLabel =(node.properties[Object.keys(node.properties)[1]]);  //era nodeLabel + in fata si aaprea si label-ul 
        convertedNodes.push({
            id: node.id,
            label: displayedLabel,
            group: nodeLabel
        })
    });

    return convertedNodes;
}

function convertEdges(edges) {
    var convertedEdges = [];

    edges.forEach(function (edge) {
        convertedEdges.push({
            from: edge.startNode,
            to: edge.endNode,
            label: edge.type
        })
    });

    return convertedEdges;
}


    </script>
    

    </div>

    

</body>
</html>