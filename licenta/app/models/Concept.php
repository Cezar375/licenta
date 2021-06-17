<?php

require_once 'C:\xampp\htdocs\licenta\vendor\autoload.php';   #conexiune Neo4J
require_once 'C:\xampp\htdocs\licenta\htmlpurifier-4.13.0-lite\library\HTMLPurifier.auto.php';
use GraphAware\Neo4j\Client\ClientBuilder;


class Concept
{

    public $denumire;
    public $concepteCuCareAreRelatii=array();
    public $relatii=array();
    public $taguri=array();
    public $descriere;


    public function validareInfoAdaugareConcept()
    {
        if(strlen($this->denumire)>100)
             return false;

        if(!preg_match("/^[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+$/",$this->denumire))
             return false;     
             

        if(isset($this->descriere) && $this->descriere!='')     
          {
            if(strlen($this->descriere)>1500)
               return false;
             
            //if(!preg_match("/^[a-zA-Z0-9 ăâîșțĂÂÎȘȚ.,?!~;:'-+)(]+$/",$this->descriere))
               //return false;
          }          

        if(isset($this->concepteCuCareAuRelatii))
        {
            foreach($this->concepteCuCareAreRelatii as $concept)
            {
               if (strlen($concept)>150)
               {
                   return false;
               }

               if(!preg_match("/^[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+$/",$concept))
                   return false; 

            } 
        
           foreach($this->relatii as $relatie)
           {  
               if (strlen($relatie)>150)
               {
                   return false;
               }

               if(!preg_match("/^[a-zA-ZăâîșțĂÂÎȘȚ]+[a-zA-ZăâîșțĂÂÎȘȚ0-9_]*$/",$relatie))
                   return false; 
           }

        }   

        return true;
    }
    
    
    public function NUexistaConceptulDeja()
    {
       $client = ClientBuilder::create()
       ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
       ->build();
 
       $rezultat=$client->run('MATCH (n:Concept {nume:"' . $this->denumire  . '"}) RETURN n');

       try
       {
         $record=$rezultat->getRecord();
         //echo 'Exista, deci nu mai poate fi adaugat';
       }
       catch(Exception $e)
       {
           //echo 'Nu exista, deci poate fi adaugat';
           //$client->run('CREATE (' . $this->denumire . ':Concept{nume:"' . $this->denumire  . '",descriere:"'  .   $this->descriere    .'"})');
           return true;
       }

        return false;
    }

    public function adaugaConceptBD()
    {
       //neo4j e userul
       //parola e parola
       //numele DB-ului e licentaDB

       $client = ClientBuilder::create()
       ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
       ->build();
 
       $search = array(
        '@<script[^>]*?>.*?</script>@si'   // scoatem JS-ul potential malitios daca a fost dat
      );
     
        $output = preg_replace($search, '', $this->descriere);
        $this->descriere=$output;

       $client->run('CREATE (n:Concept{nume:"' . $this->denumire  . '",descriere:"'  .   addslashes($this->descriere)    .'"})');  //n va fi numele nodului
                                                                                                                                  //e neimportant pt ca am deja numele salvat in proprietatea nume 
                                                                                                                       
                                                                                                                       
       //acum ca am creat nodul corespunzator noului concept, vom adauga relatiile(arcele) sale(daca are, daca au fost specificate la creare)
       
       for($i = 0; $i < count($this->concepteCuCareAreRelatii); $i++) //lungimea celor 2 vectori va fi egala 
       {
          //daca se da relatie cu un concept ne existent pur si simplu nu se va face vreun match, deci nu se va adauga nimic in cazul respectiv 
          $query= "MATCH (a:Concept), (b:Concept)  
                   WHERE a.nume = '" . $this->denumire . "' AND b.nume = '"  . $this->concepteCuCareAreRelatii[$i] .  "'
                   MERGE (a)-[r:" . $this->relatii[$i]    . "]->(b)
                   RETURN type(r)";


          $client->run($query);  //executam query-ul         
       }

       $arrayToateTagurile=array(
         'General and reference' ,     'Document types' ,     'Surveys and overviews' ,     'Reference works' ,     'General conference proceedings' ,     'Biographies' ,     'General literature' ,     'Computing standards, RFCs and guidelines' ,     'Cross-computing tools and techniques' ,     'Reliability' ,     'Empirical studies' ,     'Measurement' ,     'Metrics' ,     'Evaluation' ,     'Experimentation' ,     'Estimation' ,     'Design' ,     'Performance' ,     'Validation' ,     'Verification' ,     'Hardware' ,     'Printed circuit boards' ,     'Electromagnetic interference and compatibility' ,     'PCB design and layout' ,     'Communication hardware, interfaces and storage' ,     'Signal processing systems' ,     'Digital signal processing' ,     'Beamforming' ,     'Noise reduction' ,     'Sensors and actuators' ,     'Buses and high-speed links' ,     'Displays and imagers' ,     'External storage' ,     'Networking hardware' ,     'Printers' ,     'Sensor applications and deployments' ,     'Sensor devices and platforms' ,     'Sound-based input / output' ,     'Tactile and hand-based interfaces' ,     'Touch screens' ,     'Haptic devices' ,     'Scanners' ,     'Wireless devices' ,     'Wireless integrated network sensors' ,     'Electro-mechanical devices' ,     'Integrated circuits' ,     '3D integrated circuits' ,     'Interconnect' ,     'Input / output circuits' ,     'Metallic interconnect' ,     'Photonic and optical interconnect' ,     'Radio frequency and wireless interconnect' ,     'Semiconductor memory' ,     'Dynamic memory' ,     'Static memory' ,     'Non-volatile memory' ,     'Read-only memory' ,     'Digital switches' ,     'Transistors' ,     'Logic families' ,     'Logic circuits' ,     'Arithmetic and datapath circuits' ,     'Asynchronous circuits' ,     'Combinational circuits' ,     'Design modules and hierarchy' ,     'Finite state machines' ,     'Sequential circuits' ,     'Reconfigurable logic and FPGAs' ,     'Hardware accelerators' ,     'High-speed input / output' ,     'Programmable logic elements' ,     'Programmable interconnect' ,     'Reconfigurable logic applications' ,     'Evolvable hardware' ,     'Very large scale integration design' ,     '3D integrated circuits' ,     'Analog and mixed-signal circuits' ,     'Data conversion' ,     'Clock generation and timing' ,     'Analog and mixed-signal circuit optimization' ,     'Radio frequency and wireless circuits' ,     'Wireline communication' ,     'Analog and mixed-signal circuit synthesis' ,     'Application-specific VLSI designs' ,     'Application specific integrated circuits' ,     'Application specific instruction set processors' ,     'Application specific processors' ,     'Design reuse and communication-based design' ,     'Network on chip' ,     'System on a chip' ,     'Platform-based design' ,     'Hard and soft IP' ,     'Design rules' ,     'Economics of chip design and manufacturing' ,     'Full-custom circuits' ,     'VLSI design manufacturing considerations' ,     'On-chip resource management' ,     'On-chip sensors' ,     'Standard cell libraries' ,     'VLSI packaging' ,     'Die and wafer stacking' ,     'Input / output styles' ,     'Multi-chip modules' ,     'Package-level interconnect' ,     'VLSI system specification and constraints' ,     'Power and energy' ,     'Thermal issues' ,     'Temperature monitoring' ,     'Temperature simulation and estimation' ,     'Temperature control' ,     'Temperature optimization' ,     'Energy generation and storage' ,     'Batteries' ,     'Fuel-based energy' ,     'Renewable energy' ,     'Reusable energy storage' ,     'Energy distribution' ,     'Energy metering' ,     'Power conversion' ,     'Power networks' ,     'Smart grid' ,     'Impact on the environment' ,     'Power estimation and optimization' ,     'Switching devices power issues' ,     'Interconnect power issues' ,     'Circuits power issues' ,     'Chip-level power issues' ,     'Platform power issues' ,     'Enterprise level and data centers power issues' ,     'Electronic design automation' ,     'High-level and register-transfer level synthesis' ,     'Datapath optimization' ,     'Hardware-software codesign' ,     'Resource binding and sharing' ,     'Operations scheduling' ,     'Hardware description languages and compilation' ,     'Logic synthesis' ,     'Combinational synthesis' ,     'Circuit optimization' ,     'Sequential synthesis' ,     'Technology-mapping' ,     'Transistor-level synthesis' ,     'Modeling and parameter extraction' ,     'Physical design (EDA)' ,     'Clock-network synthesis' ,     'Packaging' ,     'Partitioning and floorplanning' ,     'Placement' ,     'Physical synthesis' ,     'Power grid design' ,     'Wire routing' ,     'Timing analysis' ,     'Electrical-level simulation' ,     'Model-order reduction' ,     'Compact delay models' ,     'Static timing analysis' ,     'Statistical timing analysis' ,     'Transition-based timing analysis' ,     'Methodologies for EDA' ,     'Best practices for EDA' ,     'Design databases for EDA' ,     'Software tools for EDA' ,     'Hardware validation' ,     'Functional verification' ,     'Model checking' ,     'Coverage metrics' ,     'Equivalence checking' ,     'Semi-formal verification' ,     'Simulation and emulation' ,     'Transaction-level verification' ,     'Theorem proving and SAT solving' ,     'Assertion checking' ,     'Physical verification' ,     'Design rule checking' ,     'Layout-versus-schematics' ,     'Power and thermal analysis' ,     'Timing analysis and sign-off' ,     'Post-manufacture validation and debug' ,     'Bug detection, localization and diagnosis' ,     'Bug fixing (hardware)' ,     'Design for debug' ,     'Hardware test' ,     'Analog, mixed-signal and radio frequency test' ,     'Board- and system-level test' ,     'Defect-based test' ,     'Design for testability' ,     'Built-in self-test' ,     'Online test and diagnostics' ,     'Test data compression' ,     'Fault models and test metrics' ,     'Memory test and repair' ,     'Hardware reliability screening' ,     'Test-pattern generation and fault simulation' ,     'Testing with distributed and parallel systems' ,     'Robustness' ,     'Fault tolerance' ,     'Error detection and error correction' ,     'Failure prediction' ,     'Failure recovery, maintenance and self-repair' ,     'Redundancy' ,     'Self-checking mechanisms' ,     'System-level fault tolerance' ,     'Design for manufacturability' ,     'Process variations' ,     'Yield and cost modeling' ,     'Yield and cost optimization' ,     'Hardware reliability' ,     'Aging of circuits and systems' ,     'Circuit hardening' ,     'Early-life failures and infant mortality' ,     'Process, voltage and temperature variations' ,     'Signal integrity and noise analysis' ,     'Transient errors and upsets' ,     'Safety critical systems' ,     'Emerging technologies' ,     'Analysis and design of emerging devices and systems' ,     'Emerging architectures' ,     'Emerging languages and compilers' ,     'Emerging simulation' ,     'Emerging tools and methodologies' ,     'Biology-related information processing' ,     'Bio-embedded electronics' ,     'Neural systems' ,     'Circuit substrates' ,     'III-V compounds' ,     'Carbon based electronics' ,     'Cellular neural networks' ,     'Flexible and printable circuits' ,     'Superconducting circuits' ,     'Electromechanical systems' ,     'Microelectromechanical systems' ,     'Nanoelectromechanical systems' ,     'Emerging interfaces' ,     'Memory and dense storage' ,     'Emerging optical and photonic technologies' ,     'Reversible logic' ,     'Plasmonics' ,     'Quantum technologies' ,     'Single electron devices' ,     'Tunneling devices' ,     'Quantum computation' ,     'Quantum communication and cryptography' ,     'Quantum error correction and fault tolerance' ,     'Quantum dots and cellular automata' ,     'Spintronics and magnetic technologies' ,     'Computer systems organization' ,     'Architectures' ,     'Serial architectures' ,     'Reduced instruction set computing' ,     'Complex instruction set computing' ,     'Superscalar architectures' ,     'Pipeline computing' ,     'Stack machines' ,     'Parallel architectures' ,     'Very long instruction word' ,     'Interconnection architectures' ,     'Multiple instruction, multiple data' ,     'Cellular architectures' ,     'Multiple instruction, single data' ,     'Single instruction, multiple data' ,     'Systolic arrays' ,     'Multicore architectures' ,     'Distributed architectures' ,     'Cloud computing' ,     'Client-server architectures' ,     'n-tier architectures' ,     'Peer-to-peer architectures' ,     'Grid computing' ,     'Other architectures' ,     'Neural networks' ,     'Reconfigurable computing' ,     'Analog computers' ,     'Data flow architectures' ,     'Heterogeneous (hybrid) systems' ,     'Self-organizing autonomic computing' ,     'Optical computing' ,     'Quantum computing' ,     'Molecular computing' ,     'High-level language architectures' ,     'Special purpose systems' ,     'Embedded and cyber-physical systems' ,     'Sensor networks' ,     'Robotics' ,     'Robotic components' ,     'Robotic control' ,     'Evolutionary robotics' ,     'Robotic autonomy' ,     'External interfaces for robotics' ,     'Sensors and actuators' ,     'System on a chip' ,     'Embedded systems' ,     'Firmware' ,     'Embedded hardware' ,     'Embedded software' ,     'Real-time systems' ,     'Real-time operating systems' ,     'Real-time languages' ,     'Real-time system specification' ,     'Real-time system architecture' ,     'Dependable and fault-tolerant systems and networks' ,     'Reliability' ,     'Availability' ,     'Maintainability and maintenance' ,     'Processors and memory architectures' ,     'Secondary storage organization' ,     'Redundancy' ,     'Fault-tolerant network topologies' ,     'Networks' ,     'Network architectures' ,     'Network design principles' ,     'Layering' ,     'Naming and addressing' ,     'Programming interfaces' ,     'Network protocols' ,     'Network protocol design' ,     'Protocol correctness' ,     'Protocol testing and verification' ,     'Formal specifications' ,     'Link-layer protocols' ,     'Network layer protocols' ,     'Routing protocols' ,     'Signaling protocols' ,     'Transport protocols' ,     'Session protocols' ,     'Presentation protocols' ,     'Application layer protocols' ,     'Peer-to-peer protocols' ,     'OAM protocols' ,     'Time synchronization protocols' ,     'Network policy' ,     'Cross-layer protocols' ,     'Network File System (NFS) protocol' ,     'Network components' ,     'Intermediate nodes' ,     'Routers' ,     'Bridges and switches' ,     'Physical links' ,     'Repeaters' ,     'Middle boxes / network appliances' ,     'End nodes' ,     'Network adapters' ,     'Network servers' ,     'Wireless access points, base stations and infrastructure' ,     'Cognitive radios' ,     'Logical nodes' ,     'Network domains' ,     'Network algorithms' ,     'Data path algorithms' ,     'Packet classification' ,     'Deep packet inspection' ,     'Packet scheduling' ,     'Control path algorithms' ,     'Network resources allocation' ,     'Network control algorithms' ,     'Traffic engineering algorithms' ,     'Network design and planning algorithms' ,     'Network economics' ,     'Network performance evaluation' ,     'Network performance modeling' ,     'Network simulations' ,     'Network experimentation' ,     'Network performance analysis' ,     'Network measurement' ,     'Network properties' ,     'Network security' ,     'Security protocols' ,     'Web protocol security' ,     'Mobile and wireless security' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Network range' ,     'Short-range networks' ,     'Local area networks' ,     'Metropolitan area networks' ,     'Wide area networks' ,     'Very long-range networks' ,     'Network structure' ,     'Topology analysis and generation' ,     'Physical topologies' ,     'Logical / virtual topologies' ,     'Network topology types' ,     'Point-to-point networks' ,     'Bus networks' ,     'Star networks' ,     'Ring networks' ,     'Token ring networks' ,     'Fiber distributed data interface (FDDI)' ,     'Mesh networks' ,     'Wireless mesh networks' ,     'Hybrid networks' ,     'Network dynamics' ,     'Network reliability' ,     'Error detection and error correction' ,     'Network mobility' ,     'Network manageability' ,     'Network privacy and anonymity' ,     'Network services' ,     'Naming and addressing' ,     'Cloud computing' ,     'Location based services' ,     'Programmable networks' ,     'In-network processing' ,     'Network management' ,     'Network monitoring' ,     'Network types' ,     'Network on chip' ,     'Home networks' ,     'Storage area networks' ,     'Data center networks' ,     'Wired access networks' ,     'Cyber-physical networks' ,     'Sensor networks' ,     'Mobile networks' ,     'Overlay and other logical network structures' ,     'Peer-to-peer networks' ,     'World Wide Web (network structure)' ,     'Social media networks' ,     'Online social networks' ,     'Wireless access networks' ,     'Wireless local area networks' ,     'Wireless personal area networks' ,     'Ad hoc networks' ,     'Mobile ad hoc networks' ,     'Public Internet' ,     'Packet-switching networks' ,     'Software and its engineering' ,     'Software organization and properties' ,     'Contextual software domains' ,     'E-commerce infrastructure' ,     'Software infrastructure' ,     'Interpreters' ,     'Middleware' ,     'Message oriented middleware' ,     'Reflective middleware' ,     'Embedded middleware' ,     'Virtual machines' ,     'Operating systems' ,     'File systems management' ,     'Memory management' ,     'Virtual memory' ,     'Main memory' ,     'Allocation / deallocation strategies' ,     'Garbage collection' ,     'Distributed memory' ,     'Secondary storage' ,     'Process management' ,     'Scheduling' ,     'Deadlocks' ,     'Multithreading' ,     'Multiprocessing / multiprogramming / multitasking' ,     'Monitors' ,     'Mutual exclusion' ,     'Concurrency control' ,     'Power management' ,     'Process synchronization' ,     'Communications management' ,     'Buffering' ,     'Input / output' ,     'Message passing' ,     'Virtual worlds software' ,     'Interactive games' ,     'Virtual worlds training simulations' ,     'Software system structures' ,     'Embedded software' ,     'Software architectures' ,     'n-tier architectures' ,     'Peer-to-peer architectures' ,     'Data flow architectures' ,     'Cooperating communicating processes' ,     'Layered systems' ,     'Publish-subscribe / event-based architectures' ,     'Electronic blackboards' ,     'Simulator / interpreter' ,     'Object oriented architectures' ,     'Tightly coupled architectures' ,     'Space-based architectures' ,     '3-tier architectures' ,     'Software system models' ,     'Petri nets' ,     'State systems' ,     'Entity relationship modeling' ,     'Model-driven software engineering' ,     'Feature interaction' ,     'Massively parallel systems' ,     'Ultra-large-scale systems' ,     'Distributed systems organizing principles' ,     'Cloud computing' ,     'Client-server architectures' ,     'Grid computing' ,     'Organizing principles for web applications' ,     'Real-time systems software' ,     'Abstraction, modeling and modularity' ,     'Software functional properties' ,     'Correctness' ,     'Synchronization' ,     'Functionality' ,     'Real-time schedulability' ,     'Consistency' ,     'Completeness' ,     'Access protection' ,     'Formal methods' ,     'Model checking' ,     'Software verification' ,     'Automated static analysis' ,     'Dynamic analysis' ,     'Extra-functional properties' ,     'Interoperability' ,     'Software performance' ,     'Software reliability' ,     'Software fault tolerance' ,     'Checkpoint / restart' ,     'Software safety' ,     'Software usability' ,     'Software notations and tools' ,     'General programming languages' ,     'Language types' ,     'Parallel programming languages' ,     'Distributed programming languages' ,     'Imperative languages' ,     'Object oriented languages' ,     'Functional languages' ,     'Concurrent programming languages' ,     'Constraint and logic languages' ,     'Data flow languages' ,     'Extensible languages' ,     'Assembly languages' ,     'Multiparadigm languages' ,     'Very high level languages' ,     'Language features' ,     'Abstract data types' ,     'Polymorphism' ,     'Inheritance' ,     'Control structures' ,     'Data types and structures' ,     'Classes and objects' ,     'Modules / packages' ,     'Constraints' ,     'Recursion' ,     'Concurrent programming structures' ,     'Procedures, functions and subroutines' ,     'Patterns' ,     'Coroutines' ,     'Frameworks' ,     'Formal language definitions' ,     'Syntax' ,     'Semantics' ,     'Compilers' ,     'Interpreters' ,     'Incremental compilers' ,     'Retargetable compilers' ,     'Just-in-time compilers' ,     'Dynamic compilers' ,     'Translator writing systems and compiler generators' ,     'Source code generation' ,     'Runtime environments' ,     'Preprocessors' ,     'Parsers' ,     'Context specific languages' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Scripting languages' ,     'Domain specific languages' ,     'Specialized application languages' ,     'API languages' ,     'Graphical user interface languages' ,     'Window managers' ,     'Command and control languages' ,     'Macro languages' ,     'Programming by example' ,     'State based definitions' ,     'Visual languages' ,     'Interface definition languages' ,     'System description languages' ,     'Design languages' ,     'Unified Modeling Language (UML)' ,     'Architecture description languages' ,     'System modeling languages' ,     'Orchestration languages' ,     'Integration frameworks' ,     'Specification languages' ,     'Development frameworks and environments' ,     'Object oriented frameworks' ,     'Software as a service orchestration system' ,     'Integrated and visual development environments' ,     'Application specific development environments' ,     'Software configuration management and version control systems' ,     'Software libraries and repositories' ,     'Software maintenance tools' ,     'Software creation and management' ,     'Designing software' ,     'Requirements analysis' ,     'Software design engineering' ,     'Software design tradeoffs' ,     'Software implementation planning' ,     'Software design techniques' ,     'Software development process management' ,     'Software development methods' ,     'Rapid application development' ,     'Agile software development' ,     'Capability Maturity Model' ,     'Waterfall model' ,     'Spiral model' ,     'V-model' ,     'Design patterns' ,     'Risk management' ,     'Software development techniques' ,     'Software prototyping' ,     'Object oriented development' ,     'Flowcharts' ,     'Reusability' ,     'Software product lines' ,     'Error handling and recovery' ,     'Automatic programming' ,     'Genetic programming' ,     'Software verification and validation' ,     'Software prototyping' ,     'Operational analysis' ,     'Software defect analysis' ,     'Software testing and debugging' ,     'Fault tree analysis' ,     'Process validation' ,     'Walkthroughs' ,     'Pair programming' ,     'Use cases' ,     'Acceptance testing' ,     'Traceability' ,     'Formal software verification' ,     'Empirical software validation' ,     'Software post-development issues' ,     'Software reverse engineering' ,     'Documentation' ,     'Backup procedures' ,     'Software evolution' ,     'Software version control' ,     'Maintaining software' ,     'System administration' ,     'Collaboration in software development' ,     'Open source model' ,     'Programming teams' ,     'Search-based software engineering' ,     'Theory of computation' ,     'Models of computation' ,     'Computability' ,     'Lambda calculus' ,     'Turing machines' ,     'Recursive functions' ,     'Probabilistic computation' ,     'Quantum computation theory' ,     'Quantum complexity theory' ,     'Quantum communication complexity' ,     'Quantum query complexity' ,     'Quantum information theory' ,     'Interactive computation' ,     'Streaming models' ,     'Concurrency' ,     'Parallel computing models' ,     'Distributed computing models' ,     'Process calculi' ,     'Timed and hybrid models' ,     'Abstract machines' ,     'Formal languages and automata theory' ,     'Formalisms' ,     'Algebraic language theory' ,     'Rewrite systems' ,     'Automata over infinite objects' ,     'Grammars and context-free languages' ,     'Tree languages' ,     'Automata extensions' ,     'Transducers' ,     'Quantitative automata' ,     'Regular languages' ,     'Computational complexity and cryptography' ,     'Complexity classes' ,     'Problems, reductions and completeness' ,     'Communication complexity' ,     'Circuit complexity' ,     'Oracles and decision trees' ,     'Algebraic complexity theory' ,     'Quantum complexity theory' ,     'Proof complexity' ,     'Interactive proof systems' ,     'Complexity theory and logic' ,     'Cryptographic primitives' ,     'Cryptographic protocols' ,     'Logic' ,     'Logic and verification' ,     'Proof theory' ,     'Modal and temporal logics' ,     'Automated reasoning' ,     'Constraint and logic programming' ,     'Constructive mathematics' ,     'Description logics' ,     'Equational logic and rewriting' ,     'Finite Model Theory' ,     'Higher order logic' ,     'Linear logic' ,     'Programming logic' ,     'Abstraction' ,     'Verification by model checking' ,     'Type theory' ,     'Hoare logic' ,     'Separation logic' ,     'Design and analysis of algorithms' ,     'Graph algorithms analysis' ,     'Network flows' ,     'Sparsification and spanners' ,     'Shortest paths' ,     'Dynamic graph algorithms' ,     'Approximation algorithms analysis' ,     'Scheduling algorithms' ,     'Packing and covering problems' ,     'Routing and network design problems' ,     'Facility location and clustering' ,     'Rounding techniques' ,     'Stochastic approximation' ,     'Numeric approximation algorithms' ,     'Mathematical optimization' ,     'Discrete optimization' ,     'Network optimization' ,     'Optimization with randomized search heuristics' ,     'Simulated annealing' ,     'Evolutionary algorithms' ,     'Tabu search' ,     'Randomized local search' ,     'Continuous optimization' ,     'Linear programming' ,     'Semidefinite programming' ,     'Convex optimization' ,     'Quasiconvex programming and unimodality' ,     'Stochastic control and optimization' ,     'Quadratic programming' ,     'Nonconvex optimization' ,     'Bio-inspired optimization' ,     'Mixed discrete-continuous optimization' ,     'Submodular optimization and polymatroids' ,     'Integer programming' ,     'Bio-inspired optimization' ,     'Non-parametric optimization' ,     'Genetic programming' ,     'Developmental representations' ,     'Data structures design and analysis' ,     'Data compression' ,     'Pattern matching' ,     'Sorting and searching' ,     'Predecessor queries' ,     'Cell probe models and lower bounds' ,     'Online algorithms' ,     'Online learning algorithms' ,     'Scheduling algorithms' ,     'Caching and paging algorithms' ,     'K-server algorithms' ,     'Adversary models' ,     'Parameterized complexity and exact algorithms' ,     'Fixed parameter tractability' ,     'W hierarchy' ,     'Streaming, sublinear and near linear time algorithms' ,     'Bloom filters and hashing' ,     'Sketching and sampling' ,     'Lower bounds and information complexity' ,     'Random order and robust communication complexity' ,     'Nearest neighbor algorithms' ,     'Parallel algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Shared memory algorithms' ,     'Vector / streaming algorithms' ,     'Massively parallel algorithms' ,     'Distributed algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Algorithm design techniques' ,     'Backtracking' ,     'Branch-and-bound' ,     'Divide and conquer' ,     'Dynamic programming' ,     'Preconditioning' ,     'Concurrent algorithms' ,     'Randomness, geometry and discrete structures' ,     'Pseudorandomness and derandomization' ,     'Computational geometry' ,     'Generating random combinatorial structures' ,     'Random walks and Markov chains' ,     'Expander graphs and randomness extractors' ,     'Error-correcting codes' ,     'Random projections and metric embeddings' ,     'Random network models' ,     'Random search heuristics' ,     'Theory and algorithms for application domains' ,     'Machine learning theory' ,     'Sample complexity and generalization bounds' ,     'Boolean function learning' ,     'Unsupervised learning and clustering' ,     'Kernel methods' ,     'Support vector machines' ,     'Gaussian processes' ,     'Boosting' ,     'Bayesian analysis' ,     'Inductive inference' ,     'Online learning theory' ,     'Multi-agent learning' ,     'Models of learning' ,     'Query learning' ,     'Structured prediction' ,     'Reinforcement learning' ,     'Sequential decision making' ,     'Inverse reinforcement learning' ,     'Apprenticeship learning' ,     'Multi-agent reinforcement learning' ,     'Adversarial learning' ,     'Active learning' ,     'Semi-supervised learning' ,     'Markov decision processes' ,     'Regret bounds' ,     'Algorithmic game theory and mechanism design' ,     'Social networks' ,     'Algorithmic game theory' ,     'Algorithmic mechanism design' ,     'Solution concepts in game theory' ,     'Exact and approximate computation of equilibria' ,     'Quality of equilibria' ,     'Convergence and learning in games' ,     'Market equilibria' ,     'Computational pricing and auctions' ,     'Representations of games and their complexity' ,     'Network games' ,     'Network formation' ,     'Computational advertising theory' ,     'Database theory' ,     'Data exchange' ,     'Data provenance' ,     'Data modeling' ,     'Database query languages (principles)' ,     'Database constraints theory' ,     'Database interoperability' ,     'Data structures and algorithms for data management' ,     'Database query processing and optimization (theory)' ,     'Data integration' ,     'Logic and databases' ,     'Theory of database privacy and security' ,     'Incomplete, inconsistent, and uncertain databases' ,     'Theory of randomized search heuristics' ,     'Semantics and reasoning' ,     'Program constructs' ,     'Control primitives' ,     'Functional constructs' ,     'Object oriented constructs' ,     'Program schemes' ,     'Type structures' ,     'Program semantics' ,     'Algebraic semantics' ,     'Denotational semantics' ,     'Operational semantics' ,     'Axiomatic semantics' ,     'Action semantics' ,     'Categorical semantics' ,     'Program reasoning' ,     'Invariants' ,     'Program specifications' ,     'Pre- and post-conditions' ,     'Program verification' ,     'Program analysis' ,     'Assertions' ,     'Parsing' ,     'Abstraction' ,     'Mathematics of computing' ,     'Discrete mathematics' ,     'Combinatorics' ,     'Combinatoric problems' ,     'Permutations and combinations' ,     'Combinatorial algorithms' ,     'Generating functions' ,     'Combinatorial optimization' ,     'Combinatorics on words' ,     'Enumeration' ,     'Graph theory' ,     'Trees' ,     'Hypergraphs' ,     'Random graphs' ,     'Graph coloring' ,     'Paths and connectivity problems' ,     'Graph enumeration' ,     'Matchings and factors' ,     'Graphs and surfaces' ,     'Network flows' ,     'Spectra of graphs' ,     'Extremal graph theory' ,     'Matroids and greedoids' ,     'Graph algorithms' ,     'Approximation algorithms' ,     'Probability and statistics' ,     'Probabilistic representations' ,     'Bayesian networks' ,     'Markov networks' ,     'Factor graphs' ,     'Decision diagrams' ,     'Equational models' ,     'Causal networks' ,     'Stochastic differential equations' ,     'Nonparametric representations' ,     'Kernel density estimators' ,     'Spline models' ,     'Bayesian nonparametric models' ,     'Probabilistic inference problems' ,     'Maximum likelihood estimation' ,     'Bayesian computation' ,     'Computing most probable explanation' ,     'Hypothesis testing and confidence interval computation' ,     'Density estimation' ,     'Quantile regression' ,     'Max marginal computation' ,     'Probabilistic reasoning algorithms' ,     'Variable elimination' ,     'Loopy belief propagation' ,     'Variational methods' ,     'Expectation maximization' ,     'Markov-chain Monte Carlo methods' ,     'Gibbs sampling' ,     'Metropolis-Hastings algorithm' ,     'Simulated annealing' ,     'Markov-chain Monte Carlo convergence measures' ,     'Sequential Monte Carlo methods' ,     'Kalman filters and hidden Markov models' ,     'Resampling methods' ,     'Bootstrapping' ,     'Jackknifing' ,     'Random number generation' ,     'Probabilistic algorithms' ,     'Statistical paradigms' ,     'Queueing theory' ,     'Contingency table analysis' ,     'Regression analysis' ,     'Robust regression' ,     'Time series analysis' ,     'Survival analysis' ,     'Renewal theory' ,     'Dimensionality reduction' ,     'Cluster analysis' ,     'Statistical graphics' ,     'Exploratory data analysis' ,     'Stochastic processes' ,     'Markov processes' ,     'Nonparametric statistics' ,     'Distribution functions' ,     'Multivariate statistics' ,     'Mathematical software' ,     'Solvers' ,     'Statistical software' ,     'Mathematical software performance' ,     'Information theory' ,     'Coding theory' ,     'Mathematical analysis' ,     'Numerical analysis' ,     'Computation of transforms' ,     'Computations in finite fields' ,     'Computations on matrices' ,     'Computations on polynomials' ,     'Gröbner bases and other special bases' ,     'Number-theoretic computations' ,     'Interpolation' ,     'Numerical differentiation' ,     'Interval arithmetic' ,     'Arbitrary-precision arithmetic' ,     'Automatic differentiation' ,     'Mesh generation' ,     'Discretization' ,     'Mathematical optimization' ,     'Discrete optimization' ,     'Network optimization' ,     'Optimization with randomized search heuristics' ,     'Simulated annealing' ,     'Evolutionary algorithms' ,     'Tabu search' ,     'Randomized local search' ,     'Continuous optimization' ,     'Linear programming' ,     'Semidefinite programming' ,     'Convex optimization' ,     'Quasiconvex programming and unimodality' ,     'Stochastic control and optimization' ,     'Quadratic programming' ,     'Nonconvex optimization' ,     'Bio-inspired optimization' ,     'Mixed discrete-continuous optimization' ,     'Submodular optimization and polymatroids' ,     'Integer programming' ,     'Bio-inspired optimization' ,     'Non-parametric optimization' ,     'Genetic programming' ,     'Developmental representations' ,     'Differential equations' ,     'Ordinary differential equations' ,     'Partial differential equations' ,     'Differential algebraic equations' ,     'Differential variational inequalities' ,     'Calculus' ,     'Lambda calculus' ,     'Differential calculus' ,     'Integral calculus' ,     'Functional analysis' ,     'Approximation' ,     'Integral equations' ,     'Nonlinear equations' ,     'Quadrature' ,     'Continuous mathematics' ,     'Calculus' ,     'Lambda calculus' ,     'Differential calculus' ,     'Integral calculus' ,     'Topology' ,     'Point-set topology' ,     'Algebraic topology' ,     'Geometric topology' ,     'Continuous functions' ,     'Information systems' ,     'Data management systems' ,     'Database design and models' ,     'Relational database model' ,     'Entity relationship models' ,     'Graph-based database models' ,     'Hierarchical data models' ,     'Network data models' ,     'Physical data models' ,     'Data model extensions' ,     'Semi-structured data' ,     'Data streams' ,     'Data provenance' ,     'Incomplete data' ,     'Temporal data' ,     'Uncertainty' ,     'Inconsistent data' ,     'Data structures' ,     'Data access methods' ,     'Multidimensional range search' ,     'Data scans' ,     'Point lookups' ,     'Unidimensional range search' ,     'Proximity search' ,     'Data layout' ,     'Data compression' ,     'Data encryption' ,     'Record and block layout' ,     'Database management system engines' ,     'DBMS engine architectures' ,     'Database query processing' ,     'Query optimization' ,     'Query operators' ,     'Query planning' ,     'Join algorithms' ,     'Database transaction processing' ,     'Data locking' ,     'Transaction logging' ,     'Database recovery' ,     'Record and buffer management' ,     'Parallel and distributed DBMSs' ,     'Key-value stores' ,     'MapReduce-based systems' ,     'Relational parallel and distributed DBMSs' ,     'Triggers and rules' ,     'Database views' ,     'Integrity checking' ,     'Distributed database transactions' ,     'Distributed data locking' ,     'Deadlocks' ,     'Distributed database recovery' ,     'Main memory engines' ,     'Online analytical processing engines' ,     'Stream management' ,     'Query languages' ,     'Relational database query languages' ,     'Structured Query Language' ,     'XML query languages' ,     'XPath' ,     'XQuery' ,     'Query languages for non-relational engines' ,     'MapReduce languages' ,     'Call level interfaces' ,     'Database administration' ,     'Database utilities and tools' ,     'Database performance evaluation' ,     'Autonomous database administration' ,     'Data dictionaries' ,     'Information integration' ,     'Deduplication' ,     'Extraction, transformation and loading' ,     'Data exchange' ,     'Data cleaning' ,     'Wrappers (data mining)' ,     'Mediators and data integration' ,     'Entity resolution' ,     'Data warehouses' ,     'Federated databases' ,     'Middleware for databases' ,     'Database web servers' ,     'Application servers' ,     'Object-relational mapping facilities' ,     'Data federation tools' ,     'Data replication tools' ,     'Distributed transaction monitors' ,     'Message queues' ,     'Service buses' ,     'Enterprise application integration tools' ,     'Middleware business process managers' ,     'Information storage systems' ,     'Information storage technologies' ,     'Magnetic disks' ,     'Magnetic tapes' ,     'Optical / magneto-optical disks' ,     'Storage class memory' ,     'Flash memory' ,     'Phase change memory' ,     'Disk arrays' ,     'Tape libraries' ,     'Record storage systems' ,     'Record storage alternatives' ,     'Heap (data structure)' ,     'Hashed file organization' ,     'Indexed file organization' ,     'Linked lists' ,     'Directory structures' ,     'B-trees' ,     'Vnodes' ,     'Inodes' ,     'Extent-based file structures' ,     'Block / page strategies' ,     'Slotted pages' ,     'Intrapage space management' ,     'Interpage free-space management' ,     'Record layout alternatives' ,     'Fixed length attributes' ,     'Variable length attributes' ,     'Null values in records' ,     'Relational storage' ,     'Horizontal partitioning' ,     'Vertical partitioning' ,     'Column based storage' ,     'Hybrid storage layouts' ,     'Compression strategies' ,     'Storage replication' ,     'Mirroring' ,     'RAID' ,     'Point-in-time copies' ,     'Remote replication' ,     'Storage recovery strategies' ,     'Storage architectures' ,     'Cloud based storage' ,     'Storage network architectures' ,     'Storage area networks' ,     'Direct attached storage' ,     'Network attached storage' ,     'Distributed storage' ,     'Storage management' ,     'Hierarchical storage management' ,     'Storage virtualization' ,     'Information lifecycle management' ,     'Version management' ,     'Storage power management' ,     'Thin provisioning' ,     'Information systems applications' ,     'Enterprise information systems' ,     'Intranets' ,     'Extranets' ,     'Enterprise resource planning' ,     'Enterprise applications' ,     'Data centers' ,     'Collaborative and social computing systems and tools' ,     'Blogs' ,     'Wikis' ,     'Reputation systems' ,     'Open source software' ,     'Social networking sites' ,     'Social tagging systems' ,     'Synchronous editors' ,     'Asynchronous editors' ,     'Spatial-temporal systems' ,     'Location based services' ,     'Geographic information systems' ,     'Sensor networks' ,     'Data streaming' ,     'Global positioning systems' ,     'Decision support systems' ,     'Data warehouses' ,     'Expert systems' ,     'Data analytics' ,     'Online analytical processing' ,     'Mobile information processing systems' ,     'Process control systems' ,     'Multimedia information systems' ,     'Multimedia databases' ,     'Multimedia streaming' ,     'Multimedia content creation' ,     'Massively multiplayer online games' ,     'Data mining' ,     'Data cleaning' ,     'Collaborative filtering' ,     'Association rules' ,     'Clustering' ,     'Nearest-neighbor search' ,     'Data stream mining' ,     'Digital libraries and archives' ,     'Computational advertising' ,     'Computing platforms' ,     'World Wide Web' ,     'Web searching and information discovery' ,     'Web search engines' ,     'Web crawling' ,     'Web indexing' ,     'Page and site ranking' ,     'Spam detection' ,     'Content ranking' ,     'Collaborative filtering' ,     'Social recommendation' ,     'Personalization' ,     'Social tagging' ,     'Online advertising' ,     'Sponsored search advertising' ,     'Content match advertising' ,     'Display advertising' ,     'Social advertising' ,     'Web mining' ,     'Site wrapping' ,     'Data extraction and integration' ,     'Deep web' ,     'Surfacing' ,     'Search results deduplication' ,     'Web log analysis' ,     'Traffic analysis' ,     'Web applications' ,     'Internet communications tools' ,     'Email' ,     'Blogs' ,     'Texting' ,     'Chat' ,     'Web conferencing' ,     'Social networks' ,     'Crowdsourcing' ,     'Answer ranking' ,     'Trust' ,     'Incentive schemes' ,     'Reputation systems' ,     'Electronic commerce' ,     'Digital cash' ,     'E-commerce infrastructure' ,     'Electronic data interchange' ,     'Electronic funds transfer' ,     'Online shopping' ,     'Online banking' ,     'Secure online transactions' ,     'Online auctions' ,     'Web interfaces' ,     'Wikis' ,     'Browsers' ,     'Mashups' ,     'Web services' ,     'Simple Object Access Protocol (SOAP)' ,     'RESTful web services' ,     'Web Services Description Language (WSDL)' ,     'Universal Description Discovery and Integration (UDDI)' ,     'Service discovery and interfaces' ,     'Web data description languages' ,     'Semantic web description languages' ,     'Resource Description Framework (RDF)' ,     'Web Ontology Language (OWL)' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Information retrieval' ,     'Document representation' ,     'Document structure' ,     'Document topic models' ,     'Content analysis and feature selection' ,     'Data encoding and canonicalization' ,     'Document collection models' ,     'Ontologies' ,     'Dictionaries' ,     'Thesauri' ,     'Information retrieval query processing' ,     'Query representation' ,     'Query intent' ,     'Query log analysis' ,     'Query suggestion' ,     'Query reformulation' ,     'Users and interactive retrieval' ,     'Personalization' ,     'Task models' ,     'Search interfaces' ,     'Collaborative search' ,     'Retrieval models and ranking' ,     'Rank aggregation' ,     'Probabilistic retrieval models' ,     'Language models' ,     'Similarity measures' ,     'Learning to rank' ,     'Combination, fusion and federated search' ,     'Information retrieval diversity' ,     'Top-k retrieval in databases' ,     'Novelty in information retrieval' ,     'Retrieval tasks and goals' ,     'Question answering' ,     'Document filtering' ,     'Recommender systems' ,     'Information extraction' ,     'Sentiment analysis' ,     'Expert search' ,     'Near-duplicate and plagiarism detection' ,     'Clustering and classification' ,     'Summarization' ,     'Business intelligence' ,     'Evaluation of retrieval results' ,     'Test collections' ,     'Relevance assessment' ,     'Retrieval effectiveness' ,     'Retrieval efficiency' ,     'Presentation of retrieval results' ,     'Search engine architectures and scalability' ,     'Search engine indexing' ,     'Search index compression' ,     'Distributed retrieval' ,     'Peer-to-peer retrieval' ,     'Retrieval on mobile devices' ,     'Adversarial retrieval' ,     'Link and co-citation analysis' ,     'Searching with auxiliary databases' ,     'Specialized information retrieval' ,     'Structure and multilingual text search' ,     'Structured text search' ,     'Mathematics retrieval' ,     'Chemical and biochemical retrieval' ,     'Multilingual and cross-lingual retrieval' ,     'Multimedia and multimodal retrieval' ,     'Image search' ,     'Video search' ,     'Speech / audio search' ,     'Music retrieval' ,     'Environment-specific retrieval' ,     'Enterprise search' ,     'Desktop search' ,     'Web and social media search' ,     'Security and privacy' ,     'Cryptography' ,     'Key management' ,     'Public key (asymmetric) techniques' ,     'Digital signatures' ,     'Public key encryption' ,     'Symmetric cryptography and hash functions' ,     'Block and stream ciphers' ,     'Hash functions and message authentication codes' ,     'Cryptanalysis and other attacks' ,     'Information-theoretic techniques' ,     'Mathematical foundations of cryptography' ,     'Formal methods and theory of security' ,     'Trust frameworks' ,     'Security requirements' ,     'Formal security models' ,     'Logic and verification' ,     'Security services' ,     'Authentication' ,     'Biometrics' ,     'Graphical / visual passwords' ,     'Multi-factor authentication' ,     'Access control' ,     'Pseudonymity, anonymity and untraceability' ,     'Privacy-preserving protocols' ,     'Digital rights management' ,     'Authorization' ,     'Intrusion/anomaly detection and malware mitigation' ,     'Malware and its mitigation' ,     'Intrusion detection systems' ,     'Artificial immune systems' ,     'Social engineering attacks' ,     'Spoofing attacks' ,     'Phishing' ,     'Security in hardware' ,     'Tamper-proof and tamper-resistant designs' ,     'Embedded systems security' ,     'Hardware security implementation' ,     'Hardware-based security protocols' ,     'Hardware attacks and countermeasures' ,     'Malicious design modifications' ,     'Side-channel analysis and countermeasures' ,     'Hardware reverse engineering' ,     'Systems security' ,     'Operating systems security' ,     'Mobile platform security' ,     'Trusted computing' ,     'Virtualization and security' ,     'Browser security' ,     'Distributed systems security' ,     'Information flow control' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Vulnerability management' ,     'Penetration testing' ,     'Vulnerability scanners' ,     'File system security' ,     'Network security' ,     'Security protocols' ,     'Web protocol security' ,     'Mobile and wireless security' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Database and storage security' ,     'Data anonymization and sanitization' ,     'Management and querying of encrypted data' ,     'Information accountability and usage control' ,     'Database activity monitoring' ,     'Software and application security' ,     'Software security engineering' ,     'Web application security' ,     'Social network security and privacy' ,     'Domain-specific security and privacy architectures' ,     'Software reverse engineering' ,     'Human and societal aspects of security and privacy' ,     'Economics of security and privacy' ,     'Social aspects of security and privacy' ,     'Privacy protections' ,     'Usability in security and privacy' ,     'Human-centered computing' ,     'Human computer interaction (HCI)' ,     'HCI design and evaluation methods' ,     'User models' ,     'User studies' ,     'Usability testing' ,     'Heuristic evaluations' ,     'Walkthrough evaluations' ,     'Laboratory experiments' ,     'Field studies' ,     'Interaction paradigms' ,     'Hypertext / hypermedia' ,     'Mixed / augmented reality' ,     'Command line interfaces' ,     'Graphical user interfaces' ,     'Virtual reality' ,     'Web-based interaction' ,     'Natural language interfaces' ,     'Collaborative interaction' ,     'Interaction devices' ,     'Graphics input devices' ,     'Displays and imagers' ,     'Sound-based input / output' ,     'Keyboards' ,     'Pointing devices' ,     'Touch screens' ,     'Haptic devices' ,     'HCI theory, concepts and models' ,     'Interaction techniques' ,     'Auditory feedback' ,     'Text input' ,     'Pointing' ,     'Gestural input' ,     'Interactive systems and tools' ,     'User interface management systems' ,     'User interface programming' ,     'User interface toolkits' ,     'Empirical studies in HCI' ,     'Interaction design' ,     'Interaction design process and methods' ,     'User interface design' ,     'User centered design' ,     'Activity centered design' ,     'Scenario-based design' ,     'Participatory design' ,     'Contextual design' ,     'Interface design prototyping' ,     'Interaction design theory, concepts and paradigms' ,     'Empirical studies in interaction design' ,     'Systems and tools for interaction design' ,     'Wireframes' ,     'Collaborative and social computing' ,     'Collaborative and social computing theory, concepts and paradigms' ,     'Social content sharing' ,     'Collaborative content creation' ,     'Collaborative filtering' ,     'Social recommendation' ,     'Social networks' ,     'Social tagging' ,     'Computer supported cooperative work' ,     'Social engineering (social sciences)' ,     'Social navigation' ,     'Social media' ,     'Collaborative and social computing design and evaluation methods' ,     'Social network analysis' ,     'Ethnographic studies' ,     'Collaborative and social computing systems and tools' ,     'Blogs' ,     'Wikis' ,     'Reputation systems' ,     'Open source software' ,     'Social networking sites' ,     'Social tagging systems' ,     'Synchronous editors' ,     'Asynchronous editors' ,     'Empirical studies in collaborative and social computing' ,     'Collaborative and social computing devices' ,     'Ubiquitous and mobile computing' ,     'Ubiquitous and mobile computing theory, concepts and paradigms' ,     'Ubiquitous computing' ,     'Mobile computing' ,     'Ambient intelligence' ,     'Ubiquitous and mobile computing systems and tools' ,     'Ubiquitous and mobile devices' ,     'Smartphones' ,     'Interactive whiteboards' ,     'Mobile phones' ,     'Mobile devices' ,     'Portable media players' ,     'Personal digital assistants' ,     'Handheld game consoles' ,     'E-book readers' ,     'Tablet computers' ,     'Ubiquitous and mobile computing design and evaluation methods' ,     'Empirical studies in ubiquitous and mobile computing' ,     'Visualization' ,     'Visualization techniques' ,     'Treemaps' ,     'Hyperbolic trees' ,     'Heat maps' ,     'Graph drawings' ,     'Dendrograms' ,     'Cladograms' ,     'Visualization application domains' ,     'Scientific visualization' ,     'Visual analytics' ,     'Geographic visualization' ,     'Information visualization' ,     'Visualization systems and tools' ,     'Visualization toolkits' ,     'Visualization theory, concepts and paradigms' ,     'Empirical studies in visualization' ,     'Visualization design and evaluation methods' ,     'Accessibility' ,     'Accessibility theory, concepts and paradigms' ,     'Empirical studies in accessibility' ,     'Accessibility design and evaluation methods' ,     'Accessibility technologies' ,     'Accessibility systems and tools' ,     'Computing methodologies' ,     'Symbolic and algebraic manipulation' ,     'Symbolic and algebraic algorithms' ,     'Combinatorial algorithms' ,     'Algebraic algorithms' ,     'Nonalgebraic algorithms' ,     'Symbolic calculus algorithms' ,     'Exact arithmetic algorithms' ,     'Hybrid symbolic-numeric methods' ,     'Discrete calculus algorithms' ,     'Number theory algorithms' ,     'Equation and inequality solving algorithms' ,     'Linear algebra algorithms' ,     'Theorem proving algorithms' ,     'Boolean algebra algorithms' ,     'Optimization algorithms' ,     'Computer algebra systems' ,     'Special-purpose algebraic systems' ,     'Representation of mathematical objects' ,     'Representation of exact numbers' ,     'Representation of mathematical functions' ,     'Representation of Boolean functions' ,     'Representation of polynomials' ,     'Parallel computing methodologies' ,     'Parallel algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Shared memory algorithms' ,     'Vector / streaming algorithms' ,     'Massively parallel algorithms' ,     'Parallel programming languages' ,     'Artificial intelligence' ,     'Natural language processing' ,     'Information extraction' ,     'Machine translation' ,     'Discourse, dialogue and pragmatics' ,     'Natural language generation' ,     'Speech recognition' ,     'Lexical semantics' ,     'Phonology / morphology' ,     'Language resources' ,     'Knowledge representation and reasoning' ,     'Description logics' ,     'Semantic networks' ,     'Nonmonotonic, default reasoning and belief revision' ,     'Probabilistic reasoning' ,     'Vagueness and fuzzy logic' ,     'Causal reasoning and diagnostics' ,     'Temporal reasoning' ,     'Cognitive robotics' ,     'Ontology engineering' ,     'Logic programming and answer set programming' ,     'Spatial and physical reasoning' ,     'Reasoning about belief and knowledge' ,     'Planning and scheduling' ,     'Planning for deterministic actions' ,     'Planning under uncertainty' ,     'Multi-agent planning' ,     'Planning with abstraction and generalization' ,     'Robotic planning' ,     'Evolutionary robotics' ,     'Search methodologies' ,     'Heuristic function construction' ,     'Discrete space search' ,     'Continuous space search' ,     'Randomized search' ,     'Game tree search' ,     'Abstraction and micro-operators' ,     'Search with partial observations' ,     'Control methods' ,     'Robotic planning' ,     'Evolutionary robotics' ,     'Computational control theory' ,     'Motion path planning' ,     'Philosophical/theoretical foundations of artificial intelligence' ,     'Cognitive science' ,     'Theory of mind' ,     'Distributed artificial intelligence' ,     'Multi-agent systems' ,     'Intelligent agents' ,     'Mobile agents' ,     'Cooperation and coordination' ,     'Computer vision' ,     'Computer vision tasks' ,     'Biometrics' ,     'Scene understanding' ,     'Activity recognition and understanding' ,     'Video summarization' ,     'Visual content-based indexing and retrieval' ,     'Visual inspection' ,     'Vision for robotics' ,     'Scene anomaly detection' ,     'Image and video acquisition' ,     'Camera calibration' ,     'Epipolar geometry' ,     'Computational photography' ,     'Hyperspectral imaging' ,     'Motion capture' ,     '3D imaging' ,     'Active vision' ,     'Computer vision representations' ,     'Image representations' ,     'Shape representations' ,     'Appearance and texture representations' ,     'Hierarchical representations' ,     'Computer vision problems' ,     'Interest point and salient region detections' ,     'Image segmentation' ,     'Video segmentation' ,     'Shape inference' ,     'Object detection' ,     'Object recognition' ,     'Object identification' ,     'Tracking' ,     'Reconstruction' ,     'Matching' ,     'Machine learning' ,     'Learning paradigms' ,     'Supervised learning' ,     'Ranking' ,     'Learning to rank' ,     'Supervised learning by classification' ,     'Supervised learning by regression' ,     'Structured outputs' ,     'Cost-sensitive learning' ,     'Unsupervised learning' ,     'Cluster analysis' ,     'Anomaly detection' ,     'Mixture modeling' ,     'Topic modeling' ,     'Source separation' ,     'Motif discovery' ,     'Dimensionality reduction and manifold learning' ,     'Reinforcement learning' ,     'Sequential decision making' ,     'Inverse reinforcement learning' ,     'Apprenticeship learning' ,     'Multi-agent reinforcement learning' ,     'Adversarial learning' ,     'Multi-task learning' ,     'Transfer learning' ,     'Lifelong machine learning' ,     'Learning under covariate shift' ,     'Learning settings' ,     'Batch learning' ,     'Online learning settings' ,     'Learning from demonstrations' ,     'Learning from critiques' ,     'Learning from implicit feedback' ,     'Active learning settings' ,     'Semi-supervised learning settings' ,     'Machine learning approaches' ,     'Classification and regression trees' ,     'Kernel methods' ,     'Support vector machines' ,     'Gaussian processes' ,     'Neural networks' ,     'Logical and relational learning' ,     'Inductive logic learning' ,     'Statistical relational learning' ,     'Learning in probabilistic graphical models' ,     'Maximum likelihood modeling' ,     'Maximum entropy modeling' ,     'Maximum a posteriori modeling' ,     'Mixture models' ,     'Latent variable models' ,     'Bayesian network models' ,     'Learning linear models' ,     'Perceptron algorithm' ,     'Factorization methods' ,     'Non-negative matrix factorization' ,     'Factor analysis' ,     'Principal component analysis' ,     'Canonical correlation analysis' ,     'Latent Dirichlet allocation' ,     'Rule learning' ,     'Instance-based learning' ,     'Markov decision processes' ,     'Partially-observable Markov decision processes' ,     'Stochastic games' ,     'Learning latent representations' ,     'Deep belief networks' ,     'Bio-inspired approaches' ,     'Artificial life' ,     'Evolvable hardware' ,     'Genetic algorithms' ,     'Genetic programming' ,     'Evolutionary robotics' ,     'Generative and developmental approaches' ,     'Machine learning algorithms' ,     'Dynamic programming for Markov decision processes' ,     'Value iteration' ,     'Q-learning' ,     'Policy iteration' ,     'Temporal difference learning' ,     'Approximate dynamic programming methods' ,     'Ensemble methods' ,     'Boosting' ,     'Bagging' ,     'Spectral methods' ,     'Feature selection' ,     'Regularization' ,     'Cross-validation' ,     'Modeling and simulation' ,     'Model development and analysis' ,     'Modeling methodologies' ,     'Model verification and validation' ,     'Uncertainty quantification' ,     'Simulation theory' ,     'Systems theory' ,     'Network science' ,     'Simulation types and techniques' ,     'Uncertainty quantification' ,     'Quantum mechanic simulation' ,     'Molecular simulation' ,     'Rare-event simulation' ,     'Discrete-event simulation' ,     'Agent / discrete models' ,     'Distributed simulation' ,     'Continuous simulation' ,     'Continuous models' ,     'Real-time simulation' ,     'Interactive simulation' ,     'Multiscale systems' ,     'Massively parallel and high-performance simulations' ,     'Data assimilation' ,     'Scientific visualization' ,     'Visual analytics' ,     'Simulation by animation' ,     'Artificial life' ,     'Simulation support systems' ,     'Simulation environments' ,     'Simulation languages' ,     'Simulation tools' ,     'Simulation evaluation' ,     'Computer graphics' ,     'Animation' ,     'Motion capture' ,     'Procedural animation' ,     'Physical simulation' ,     'Motion processing' ,     'Collision detection' ,     'Rendering' ,     'Rasterization' ,     'Ray tracing' ,     'Non-photorealistic rendering' ,     'Reflectance modeling' ,     'Visibility' ,     'Image manipulation' ,     'Computational photography' ,     'Image processing' ,     'Texturing' ,     'Image-based rendering' ,     'Antialiasing' ,     'Graphics systems and interfaces' ,     'Graphics processors' ,     'Graphics input devices' ,     'Mixed / augmented reality' ,     'Perception' ,     'Graphics file formats' ,     'Virtual reality' ,     'Image compression' ,     'Shape modeling' ,     'Mesh models' ,     'Mesh geometry models' ,     'Parametric curve and surface models' ,     'Point-based models' ,     'Volumetric models' ,     'Shape analysis' ,     'Distributed computing methodologies' ,     'Distributed algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Distributed programming languages' ,     'Concurrent computing methodologies' ,     'Concurrent programming languages' ,     'Concurrent algorithms' ,     'Applied computing' ,     'Electronic commerce' ,     'Digital cash' ,     'E-commerce infrastructure' ,     'Electronic data interchange' ,     'Electronic funds transfer' ,     'Online shopping' ,     'Online banking' ,     'Secure online transactions' ,     'Online auctions' ,     'Enterprise computing' ,     'Enterprise information systems' ,     'Intranets' ,     'Extranets' ,     'Enterprise resource planning' ,     'Enterprise applications' ,     'Data centers' ,     'Business process management' ,     'Business process modeling' ,     'Business process management systems' ,     'Business process monitoring' ,     'Cross-organizational business processes' ,     'Business intelligence' ,     'Enterprise architectures' ,     'Enterprise architecture management' ,     'Enterprise architecture frameworks' ,     'Enterprise architecture modeling' ,     'Service-oriented architectures' ,     'Event-driven architectures' ,     'Business rules' ,     'Enterprise modeling' ,     'Enterprise ontologies, taxonomies and vocabularies' ,     'Enterprise data management' ,     'Reference models' ,     'Business-IT alignment' ,     'IT architectures' ,     'IT governance' ,     'Enterprise computing infrastructures' ,     'Enterprise interoperability' ,     'Enterprise application integration' ,     'Information integration and interoperability' ,     'Physical sciences and engineering' ,     'Aerospace' ,     'Avionics' ,     'Archaeology' ,     'Astronomy' ,     'Chemistry' ,     'Earth and atmospheric sciences' ,     'Environmental sciences' ,     'Engineering' ,     'Computer-aided design' ,     'Physics' ,     'Mathematics and statistics' ,     'Electronics' ,     'Avionics' ,     'Telecommunications' ,     'Internet telephony' ,     'Life and medical sciences' ,     'Computational biology' ,     'Molecular sequence analysis' ,     'Recognition of genes and regulatory elements' ,     'Molecular evolution' ,     'Computational transcriptomics' ,     'Biological networks' ,     'Sequencing and genotyping technologies' ,     'Imaging' ,     'Computational proteomics' ,     'Molecular structural biology' ,     'Computational genomics' ,     'Genomics' ,     'Computational genomics' ,     'Systems biology' ,     'Consumer health' ,     'Health care information systems' ,     'Health informatics' ,     'Bioinformatics' ,     'Metabolomics / metabonomics' ,     'Genetics' ,     'Population genetics' ,     'Proteomics' ,     'Computational proteomics' ,     'Transcriptomics' ,     'Law, social and behavioral sciences' ,     'Anthropology' ,     'Ethnography' ,     'Law' ,     'Psychology' ,     'Economics' ,     'Sociology' ,     'Computer forensics' ,     'Surveillance mechanisms' ,     'Investigation techniques' ,     'Evidence collection, storage and analysis' ,     'Network forensics' ,     'System forensics' ,     'Data recovery' ,     'Arts and humanities' ,     'Fine arts' ,     'Performing arts' ,     'Architecture (buildings)' ,     'Computer-aided design' ,     'Language translation' ,     'Media arts' ,     'Sound and music computing' ,     'Computers in other domains' ,     'Digital libraries and archives' ,     'Publishing' ,     'Military' ,     'Cyberwarfare' ,     'Cartography' ,     'Agriculture' ,     'Computing in government' ,     'Voting / election technologies' ,     'E-government' ,     'Personal computers and PC applications' ,     'Word processors' ,     'Spreadsheets' ,     'Computer games' ,     'Microcomputers' ,     'Operations research' ,     'Consumer products' ,     'Industry and manufacturing' ,     'Supply chain management' ,     'Command and control' ,     'Computer-aided manufacturing' ,     'Decision analysis' ,     'Multi-criterion optimization and decision-making' ,     'Transportation' ,     'Forecasting' ,     'Marketing' ,     'Education' ,     'Digital libraries and archives' ,     'Computer-assisted instruction' ,     'Interactive learning environments' ,     'Collaborative learning' ,     'Learning management systems' ,     'Distance learning' ,     'E-learning' ,     'Computer-managed instruction' ,     'Document management and text processing' ,     'Document searching' ,     'Document management' ,     'Text editing' ,     'Version control' ,     'Document metadata' ,     'Document capture' ,     'Document analysis' ,     'Document scanning' ,     'Graphics recognition and interpretation' ,     'Optical character recognition' ,     'Online handwriting recognition' ,     'Document preparation' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Annotation' ,     'Format and notation' ,     'Multi / mixed media creation' ,     'Image composition' ,     'Hypertext / hypermedia creation' ,     'Document scripting languages' ,     'Social and professional topics' ,     'Professional topics' ,     'Computing industry' ,     'Industry statistics' ,     'Computer manufacturing' ,     'Sustainability' ,     'Management of computing and information systems' ,     'Project and people management' ,     'Project management techniques' ,     'Project staffing' ,     'Systems planning' ,     'Systems analysis and design' ,     'Systems development' ,     'Computer and information systems training' ,     'Implementation management' ,     'Hardware selection' ,     'Computing equipment management' ,     'Pricing and resource allocation' ,     'Software management' ,     'Software maintenance' ,     'Software selection and adaptation' ,     'System management' ,     'Centralization / decentralization' ,     'Technology audits' ,     'Quality assurance' ,     'Network operations' ,     'File systems management' ,     'Information system economics' ,     'History of computing' ,     'Historical people' ,     'History of hardware' ,     'History of software' ,     'History of programming languages' ,     'History of computing theory' ,     'Computing education' ,     'Computational thinking' ,     'Accreditation' ,     'Model curricula' ,     'Computing education programs' ,     'Information systems education' ,     'Computer science education' ,     'CS1' ,     'Computer engineering education' ,     'Information technology education' ,     'Information science education' ,     'Computational science and engineering education' ,     'Software engineering education' ,     'Informal education' ,     'Computing literacy' ,     'Student assessment' ,     'K-12 education' ,     'Adult education' ,     'Computing and business' ,     'Employment issues' ,     'Automation' ,     'Computer supported cooperative work' ,     'Economic impact' ,     'Offshoring' ,     'Reengineering' ,     'Socio-technical systems' ,     'Computing profession' ,     'Codes of ethics' ,     'Employment issues' ,     'Funding' ,     'Computing occupations' ,     'Computing organizations' ,     'Testing, certification and licensing' ,     'Assistive technologies' ,     'Computing / technology policy' ,     'Intellectual property' ,     'Digital rights management' ,     'Copyrights' ,     'Software reverse engineering' ,     'Patents' ,     'Trademarks' ,     'Internet governance / domain names' ,     'Licensing' ,     'Treaties' ,     'Database protection laws' ,     'Secondary liability' ,     'Soft intellectual property' ,     'Hardware reverse engineering' ,     'Privacy policies' ,     'Censorship' ,     'Pornography' ,     'Hate speech' ,     'Political speech' ,     'Technology and censorship' ,     'Censoring filters' ,     'Surveillance' ,     'Governmental surveillance' ,     'Corporate surveillance' ,     'Commerce policy' ,     'Taxation' ,     'Transborder data flow' ,     'Antitrust and competition' ,     'Governmental regulations' ,     'Online auctions policy' ,     'Consumer products policy' ,     'Network access control' ,     'Censoring filters' ,     'Broadband access' ,     'Net neutrality' ,     'Network access restrictions' ,     'Age-based restrictions' ,     'Acceptable use policy restrictions' ,     'Universal access' ,     'Computer crime' ,     'Social engineering attacks' ,     'Spoofing attacks' ,     'Phishing' ,     'Identity theft' ,     'Financial crime' ,     'Malware / spyware crime' ,     'Government technology policy' ,     'Governmental regulations' ,     'Import / export controls' ,     'Medical information policy' ,     'Medical records' ,     'Personal health records' ,     'Genetic information' ,     'Patient privacy' ,     'Health information exchanges' ,     'Medical technologies' ,     'Remote medicine' ,     'User characteristics' ,     'Race and ethnicity' ,     'Religious orientation' ,     'Gender' ,     'Men' ,     'Women' ,     'Sexual orientation' ,     'People with disabilities' ,     'Geographic characteristics' ,     'Cultural characteristics' ,     'Age' ,     'Children' ,     'Seniors' ,     'Adolescents' );
        
       //adaugam tagurile in tabelul de taguri
       $con=mysqli_connect("Localhost", "root" ,"", "licenta");
       for($i=0;$i<count($this->taguri); $i++)
       {
        if(in_array($this->taguri[$i], $arrayToateTagurile) )  //tagul nu e valid
        {
          $query = $con->prepare("INSERT INTO taguri(nume_concept,tag) values(?,?)");  //facem prepare la query, ordonat dupa time desc by default
          $query->bind_param("ss",$this->denumire,$this->taguri[$i]);  //bind-uim parametrii
          $query->execute(); //executam query-ul    
        }
        
       }
       $con->close();
                                                                                                              
       }

       public function getRelatiiConcept($numeConcept,$underscore='') //va trebui sa returneze toate relatiile si nodurile unui nod ce are un anume nume
       {
           //MATCH (a:Concept {nume: 'conceptD'})-[r]-(b) RETURN r, a, b

           if($underscore!='')
                $numeConcept=str_replace("_"," ",$numeConcept);  //VA inlocui _ cu spatiu din $numeConcept, pt API, nu pot avea ruta cu spatii

           $client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
            ->build();

           $query = 'MATCH (a:Concept {nume:"' . $numeConcept . '"})-[r]->(nodVecin) RETURN type(r) as relatie, a, nodVecin' ;
           $result = $client->run($query);


           $rezultatFinal=array();
           foreach ($result->records() as $record) 
           {
             $toPush=array();
             $toPush['nume']= $record->get('nodVecin')->get('nume')  ;
             //$toPush['descriere']= $record->get('nodVecin')->get('descriere')  ;
             $toPush['relatie']= $record->get('relatie')  ;

             array_push($rezultatFinal,$toPush);
           }

           return $rezultatFinal;
       }


       public function getToateNodurileConectate($numeConcept , $underscore='', $nivel=null)  //nivel va fi 2 by default in query daca nu este specificat
       {

        //MATCH ({nume :"Baze de date"})-[*]-(connected)
        //RETURN connected
        
        if($underscore!='')
                $numeConcept=str_replace("_"," ",$numeConcept);  //VA inlocui _ cu spatiu din $numeConcept, pt API, nu pot avea ruta cu spatii

        $client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
            ->build();

           $query='default';
           if($nivel!=null)
           {
             if(!preg_match('/^[1-9][0-9]{0,15}$/', $nivel))
             {
               return "ID-ul nu este numar";
             }
           }

           if($nivel!=null) 
           {
            $query = 'MATCH p=(n)-[*1..   ' . $nivel .  ']-(nodVecin)
            WHERE n.nume = "' . $numeConcept  .'"
            RETURN  DISTINCT nodVecin, labels(nodVecin) as labels, min(length(p)) as u
            ORDER BY u ' ;
           //echo $query;
           }
           else
           {
            $query = 'MATCH p=(n)-[*1..2]-(nodVecin)
            WHERE n.nume = "' . $numeConcept  .'"
            RETURN  DISTINCT nodVecin, labels(nodVecin) as labels, min(length(p)) as u
            ORDER BY u ' ;
           }

           $result = $client->run($query);

           $rezultatFinal=array();
           foreach ($result->records() as $record) 
           {
             $toPush=array();
             $toPush['nume']= $record->get('nodVecin')->get('nume')  ;//vom avea numele tuturor nodurilor la care se poate ajunge plecand din $numeConcept
             $toPush['labels']= $record->get('labels')  ;//vom avea numele tuturor nodurilor la care se poate ajunge plecand din $numeConcept

             array_push($rezultatFinal,$toPush);
           }

           return $rezultatFinal;
        
       }

       public function getInfoNod($numeConcept , $underscore='')
       {
         if($underscore!='')
            $numeConcept=str_replace("_"," ",$numeConcept);  //VA inlocui _ cu spatiu din $numeConcept, pt API, nu pot avea ruta cu spatii

         $client = ClientBuilder::create()
          ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
          ->build();

          $query ='MATCH (nod:Concept) WHERE nod.nume="'. $numeConcept . '" RETURN nod';

          //echo $query;
          
          $result = $client->run($query);


          $rezultatFinal=array();
          foreach ($result->records() as $record) 
          {
            $toPush=array();
            $toPush['nume']= $record->get('nod')->get('nume')  ;//vom avea numele tuturor nodurilor la care se poate ajunge plecand din $numeConcept
            $toPush['descriere']=$record->get('nod')->get('descriere');

            array_push($rezultatFinal,$toPush);
          }

          return $rezultatFinal;


       }

       public function stergeNod($numeConcept , $underscore='')
       {
        if($underscore!='')
        $numeConcept=str_replace("_"," ",$numeConcept);  //VA inlocui _ cu spatiu din $numeConcept, pt API, nu pot avea ruta cu spatii

        $client = ClientBuilder::create()
          ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
          ->build();

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $numeConcept . '" RETURN nod';  //ca sa vedem daca exista

        $result = $client->run($query);
        $rezultatFinal=array();

        foreach ($result->records() as $record) 
             if( $record->get('nod')->get('nume') != null )  //l-am gasit, deci il stergem
            {
               $query ='MATCH (nod:Concept) WHERE nod.nume="'. $numeConcept . '" DETACH DELETE nod';
               $client->run($query);

               $con=mysqli_connect("Localhost", "root" ,"", "licenta");
               $query = $con->prepare("DELETE FROM comentarii where nume_concept=? ");  //facem prepare la query
               $query->bind_param("s", $numeConcept );  //bind-uim parametrii
               $query->execute(); //executam query-ul

               $con=mysqli_connect("Localhost", "root" ,"", "licenta");
               $query = $con->prepare("DELETE FROM taguri where nume_concept=? ");  //facem prepare la query
               $query->bind_param("s", $numeConcept );  //bind-uim parametrii
               $query->execute(); //executam query-ul

               return true;
               
            }

            else
           {
            return false;
           }

        
       }

       public function modificaDescrierea($continutDescriereNoua)
       {
        if($continutDescriereNoua!='')     
        {
                                  
          if(strlen($continutDescriereNoua)>1500)
             return "Descrierea are peste 1500 caractere";
           
          //if(!preg_match("/^[a-zA-Z0-9 ăâîșțĂÂÎȘȚ.,?!~;:'-+)(]+$/",$continutDescriereNoua))
            // return "Descrierea nu respecta formatul necesar!";
        }          

        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();


        $search = array(
          '@<script[^>]*?>.*?</script>@si'   // scoatem JS-ul potential malitios daca a fost dat
        );
       
          $output = preg_replace($search, '', $continutDescriereNoua);
          $continutDescriereNoua=$output;

        $purifier = new HTMLPurifier();
        $continutDescriereNoua = $purifier->purify($continutDescriereNoua);

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" RETURN nod';  //ca sa vedem daca exista

        $result = $client->run($query);

        foreach ($result->records() as $record) 
            if( $record->get('nod')->get('nume') != null )  //l-am gasit, deci il stergem
            {
              //$query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . "' SET nod.descriere='" . $continutDescriereNoua . "'";  //ca sa vedem daca exista

              $query ="MATCH (nod:Concept) WHERE nod.nume='". $this->denumire . "' SET nod.descriere='" . addslashes($continutDescriereNoua) . "'";
              
              $result = $client->run($query);
              return "Descrierea modificata cu succes!";  
            }

        return "Conceptul cu numele dat nu exista!";        

       }

       public function modificaNume($nouNume)
       {
        
        $nouNume=str_replace("%20"," ",$nouNume);   //cand vine ca query param de la API space-urile vor fi inlocuite cu %20, trebuie sa le inlocuim la loc aici inainte de inserarea in DB

        if(strlen($nouNume)>100)
            return "Noul nume are peste 100 caractere!";
           
        if(!preg_match("/^[a-zA-Z0-9 ăâîșțĂÂÎȘȚ]+$/",$nouNume))
            return "Noul nume nu respecta formatul necesar!";
                  

        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        //////////////////////////////////////////////////////////////////////////
        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $nouNume . '" RETURN nod';  //ca sa vedem daca exista
        $result = $client->run($query);

        foreach ($result->records() as $record) 
          if( $record->get('nod')->get('nume') != null )  //numele dat exista deja
          {
            return "Alegeti alt nume, cel dat este deja folosit!";
          }
        //////////////////////////////////////////////////////////////////////////

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" RETURN nod';  //ca sa vedem daca exista
        $result = $client->run($query);

        foreach ($result->records() as $record) 
          if( $record->get('nod')->get('nume') != null )  //l-am gasit
          {
            $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" SET nod.nume="' . $nouNume . '"';  //ca sa vedem daca exista
            //echo $query;
            $result = $client->run($query);

            //modificam peste tot numele in tabelul comentarii
            $con=mysqli_connect("Localhost", "root" ,"", "licenta");
            $query = $con->prepare("UPDATE comentarii SET nume_concept=? where nume_concept=? ");  //facem prepare la query
            $query->bind_param("ss",$nouNume, $this->denumire );  //bind-uim parametrii
            $query->execute(); //executam query-ul

            $query = $con->prepare("UPDATE taguri SET nume_concept=? where nume_concept=? ");  //tabelul taguri
            $query->bind_param("ss",$nouNume, $this->denumire );  //bind-uim parametrii
            $query->execute(); //executam query-ul
            

            return "Nume modificat cu succes!";  
          }


        return "Conceptul cu numele dat nu exista!"; 
        
       }

       public function adaugaComentariu($continutComentariu,$numeUtilizator)
       {

        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT * from utilizatori where nume=?");  //facem prepare la query
        $query->bind_param("s",$numeUtilizator);  //bind-uim parametrii
        $query->execute(); //executam query-ul

        $result=$query->get_result();
        $row =$result->fetch_assoc();  //va lua primul row daca returneaza mai multe row-uri
        
        if ($result->num_rows!=1)  //va fi doar un singur nume asa in baza de date oricum
        {
              return "Numele de utilizator nu exista!";
        }
        
        if(strlen($continutComentariu)>1500)
            return "Comentariul are peste 1500 caractere!";

        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" RETURN nod';  //ca sa vedem daca exista
        $result = $client->run($query);

        $search = array(
          '@<script[^>]*?>.*?</script>@si'   // scoatem JS-ul potential malitios daca a fost dat
        );
       
          $output = preg_replace($search, '', $continutComentariu);
          $continutComentariu=$output;

        $purifier = new HTMLPurifier();
        $continutComentariu = $purifier->purify($continutComentariu);

        foreach ($result->records() as $record) 
            if( $record->get('nod')->get('nume') != null )
            {
              
              $query=$con->prepare("INSERT INTO comentarii(nume_concept,nume_user,comentariu) values(?,?,?)");
              $continutComentariu=addslashes($continutComentariu);
              $query->bind_param("sss",$this->denumire , $numeUtilizator , $continutComentariu );  //s de la String bind-uim toti parametrii        
              $query->execute(); //executam query-ul

              return "Comentariu adaugat! ID=" . mysqli_insert_id($con);

              $con->close();
            }

            return "Conceptul caruia se doreste a fi adaugat comentariul nu exista!";

        

      }

      public function getToateComentariile()
      {

        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" RETURN nod';  //ca sa vedem daca exista
        $result = $client->run($query);

        foreach ($result->records() as $record) 
            if( $record->get('nod')->get('nume') != null )  //l-am gasit, deci ii vom lua comentariile
            {
              $con=mysqli_connect("Localhost", "root" ,"", "licenta");
              $query = $con->prepare("SELECT * from comentarii where nume_concept=? ORDER BY time DESC");  //facem prepare la query, ordonat dupa time desc by default
              $query->bind_param("s",$this->denumire);  //bind-uim parametrii
              $query->execute(); //executam query-ul
              
              $result=$query->get_result();

              if($result->num_rows==0)
              {
                $con->close();
                return "Niciun comentariu!";
              }
              else
              {
                $array = array();
                while($row=$result->fetch_assoc())
                {
                    $row['comentariu']=stripslashes( $row['comentariu']);
                    array_push($array,$row);
                }

                $con->close();
                return $array;
              }
            }
            
              return "Conceptul nu exista!";
            

      }

      public function getComentariuSpecific($id)
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT * from comentarii where id=? ");  //facem prepare la query
        $query->bind_param("i",$id);  //bind-uim parametrii
        $query->execute(); //executam query-ul
        
        $result=$query->get_result();

        if($result->num_rows==0)
        {
          $con->close();
          return "Nu exista un comentariu cu acest ID!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
              $row['comentariu']=stripslashes( $row['comentariu']);
              array_push($array,$row);
          }

          $con->close();
          return $array;
        }
      }

      public function stergeUnComentariu($id)
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT * from comentarii where id=? ");  //facem prepare la query
        $query->bind_param("i",$id);  //bind-uim parametrii
        $query->execute(); //executam query-ul
        
        $result=$query->get_result();

        if($result->num_rows==0)
        {
          $con->close();
          return "Nu exista un comentariu cu acest ID, nu s-a efectuat o stergere!";
        }
        else
        {
          $query = $con->prepare("DELETE from comentarii where id=? ");  //facem prepare la query
          $query->bind_param("i",$id);  //bind-uim parametrii
          $query->execute(); //executam query-ul

          if(mysqli_affected_rows($con)==1)
          {
             return "Comentariu sters!";
          }
          else
          {
            return "Comentariul exista dar a aparut o eroare la stergere!";
          }
        }
      }

      public function filtreazaDupaTagurileDate($arrayTaguri)
      {
        //select  taguri.nume_concept 
        //from    taguri 
        //where   taguri.tag in ('March', 'Documentation') 
        //group by taguri.nume_concept 
        //having  count(distinct taguri.tag) = 2

        $arrayTaguri=array_unique($arrayTaguri);  //in caz ca s-a dat acelasi tag de 2 ori
        $sir='';
        foreach($arrayTaguri as $tag)
        {
          $sir=$sir . ",'" . $tag . "'";
        }
        $sir=substr($sir, 1);  //stergem primul , 

        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = "select  taguri.nume_concept " .
                 "from    taguri " .
                 "where   taguri.tag in (" . $sir . ") " .
                 "group by taguri.nume_concept " .
                 "having  count(distinct taguri.tag) = " .  count($arrayTaguri) ;  //facem prepare la query
        
        $result = mysqli_query($con, $query); //executam query-ul

        $rezultat=array();
        if (mysqli_num_rows($result) > 0) 
        {    
          while($row = mysqli_fetch_assoc($result)) 
          {
           $rezultat[]=$row;
          }
           $con->close();
           return $rezultat;
        } 
        else 
        {
          $con->close();
          return "Nu exista concepte cu toate aceste taguri!";
        }


      }

      public function getToateTagurileExistente()
      {
        
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT tag from  taguri where nume_concept=?");  //facem prepare la query, ordonat dupa time desc by default
        $query->bind_param("s",$this->denumire);  //bind-uim parametrii


        $query->execute(); //executam query-ul
        $result=$query->get_result();

        if($result->num_rows==0)
        {
          $con->close();
          return "Conceptul nu are taguri asociate!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
            $row['tag']=stripslashes( $row['tag']);
            array_push($array,$row);
          }

          $con->close();
          return $array;
        }

      }

      public function stergeUnTag($tagDeSters)
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = $con->prepare("SELECT * from  taguri where nume_concept=? and tag=?");  //facem prepare la query, ordonat dupa time desc by default

        $tagDeSters = str_replace('%20', ' ', $tagDeSters);
        $query->bind_param("ss",$this->denumire, $tagDeSters);  //bind-uim parametrii
        $query->execute(); //executam query-ul
        $result=$query->get_result();

        if($result->num_rows>=1)  //am gasit perechea
        {
          $query = $con->prepare("DELETE from  taguri where nume_concept=? and tag=?");  //facem prepare la query, ordonat dupa time desc by default
          $query->bind_param("ss",$this->denumire, $tagDeSters);  //bind-uim parametrii
  
          $query->execute(); //executam query-ul
          
          if(mysqli_affected_rows($con)==1)
          {
            $con->close();
            return "Tag sters!";
          }
          else
          {
            $con->close();
            return "Eroare!";
          }
        }
        else
        {
          $con->close();
          return "Perechea concept-tag nu exista!";
        }

      
      }

      public function adaugaUnTag($tagDeAdaugat)
      {
        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query ='MATCH (nod:Concept) WHERE nod.nume="'. $this->denumire . '" RETURN nod';  //ca sa vedem daca exista
        $result = $client->run($query);

        $tagDeAdaugat = str_replace('%20', ' ', $tagDeAdaugat);
        $arrayToateTagurile=array(
          'General and reference' ,     'Document types' ,     'Surveys and overviews' ,     'Reference works' ,     'General conference proceedings' ,     'Biographies' ,     'General literature' ,     'Computing standards, RFCs and guidelines' ,     'Cross-computing tools and techniques' ,     'Reliability' ,     'Empirical studies' ,     'Measurement' ,     'Metrics' ,     'Evaluation' ,     'Experimentation' ,     'Estimation' ,     'Design' ,     'Performance' ,     'Validation' ,     'Verification' ,     'Hardware' ,     'Printed circuit boards' ,     'Electromagnetic interference and compatibility' ,     'PCB design and layout' ,     'Communication hardware, interfaces and storage' ,     'Signal processing systems' ,     'Digital signal processing' ,     'Beamforming' ,     'Noise reduction' ,     'Sensors and actuators' ,     'Buses and high-speed links' ,     'Displays and imagers' ,     'External storage' ,     'Networking hardware' ,     'Printers' ,     'Sensor applications and deployments' ,     'Sensor devices and platforms' ,     'Sound-based input / output' ,     'Tactile and hand-based interfaces' ,     'Touch screens' ,     'Haptic devices' ,     'Scanners' ,     'Wireless devices' ,     'Wireless integrated network sensors' ,     'Electro-mechanical devices' ,     'Integrated circuits' ,     '3D integrated circuits' ,     'Interconnect' ,     'Input / output circuits' ,     'Metallic interconnect' ,     'Photonic and optical interconnect' ,     'Radio frequency and wireless interconnect' ,     'Semiconductor memory' ,     'Dynamic memory' ,     'Static memory' ,     'Non-volatile memory' ,     'Read-only memory' ,     'Digital switches' ,     'Transistors' ,     'Logic families' ,     'Logic circuits' ,     'Arithmetic and datapath circuits' ,     'Asynchronous circuits' ,     'Combinational circuits' ,     'Design modules and hierarchy' ,     'Finite state machines' ,     'Sequential circuits' ,     'Reconfigurable logic and FPGAs' ,     'Hardware accelerators' ,     'High-speed input / output' ,     'Programmable logic elements' ,     'Programmable interconnect' ,     'Reconfigurable logic applications' ,     'Evolvable hardware' ,     'Very large scale integration design' ,     '3D integrated circuits' ,     'Analog and mixed-signal circuits' ,     'Data conversion' ,     'Clock generation and timing' ,     'Analog and mixed-signal circuit optimization' ,     'Radio frequency and wireless circuits' ,     'Wireline communication' ,     'Analog and mixed-signal circuit synthesis' ,     'Application-specific VLSI designs' ,     'Application specific integrated circuits' ,     'Application specific instruction set processors' ,     'Application specific processors' ,     'Design reuse and communication-based design' ,     'Network on chip' ,     'System on a chip' ,     'Platform-based design' ,     'Hard and soft IP' ,     'Design rules' ,     'Economics of chip design and manufacturing' ,     'Full-custom circuits' ,     'VLSI design manufacturing considerations' ,     'On-chip resource management' ,     'On-chip sensors' ,     'Standard cell libraries' ,     'VLSI packaging' ,     'Die and wafer stacking' ,     'Input / output styles' ,     'Multi-chip modules' ,     'Package-level interconnect' ,     'VLSI system specification and constraints' ,     'Power and energy' ,     'Thermal issues' ,     'Temperature monitoring' ,     'Temperature simulation and estimation' ,     'Temperature control' ,     'Temperature optimization' ,     'Energy generation and storage' ,     'Batteries' ,     'Fuel-based energy' ,     'Renewable energy' ,     'Reusable energy storage' ,     'Energy distribution' ,     'Energy metering' ,     'Power conversion' ,     'Power networks' ,     'Smart grid' ,     'Impact on the environment' ,     'Power estimation and optimization' ,     'Switching devices power issues' ,     'Interconnect power issues' ,     'Circuits power issues' ,     'Chip-level power issues' ,     'Platform power issues' ,     'Enterprise level and data centers power issues' ,     'Electronic design automation' ,     'High-level and register-transfer level synthesis' ,     'Datapath optimization' ,     'Hardware-software codesign' ,     'Resource binding and sharing' ,     'Operations scheduling' ,     'Hardware description languages and compilation' ,     'Logic synthesis' ,     'Combinational synthesis' ,     'Circuit optimization' ,     'Sequential synthesis' ,     'Technology-mapping' ,     'Transistor-level synthesis' ,     'Modeling and parameter extraction' ,     'Physical design (EDA)' ,     'Clock-network synthesis' ,     'Packaging' ,     'Partitioning and floorplanning' ,     'Placement' ,     'Physical synthesis' ,     'Power grid design' ,     'Wire routing' ,     'Timing analysis' ,     'Electrical-level simulation' ,     'Model-order reduction' ,     'Compact delay models' ,     'Static timing analysis' ,     'Statistical timing analysis' ,     'Transition-based timing analysis' ,     'Methodologies for EDA' ,     'Best practices for EDA' ,     'Design databases for EDA' ,     'Software tools for EDA' ,     'Hardware validation' ,     'Functional verification' ,     'Model checking' ,     'Coverage metrics' ,     'Equivalence checking' ,     'Semi-formal verification' ,     'Simulation and emulation' ,     'Transaction-level verification' ,     'Theorem proving and SAT solving' ,     'Assertion checking' ,     'Physical verification' ,     'Design rule checking' ,     'Layout-versus-schematics' ,     'Power and thermal analysis' ,     'Timing analysis and sign-off' ,     'Post-manufacture validation and debug' ,     'Bug detection, localization and diagnosis' ,     'Bug fixing (hardware)' ,     'Design for debug' ,     'Hardware test' ,     'Analog, mixed-signal and radio frequency test' ,     'Board- and system-level test' ,     'Defect-based test' ,     'Design for testability' ,     'Built-in self-test' ,     'Online test and diagnostics' ,     'Test data compression' ,     'Fault models and test metrics' ,     'Memory test and repair' ,     'Hardware reliability screening' ,     'Test-pattern generation and fault simulation' ,     'Testing with distributed and parallel systems' ,     'Robustness' ,     'Fault tolerance' ,     'Error detection and error correction' ,     'Failure prediction' ,     'Failure recovery, maintenance and self-repair' ,     'Redundancy' ,     'Self-checking mechanisms' ,     'System-level fault tolerance' ,     'Design for manufacturability' ,     'Process variations' ,     'Yield and cost modeling' ,     'Yield and cost optimization' ,     'Hardware reliability' ,     'Aging of circuits and systems' ,     'Circuit hardening' ,     'Early-life failures and infant mortality' ,     'Process, voltage and temperature variations' ,     'Signal integrity and noise analysis' ,     'Transient errors and upsets' ,     'Safety critical systems' ,     'Emerging technologies' ,     'Analysis and design of emerging devices and systems' ,     'Emerging architectures' ,     'Emerging languages and compilers' ,     'Emerging simulation' ,     'Emerging tools and methodologies' ,     'Biology-related information processing' ,     'Bio-embedded electronics' ,     'Neural systems' ,     'Circuit substrates' ,     'III-V compounds' ,     'Carbon based electronics' ,     'Cellular neural networks' ,     'Flexible and printable circuits' ,     'Superconducting circuits' ,     'Electromechanical systems' ,     'Microelectromechanical systems' ,     'Nanoelectromechanical systems' ,     'Emerging interfaces' ,     'Memory and dense storage' ,     'Emerging optical and photonic technologies' ,     'Reversible logic' ,     'Plasmonics' ,     'Quantum technologies' ,     'Single electron devices' ,     'Tunneling devices' ,     'Quantum computation' ,     'Quantum communication and cryptography' ,     'Quantum error correction and fault tolerance' ,     'Quantum dots and cellular automata' ,     'Spintronics and magnetic technologies' ,     'Computer systems organization' ,     'Architectures' ,     'Serial architectures' ,     'Reduced instruction set computing' ,     'Complex instruction set computing' ,     'Superscalar architectures' ,     'Pipeline computing' ,     'Stack machines' ,     'Parallel architectures' ,     'Very long instruction word' ,     'Interconnection architectures' ,     'Multiple instruction, multiple data' ,     'Cellular architectures' ,     'Multiple instruction, single data' ,     'Single instruction, multiple data' ,     'Systolic arrays' ,     'Multicore architectures' ,     'Distributed architectures' ,     'Cloud computing' ,     'Client-server architectures' ,     'n-tier architectures' ,     'Peer-to-peer architectures' ,     'Grid computing' ,     'Other architectures' ,     'Neural networks' ,     'Reconfigurable computing' ,     'Analog computers' ,     'Data flow architectures' ,     'Heterogeneous (hybrid) systems' ,     'Self-organizing autonomic computing' ,     'Optical computing' ,     'Quantum computing' ,     'Molecular computing' ,     'High-level language architectures' ,     'Special purpose systems' ,     'Embedded and cyber-physical systems' ,     'Sensor networks' ,     'Robotics' ,     'Robotic components' ,     'Robotic control' ,     'Evolutionary robotics' ,     'Robotic autonomy' ,     'External interfaces for robotics' ,     'Sensors and actuators' ,     'System on a chip' ,     'Embedded systems' ,     'Firmware' ,     'Embedded hardware' ,     'Embedded software' ,     'Real-time systems' ,     'Real-time operating systems' ,     'Real-time languages' ,     'Real-time system specification' ,     'Real-time system architecture' ,     'Dependable and fault-tolerant systems and networks' ,     'Reliability' ,     'Availability' ,     'Maintainability and maintenance' ,     'Processors and memory architectures' ,     'Secondary storage organization' ,     'Redundancy' ,     'Fault-tolerant network topologies' ,     'Networks' ,     'Network architectures' ,     'Network design principles' ,     'Layering' ,     'Naming and addressing' ,     'Programming interfaces' ,     'Network protocols' ,     'Network protocol design' ,     'Protocol correctness' ,     'Protocol testing and verification' ,     'Formal specifications' ,     'Link-layer protocols' ,     'Network layer protocols' ,     'Routing protocols' ,     'Signaling protocols' ,     'Transport protocols' ,     'Session protocols' ,     'Presentation protocols' ,     'Application layer protocols' ,     'Peer-to-peer protocols' ,     'OAM protocols' ,     'Time synchronization protocols' ,     'Network policy' ,     'Cross-layer protocols' ,     'Network File System (NFS) protocol' ,     'Network components' ,     'Intermediate nodes' ,     'Routers' ,     'Bridges and switches' ,     'Physical links' ,     'Repeaters' ,     'Middle boxes / network appliances' ,     'End nodes' ,     'Network adapters' ,     'Network servers' ,     'Wireless access points, base stations and infrastructure' ,     'Cognitive radios' ,     'Logical nodes' ,     'Network domains' ,     'Network algorithms' ,     'Data path algorithms' ,     'Packet classification' ,     'Deep packet inspection' ,     'Packet scheduling' ,     'Control path algorithms' ,     'Network resources allocation' ,     'Network control algorithms' ,     'Traffic engineering algorithms' ,     'Network design and planning algorithms' ,     'Network economics' ,     'Network performance evaluation' ,     'Network performance modeling' ,     'Network simulations' ,     'Network experimentation' ,     'Network performance analysis' ,     'Network measurement' ,     'Network properties' ,     'Network security' ,     'Security protocols' ,     'Web protocol security' ,     'Mobile and wireless security' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Network range' ,     'Short-range networks' ,     'Local area networks' ,     'Metropolitan area networks' ,     'Wide area networks' ,     'Very long-range networks' ,     'Network structure' ,     'Topology analysis and generation' ,     'Physical topologies' ,     'Logical / virtual topologies' ,     'Network topology types' ,     'Point-to-point networks' ,     'Bus networks' ,     'Star networks' ,     'Ring networks' ,     'Token ring networks' ,     'Fiber distributed data interface (FDDI)' ,     'Mesh networks' ,     'Wireless mesh networks' ,     'Hybrid networks' ,     'Network dynamics' ,     'Network reliability' ,     'Error detection and error correction' ,     'Network mobility' ,     'Network manageability' ,     'Network privacy and anonymity' ,     'Network services' ,     'Naming and addressing' ,     'Cloud computing' ,     'Location based services' ,     'Programmable networks' ,     'In-network processing' ,     'Network management' ,     'Network monitoring' ,     'Network types' ,     'Network on chip' ,     'Home networks' ,     'Storage area networks' ,     'Data center networks' ,     'Wired access networks' ,     'Cyber-physical networks' ,     'Sensor networks' ,     'Mobile networks' ,     'Overlay and other logical network structures' ,     'Peer-to-peer networks' ,     'World Wide Web (network structure)' ,     'Social media networks' ,     'Online social networks' ,     'Wireless access networks' ,     'Wireless local area networks' ,     'Wireless personal area networks' ,     'Ad hoc networks' ,     'Mobile ad hoc networks' ,     'Public Internet' ,     'Packet-switching networks' ,     'Software and its engineering' ,     'Software organization and properties' ,     'Contextual software domains' ,     'E-commerce infrastructure' ,     'Software infrastructure' ,     'Interpreters' ,     'Middleware' ,     'Message oriented middleware' ,     'Reflective middleware' ,     'Embedded middleware' ,     'Virtual machines' ,     'Operating systems' ,     'File systems management' ,     'Memory management' ,     'Virtual memory' ,     'Main memory' ,     'Allocation / deallocation strategies' ,     'Garbage collection' ,     'Distributed memory' ,     'Secondary storage' ,     'Process management' ,     'Scheduling' ,     'Deadlocks' ,     'Multithreading' ,     'Multiprocessing / multiprogramming / multitasking' ,     'Monitors' ,     'Mutual exclusion' ,     'Concurrency control' ,     'Power management' ,     'Process synchronization' ,     'Communications management' ,     'Buffering' ,     'Input / output' ,     'Message passing' ,     'Virtual worlds software' ,     'Interactive games' ,     'Virtual worlds training simulations' ,     'Software system structures' ,     'Embedded software' ,     'Software architectures' ,     'n-tier architectures' ,     'Peer-to-peer architectures' ,     'Data flow architectures' ,     'Cooperating communicating processes' ,     'Layered systems' ,     'Publish-subscribe / event-based architectures' ,     'Electronic blackboards' ,     'Simulator / interpreter' ,     'Object oriented architectures' ,     'Tightly coupled architectures' ,     'Space-based architectures' ,     '3-tier architectures' ,     'Software system models' ,     'Petri nets' ,     'State systems' ,     'Entity relationship modeling' ,     'Model-driven software engineering' ,     'Feature interaction' ,     'Massively parallel systems' ,     'Ultra-large-scale systems' ,     'Distributed systems organizing principles' ,     'Cloud computing' ,     'Client-server architectures' ,     'Grid computing' ,     'Organizing principles for web applications' ,     'Real-time systems software' ,     'Abstraction, modeling and modularity' ,     'Software functional properties' ,     'Correctness' ,     'Synchronization' ,     'Functionality' ,     'Real-time schedulability' ,     'Consistency' ,     'Completeness' ,     'Access protection' ,     'Formal methods' ,     'Model checking' ,     'Software verification' ,     'Automated static analysis' ,     'Dynamic analysis' ,     'Extra-functional properties' ,     'Interoperability' ,     'Software performance' ,     'Software reliability' ,     'Software fault tolerance' ,     'Checkpoint / restart' ,     'Software safety' ,     'Software usability' ,     'Software notations and tools' ,     'General programming languages' ,     'Language types' ,     'Parallel programming languages' ,     'Distributed programming languages' ,     'Imperative languages' ,     'Object oriented languages' ,     'Functional languages' ,     'Concurrent programming languages' ,     'Constraint and logic languages' ,     'Data flow languages' ,     'Extensible languages' ,     'Assembly languages' ,     'Multiparadigm languages' ,     'Very high level languages' ,     'Language features' ,     'Abstract data types' ,     'Polymorphism' ,     'Inheritance' ,     'Control structures' ,     'Data types and structures' ,     'Classes and objects' ,     'Modules / packages' ,     'Constraints' ,     'Recursion' ,     'Concurrent programming structures' ,     'Procedures, functions and subroutines' ,     'Patterns' ,     'Coroutines' ,     'Frameworks' ,     'Formal language definitions' ,     'Syntax' ,     'Semantics' ,     'Compilers' ,     'Interpreters' ,     'Incremental compilers' ,     'Retargetable compilers' ,     'Just-in-time compilers' ,     'Dynamic compilers' ,     'Translator writing systems and compiler generators' ,     'Source code generation' ,     'Runtime environments' ,     'Preprocessors' ,     'Parsers' ,     'Context specific languages' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Scripting languages' ,     'Domain specific languages' ,     'Specialized application languages' ,     'API languages' ,     'Graphical user interface languages' ,     'Window managers' ,     'Command and control languages' ,     'Macro languages' ,     'Programming by example' ,     'State based definitions' ,     'Visual languages' ,     'Interface definition languages' ,     'System description languages' ,     'Design languages' ,     'Unified Modeling Language (UML)' ,     'Architecture description languages' ,     'System modeling languages' ,     'Orchestration languages' ,     'Integration frameworks' ,     'Specification languages' ,     'Development frameworks and environments' ,     'Object oriented frameworks' ,     'Software as a service orchestration system' ,     'Integrated and visual development environments' ,     'Application specific development environments' ,     'Software configuration management and version control systems' ,     'Software libraries and repositories' ,     'Software maintenance tools' ,     'Software creation and management' ,     'Designing software' ,     'Requirements analysis' ,     'Software design engineering' ,     'Software design tradeoffs' ,     'Software implementation planning' ,     'Software design techniques' ,     'Software development process management' ,     'Software development methods' ,     'Rapid application development' ,     'Agile software development' ,     'Capability Maturity Model' ,     'Waterfall model' ,     'Spiral model' ,     'V-model' ,     'Design patterns' ,     'Risk management' ,     'Software development techniques' ,     'Software prototyping' ,     'Object oriented development' ,     'Flowcharts' ,     'Reusability' ,     'Software product lines' ,     'Error handling and recovery' ,     'Automatic programming' ,     'Genetic programming' ,     'Software verification and validation' ,     'Software prototyping' ,     'Operational analysis' ,     'Software defect analysis' ,     'Software testing and debugging' ,     'Fault tree analysis' ,     'Process validation' ,     'Walkthroughs' ,     'Pair programming' ,     'Use cases' ,     'Acceptance testing' ,     'Traceability' ,     'Formal software verification' ,     'Empirical software validation' ,     'Software post-development issues' ,     'Software reverse engineering' ,     'Documentation' ,     'Backup procedures' ,     'Software evolution' ,     'Software version control' ,     'Maintaining software' ,     'System administration' ,     'Collaboration in software development' ,     'Open source model' ,     'Programming teams' ,     'Search-based software engineering' ,     'Theory of computation' ,     'Models of computation' ,     'Computability' ,     'Lambda calculus' ,     'Turing machines' ,     'Recursive functions' ,     'Probabilistic computation' ,     'Quantum computation theory' ,     'Quantum complexity theory' ,     'Quantum communication complexity' ,     'Quantum query complexity' ,     'Quantum information theory' ,     'Interactive computation' ,     'Streaming models' ,     'Concurrency' ,     'Parallel computing models' ,     'Distributed computing models' ,     'Process calculi' ,     'Timed and hybrid models' ,     'Abstract machines' ,     'Formal languages and automata theory' ,     'Formalisms' ,     'Algebraic language theory' ,     'Rewrite systems' ,     'Automata over infinite objects' ,     'Grammars and context-free languages' ,     'Tree languages' ,     'Automata extensions' ,     'Transducers' ,     'Quantitative automata' ,     'Regular languages' ,     'Computational complexity and cryptography' ,     'Complexity classes' ,     'Problems, reductions and completeness' ,     'Communication complexity' ,     'Circuit complexity' ,     'Oracles and decision trees' ,     'Algebraic complexity theory' ,     'Quantum complexity theory' ,     'Proof complexity' ,     'Interactive proof systems' ,     'Complexity theory and logic' ,     'Cryptographic primitives' ,     'Cryptographic protocols' ,     'Logic' ,     'Logic and verification' ,     'Proof theory' ,     'Modal and temporal logics' ,     'Automated reasoning' ,     'Constraint and logic programming' ,     'Constructive mathematics' ,     'Description logics' ,     'Equational logic and rewriting' ,     'Finite Model Theory' ,     'Higher order logic' ,     'Linear logic' ,     'Programming logic' ,     'Abstraction' ,     'Verification by model checking' ,     'Type theory' ,     'Hoare logic' ,     'Separation logic' ,     'Design and analysis of algorithms' ,     'Graph algorithms analysis' ,     'Network flows' ,     'Sparsification and spanners' ,     'Shortest paths' ,     'Dynamic graph algorithms' ,     'Approximation algorithms analysis' ,     'Scheduling algorithms' ,     'Packing and covering problems' ,     'Routing and network design problems' ,     'Facility location and clustering' ,     'Rounding techniques' ,     'Stochastic approximation' ,     'Numeric approximation algorithms' ,     'Mathematical optimization' ,     'Discrete optimization' ,     'Network optimization' ,     'Optimization with randomized search heuristics' ,     'Simulated annealing' ,     'Evolutionary algorithms' ,     'Tabu search' ,     'Randomized local search' ,     'Continuous optimization' ,     'Linear programming' ,     'Semidefinite programming' ,     'Convex optimization' ,     'Quasiconvex programming and unimodality' ,     'Stochastic control and optimization' ,     'Quadratic programming' ,     'Nonconvex optimization' ,     'Bio-inspired optimization' ,     'Mixed discrete-continuous optimization' ,     'Submodular optimization and polymatroids' ,     'Integer programming' ,     'Bio-inspired optimization' ,     'Non-parametric optimization' ,     'Genetic programming' ,     'Developmental representations' ,     'Data structures design and analysis' ,     'Data compression' ,     'Pattern matching' ,     'Sorting and searching' ,     'Predecessor queries' ,     'Cell probe models and lower bounds' ,     'Online algorithms' ,     'Online learning algorithms' ,     'Scheduling algorithms' ,     'Caching and paging algorithms' ,     'K-server algorithms' ,     'Adversary models' ,     'Parameterized complexity and exact algorithms' ,     'Fixed parameter tractability' ,     'W hierarchy' ,     'Streaming, sublinear and near linear time algorithms' ,     'Bloom filters and hashing' ,     'Sketching and sampling' ,     'Lower bounds and information complexity' ,     'Random order and robust communication complexity' ,     'Nearest neighbor algorithms' ,     'Parallel algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Shared memory algorithms' ,     'Vector / streaming algorithms' ,     'Massively parallel algorithms' ,     'Distributed algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Algorithm design techniques' ,     'Backtracking' ,     'Branch-and-bound' ,     'Divide and conquer' ,     'Dynamic programming' ,     'Preconditioning' ,     'Concurrent algorithms' ,     'Randomness, geometry and discrete structures' ,     'Pseudorandomness and derandomization' ,     'Computational geometry' ,     'Generating random combinatorial structures' ,     'Random walks and Markov chains' ,     'Expander graphs and randomness extractors' ,     'Error-correcting codes' ,     'Random projections and metric embeddings' ,     'Random network models' ,     'Random search heuristics' ,     'Theory and algorithms for application domains' ,     'Machine learning theory' ,     'Sample complexity and generalization bounds' ,     'Boolean function learning' ,     'Unsupervised learning and clustering' ,     'Kernel methods' ,     'Support vector machines' ,     'Gaussian processes' ,     'Boosting' ,     'Bayesian analysis' ,     'Inductive inference' ,     'Online learning theory' ,     'Multi-agent learning' ,     'Models of learning' ,     'Query learning' ,     'Structured prediction' ,     'Reinforcement learning' ,     'Sequential decision making' ,     'Inverse reinforcement learning' ,     'Apprenticeship learning' ,     'Multi-agent reinforcement learning' ,     'Adversarial learning' ,     'Active learning' ,     'Semi-supervised learning' ,     'Markov decision processes' ,     'Regret bounds' ,     'Algorithmic game theory and mechanism design' ,     'Social networks' ,     'Algorithmic game theory' ,     'Algorithmic mechanism design' ,     'Solution concepts in game theory' ,     'Exact and approximate computation of equilibria' ,     'Quality of equilibria' ,     'Convergence and learning in games' ,     'Market equilibria' ,     'Computational pricing and auctions' ,     'Representations of games and their complexity' ,     'Network games' ,     'Network formation' ,     'Computational advertising theory' ,     'Database theory' ,     'Data exchange' ,     'Data provenance' ,     'Data modeling' ,     'Database query languages (principles)' ,     'Database constraints theory' ,     'Database interoperability' ,     'Data structures and algorithms for data management' ,     'Database query processing and optimization (theory)' ,     'Data integration' ,     'Logic and databases' ,     'Theory of database privacy and security' ,     'Incomplete, inconsistent, and uncertain databases' ,     'Theory of randomized search heuristics' ,     'Semantics and reasoning' ,     'Program constructs' ,     'Control primitives' ,     'Functional constructs' ,     'Object oriented constructs' ,     'Program schemes' ,     'Type structures' ,     'Program semantics' ,     'Algebraic semantics' ,     'Denotational semantics' ,     'Operational semantics' ,     'Axiomatic semantics' ,     'Action semantics' ,     'Categorical semantics' ,     'Program reasoning' ,     'Invariants' ,     'Program specifications' ,     'Pre- and post-conditions' ,     'Program verification' ,     'Program analysis' ,     'Assertions' ,     'Parsing' ,     'Abstraction' ,     'Mathematics of computing' ,     'Discrete mathematics' ,     'Combinatorics' ,     'Combinatoric problems' ,     'Permutations and combinations' ,     'Combinatorial algorithms' ,     'Generating functions' ,     'Combinatorial optimization' ,     'Combinatorics on words' ,     'Enumeration' ,     'Graph theory' ,     'Trees' ,     'Hypergraphs' ,     'Random graphs' ,     'Graph coloring' ,     'Paths and connectivity problems' ,     'Graph enumeration' ,     'Matchings and factors' ,     'Graphs and surfaces' ,     'Network flows' ,     'Spectra of graphs' ,     'Extremal graph theory' ,     'Matroids and greedoids' ,     'Graph algorithms' ,     'Approximation algorithms' ,     'Probability and statistics' ,     'Probabilistic representations' ,     'Bayesian networks' ,     'Markov networks' ,     'Factor graphs' ,     'Decision diagrams' ,     'Equational models' ,     'Causal networks' ,     'Stochastic differential equations' ,     'Nonparametric representations' ,     'Kernel density estimators' ,     'Spline models' ,     'Bayesian nonparametric models' ,     'Probabilistic inference problems' ,     'Maximum likelihood estimation' ,     'Bayesian computation' ,     'Computing most probable explanation' ,     'Hypothesis testing and confidence interval computation' ,     'Density estimation' ,     'Quantile regression' ,     'Max marginal computation' ,     'Probabilistic reasoning algorithms' ,     'Variable elimination' ,     'Loopy belief propagation' ,     'Variational methods' ,     'Expectation maximization' ,     'Markov-chain Monte Carlo methods' ,     'Gibbs sampling' ,     'Metropolis-Hastings algorithm' ,     'Simulated annealing' ,     'Markov-chain Monte Carlo convergence measures' ,     'Sequential Monte Carlo methods' ,     'Kalman filters and hidden Markov models' ,     'Resampling methods' ,     'Bootstrapping' ,     'Jackknifing' ,     'Random number generation' ,     'Probabilistic algorithms' ,     'Statistical paradigms' ,     'Queueing theory' ,     'Contingency table analysis' ,     'Regression analysis' ,     'Robust regression' ,     'Time series analysis' ,     'Survival analysis' ,     'Renewal theory' ,     'Dimensionality reduction' ,     'Cluster analysis' ,     'Statistical graphics' ,     'Exploratory data analysis' ,     'Stochastic processes' ,     'Markov processes' ,     'Nonparametric statistics' ,     'Distribution functions' ,     'Multivariate statistics' ,     'Mathematical software' ,     'Solvers' ,     'Statistical software' ,     'Mathematical software performance' ,     'Information theory' ,     'Coding theory' ,     'Mathematical analysis' ,     'Numerical analysis' ,     'Computation of transforms' ,     'Computations in finite fields' ,     'Computations on matrices' ,     'Computations on polynomials' ,     'Gröbner bases and other special bases' ,     'Number-theoretic computations' ,     'Interpolation' ,     'Numerical differentiation' ,     'Interval arithmetic' ,     'Arbitrary-precision arithmetic' ,     'Automatic differentiation' ,     'Mesh generation' ,     'Discretization' ,     'Mathematical optimization' ,     'Discrete optimization' ,     'Network optimization' ,     'Optimization with randomized search heuristics' ,     'Simulated annealing' ,     'Evolutionary algorithms' ,     'Tabu search' ,     'Randomized local search' ,     'Continuous optimization' ,     'Linear programming' ,     'Semidefinite programming' ,     'Convex optimization' ,     'Quasiconvex programming and unimodality' ,     'Stochastic control and optimization' ,     'Quadratic programming' ,     'Nonconvex optimization' ,     'Bio-inspired optimization' ,     'Mixed discrete-continuous optimization' ,     'Submodular optimization and polymatroids' ,     'Integer programming' ,     'Bio-inspired optimization' ,     'Non-parametric optimization' ,     'Genetic programming' ,     'Developmental representations' ,     'Differential equations' ,     'Ordinary differential equations' ,     'Partial differential equations' ,     'Differential algebraic equations' ,     'Differential variational inequalities' ,     'Calculus' ,     'Lambda calculus' ,     'Differential calculus' ,     'Integral calculus' ,     'Functional analysis' ,     'Approximation' ,     'Integral equations' ,     'Nonlinear equations' ,     'Quadrature' ,     'Continuous mathematics' ,     'Calculus' ,     'Lambda calculus' ,     'Differential calculus' ,     'Integral calculus' ,     'Topology' ,     'Point-set topology' ,     'Algebraic topology' ,     'Geometric topology' ,     'Continuous functions' ,     'Information systems' ,     'Data management systems' ,     'Database design and models' ,     'Relational database model' ,     'Entity relationship models' ,     'Graph-based database models' ,     'Hierarchical data models' ,     'Network data models' ,     'Physical data models' ,     'Data model extensions' ,     'Semi-structured data' ,     'Data streams' ,     'Data provenance' ,     'Incomplete data' ,     'Temporal data' ,     'Uncertainty' ,     'Inconsistent data' ,     'Data structures' ,     'Data access methods' ,     'Multidimensional range search' ,     'Data scans' ,     'Point lookups' ,     'Unidimensional range search' ,     'Proximity search' ,     'Data layout' ,     'Data compression' ,     'Data encryption' ,     'Record and block layout' ,     'Database management system engines' ,     'DBMS engine architectures' ,     'Database query processing' ,     'Query optimization' ,     'Query operators' ,     'Query planning' ,     'Join algorithms' ,     'Database transaction processing' ,     'Data locking' ,     'Transaction logging' ,     'Database recovery' ,     'Record and buffer management' ,     'Parallel and distributed DBMSs' ,     'Key-value stores' ,     'MapReduce-based systems' ,     'Relational parallel and distributed DBMSs' ,     'Triggers and rules' ,     'Database views' ,     'Integrity checking' ,     'Distributed database transactions' ,     'Distributed data locking' ,     'Deadlocks' ,     'Distributed database recovery' ,     'Main memory engines' ,     'Online analytical processing engines' ,     'Stream management' ,     'Query languages' ,     'Relational database query languages' ,     'Structured Query Language' ,     'XML query languages' ,     'XPath' ,     'XQuery' ,     'Query languages for non-relational engines' ,     'MapReduce languages' ,     'Call level interfaces' ,     'Database administration' ,     'Database utilities and tools' ,     'Database performance evaluation' ,     'Autonomous database administration' ,     'Data dictionaries' ,     'Information integration' ,     'Deduplication' ,     'Extraction, transformation and loading' ,     'Data exchange' ,     'Data cleaning' ,     'Wrappers (data mining)' ,     'Mediators and data integration' ,     'Entity resolution' ,     'Data warehouses' ,     'Federated databases' ,     'Middleware for databases' ,     'Database web servers' ,     'Application servers' ,     'Object-relational mapping facilities' ,     'Data federation tools' ,     'Data replication tools' ,     'Distributed transaction monitors' ,     'Message queues' ,     'Service buses' ,     'Enterprise application integration tools' ,     'Middleware business process managers' ,     'Information storage systems' ,     'Information storage technologies' ,     'Magnetic disks' ,     'Magnetic tapes' ,     'Optical / magneto-optical disks' ,     'Storage class memory' ,     'Flash memory' ,     'Phase change memory' ,     'Disk arrays' ,     'Tape libraries' ,     'Record storage systems' ,     'Record storage alternatives' ,     'Heap (data structure)' ,     'Hashed file organization' ,     'Indexed file organization' ,     'Linked lists' ,     'Directory structures' ,     'B-trees' ,     'Vnodes' ,     'Inodes' ,     'Extent-based file structures' ,     'Block / page strategies' ,     'Slotted pages' ,     'Intrapage space management' ,     'Interpage free-space management' ,     'Record layout alternatives' ,     'Fixed length attributes' ,     'Variable length attributes' ,     'Null values in records' ,     'Relational storage' ,     'Horizontal partitioning' ,     'Vertical partitioning' ,     'Column based storage' ,     'Hybrid storage layouts' ,     'Compression strategies' ,     'Storage replication' ,     'Mirroring' ,     'RAID' ,     'Point-in-time copies' ,     'Remote replication' ,     'Storage recovery strategies' ,     'Storage architectures' ,     'Cloud based storage' ,     'Storage network architectures' ,     'Storage area networks' ,     'Direct attached storage' ,     'Network attached storage' ,     'Distributed storage' ,     'Storage management' ,     'Hierarchical storage management' ,     'Storage virtualization' ,     'Information lifecycle management' ,     'Version management' ,     'Storage power management' ,     'Thin provisioning' ,     'Information systems applications' ,     'Enterprise information systems' ,     'Intranets' ,     'Extranets' ,     'Enterprise resource planning' ,     'Enterprise applications' ,     'Data centers' ,     'Collaborative and social computing systems and tools' ,     'Blogs' ,     'Wikis' ,     'Reputation systems' ,     'Open source software' ,     'Social networking sites' ,     'Social tagging systems' ,     'Synchronous editors' ,     'Asynchronous editors' ,     'Spatial-temporal systems' ,     'Location based services' ,     'Geographic information systems' ,     'Sensor networks' ,     'Data streaming' ,     'Global positioning systems' ,     'Decision support systems' ,     'Data warehouses' ,     'Expert systems' ,     'Data analytics' ,     'Online analytical processing' ,     'Mobile information processing systems' ,     'Process control systems' ,     'Multimedia information systems' ,     'Multimedia databases' ,     'Multimedia streaming' ,     'Multimedia content creation' ,     'Massively multiplayer online games' ,     'Data mining' ,     'Data cleaning' ,     'Collaborative filtering' ,     'Association rules' ,     'Clustering' ,     'Nearest-neighbor search' ,     'Data stream mining' ,     'Digital libraries and archives' ,     'Computational advertising' ,     'Computing platforms' ,     'World Wide Web' ,     'Web searching and information discovery' ,     'Web search engines' ,     'Web crawling' ,     'Web indexing' ,     'Page and site ranking' ,     'Spam detection' ,     'Content ranking' ,     'Collaborative filtering' ,     'Social recommendation' ,     'Personalization' ,     'Social tagging' ,     'Online advertising' ,     'Sponsored search advertising' ,     'Content match advertising' ,     'Display advertising' ,     'Social advertising' ,     'Web mining' ,     'Site wrapping' ,     'Data extraction and integration' ,     'Deep web' ,     'Surfacing' ,     'Search results deduplication' ,     'Web log analysis' ,     'Traffic analysis' ,     'Web applications' ,     'Internet communications tools' ,     'Email' ,     'Blogs' ,     'Texting' ,     'Chat' ,     'Web conferencing' ,     'Social networks' ,     'Crowdsourcing' ,     'Answer ranking' ,     'Trust' ,     'Incentive schemes' ,     'Reputation systems' ,     'Electronic commerce' ,     'Digital cash' ,     'E-commerce infrastructure' ,     'Electronic data interchange' ,     'Electronic funds transfer' ,     'Online shopping' ,     'Online banking' ,     'Secure online transactions' ,     'Online auctions' ,     'Web interfaces' ,     'Wikis' ,     'Browsers' ,     'Mashups' ,     'Web services' ,     'Simple Object Access Protocol (SOAP)' ,     'RESTful web services' ,     'Web Services Description Language (WSDL)' ,     'Universal Description Discovery and Integration (UDDI)' ,     'Service discovery and interfaces' ,     'Web data description languages' ,     'Semantic web description languages' ,     'Resource Description Framework (RDF)' ,     'Web Ontology Language (OWL)' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Information retrieval' ,     'Document representation' ,     'Document structure' ,     'Document topic models' ,     'Content analysis and feature selection' ,     'Data encoding and canonicalization' ,     'Document collection models' ,     'Ontologies' ,     'Dictionaries' ,     'Thesauri' ,     'Information retrieval query processing' ,     'Query representation' ,     'Query intent' ,     'Query log analysis' ,     'Query suggestion' ,     'Query reformulation' ,     'Users and interactive retrieval' ,     'Personalization' ,     'Task models' ,     'Search interfaces' ,     'Collaborative search' ,     'Retrieval models and ranking' ,     'Rank aggregation' ,     'Probabilistic retrieval models' ,     'Language models' ,     'Similarity measures' ,     'Learning to rank' ,     'Combination, fusion and federated search' ,     'Information retrieval diversity' ,     'Top-k retrieval in databases' ,     'Novelty in information retrieval' ,     'Retrieval tasks and goals' ,     'Question answering' ,     'Document filtering' ,     'Recommender systems' ,     'Information extraction' ,     'Sentiment analysis' ,     'Expert search' ,     'Near-duplicate and plagiarism detection' ,     'Clustering and classification' ,     'Summarization' ,     'Business intelligence' ,     'Evaluation of retrieval results' ,     'Test collections' ,     'Relevance assessment' ,     'Retrieval effectiveness' ,     'Retrieval efficiency' ,     'Presentation of retrieval results' ,     'Search engine architectures and scalability' ,     'Search engine indexing' ,     'Search index compression' ,     'Distributed retrieval' ,     'Peer-to-peer retrieval' ,     'Retrieval on mobile devices' ,     'Adversarial retrieval' ,     'Link and co-citation analysis' ,     'Searching with auxiliary databases' ,     'Specialized information retrieval' ,     'Structure and multilingual text search' ,     'Structured text search' ,     'Mathematics retrieval' ,     'Chemical and biochemical retrieval' ,     'Multilingual and cross-lingual retrieval' ,     'Multimedia and multimodal retrieval' ,     'Image search' ,     'Video search' ,     'Speech / audio search' ,     'Music retrieval' ,     'Environment-specific retrieval' ,     'Enterprise search' ,     'Desktop search' ,     'Web and social media search' ,     'Security and privacy' ,     'Cryptography' ,     'Key management' ,     'Public key (asymmetric) techniques' ,     'Digital signatures' ,     'Public key encryption' ,     'Symmetric cryptography and hash functions' ,     'Block and stream ciphers' ,     'Hash functions and message authentication codes' ,     'Cryptanalysis and other attacks' ,     'Information-theoretic techniques' ,     'Mathematical foundations of cryptography' ,     'Formal methods and theory of security' ,     'Trust frameworks' ,     'Security requirements' ,     'Formal security models' ,     'Logic and verification' ,     'Security services' ,     'Authentication' ,     'Biometrics' ,     'Graphical / visual passwords' ,     'Multi-factor authentication' ,     'Access control' ,     'Pseudonymity, anonymity and untraceability' ,     'Privacy-preserving protocols' ,     'Digital rights management' ,     'Authorization' ,     'Intrusion/anomaly detection and malware mitigation' ,     'Malware and its mitigation' ,     'Intrusion detection systems' ,     'Artificial immune systems' ,     'Social engineering attacks' ,     'Spoofing attacks' ,     'Phishing' ,     'Security in hardware' ,     'Tamper-proof and tamper-resistant designs' ,     'Embedded systems security' ,     'Hardware security implementation' ,     'Hardware-based security protocols' ,     'Hardware attacks and countermeasures' ,     'Malicious design modifications' ,     'Side-channel analysis and countermeasures' ,     'Hardware reverse engineering' ,     'Systems security' ,     'Operating systems security' ,     'Mobile platform security' ,     'Trusted computing' ,     'Virtualization and security' ,     'Browser security' ,     'Distributed systems security' ,     'Information flow control' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Vulnerability management' ,     'Penetration testing' ,     'Vulnerability scanners' ,     'File system security' ,     'Network security' ,     'Security protocols' ,     'Web protocol security' ,     'Mobile and wireless security' ,     'Denial-of-service attacks' ,     'Firewalls' ,     'Database and storage security' ,     'Data anonymization and sanitization' ,     'Management and querying of encrypted data' ,     'Information accountability and usage control' ,     'Database activity monitoring' ,     'Software and application security' ,     'Software security engineering' ,     'Web application security' ,     'Social network security and privacy' ,     'Domain-specific security and privacy architectures' ,     'Software reverse engineering' ,     'Human and societal aspects of security and privacy' ,     'Economics of security and privacy' ,     'Social aspects of security and privacy' ,     'Privacy protections' ,     'Usability in security and privacy' ,     'Human-centered computing' ,     'Human computer interaction (HCI)' ,     'HCI design and evaluation methods' ,     'User models' ,     'User studies' ,     'Usability testing' ,     'Heuristic evaluations' ,     'Walkthrough evaluations' ,     'Laboratory experiments' ,     'Field studies' ,     'Interaction paradigms' ,     'Hypertext / hypermedia' ,     'Mixed / augmented reality' ,     'Command line interfaces' ,     'Graphical user interfaces' ,     'Virtual reality' ,     'Web-based interaction' ,     'Natural language interfaces' ,     'Collaborative interaction' ,     'Interaction devices' ,     'Graphics input devices' ,     'Displays and imagers' ,     'Sound-based input / output' ,     'Keyboards' ,     'Pointing devices' ,     'Touch screens' ,     'Haptic devices' ,     'HCI theory, concepts and models' ,     'Interaction techniques' ,     'Auditory feedback' ,     'Text input' ,     'Pointing' ,     'Gestural input' ,     'Interactive systems and tools' ,     'User interface management systems' ,     'User interface programming' ,     'User interface toolkits' ,     'Empirical studies in HCI' ,     'Interaction design' ,     'Interaction design process and methods' ,     'User interface design' ,     'User centered design' ,     'Activity centered design' ,     'Scenario-based design' ,     'Participatory design' ,     'Contextual design' ,     'Interface design prototyping' ,     'Interaction design theory, concepts and paradigms' ,     'Empirical studies in interaction design' ,     'Systems and tools for interaction design' ,     'Wireframes' ,     'Collaborative and social computing' ,     'Collaborative and social computing theory, concepts and paradigms' ,     'Social content sharing' ,     'Collaborative content creation' ,     'Collaborative filtering' ,     'Social recommendation' ,     'Social networks' ,     'Social tagging' ,     'Computer supported cooperative work' ,     'Social engineering (social sciences)' ,     'Social navigation' ,     'Social media' ,     'Collaborative and social computing design and evaluation methods' ,     'Social network analysis' ,     'Ethnographic studies' ,     'Collaborative and social computing systems and tools' ,     'Blogs' ,     'Wikis' ,     'Reputation systems' ,     'Open source software' ,     'Social networking sites' ,     'Social tagging systems' ,     'Synchronous editors' ,     'Asynchronous editors' ,     'Empirical studies in collaborative and social computing' ,     'Collaborative and social computing devices' ,     'Ubiquitous and mobile computing' ,     'Ubiquitous and mobile computing theory, concepts and paradigms' ,     'Ubiquitous computing' ,     'Mobile computing' ,     'Ambient intelligence' ,     'Ubiquitous and mobile computing systems and tools' ,     'Ubiquitous and mobile devices' ,     'Smartphones' ,     'Interactive whiteboards' ,     'Mobile phones' ,     'Mobile devices' ,     'Portable media players' ,     'Personal digital assistants' ,     'Handheld game consoles' ,     'E-book readers' ,     'Tablet computers' ,     'Ubiquitous and mobile computing design and evaluation methods' ,     'Empirical studies in ubiquitous and mobile computing' ,     'Visualization' ,     'Visualization techniques' ,     'Treemaps' ,     'Hyperbolic trees' ,     'Heat maps' ,     'Graph drawings' ,     'Dendrograms' ,     'Cladograms' ,     'Visualization application domains' ,     'Scientific visualization' ,     'Visual analytics' ,     'Geographic visualization' ,     'Information visualization' ,     'Visualization systems and tools' ,     'Visualization toolkits' ,     'Visualization theory, concepts and paradigms' ,     'Empirical studies in visualization' ,     'Visualization design and evaluation methods' ,     'Accessibility' ,     'Accessibility theory, concepts and paradigms' ,     'Empirical studies in accessibility' ,     'Accessibility design and evaluation methods' ,     'Accessibility technologies' ,     'Accessibility systems and tools' ,     'Computing methodologies' ,     'Symbolic and algebraic manipulation' ,     'Symbolic and algebraic algorithms' ,     'Combinatorial algorithms' ,     'Algebraic algorithms' ,     'Nonalgebraic algorithms' ,     'Symbolic calculus algorithms' ,     'Exact arithmetic algorithms' ,     'Hybrid symbolic-numeric methods' ,     'Discrete calculus algorithms' ,     'Number theory algorithms' ,     'Equation and inequality solving algorithms' ,     'Linear algebra algorithms' ,     'Theorem proving algorithms' ,     'Boolean algebra algorithms' ,     'Optimization algorithms' ,     'Computer algebra systems' ,     'Special-purpose algebraic systems' ,     'Representation of mathematical objects' ,     'Representation of exact numbers' ,     'Representation of mathematical functions' ,     'Representation of Boolean functions' ,     'Representation of polynomials' ,     'Parallel computing methodologies' ,     'Parallel algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Shared memory algorithms' ,     'Vector / streaming algorithms' ,     'Massively parallel algorithms' ,     'Parallel programming languages' ,     'Artificial intelligence' ,     'Natural language processing' ,     'Information extraction' ,     'Machine translation' ,     'Discourse, dialogue and pragmatics' ,     'Natural language generation' ,     'Speech recognition' ,     'Lexical semantics' ,     'Phonology / morphology' ,     'Language resources' ,     'Knowledge representation and reasoning' ,     'Description logics' ,     'Semantic networks' ,     'Nonmonotonic, default reasoning and belief revision' ,     'Probabilistic reasoning' ,     'Vagueness and fuzzy logic' ,     'Causal reasoning and diagnostics' ,     'Temporal reasoning' ,     'Cognitive robotics' ,     'Ontology engineering' ,     'Logic programming and answer set programming' ,     'Spatial and physical reasoning' ,     'Reasoning about belief and knowledge' ,     'Planning and scheduling' ,     'Planning for deterministic actions' ,     'Planning under uncertainty' ,     'Multi-agent planning' ,     'Planning with abstraction and generalization' ,     'Robotic planning' ,     'Evolutionary robotics' ,     'Search methodologies' ,     'Heuristic function construction' ,     'Discrete space search' ,     'Continuous space search' ,     'Randomized search' ,     'Game tree search' ,     'Abstraction and micro-operators' ,     'Search with partial observations' ,     'Control methods' ,     'Robotic planning' ,     'Evolutionary robotics' ,     'Computational control theory' ,     'Motion path planning' ,     'Philosophical/theoretical foundations of artificial intelligence' ,     'Cognitive science' ,     'Theory of mind' ,     'Distributed artificial intelligence' ,     'Multi-agent systems' ,     'Intelligent agents' ,     'Mobile agents' ,     'Cooperation and coordination' ,     'Computer vision' ,     'Computer vision tasks' ,     'Biometrics' ,     'Scene understanding' ,     'Activity recognition and understanding' ,     'Video summarization' ,     'Visual content-based indexing and retrieval' ,     'Visual inspection' ,     'Vision for robotics' ,     'Scene anomaly detection' ,     'Image and video acquisition' ,     'Camera calibration' ,     'Epipolar geometry' ,     'Computational photography' ,     'Hyperspectral imaging' ,     'Motion capture' ,     '3D imaging' ,     'Active vision' ,     'Computer vision representations' ,     'Image representations' ,     'Shape representations' ,     'Appearance and texture representations' ,     'Hierarchical representations' ,     'Computer vision problems' ,     'Interest point and salient region detections' ,     'Image segmentation' ,     'Video segmentation' ,     'Shape inference' ,     'Object detection' ,     'Object recognition' ,     'Object identification' ,     'Tracking' ,     'Reconstruction' ,     'Matching' ,     'Machine learning' ,     'Learning paradigms' ,     'Supervised learning' ,     'Ranking' ,     'Learning to rank' ,     'Supervised learning by classification' ,     'Supervised learning by regression' ,     'Structured outputs' ,     'Cost-sensitive learning' ,     'Unsupervised learning' ,     'Cluster analysis' ,     'Anomaly detection' ,     'Mixture modeling' ,     'Topic modeling' ,     'Source separation' ,     'Motif discovery' ,     'Dimensionality reduction and manifold learning' ,     'Reinforcement learning' ,     'Sequential decision making' ,     'Inverse reinforcement learning' ,     'Apprenticeship learning' ,     'Multi-agent reinforcement learning' ,     'Adversarial learning' ,     'Multi-task learning' ,     'Transfer learning' ,     'Lifelong machine learning' ,     'Learning under covariate shift' ,     'Learning settings' ,     'Batch learning' ,     'Online learning settings' ,     'Learning from demonstrations' ,     'Learning from critiques' ,     'Learning from implicit feedback' ,     'Active learning settings' ,     'Semi-supervised learning settings' ,     'Machine learning approaches' ,     'Classification and regression trees' ,     'Kernel methods' ,     'Support vector machines' ,     'Gaussian processes' ,     'Neural networks' ,     'Logical and relational learning' ,     'Inductive logic learning' ,     'Statistical relational learning' ,     'Learning in probabilistic graphical models' ,     'Maximum likelihood modeling' ,     'Maximum entropy modeling' ,     'Maximum a posteriori modeling' ,     'Mixture models' ,     'Latent variable models' ,     'Bayesian network models' ,     'Learning linear models' ,     'Perceptron algorithm' ,     'Factorization methods' ,     'Non-negative matrix factorization' ,     'Factor analysis' ,     'Principal component analysis' ,     'Canonical correlation analysis' ,     'Latent Dirichlet allocation' ,     'Rule learning' ,     'Instance-based learning' ,     'Markov decision processes' ,     'Partially-observable Markov decision processes' ,     'Stochastic games' ,     'Learning latent representations' ,     'Deep belief networks' ,     'Bio-inspired approaches' ,     'Artificial life' ,     'Evolvable hardware' ,     'Genetic algorithms' ,     'Genetic programming' ,     'Evolutionary robotics' ,     'Generative and developmental approaches' ,     'Machine learning algorithms' ,     'Dynamic programming for Markov decision processes' ,     'Value iteration' ,     'Q-learning' ,     'Policy iteration' ,     'Temporal difference learning' ,     'Approximate dynamic programming methods' ,     'Ensemble methods' ,     'Boosting' ,     'Bagging' ,     'Spectral methods' ,     'Feature selection' ,     'Regularization' ,     'Cross-validation' ,     'Modeling and simulation' ,     'Model development and analysis' ,     'Modeling methodologies' ,     'Model verification and validation' ,     'Uncertainty quantification' ,     'Simulation theory' ,     'Systems theory' ,     'Network science' ,     'Simulation types and techniques' ,     'Uncertainty quantification' ,     'Quantum mechanic simulation' ,     'Molecular simulation' ,     'Rare-event simulation' ,     'Discrete-event simulation' ,     'Agent / discrete models' ,     'Distributed simulation' ,     'Continuous simulation' ,     'Continuous models' ,     'Real-time simulation' ,     'Interactive simulation' ,     'Multiscale systems' ,     'Massively parallel and high-performance simulations' ,     'Data assimilation' ,     'Scientific visualization' ,     'Visual analytics' ,     'Simulation by animation' ,     'Artificial life' ,     'Simulation support systems' ,     'Simulation environments' ,     'Simulation languages' ,     'Simulation tools' ,     'Simulation evaluation' ,     'Computer graphics' ,     'Animation' ,     'Motion capture' ,     'Procedural animation' ,     'Physical simulation' ,     'Motion processing' ,     'Collision detection' ,     'Rendering' ,     'Rasterization' ,     'Ray tracing' ,     'Non-photorealistic rendering' ,     'Reflectance modeling' ,     'Visibility' ,     'Image manipulation' ,     'Computational photography' ,     'Image processing' ,     'Texturing' ,     'Image-based rendering' ,     'Antialiasing' ,     'Graphics systems and interfaces' ,     'Graphics processors' ,     'Graphics input devices' ,     'Mixed / augmented reality' ,     'Perception' ,     'Graphics file formats' ,     'Virtual reality' ,     'Image compression' ,     'Shape modeling' ,     'Mesh models' ,     'Mesh geometry models' ,     'Parametric curve and surface models' ,     'Point-based models' ,     'Volumetric models' ,     'Shape analysis' ,     'Distributed computing methodologies' ,     'Distributed algorithms' ,     'MapReduce algorithms' ,     'Self-organization' ,     'Distributed programming languages' ,     'Concurrent computing methodologies' ,     'Concurrent programming languages' ,     'Concurrent algorithms' ,     'Applied computing' ,     'Electronic commerce' ,     'Digital cash' ,     'E-commerce infrastructure' ,     'Electronic data interchange' ,     'Electronic funds transfer' ,     'Online shopping' ,     'Online banking' ,     'Secure online transactions' ,     'Online auctions' ,     'Enterprise computing' ,     'Enterprise information systems' ,     'Intranets' ,     'Extranets' ,     'Enterprise resource planning' ,     'Enterprise applications' ,     'Data centers' ,     'Business process management' ,     'Business process modeling' ,     'Business process management systems' ,     'Business process monitoring' ,     'Cross-organizational business processes' ,     'Business intelligence' ,     'Enterprise architectures' ,     'Enterprise architecture management' ,     'Enterprise architecture frameworks' ,     'Enterprise architecture modeling' ,     'Service-oriented architectures' ,     'Event-driven architectures' ,     'Business rules' ,     'Enterprise modeling' ,     'Enterprise ontologies, taxonomies and vocabularies' ,     'Enterprise data management' ,     'Reference models' ,     'Business-IT alignment' ,     'IT architectures' ,     'IT governance' ,     'Enterprise computing infrastructures' ,     'Enterprise interoperability' ,     'Enterprise application integration' ,     'Information integration and interoperability' ,     'Physical sciences and engineering' ,     'Aerospace' ,     'Avionics' ,     'Archaeology' ,     'Astronomy' ,     'Chemistry' ,     'Earth and atmospheric sciences' ,     'Environmental sciences' ,     'Engineering' ,     'Computer-aided design' ,     'Physics' ,     'Mathematics and statistics' ,     'Electronics' ,     'Avionics' ,     'Telecommunications' ,     'Internet telephony' ,     'Life and medical sciences' ,     'Computational biology' ,     'Molecular sequence analysis' ,     'Recognition of genes and regulatory elements' ,     'Molecular evolution' ,     'Computational transcriptomics' ,     'Biological networks' ,     'Sequencing and genotyping technologies' ,     'Imaging' ,     'Computational proteomics' ,     'Molecular structural biology' ,     'Computational genomics' ,     'Genomics' ,     'Computational genomics' ,     'Systems biology' ,     'Consumer health' ,     'Health care information systems' ,     'Health informatics' ,     'Bioinformatics' ,     'Metabolomics / metabonomics' ,     'Genetics' ,     'Population genetics' ,     'Proteomics' ,     'Computational proteomics' ,     'Transcriptomics' ,     'Law, social and behavioral sciences' ,     'Anthropology' ,     'Ethnography' ,     'Law' ,     'Psychology' ,     'Economics' ,     'Sociology' ,     'Computer forensics' ,     'Surveillance mechanisms' ,     'Investigation techniques' ,     'Evidence collection, storage and analysis' ,     'Network forensics' ,     'System forensics' ,     'Data recovery' ,     'Arts and humanities' ,     'Fine arts' ,     'Performing arts' ,     'Architecture (buildings)' ,     'Computer-aided design' ,     'Language translation' ,     'Media arts' ,     'Sound and music computing' ,     'Computers in other domains' ,     'Digital libraries and archives' ,     'Publishing' ,     'Military' ,     'Cyberwarfare' ,     'Cartography' ,     'Agriculture' ,     'Computing in government' ,     'Voting / election technologies' ,     'E-government' ,     'Personal computers and PC applications' ,     'Word processors' ,     'Spreadsheets' ,     'Computer games' ,     'Microcomputers' ,     'Operations research' ,     'Consumer products' ,     'Industry and manufacturing' ,     'Supply chain management' ,     'Command and control' ,     'Computer-aided manufacturing' ,     'Decision analysis' ,     'Multi-criterion optimization and decision-making' ,     'Transportation' ,     'Forecasting' ,     'Marketing' ,     'Education' ,     'Digital libraries and archives' ,     'Computer-assisted instruction' ,     'Interactive learning environments' ,     'Collaborative learning' ,     'Learning management systems' ,     'Distance learning' ,     'E-learning' ,     'Computer-managed instruction' ,     'Document management and text processing' ,     'Document searching' ,     'Document management' ,     'Text editing' ,     'Version control' ,     'Document metadata' ,     'Document capture' ,     'Document analysis' ,     'Document scanning' ,     'Graphics recognition and interpretation' ,     'Optical character recognition' ,     'Online handwriting recognition' ,     'Document preparation' ,     'Markup languages' ,     'Extensible Markup Language (XML)' ,     'Hypertext languages' ,     'Annotation' ,     'Format and notation' ,     'Multi / mixed media creation' ,     'Image composition' ,     'Hypertext / hypermedia creation' ,     'Document scripting languages' ,     'Social and professional topics' ,     'Professional topics' ,     'Computing industry' ,     'Industry statistics' ,     'Computer manufacturing' ,     'Sustainability' ,     'Management of computing and information systems' ,     'Project and people management' ,     'Project management techniques' ,     'Project staffing' ,     'Systems planning' ,     'Systems analysis and design' ,     'Systems development' ,     'Computer and information systems training' ,     'Implementation management' ,     'Hardware selection' ,     'Computing equipment management' ,     'Pricing and resource allocation' ,     'Software management' ,     'Software maintenance' ,     'Software selection and adaptation' ,     'System management' ,     'Centralization / decentralization' ,     'Technology audits' ,     'Quality assurance' ,     'Network operations' ,     'File systems management' ,     'Information system economics' ,     'History of computing' ,     'Historical people' ,     'History of hardware' ,     'History of software' ,     'History of programming languages' ,     'History of computing theory' ,     'Computing education' ,     'Computational thinking' ,     'Accreditation' ,     'Model curricula' ,     'Computing education programs' ,     'Information systems education' ,     'Computer science education' ,     'CS1' ,     'Computer engineering education' ,     'Information technology education' ,     'Information science education' ,     'Computational science and engineering education' ,     'Software engineering education' ,     'Informal education' ,     'Computing literacy' ,     'Student assessment' ,     'K-12 education' ,     'Adult education' ,     'Computing and business' ,     'Employment issues' ,     'Automation' ,     'Computer supported cooperative work' ,     'Economic impact' ,     'Offshoring' ,     'Reengineering' ,     'Socio-technical systems' ,     'Computing profession' ,     'Codes of ethics' ,     'Employment issues' ,     'Funding' ,     'Computing occupations' ,     'Computing organizations' ,     'Testing, certification and licensing' ,     'Assistive technologies' ,     'Computing / technology policy' ,     'Intellectual property' ,     'Digital rights management' ,     'Copyrights' ,     'Software reverse engineering' ,     'Patents' ,     'Trademarks' ,     'Internet governance / domain names' ,     'Licensing' ,     'Treaties' ,     'Database protection laws' ,     'Secondary liability' ,     'Soft intellectual property' ,     'Hardware reverse engineering' ,     'Privacy policies' ,     'Censorship' ,     'Pornography' ,     'Hate speech' ,     'Political speech' ,     'Technology and censorship' ,     'Censoring filters' ,     'Surveillance' ,     'Governmental surveillance' ,     'Corporate surveillance' ,     'Commerce policy' ,     'Taxation' ,     'Transborder data flow' ,     'Antitrust and competition' ,     'Governmental regulations' ,     'Online auctions policy' ,     'Consumer products policy' ,     'Network access control' ,     'Censoring filters' ,     'Broadband access' ,     'Net neutrality' ,     'Network access restrictions' ,     'Age-based restrictions' ,     'Acceptable use policy restrictions' ,     'Universal access' ,     'Computer crime' ,     'Social engineering attacks' ,     'Spoofing attacks' ,     'Phishing' ,     'Identity theft' ,     'Financial crime' ,     'Malware / spyware crime' ,     'Government technology policy' ,     'Governmental regulations' ,     'Import / export controls' ,     'Medical information policy' ,     'Medical records' ,     'Personal health records' ,     'Genetic information' ,     'Patient privacy' ,     'Health information exchanges' ,     'Medical technologies' ,     'Remote medicine' ,     'User characteristics' ,     'Race and ethnicity' ,     'Religious orientation' ,     'Gender' ,     'Men' ,     'Women' ,     'Sexual orientation' ,     'People with disabilities' ,     'Geographic characteristics' ,     'Cultural characteristics' ,     'Age' ,     'Children' ,     'Seniors' ,     'Adolescents' );
        if(!in_array($tagDeAdaugat, $arrayToateTagurile) )  //tagul nu e valid
        {
          return "Tagul nu este valid conform ACM CCS!";          
        }

        foreach ($result->records() as $record) 
          if( $record->get('nod')->get('nume') != null )  //exista
          {
            $con=mysqli_connect("Localhost", "root" ,"", "licenta");

            $query = $con->prepare("SELECT * from  taguri where nume_concept=? and tag=?");  //facem prepare la query, ordonat dupa time desc by default
            $query->bind_param("ss",$this->denumire, $tagDeAdaugat);  //bind-uim parametrii
            $query->execute(); //executam query-ul
            $result=$query->get_result();

            if($result->num_rows>=1)  //am gasit perechea
            {
               $con->close();
               return "Exista deja tagul specificat pentru conceptul dat!";
            }

            $query = $con->prepare("insert into taguri(nume_concept,tag) values(?,?)");  //facem prepare la query, ordonat dupa time desc by default
            $query->bind_param("ss",$this->denumire, $tagDeAdaugat);  //bind-uim parametrii
            $query->execute(); //executam query-ul
            
            if(mysqli_affected_rows($con)==1)
            {
              $con->close();
              return "Tag adaugat!";
            }
            else
            {
              $con->close();
              return "Eroare!";
            }

          }
          
          //daca ajunge aici=> nu exista
          return "Conceptul cu numele dat nu exista!";
        
      
      }

      public function getToateConcepteleInnerSelect()
      {
        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query = 'MATCH (n:Concept) RETURN DISTINCT n , labels(n) as labels ORDER BY n.nume';
       //echo $query;
       
       $result = $client->run($query);

       $rezultatFinal='';
       foreach ($result->records() as $record) 
       {
         $toPush=array();
         $toPush['nume']= $record->get('n')->get('nume')  ;//vom avea numele tuturor nodurilor la care se poate ajunge plecand din $numeConcept
         $toPush['labels']= $record->get('labels')  ;

         if(!in_array("Materie",$toPush['labels']))  //doar daca n-are Materie ca label
              {
                $rezultatFinal=$rezultatFinal . '<option>' . $toPush['nume'] . '</option>' ;
              }  
       }

       return $rezultatFinal;
      }


      public function aflaMateriaCorespunzatoareConceptului()
      {
        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query = "MATCH p=shortestPath((conceptSelectat {nume:'" . $this->denumire  ."'})-[*]-(x:Materie))
        WITH length(p) AS l, collect(x.nume) as targets
        ORDER BY l
        LIMIT 1
        UNWIND targets as target
        RETURN target";
       
       $result = $client->run($query);

       $rezultatFinal=array();

       foreach ($result->records() as $record) 
       {   if( $record->get('target') != null )  //nu este izolat
           {
            $toPush=array();
            $toPush['nume']= $record->get('target')  ;
            //$toPush['descriere']= $record->get('nodVecin')->get('descriere')  ;
            array_push($rezultatFinal,$toPush);
           }
           else
           {
             $rezultatFinal="Eroare!";
           }
           
       }
       
       return $rezultatFinal;

      }

      public function numaraTagurile()
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = "SELECT tag,COUNT(tag) AS aparitii FROM taguri GROUP BY tag ORDER BY aparitii DESC";  //facem prepare la query, ordonat dupa time desc by default

        $result = mysqli_query($con, $query); //executam query-ul

        if($result->num_rows==0)
        {
          $con->close();
          return "Eroare!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
            $row['tag']=stripslashes( $row['tag']);
            array_push($array,$row);
          }

          $con->close();
          return $array;
        }
      }

      public function numaraComentarii()
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = "SELECT nume_user,COUNT(nume_user) AS aparitii FROM comentarii GROUP BY nume_user ORDER BY aparitii DESC";  //facem prepare la query, ordonat dupa time desc by default

        $result = mysqli_query($con, $query); //executam query-ul

        if($result->num_rows==0)
        {
          $con->close();
          return "Eroare!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
            $row['nume_user']=stripslashes( $row['nume_user']);
            array_push($array,$row);
          }

          $con->close();
          return $array;
        }
      }

      public function numaraRelatii()
      {
        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:parola@localhost:7474') // Example for HTTP connection configuration (port is optional)
        ->build();

        $query = "MATCH (u:Concept)-[*1..1]-(m:Concept) WHERE size(labels(u)) = 1 RETURN u.nume, count(m) as aparitii ORDER BY count(m)";
       
       $result = $client->run($query);

       $rezultatFinal=array();

       foreach ($result->records() as $record) 
       {   
        $array=array(); 
        if( $record->get('u.nume') != null )
           {
             array_push($array,$record->get('u.nume'));
             array_push($array,$record->get('aparitii'));
             array_push($rezultatFinal,$array);
           }
           else
           {
            return "Eroare!";
           }

      }

       return $rezultatFinal;
      
    }
    
    
    public function numaraTagurilePerConcept()
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = "SELECT nume_concept,COUNT(nume_concept) AS nr_taguri FROM taguri GROUP BY nume_concept ORDER BY nr_taguri DESC";  //facem prepare la query, ordonat dupa time desc by default

        $result = mysqli_query($con, $query); //executam query-ul

        if($result->num_rows==0)
        {
          $con->close();
          return "Eroare!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
            $row['nume_concept']=stripslashes( $row['nume_concept']);
            array_push($array,$row);
          }

          $con->close();
          return $array;
        }
      }

      public function numaraComentariiPerConcept()
      {
        $con=mysqli_connect("Localhost", "root" ,"", "licenta");
        $query = "SELECT nume_concept,COUNT(nume_concept) AS nr_comentarii FROM comentarii GROUP BY nume_concept ORDER BY nr_comentarii DESC";  //facem prepare la query, ordonat dupa time desc by default

        $result = mysqli_query($con, $query); //executam query-ul

        if($result->num_rows==0)
        {
          $con->close();
          return "Eroare!";
        }
        else
        {
          $array = array();
          while($row=$result->fetch_assoc())
          {
            $row['nume_concept']=stripslashes( $row['nume_concept']);
            array_push($array,$row);
          }

          $con->close();
          return $array;
        }
      }

      

      
}

?>