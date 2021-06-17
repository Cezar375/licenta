<?php

require_once 'core/App.php';
require_once 'core/Controller.php';
session_start();

if(!isset($_SESSION['logat'])) //daca nu e setata deja, ca sa nu se schimbe cand dau refresh la pagina 
 $_SESSION['logat']="false"; //initializam cu false sesiunea pt loggedIn

if(!isset($_SESSION['userID']))
 $_SESSION['userID']=-1;

 if(!isset($_SESSION['privileges']))
 $_SESSION['privileges']="student";

if(!isset($_SESSION['numeUtilizator']))
 $_SESSION['numeUtilizator']=-1;

if(!isset($_SESSION['optionsCSV']))
{
    $_SESSION['optionsCSV']='<option>General and reference</option>
    <option>Document types</option>
    <option>Surveys and overviews</option>
    <option>Reference works</option>
    <option>General conference proceedings</option>
    <option>Biographies</option>
    <option>General literature</option>
    <option>Computing standards, RFCs and guidelines</option>
    <option>Cross-computing tools and techniques</option>
    <option>Reliability</option>
    <option>Empirical studies</option>
    <option>Measurement</option>
    <option>Metrics</option>
    <option>Evaluation</option>
    <option>Experimentation</option>
    <option>Estimation</option>
    <option>Design</option>
    <option>Performance</option>
    <option>Validation</option>
    <option>Verification</option>
    <option>Hardware</option>
    <option>Printed circuit boards</option>
    <option>Electromagnetic interference and compatibility</option>
    <option>PCB design and layout</option>
    <option>Communication hardware, interfaces and storage</option>
    <option>Signal processing systems</option>
    <option>Digital signal processing</option>
    <option>Beamforming</option>
    <option>Noise reduction</option>
    <option>Sensors and actuators</option>
    <option>Buses and high-speed links</option>
    <option>Displays and imagers</option>
    <option>External storage</option>
    <option>Networking hardware</option>
    <option>Printers</option>
    <option>Sensor applications and deployments</option>
    <option>Sensor devices and platforms</option>
    <option>Sound-based input / output</option>
    <option>Tactile and hand-based interfaces</option>
    <option>Touch screens</option>
    <option>Haptic devices</option>
    <option>Scanners</option>
    <option>Wireless devices</option>
    <option>Wireless integrated network sensors</option>
    <option>Electro-mechanical devices</option>
    <option>Integrated circuits</option>
    <option>3D integrated circuits</option>
    <option>Interconnect</option>
    <option>Input / output circuits</option>
    <option>Metallic interconnect</option>
    <option>Photonic and optical interconnect</option>
    <option>Radio frequency and wireless interconnect</option>
    <option>Semiconductor memory</option>
    <option>Dynamic memory</option>
    <option>Static memory</option>
    <option>Non-volatile memory</option>
    <option>Read-only memory</option>
    <option>Digital switches</option>
    <option>Transistors</option>
    <option>Logic families</option>
    <option>Logic circuits</option>
    <option>Arithmetic and datapath circuits</option>
    <option>Asynchronous circuits</option>
    <option>Combinational circuits</option>
    <option>Design modules and hierarchy</option>
    <option>Finite state machines</option>
    <option>Sequential circuits</option>
    <option>Reconfigurable logic and FPGAs</option>
    <option>Hardware accelerators</option>
    <option>High-speed input / output</option>
    <option>Programmable logic elements</option>
    <option>Programmable interconnect</option>
    <option>Reconfigurable logic applications</option>
    <option>Evolvable hardware</option>
    <option>Very large scale integration design</option>
    <option>3D integrated circuits</option>
    <option>Analog and mixed-signal circuits</option>
    <option>Data conversion</option>
    <option>Clock generation and timing</option>
    <option>Analog and mixed-signal circuit optimization</option>
    <option>Radio frequency and wireless circuits</option>
    <option>Wireline communication</option>
    <option>Analog and mixed-signal circuit synthesis</option>
    <option>Application-specific VLSI designs</option>
    <option>Application specific integrated circuits</option>
    <option>Application specific instruction set processors</option>
    <option>Application specific processors</option>
    <option>Design reuse and communication-based design</option>
    <option>Network on chip</option>
    <option>System on a chip</option>
    <option>Platform-based design</option>
    <option>Hard and soft IP</option>
    <option>Design rules</option>
    <option>Economics of chip design and manufacturing</option>
    <option>Full-custom circuits</option>
    <option>VLSI design manufacturing considerations</option>
    <option>On-chip resource management</option>
    <option>On-chip sensors</option>
    <option>Standard cell libraries</option>
    <option>VLSI packaging</option>
    <option>Die and wafer stacking</option>
    <option>Input / output styles</option>
    <option>Multi-chip modules</option>
    <option>Package-level interconnect</option>
    <option>VLSI system specification and constraints</option>
    <option>Power and energy</option>
    <option>Thermal issues</option>
    <option>Temperature monitoring</option>
    <option>Temperature simulation and estimation</option>
    <option>Temperature control</option>
    <option>Temperature optimization</option>
    <option>Energy generation and storage</option>
    <option>Batteries</option>
    <option>Fuel-based energy</option>
    <option>Renewable energy</option>
    <option>Reusable energy storage</option>
    <option>Energy distribution</option>
    <option>Energy metering</option>
    <option>Power conversion</option>
    <option>Power networks</option>
    <option>Smart grid</option>
    <option>Impact on the environment</option>
    <option>Power estimation and optimization</option>
    <option>Switching devices power issues</option>
    <option>Interconnect power issues</option>
    <option>Circuits power issues</option>
    <option>Chip-level power issues</option>
    <option>Platform power issues</option>
    <option>Enterprise level and data centers power issues</option>
    <option>Electronic design automation</option>
    <option>High-level and register-transfer level synthesis</option>
    <option>Datapath optimization</option>
    <option>Hardware-software codesign</option>
    <option>Resource binding and sharing</option>
    <option>Operations scheduling</option>
    <option>Hardware description languages and compilation</option>
    <option>Logic synthesis</option>
    <option>Combinational synthesis</option>
    <option>Circuit optimization</option>
    <option>Sequential synthesis</option>
    <option>Technology-mapping</option>
    <option>Transistor-level synthesis</option>
    <option>Modeling and parameter extraction</option>
    <option>Physical design (EDA)</option>
    <option>Clock-network synthesis</option>
    <option>Packaging</option>
    <option>Partitioning and floorplanning</option>
    <option>Placement</option>
    <option>Physical synthesis</option>
    <option>Power grid design</option>
    <option>Wire routing</option>
    <option>Timing analysis</option>
    <option>Electrical-level simulation</option>
    <option>Model-order reduction</option>
    <option>Compact delay models</option>
    <option>Static timing analysis</option>
    <option>Statistical timing analysis</option>
    <option>Transition-based timing analysis</option>
    <option>Methodologies for EDA</option>
    <option>Best practices for EDA</option>
    <option>Design databases for EDA</option>
    <option>Software tools for EDA</option>
    <option>Hardware validation</option>
    <option>Functional verification</option>
    <option>Model checking</option>
    <option>Coverage metrics</option>
    <option>Equivalence checking</option>
    <option>Semi-formal verification</option>
    <option>Simulation and emulation</option>
    <option>Transaction-level verification</option>
    <option>Theorem proving and SAT solving</option>
    <option>Assertion checking</option>
    <option>Physical verification</option>
    <option>Design rule checking</option>
    <option>Layout-versus-schematics</option>
    <option>Power and thermal analysis</option>
    <option>Timing analysis and sign-off</option>
    <option>Post-manufacture validation and debug</option>
    <option>Bug detection, localization and diagnosis</option>
    <option>Bug fixing (hardware)</option>
    <option>Design for debug</option>
    <option>Hardware test</option>
    <option>Analog, mixed-signal and radio frequency test</option>
    <option>Board- and system-level test</option>
    <option>Defect-based test</option>
    <option>Design for testability</option>
    <option>Built-in self-test</option>
    <option>Online test and diagnostics</option>
    <option>Test data compression</option>
    <option>Fault models and test metrics</option>
    <option>Memory test and repair</option>
    <option>Hardware reliability screening</option>
    <option>Test-pattern generation and fault simulation</option>
    <option>Testing with distributed and parallel systems</option>
    <option>Robustness</option>
    <option>Fault tolerance</option>
    <option>Error detection and error correction</option>
    <option>Failure prediction</option>
    <option>Failure recovery, maintenance and self-repair</option>
    <option>Redundancy</option>
    <option>Self-checking mechanisms</option>
    <option>System-level fault tolerance</option>
    <option>Design for manufacturability</option>
    <option>Process variations</option>
    <option>Yield and cost modeling</option>
    <option>Yield and cost optimization</option>
    <option>Hardware reliability</option>
    <option>Aging of circuits and systems</option>
    <option>Circuit hardening</option>
    <option>Early-life failures and infant mortality</option>
    <option>Process, voltage and temperature variations</option>
    <option>Signal integrity and noise analysis</option>
    <option>Transient errors and upsets</option>
    <option>Safety critical systems</option>
    <option>Emerging technologies</option>
    <option>Analysis and design of emerging devices and systems</option>
    <option>Emerging architectures</option>
    <option>Emerging languages and compilers</option>
    <option>Emerging simulation</option>
    <option>Emerging tools and methodologies</option>
    <option>Biology-related information processing</option>
    <option>Bio-embedded electronics</option>
    <option>Neural systems</option>
    <option>Circuit substrates</option>
    <option>III-V compounds</option>
    <option>Carbon based electronics</option>
    <option>Cellular neural networks</option>
    <option>Flexible and printable circuits</option>
    <option>Superconducting circuits</option>
    <option>Electromechanical systems</option>
    <option>Microelectromechanical systems</option>
    <option>Nanoelectromechanical systems</option>
    <option>Emerging interfaces</option>
    <option>Memory and dense storage</option>
    <option>Emerging optical and photonic technologies</option>
    <option>Reversible logic</option>
    <option>Plasmonics</option>
    <option>Quantum technologies</option>
    <option>Single electron devices</option>
    <option>Tunneling devices</option>
    <option>Quantum computation</option>
    <option>Quantum communication and cryptography</option>
    <option>Quantum error correction and fault tolerance</option>
    <option>Quantum dots and cellular automata</option>
    <option>Spintronics and magnetic technologies</option>
    <option>Computer systems organization</option>
    <option>Architectures</option>
    <option>Serial architectures</option>
    <option>Reduced instruction set computing</option>
    <option>Complex instruction set computing</option>
    <option>Superscalar architectures</option>
    <option>Pipeline computing</option>
    <option>Stack machines</option>
    <option>Parallel architectures</option>
    <option>Very long instruction word</option>
    <option>Interconnection architectures</option>
    <option>Multiple instruction, multiple data</option>
    <option>Cellular architectures</option>
    <option>Multiple instruction, single data</option>
    <option>Single instruction, multiple data</option>
    <option>Systolic arrays</option>
    <option>Multicore architectures</option>
    <option>Distributed architectures</option>
    <option>Cloud computing</option>
    <option>Client-server architectures</option>
    <option>n-tier architectures</option>
    <option>Peer-to-peer architectures</option>
    <option>Grid computing</option>
    <option>Other architectures</option>
    <option>Neural networks</option>
    <option>Reconfigurable computing</option>
    <option>Analog computers</option>
    <option>Data flow architectures</option>
    <option>Heterogeneous (hybrid) systems</option>
    <option>Self-organizing autonomic computing</option>
    <option>Optical computing</option>
    <option>Quantum computing</option>
    <option>Molecular computing</option>
    <option>High-level language architectures</option>
    <option>Special purpose systems</option>
    <option>Embedded and cyber-physical systems</option>
    <option>Sensor networks</option>
    <option>Robotics</option>
    <option>Robotic components</option>
    <option>Robotic control</option>
    <option>Evolutionary robotics</option>
    <option>Robotic autonomy</option>
    <option>External interfaces for robotics</option>
    <option>Sensors and actuators</option>
    <option>System on a chip</option>
    <option>Embedded systems</option>
    <option>Firmware</option>
    <option>Embedded hardware</option>
    <option>Embedded software</option>
    <option>Real-time systems</option>
    <option>Real-time operating systems</option>
    <option>Real-time languages</option>
    <option>Real-time system specification</option>
    <option>Real-time system architecture</option>
    <option>Dependable and fault-tolerant systems and networks</option>
    <option>Reliability</option>
    <option>Availability</option>
    <option>Maintainability and maintenance</option>
    <option>Processors and memory architectures</option>
    <option>Secondary storage organization</option>
    <option>Redundancy</option>
    <option>Fault-tolerant network topologies</option>
    <option>Networks</option>
    <option>Network architectures</option>
    <option>Network design principles</option>
    <option>Layering</option>
    <option>Naming and addressing</option>
    <option>Programming interfaces</option>
    <option>Network protocols</option>
    <option>Network protocol design</option>
    <option>Protocol correctness</option>
    <option>Protocol testing and verification</option>
    <option>Formal specifications</option>
    <option>Link-layer protocols</option>
    <option>Network layer protocols</option>
    <option>Routing protocols</option>
    <option>Signaling protocols</option>
    <option>Transport protocols</option>
    <option>Session protocols</option>
    <option>Presentation protocols</option>
    <option>Application layer protocols</option>
    <option>Peer-to-peer protocols</option>
    <option>OAM protocols</option>
    <option>Time synchronization protocols</option>
    <option>Network policy</option>
    <option>Cross-layer protocols</option>
    <option>Network File System (NFS) protocol</option>
    <option>Network components</option>
    <option>Intermediate nodes</option>
    <option>Routers</option>
    <option>Bridges and switches</option>
    <option>Physical links</option>
    <option>Repeaters</option>
    <option>Middle boxes / network appliances</option>
    <option>End nodes</option>
    <option>Network adapters</option>
    <option>Network servers</option>
    <option>Wireless access points, base stations and infrastructure</option>
    <option>Cognitive radios</option>
    <option>Logical nodes</option>
    <option>Network domains</option>
    <option>Network algorithms</option>
    <option>Data path algorithms</option>
    <option>Packet classification</option>
    <option>Deep packet inspection</option>
    <option>Packet scheduling</option>
    <option>Control path algorithms</option>
    <option>Network resources allocation</option>
    <option>Network control algorithms</option>
    <option>Traffic engineering algorithms</option>
    <option>Network design and planning algorithms</option>
    <option>Network economics</option>
    <option>Network performance evaluation</option>
    <option>Network performance modeling</option>
    <option>Network simulations</option>
    <option>Network experimentation</option>
    <option>Network performance analysis</option>
    <option>Network measurement</option>
    <option>Network properties</option>
    <option>Network security</option>
    <option>Security protocols</option>
    <option>Web protocol security</option>
    <option>Mobile and wireless security</option>
    <option>Denial-of-service attacks</option>
    <option>Firewalls</option>
    <option>Network range</option>
    <option>Short-range networks</option>
    <option>Local area networks</option>
    <option>Metropolitan area networks</option>
    <option>Wide area networks</option>
    <option>Very long-range networks</option>
    <option>Network structure</option>
    <option>Topology analysis and generation</option>
    <option>Physical topologies</option>
    <option>Logical / virtual topologies</option>
    <option>Network topology types</option>
    <option>Point-to-point networks</option>
    <option>Bus networks</option>
    <option>Star networks</option>
    <option>Ring networks</option>
    <option>Token ring networks</option>
    <option>Fiber distributed data interface (FDDI)</option>
    <option>Mesh networks</option>
    <option>Wireless mesh networks</option>
    <option>Hybrid networks</option>
    <option>Network dynamics</option>
    <option>Network reliability</option>
    <option>Error detection and error correction</option>
    <option>Network mobility</option>
    <option>Network manageability</option>
    <option>Network privacy and anonymity</option>
    <option>Network services</option>
    <option>Naming and addressing</option>
    <option>Cloud computing</option>
    <option>Location based services</option>
    <option>Programmable networks</option>
    <option>In-network processing</option>
    <option>Network management</option>
    <option>Network monitoring</option>
    <option>Network types</option>
    <option>Network on chip</option>
    <option>Home networks</option>
    <option>Storage area networks</option>
    <option>Data center networks</option>
    <option>Wired access networks</option>
    <option>Cyber-physical networks</option>
    <option>Sensor networks</option>
    <option>Mobile networks</option>
    <option>Overlay and other logical network structures</option>
    <option>Peer-to-peer networks</option>
    <option>World Wide Web (network structure)</option>
    <option>Social media networks</option>
    <option>Online social networks</option>
    <option>Wireless access networks</option>
    <option>Wireless local area networks</option>
    <option>Wireless personal area networks</option>
    <option>Ad hoc networks</option>
    <option>Mobile ad hoc networks</option>
    <option>Public Internet</option>
    <option>Packet-switching networks</option>
    <option>Software and its engineering</option>
    <option>Software organization and properties</option>
    <option>Contextual software domains</option>
    <option>E-commerce infrastructure</option>
    <option>Software infrastructure</option>
    <option>Interpreters</option>
    <option>Middleware</option>
    <option>Message oriented middleware</option>
    <option>Reflective middleware</option>
    <option>Embedded middleware</option>
    <option>Virtual machines</option>
    <option>Operating systems</option>
    <option>File systems management</option>
    <option>Memory management</option>
    <option>Virtual memory</option>
    <option>Main memory</option>
    <option>Allocation / deallocation strategies</option>
    <option>Garbage collection</option>
    <option>Distributed memory</option>
    <option>Secondary storage</option>
    <option>Process management</option>
    <option>Scheduling</option>
    <option>Deadlocks</option>
    <option>Multithreading</option>
    <option>Multiprocessing / multiprogramming / multitasking</option>
    <option>Monitors</option>
    <option>Mutual exclusion</option>
    <option>Concurrency control</option>
    <option>Power management</option>
    <option>Process synchronization</option>
    <option>Communications management</option>
    <option>Buffering</option>
    <option>Input / output</option>
    <option>Message passing</option>
    <option>Virtual worlds software</option>
    <option>Interactive games</option>
    <option>Virtual worlds training simulations</option>
    <option>Software system structures</option>
    <option>Embedded software</option>
    <option>Software architectures</option>
    <option>n-tier architectures</option>
    <option>Peer-to-peer architectures</option>
    <option>Data flow architectures</option>
    <option>Cooperating communicating processes</option>
    <option>Layered systems</option>
    <option>Publish-subscribe / event-based architectures</option>
    <option>Electronic blackboards</option>
    <option>Simulator / interpreter</option>
    <option>Object oriented architectures</option>
    <option>Tightly coupled architectures</option>
    <option>Space-based architectures</option>
    <option>3-tier architectures</option>
    <option>Software system models</option>
    <option>Petri nets</option>
    <option>State systems</option>
    <option>Entity relationship modeling</option>
    <option>Model-driven software engineering</option>
    <option>Feature interaction</option>
    <option>Massively parallel systems</option>
    <option>Ultra-large-scale systems</option>
    <option>Distributed systems organizing principles</option>
    <option>Cloud computing</option>
    <option>Client-server architectures</option>
    <option>Grid computing</option>
    <option>Organizing principles for web applications</option>
    <option>Real-time systems software</option>
    <option>Abstraction, modeling and modularity</option>
    <option>Software functional properties</option>
    <option>Correctness</option>
    <option>Synchronization</option>
    <option>Functionality</option>
    <option>Real-time schedulability</option>
    <option>Consistency</option>
    <option>Completeness</option>
    <option>Access protection</option>
    <option>Formal methods</option>
    <option>Model checking</option>
    <option>Software verification</option>
    <option>Automated static analysis</option>
    <option>Dynamic analysis</option>
    <option>Extra-functional properties</option>
    <option>Interoperability</option>
    <option>Software performance</option>
    <option>Software reliability</option>
    <option>Software fault tolerance</option>
    <option>Checkpoint / restart</option>
    <option>Software safety</option>
    <option>Software usability</option>
    <option>Software notations and tools</option>
    <option>General programming languages</option>
    <option>Language types</option>
    <option>Parallel programming languages</option>
    <option>Distributed programming languages</option>
    <option>Imperative languages</option>
    <option>Object oriented languages</option>
    <option>Functional languages</option>
    <option>Concurrent programming languages</option>
    <option>Constraint and logic languages</option>
    <option>Data flow languages</option>
    <option>Extensible languages</option>
    <option>Assembly languages</option>
    <option>Multiparadigm languages</option>
    <option>Very high level languages</option>
    <option>Language features</option>
    <option>Abstract data types</option>
    <option>Polymorphism</option>
    <option>Inheritance</option>
    <option>Control structures</option>
    <option>Data types and structures</option>
    <option>Classes and objects</option>
    <option>Modules / packages</option>
    <option>Constraints</option>
    <option>Recursion</option>
    <option>Concurrent programming structures</option>
    <option>Procedures, functions and subroutines</option>
    <option>Patterns</option>
    <option>Coroutines</option>
    <option>Frameworks</option>
    <option>Formal language definitions</option>
    <option>Syntax</option>
    <option>Semantics</option>
    <option>Compilers</option>
    <option>Interpreters</option>
    <option>Incremental compilers</option>
    <option>Retargetable compilers</option>
    <option>Just-in-time compilers</option>
    <option>Dynamic compilers</option>
    <option>Translator writing systems and compiler generators</option>
    <option>Source code generation</option>
    <option>Runtime environments</option>
    <option>Preprocessors</option>
    <option>Parsers</option>
    <option>Context specific languages</option>
    <option>Markup languages</option>
    <option>Extensible Markup Language (XML)</option>
    <option>Hypertext languages</option>
    <option>Scripting languages</option>
    <option>Domain specific languages</option>
    <option>Specialized application languages</option>
    <option>API languages</option>
    <option>Graphical user interface languages</option>
    <option>Window managers</option>
    <option>Command and control languages</option>
    <option>Macro languages</option>
    <option>Programming by example</option>
    <option>State based definitions</option>
    <option>Visual languages</option>
    <option>Interface definition languages</option>
    <option>System description languages</option>
    <option>Design languages</option>
    <option>Unified Modeling Language (UML)</option>
    <option>Architecture description languages</option>
    <option>System modeling languages</option>
    <option>Orchestration languages</option>
    <option>Integration frameworks</option>
    <option>Specification languages</option>
    <option>Development frameworks and environments</option>
    <option>Object oriented frameworks</option>
    <option>Software as a service orchestration system</option>
    <option>Integrated and visual development environments</option>
    <option>Application specific development environments</option>
    <option>Software configuration management and version control systems</option>
    <option>Software libraries and repositories</option>
    <option>Software maintenance tools</option>
    <option>Software creation and management</option>
    <option>Designing software</option>
    <option>Requirements analysis</option>
    <option>Software design engineering</option>
    <option>Software design tradeoffs</option>
    <option>Software implementation planning</option>
    <option>Software design techniques</option>
    <option>Software development process management</option>
    <option>Software development methods</option>
    <option>Rapid application development</option>
    <option>Agile software development</option>
    <option>Capability Maturity Model</option>
    <option>Waterfall model</option>
    <option>Spiral model</option>
    <option>V-model</option>
    <option>Design patterns</option>
    <option>Risk management</option>
    <option>Software development techniques</option>
    <option>Software prototyping</option>
    <option>Object oriented development</option>
    <option>Flowcharts</option>
    <option>Reusability</option>
    <option>Software product lines</option>
    <option>Error handling and recovery</option>
    <option>Automatic programming</option>
    <option>Genetic programming</option>
    <option>Software verification and validation</option>
    <option>Software prototyping</option>
    <option>Operational analysis</option>
    <option>Software defect analysis</option>
    <option>Software testing and debugging</option>
    <option>Fault tree analysis</option>
    <option>Process validation</option>
    <option>Walkthroughs</option>
    <option>Pair programming</option>
    <option>Use cases</option>
    <option>Acceptance testing</option>
    <option>Traceability</option>
    <option>Formal software verification</option>
    <option>Empirical software validation</option>
    <option>Software post-development issues</option>
    <option>Software reverse engineering</option>
    <option>Documentation</option>
    <option>Backup procedures</option>
    <option>Software evolution</option>
    <option>Software version control</option>
    <option>Maintaining software</option>
    <option>System administration</option>
    <option>Collaboration in software development</option>
    <option>Open source model</option>
    <option>Programming teams</option>
    <option>Search-based software engineering</option>
    <option>Theory of computation</option>
    <option>Models of computation</option>
    <option>Computability</option>
    <option>Lambda calculus</option>
    <option>Turing machines</option>
    <option>Recursive functions</option>
    <option>Probabilistic computation</option>
    <option>Quantum computation theory</option>
    <option>Quantum complexity theory</option>
    <option>Quantum communication complexity</option>
    <option>Quantum query complexity</option>
    <option>Quantum information theory</option>
    <option>Interactive computation</option>
    <option>Streaming models</option>
    <option>Concurrency</option>
    <option>Parallel computing models</option>
    <option>Distributed computing models</option>
    <option>Process calculi</option>
    <option>Timed and hybrid models</option>
    <option>Abstract machines</option>
    <option>Formal languages and automata theory</option>
    <option>Formalisms</option>
    <option>Algebraic language theory</option>
    <option>Rewrite systems</option>
    <option>Automata over infinite objects</option>
    <option>Grammars and context-free languages</option>
    <option>Tree languages</option>
    <option>Automata extensions</option>
    <option>Transducers</option>
    <option>Quantitative automata</option>
    <option>Regular languages</option>
    <option>Computational complexity and cryptography</option>
    <option>Complexity classes</option>
    <option>Problems, reductions and completeness</option>
    <option>Communication complexity</option>
    <option>Circuit complexity</option>
    <option>Oracles and decision trees</option>
    <option>Algebraic complexity theory</option>
    <option>Quantum complexity theory</option>
    <option>Proof complexity</option>
    <option>Interactive proof systems</option>
    <option>Complexity theory and logic</option>
    <option>Cryptographic primitives</option>
    <option>Cryptographic protocols</option>
    <option>Logic</option>
    <option>Logic and verification</option>
    <option>Proof theory</option>
    <option>Modal and temporal logics</option>
    <option>Automated reasoning</option>
    <option>Constraint and logic programming</option>
    <option>Constructive mathematics</option>
    <option>Description logics</option>
    <option>Equational logic and rewriting</option>
    <option>Finite Model Theory</option>
    <option>Higher order logic</option>
    <option>Linear logic</option>
    <option>Programming logic</option>
    <option>Abstraction</option>
    <option>Verification by model checking</option>
    <option>Type theory</option>
    <option>Hoare logic</option>
    <option>Separation logic</option>
    <option>Design and analysis of algorithms</option>
    <option>Graph algorithms analysis</option>
    <option>Network flows</option>
    <option>Sparsification and spanners</option>
    <option>Shortest paths</option>
    <option>Dynamic graph algorithms</option>
    <option>Approximation algorithms analysis</option>
    <option>Scheduling algorithms</option>
    <option>Packing and covering problems</option>
    <option>Routing and network design problems</option>
    <option>Facility location and clustering</option>
    <option>Rounding techniques</option>
    <option>Stochastic approximation</option>
    <option>Numeric approximation algorithms</option>
    <option>Mathematical optimization</option>
    <option>Discrete optimization</option>
    <option>Network optimization</option>
    <option>Optimization with randomized search heuristics</option>
    <option>Simulated annealing</option>
    <option>Evolutionary algorithms</option>
    <option>Tabu search</option>
    <option>Randomized local search</option>
    <option>Continuous optimization</option>
    <option>Linear programming</option>
    <option>Semidefinite programming</option>
    <option>Convex optimization</option>
    <option>Quasiconvex programming and unimodality</option>
    <option>Stochastic control and optimization</option>
    <option>Quadratic programming</option>
    <option>Nonconvex optimization</option>
    <option>Bio-inspired optimization</option>
    <option>Mixed discrete-continuous optimization</option>
    <option>Submodular optimization and polymatroids</option>
    <option>Integer programming</option>
    <option>Bio-inspired optimization</option>
    <option>Non-parametric optimization</option>
    <option>Genetic programming</option>
    <option>Developmental representations</option>
    <option>Data structures design and analysis</option>
    <option>Data compression</option>
    <option>Pattern matching</option>
    <option>Sorting and searching</option>
    <option>Predecessor queries</option>
    <option>Cell probe models and lower bounds</option>
    <option>Online algorithms</option>
    <option>Online learning algorithms</option>
    <option>Scheduling algorithms</option>
    <option>Caching and paging algorithms</option>
    <option>K-server algorithms</option>
    <option>Adversary models</option>
    <option>Parameterized complexity and exact algorithms</option>
    <option>Fixed parameter tractability</option>
    <option>W hierarchy</option>
    <option>Streaming, sublinear and near linear time algorithms</option>
    <option>Bloom filters and hashing</option>
    <option>Sketching and sampling</option>
    <option>Lower bounds and information complexity</option>
    <option>Random order and robust communication complexity</option>
    <option>Nearest neighbor algorithms</option>
    <option>Parallel algorithms</option>
    <option>MapReduce algorithms</option>
    <option>Self-organization</option>
    <option>Shared memory algorithms</option>
    <option>Vector / streaming algorithms</option>
    <option>Massively parallel algorithms</option>
    <option>Distributed algorithms</option>
    <option>MapReduce algorithms</option>
    <option>Self-organization</option>
    <option>Algorithm design techniques</option>
    <option>Backtracking</option>
    <option>Branch-and-bound</option>
    <option>Divide and conquer</option>
    <option>Dynamic programming</option>
    <option>Preconditioning</option>
    <option>Concurrent algorithms</option>
    <option>Randomness, geometry and discrete structures</option>
    <option>Pseudorandomness and derandomization</option>
    <option>Computational geometry</option>
    <option>Generating random combinatorial structures</option>
    <option>Random walks and Markov chains</option>
    <option>Expander graphs and randomness extractors</option>
    <option>Error-correcting codes</option>
    <option>Random projections and metric embeddings</option>
    <option>Random network models</option>
    <option>Random search heuristics</option>
    <option>Theory and algorithms for application domains</option>
    <option>Machine learning theory</option>
    <option>Sample complexity and generalization bounds</option>
    <option>Boolean function learning</option>
    <option>Unsupervised learning and clustering</option>
    <option>Kernel methods</option>
    <option>Support vector machines</option>
    <option>Gaussian processes</option>
    <option>Boosting</option>
    <option>Bayesian analysis</option>
    <option>Inductive inference</option>
    <option>Online learning theory</option>
    <option>Multi-agent learning</option>
    <option>Models of learning</option>
    <option>Query learning</option>
    <option>Structured prediction</option>
    <option>Reinforcement learning</option>
    <option>Sequential decision making</option>
    <option>Inverse reinforcement learning</option>
    <option>Apprenticeship learning</option>
    <option>Multi-agent reinforcement learning</option>
    <option>Adversarial learning</option>
    <option>Active learning</option>
    <option>Semi-supervised learning</option>
    <option>Markov decision processes</option>
    <option>Regret bounds</option>
    <option>Algorithmic game theory and mechanism design</option>
    <option>Social networks</option>
    <option>Algorithmic game theory</option>
    <option>Algorithmic mechanism design</option>
    <option>Solution concepts in game theory</option>
    <option>Exact and approximate computation of equilibria</option>
    <option>Quality of equilibria</option>
    <option>Convergence and learning in games</option>
    <option>Market equilibria</option>
    <option>Computational pricing and auctions</option>
    <option>Representations of games and their complexity</option>
    <option>Network games</option>
    <option>Network formation</option>
    <option>Computational advertising theory</option>
    <option>Database theory</option>
    <option>Data exchange</option>
    <option>Data provenance</option>
    <option>Data modeling</option>
    <option>Database query languages (principles)</option>
    <option>Database constraints theory</option>
    <option>Database interoperability</option>
    <option>Data structures and algorithms for data management</option>
    <option>Database query processing and optimization (theory)</option>
    <option>Data integration</option>
    <option>Logic and databases</option>
    <option>Theory of database privacy and security</option>
    <option>Incomplete, inconsistent, and uncertain databases</option>
    <option>Theory of randomized search heuristics</option>
    <option>Semantics and reasoning</option>
    <option>Program constructs</option>
    <option>Control primitives</option>
    <option>Functional constructs</option>
    <option>Object oriented constructs</option>
    <option>Program schemes</option>
    <option>Type structures</option>
    <option>Program semantics</option>
    <option>Algebraic semantics</option>
    <option>Denotational semantics</option>
    <option>Operational semantics</option>
    <option>Axiomatic semantics</option>
    <option>Action semantics</option>
    <option>Categorical semantics</option>
    <option>Program reasoning</option>
    <option>Invariants</option>
    <option>Program specifications</option>
    <option>Pre- and post-conditions</option>
    <option>Program verification</option>
    <option>Program analysis</option>
    <option>Assertions</option>
    <option>Parsing</option>
    <option>Abstraction</option>
    <option>Mathematics of computing</option>
    <option>Discrete mathematics</option>
    <option>Combinatorics</option>
    <option>Combinatoric problems</option>
    <option>Permutations and combinations</option>
    <option>Combinatorial algorithms</option>
    <option>Generating functions</option>
    <option>Combinatorial optimization</option>
    <option>Combinatorics on words</option>
    <option>Enumeration</option>
    <option>Graph theory</option>
    <option>Trees</option>
    <option>Hypergraphs</option>
    <option>Random graphs</option>
    <option>Graph coloring</option>
    <option>Paths and connectivity problems</option>
    <option>Graph enumeration</option>
    <option>Matchings and factors</option>
    <option>Graphs and surfaces</option>
    <option>Network flows</option>
    <option>Spectra of graphs</option>
    <option>Extremal graph theory</option>
    <option>Matroids and greedoids</option>
    <option>Graph algorithms</option>
    <option>Approximation algorithms</option>
    <option>Probability and statistics</option>
    <option>Probabilistic representations</option>
    <option>Bayesian networks</option>
    <option>Markov networks</option>
    <option>Factor graphs</option>
    <option>Decision diagrams</option>
    <option>Equational models</option>
    <option>Causal networks</option>
    <option>Stochastic differential equations</option>
    <option>Nonparametric representations</option>
    <option>Kernel density estimators</option>
    <option>Spline models</option>
    <option>Bayesian nonparametric models</option>
    <option>Probabilistic inference problems</option>
    <option>Maximum likelihood estimation</option>
    <option>Bayesian computation</option>
    <option>Computing most probable explanation</option>
    <option>Hypothesis testing and confidence interval computation</option>
    <option>Density estimation</option>
    <option>Quantile regression</option>
    <option>Max marginal computation</option>
    <option>Probabilistic reasoning algorithms</option>
    <option>Variable elimination</option>
    <option>Loopy belief propagation</option>
    <option>Variational methods</option>
    <option>Expectation maximization</option>
    <option>Markov-chain Monte Carlo methods</option>
    <option>Gibbs sampling</option>
    <option>Metropolis-Hastings algorithm</option>
    <option>Simulated annealing</option>
    <option>Markov-chain Monte Carlo convergence measures</option>
    <option>Sequential Monte Carlo methods</option>
    <option>Kalman filters and hidden Markov models</option>
    <option>Resampling methods</option>
    <option>Bootstrapping</option>
    <option>Jackknifing</option>
    <option>Random number generation</option>
    <option>Probabilistic algorithms</option>
    <option>Statistical paradigms</option>
    <option>Queueing theory</option>
    <option>Contingency table analysis</option>
    <option>Regression analysis</option>
    <option>Robust regression</option>
    <option>Time series analysis</option>
    <option>Survival analysis</option>
    <option>Renewal theory</option>
    <option>Dimensionality reduction</option>
    <option>Cluster analysis</option>
    <option>Statistical graphics</option>
    <option>Exploratory data analysis</option>
    <option>Stochastic processes</option>
    <option>Markov processes</option>
    <option>Nonparametric statistics</option>
    <option>Distribution functions</option>
    <option>Multivariate statistics</option>
    <option>Mathematical software</option>
    <option>Solvers</option>
    <option>Statistical software</option>
    <option>Mathematical software performance</option>
    <option>Information theory</option>
    <option>Coding theory</option>
    <option>Mathematical analysis</option>
    <option>Numerical analysis</option>
    <option>Computation of transforms</option>
    <option>Computations in finite fields</option>
    <option>Computations on matrices</option>
    <option>Computations on polynomials</option>
    <option>Gröbner bases and other special bases</option>
    <option>Number-theoretic computations</option>
    <option>Interpolation</option>
    <option>Numerical differentiation</option>
    <option>Interval arithmetic</option>
    <option>Arbitrary-precision arithmetic</option>
    <option>Automatic differentiation</option>
    <option>Mesh generation</option>
    <option>Discretization</option>
    <option>Mathematical optimization</option>
    <option>Discrete optimization</option>
    <option>Network optimization</option>
    <option>Optimization with randomized search heuristics</option>
    <option>Simulated annealing</option>
    <option>Evolutionary algorithms</option>
    <option>Tabu search</option>
    <option>Randomized local search</option>
    <option>Continuous optimization</option>
    <option>Linear programming</option>
    <option>Semidefinite programming</option>
    <option>Convex optimization</option>
    <option>Quasiconvex programming and unimodality</option>
    <option>Stochastic control and optimization</option>
    <option>Quadratic programming</option>
    <option>Nonconvex optimization</option>
    <option>Bio-inspired optimization</option>
    <option>Mixed discrete-continuous optimization</option>
    <option>Submodular optimization and polymatroids</option>
    <option>Integer programming</option>
    <option>Bio-inspired optimization</option>
    <option>Non-parametric optimization</option>
    <option>Genetic programming</option>
    <option>Developmental representations</option>
    <option>Differential equations</option>
    <option>Ordinary differential equations</option>
    <option>Partial differential equations</option>
    <option>Differential algebraic equations</option>
    <option>Differential variational inequalities</option>
    <option>Calculus</option>
    <option>Lambda calculus</option>
    <option>Differential calculus</option>
    <option>Integral calculus</option>
    <option>Functional analysis</option>
    <option>Approximation</option>
    <option>Integral equations</option>
    <option>Nonlinear equations</option>
    <option>Quadrature</option>
    <option>Continuous mathematics</option>
    <option>Calculus</option>
    <option>Lambda calculus</option>
    <option>Differential calculus</option>
    <option>Integral calculus</option>
    <option>Topology</option>
    <option>Point-set topology</option>
    <option>Algebraic topology</option>
    <option>Geometric topology</option>
    <option>Continuous functions</option>
    <option>Information systems</option>
    <option>Data management systems</option>
    <option>Database design and models</option>
    <option>Relational database model</option>
    <option>Entity relationship models</option>
    <option>Graph-based database models</option>
    <option>Hierarchical data models</option>
    <option>Network data models</option>
    <option>Physical data models</option>
    <option>Data model extensions</option>
    <option>Semi-structured data</option>
    <option>Data streams</option>
    <option>Data provenance</option>
    <option>Incomplete data</option>
    <option>Temporal data</option>
    <option>Uncertainty</option>
    <option>Inconsistent data</option>
    <option>Data structures</option>
    <option>Data access methods</option>
    <option>Multidimensional range search</option>
    <option>Data scans</option>
    <option>Point lookups</option>
    <option>Unidimensional range search</option>
    <option>Proximity search</option>
    <option>Data layout</option>
    <option>Data compression</option>
    <option>Data encryption</option>
    <option>Record and block layout</option>
    <option>Database management system engines</option>
    <option>DBMS engine architectures</option>
    <option>Database query processing</option>
    <option>Query optimization</option>
    <option>Query operators</option>
    <option>Query planning</option>
    <option>Join algorithms</option>
    <option>Database transaction processing</option>
    <option>Data locking</option>
    <option>Transaction logging</option>
    <option>Database recovery</option>
    <option>Record and buffer management</option>
    <option>Parallel and distributed DBMSs</option>
    <option>Key-value stores</option>
    <option>MapReduce-based systems</option>
    <option>Relational parallel and distributed DBMSs</option>
    <option>Triggers and rules</option>
    <option>Database views</option>
    <option>Integrity checking</option>
    <option>Distributed database transactions</option>
    <option>Distributed data locking</option>
    <option>Deadlocks</option>
    <option>Distributed database recovery</option>
    <option>Main memory engines</option>
    <option>Online analytical processing engines</option>
    <option>Stream management</option>
    <option>Query languages</option>
    <option>Relational database query languages</option>
    <option>Structured Query Language</option>
    <option>XML query languages</option>
    <option>XPath</option>
    <option>XQuery</option>
    <option>Query languages for non-relational engines</option>
    <option>MapReduce languages</option>
    <option>Call level interfaces</option>
    <option>Database administration</option>
    <option>Database utilities and tools</option>
    <option>Database performance evaluation</option>
    <option>Autonomous database administration</option>
    <option>Data dictionaries</option>
    <option>Information integration</option>
    <option>Deduplication</option>
    <option>Extraction, transformation and loading</option>
    <option>Data exchange</option>
    <option>Data cleaning</option>
    <option>Wrappers (data mining)</option>
    <option>Mediators and data integration</option>
    <option>Entity resolution</option>
    <option>Data warehouses</option>
    <option>Federated databases</option>
    <option>Middleware for databases</option>
    <option>Database web servers</option>
    <option>Application servers</option>
    <option>Object-relational mapping facilities</option>
    <option>Data federation tools</option>
    <option>Data replication tools</option>
    <option>Distributed transaction monitors</option>
    <option>Message queues</option>
    <option>Service buses</option>
    <option>Enterprise application integration tools</option>
    <option>Middleware business process managers</option>
    <option>Information storage systems</option>
    <option>Information storage technologies</option>
    <option>Magnetic disks</option>
    <option>Magnetic tapes</option>
    <option>Optical / magneto-optical disks</option>
    <option>Storage class memory</option>
    <option>Flash memory</option>
    <option>Phase change memory</option>
    <option>Disk arrays</option>
    <option>Tape libraries</option>
    <option>Record storage systems</option>
    <option>Record storage alternatives</option>
    <option>Heap (data structure)</option>
    <option>Hashed file organization</option>
    <option>Indexed file organization</option>
    <option>Linked lists</option>
    <option>Directory structures</option>
    <option>B-trees</option>
    <option>Vnodes</option>
    <option>Inodes</option>
    <option>Extent-based file structures</option>
    <option>Block / page strategies</option>
    <option>Slotted pages</option>
    <option>Intrapage space management</option>
    <option>Interpage free-space management</option>
    <option>Record layout alternatives</option>
    <option>Fixed length attributes</option>
    <option>Variable length attributes</option>
    <option>Null values in records</option>
    <option>Relational storage</option>
    <option>Horizontal partitioning</option>
    <option>Vertical partitioning</option>
    <option>Column based storage</option>
    <option>Hybrid storage layouts</option>
    <option>Compression strategies</option>
    <option>Storage replication</option>
    <option>Mirroring</option>
    <option>RAID</option>
    <option>Point-in-time copies</option>
    <option>Remote replication</option>
    <option>Storage recovery strategies</option>
    <option>Storage architectures</option>
    <option>Cloud based storage</option>
    <option>Storage network architectures</option>
    <option>Storage area networks</option>
    <option>Direct attached storage</option>
    <option>Network attached storage</option>
    <option>Distributed storage</option>
    <option>Storage management</option>
    <option>Hierarchical storage management</option>
    <option>Storage virtualization</option>
    <option>Information lifecycle management</option>
    <option>Version management</option>
    <option>Storage power management</option>
    <option>Thin provisioning</option>
    <option>Information systems applications</option>
    <option>Enterprise information systems</option>
    <option>Intranets</option>
    <option>Extranets</option>
    <option>Enterprise resource planning</option>
    <option>Enterprise applications</option>
    <option>Data centers</option>
    <option>Collaborative and social computing systems and tools</option>
    <option>Blogs</option>
    <option>Wikis</option>
    <option>Reputation systems</option>
    <option>Open source software</option>
    <option>Social networking sites</option>
    <option>Social tagging systems</option>
    <option>Synchronous editors</option>
    <option>Asynchronous editors</option>
    <option>Spatial-temporal systems</option>
    <option>Location based services</option>
    <option>Geographic information systems</option>
    <option>Sensor networks</option>
    <option>Data streaming</option>
    <option>Global positioning systems</option>
    <option>Decision support systems</option>
    <option>Data warehouses</option>
    <option>Expert systems</option>
    <option>Data analytics</option>
    <option>Online analytical processing</option>
    <option>Mobile information processing systems</option>
    <option>Process control systems</option>
    <option>Multimedia information systems</option>
    <option>Multimedia databases</option>
    <option>Multimedia streaming</option>
    <option>Multimedia content creation</option>
    <option>Massively multiplayer online games</option>
    <option>Data mining</option>
    <option>Data cleaning</option>
    <option>Collaborative filtering</option>
    <option>Association rules</option>
    <option>Clustering</option>
    <option>Nearest-neighbor search</option>
    <option>Data stream mining</option>
    <option>Digital libraries and archives</option>
    <option>Computational advertising</option>
    <option>Computing platforms</option>
    <option>World Wide Web</option>
    <option>Web searching and information discovery</option>
    <option>Web search engines</option>
    <option>Web crawling</option>
    <option>Web indexing</option>
    <option>Page and site ranking</option>
    <option>Spam detection</option>
    <option>Content ranking</option>
    <option>Collaborative filtering</option>
    <option>Social recommendation</option>
    <option>Personalization</option>
    <option>Social tagging</option>
    <option>Online advertising</option>
    <option>Sponsored search advertising</option>
    <option>Content match advertising</option>
    <option>Display advertising</option>
    <option>Social advertising</option>
    <option>Web mining</option>
    <option>Site wrapping</option>
    <option>Data extraction and integration</option>
    <option>Deep web</option>
    <option>Surfacing</option>
    <option>Search results deduplication</option>
    <option>Web log analysis</option>
    <option>Traffic analysis</option>
    <option>Web applications</option>
    <option>Internet communications tools</option>
    <option>Email</option>
    <option>Blogs</option>
    <option>Texting</option>
    <option>Chat</option>
    <option>Web conferencing</option>
    <option>Social networks</option>
    <option>Crowdsourcing</option>
    <option>Answer ranking</option>
    <option>Trust</option>
    <option>Incentive schemes</option>
    <option>Reputation systems</option>
    <option>Electronic commerce</option>
    <option>Digital cash</option>
    <option>E-commerce infrastructure</option>
    <option>Electronic data interchange</option>
    <option>Electronic funds transfer</option>
    <option>Online shopping</option>
    <option>Online banking</option>
    <option>Secure online transactions</option>
    <option>Online auctions</option>
    <option>Web interfaces</option>
    <option>Wikis</option>
    <option>Browsers</option>
    <option>Mashups</option>
    <option>Web services</option>
    <option>Simple Object Access Protocol (SOAP)</option>
    <option>RESTful web services</option>
    <option>Web Services Description Language (WSDL)</option>
    <option>Universal Description Discovery and Integration (UDDI)</option>
    <option>Service discovery and interfaces</option>
    <option>Web data description languages</option>
    <option>Semantic web description languages</option>
    <option>Resource Description Framework (RDF)</option>
    <option>Web Ontology Language (OWL)</option>
    <option>Markup languages</option>
    <option>Extensible Markup Language (XML)</option>
    <option>Hypertext languages</option>
    <option>Information retrieval</option>
    <option>Document representation</option>
    <option>Document structure</option>
    <option>Document topic models</option>
    <option>Content analysis and feature selection</option>
    <option>Data encoding and canonicalization</option>
    <option>Document collection models</option>
    <option>Ontologies</option>
    <option>Dictionaries</option>
    <option>Thesauri</option>
    <option>Information retrieval query processing</option>
    <option>Query representation</option>
    <option>Query intent</option>
    <option>Query log analysis</option>
    <option>Query suggestion</option>
    <option>Query reformulation</option>
    <option>Users and interactive retrieval</option>
    <option>Personalization</option>
    <option>Task models</option>
    <option>Search interfaces</option>
    <option>Collaborative search</option>
    <option>Retrieval models and ranking</option>
    <option>Rank aggregation</option>
    <option>Probabilistic retrieval models</option>
    <option>Language models</option>
    <option>Similarity measures</option>
    <option>Learning to rank</option>
    <option>Combination, fusion and federated search</option>
    <option>Information retrieval diversity</option>
    <option>Top-k retrieval in databases</option>
    <option>Novelty in information retrieval</option>
    <option>Retrieval tasks and goals</option>
    <option>Question answering</option>
    <option>Document filtering</option>
    <option>Recommender systems</option>
    <option>Information extraction</option>
    <option>Sentiment analysis</option>
    <option>Expert search</option>
    <option>Near-duplicate and plagiarism detection</option>
    <option>Clustering and classification</option>
    <option>Summarization</option>
    <option>Business intelligence</option>
    <option>Evaluation of retrieval results</option>
    <option>Test collections</option>
    <option>Relevance assessment</option>
    <option>Retrieval effectiveness</option>
    <option>Retrieval efficiency</option>
    <option>Presentation of retrieval results</option>
    <option>Search engine architectures and scalability</option>
    <option>Search engine indexing</option>
    <option>Search index compression</option>
    <option>Distributed retrieval</option>
    <option>Peer-to-peer retrieval</option>
    <option>Retrieval on mobile devices</option>
    <option>Adversarial retrieval</option>
    <option>Link and co-citation analysis</option>
    <option>Searching with auxiliary databases</option>
    <option>Specialized information retrieval</option>
    <option>Structure and multilingual text search</option>
    <option>Structured text search</option>
    <option>Mathematics retrieval</option>
    <option>Chemical and biochemical retrieval</option>
    <option>Multilingual and cross-lingual retrieval</option>
    <option>Multimedia and multimodal retrieval</option>
    <option>Image search</option>
    <option>Video search</option>
    <option>Speech / audio search</option>
    <option>Music retrieval</option>
    <option>Environment-specific retrieval</option>
    <option>Enterprise search</option>
    <option>Desktop search</option>
    <option>Web and social media search</option>
    <option>Security and privacy</option>
    <option>Cryptography</option>
    <option>Key management</option>
    <option>Public key (asymmetric) techniques</option>
    <option>Digital signatures</option>
    <option>Public key encryption</option>
    <option>Symmetric cryptography and hash functions</option>
    <option>Block and stream ciphers</option>
    <option>Hash functions and message authentication codes</option>
    <option>Cryptanalysis and other attacks</option>
    <option>Information-theoretic techniques</option>
    <option>Mathematical foundations of cryptography</option>
    <option>Formal methods and theory of security</option>
    <option>Trust frameworks</option>
    <option>Security requirements</option>
    <option>Formal security models</option>
    <option>Logic and verification</option>
    <option>Security services</option>
    <option>Authentication</option>
    <option>Biometrics</option>
    <option>Graphical / visual passwords</option>
    <option>Multi-factor authentication</option>
    <option>Access control</option>
    <option>Pseudonymity, anonymity and untraceability</option>
    <option>Privacy-preserving protocols</option>
    <option>Digital rights management</option>
    <option>Authorization</option>
    <option>Intrusion/anomaly detection and malware mitigation</option>
    <option>Malware and its mitigation</option>
    <option>Intrusion detection systems</option>
    <option>Artificial immune systems</option>
    <option>Social engineering attacks</option>
    <option>Spoofing attacks</option>
    <option>Phishing</option>
    <option>Security in hardware</option>
    <option>Tamper-proof and tamper-resistant designs</option>
    <option>Embedded systems security</option>
    <option>Hardware security implementation</option>
    <option>Hardware-based security protocols</option>
    <option>Hardware attacks and countermeasures</option>
    <option>Malicious design modifications</option>
    <option>Side-channel analysis and countermeasures</option>
    <option>Hardware reverse engineering</option>
    <option>Systems security</option>
    <option>Operating systems security</option>
    <option>Mobile platform security</option>
    <option>Trusted computing</option>
    <option>Virtualization and security</option>
    <option>Browser security</option>
    <option>Distributed systems security</option>
    <option>Information flow control</option>
    <option>Denial-of-service attacks</option>
    <option>Firewalls</option>
    <option>Vulnerability management</option>
    <option>Penetration testing</option>
    <option>Vulnerability scanners</option>
    <option>File system security</option>
    <option>Network security</option>
    <option>Security protocols</option>
    <option>Web protocol security</option>
    <option>Mobile and wireless security</option>
    <option>Denial-of-service attacks</option>
    <option>Firewalls</option>
    <option>Database and storage security</option>
    <option>Data anonymization and sanitization</option>
    <option>Management and querying of encrypted data</option>
    <option>Information accountability and usage control</option>
    <option>Database activity monitoring</option>
    <option>Software and application security</option>
    <option>Software security engineering</option>
    <option>Web application security</option>
    <option>Social network security and privacy</option>
    <option>Domain-specific security and privacy architectures</option>
    <option>Software reverse engineering</option>
    <option>Human and societal aspects of security and privacy</option>
    <option>Economics of security and privacy</option>
    <option>Social aspects of security and privacy</option>
    <option>Privacy protections</option>
    <option>Usability in security and privacy</option>
    <option>Human-centered computing</option>
    <option>Human computer interaction (HCI)</option>
    <option>HCI design and evaluation methods</option>
    <option>User models</option>
    <option>User studies</option>
    <option>Usability testing</option>
    <option>Heuristic evaluations</option>
    <option>Walkthrough evaluations</option>
    <option>Laboratory experiments</option>
    <option>Field studies</option>
    <option>Interaction paradigms</option>
    <option>Hypertext / hypermedia</option>
    <option>Mixed / augmented reality</option>
    <option>Command line interfaces</option>
    <option>Graphical user interfaces</option>
    <option>Virtual reality</option>
    <option>Web-based interaction</option>
    <option>Natural language interfaces</option>
    <option>Collaborative interaction</option>
    <option>Interaction devices</option>
    <option>Graphics input devices</option>
    <option>Displays and imagers</option>
    <option>Sound-based input / output</option>
    <option>Keyboards</option>
    <option>Pointing devices</option>
    <option>Touch screens</option>
    <option>Haptic devices</option>
    <option>HCI theory, concepts and models</option>
    <option>Interaction techniques</option>
    <option>Auditory feedback</option>
    <option>Text input</option>
    <option>Pointing</option>
    <option>Gestural input</option>
    <option>Interactive systems and tools</option>
    <option>User interface management systems</option>
    <option>User interface programming</option>
    <option>User interface toolkits</option>
    <option>Empirical studies in HCI</option>
    <option>Interaction design</option>
    <option>Interaction design process and methods</option>
    <option>User interface design</option>
    <option>User centered design</option>
    <option>Activity centered design</option>
    <option>Scenario-based design</option>
    <option>Participatory design</option>
    <option>Contextual design</option>
    <option>Interface design prototyping</option>
    <option>Interaction design theory, concepts and paradigms</option>
    <option>Empirical studies in interaction design</option>
    <option>Systems and tools for interaction design</option>
    <option>Wireframes</option>
    <option>Collaborative and social computing</option>
    <option>Collaborative and social computing theory, concepts and paradigms</option>
    <option>Social content sharing</option>
    <option>Collaborative content creation</option>
    <option>Collaborative filtering</option>
    <option>Social recommendation</option>
    <option>Social networks</option>
    <option>Social tagging</option>
    <option>Computer supported cooperative work</option>
    <option>Social engineering (social sciences)</option>
    <option>Social navigation</option>
    <option>Social media</option>
    <option>Collaborative and social computing design and evaluation methods</option>
    <option>Social network analysis</option>
    <option>Ethnographic studies</option>
    <option>Collaborative and social computing systems and tools</option>
    <option>Blogs</option>
    <option>Wikis</option>
    <option>Reputation systems</option>
    <option>Open source software</option>
    <option>Social networking sites</option>
    <option>Social tagging systems</option>
    <option>Synchronous editors</option>
    <option>Asynchronous editors</option>
    <option>Empirical studies in collaborative and social computing</option>
    <option>Collaborative and social computing devices</option>
    <option>Ubiquitous and mobile computing</option>
    <option>Ubiquitous and mobile computing theory, concepts and paradigms</option>
    <option>Ubiquitous computing</option>
    <option>Mobile computing</option>
    <option>Ambient intelligence</option>
    <option>Ubiquitous and mobile computing systems and tools</option>
    <option>Ubiquitous and mobile devices</option>
    <option>Smartphones</option>
    <option>Interactive whiteboards</option>
    <option>Mobile phones</option>
    <option>Mobile devices</option>
    <option>Portable media players</option>
    <option>Personal digital assistants</option>
    <option>Handheld game consoles</option>
    <option>E-book readers</option>
    <option>Tablet computers</option>
    <option>Ubiquitous and mobile computing design and evaluation methods</option>
    <option>Empirical studies in ubiquitous and mobile computing</option>
    <option>Visualization</option>
    <option>Visualization techniques</option>
    <option>Treemaps</option>
    <option>Hyperbolic trees</option>
    <option>Heat maps</option>
    <option>Graph drawings</option>
    <option>Dendrograms</option>
    <option>Cladograms</option>
    <option>Visualization application domains</option>
    <option>Scientific visualization</option>
    <option>Visual analytics</option>
    <option>Geographic visualization</option>
    <option>Information visualization</option>
    <option>Visualization systems and tools</option>
    <option>Visualization toolkits</option>
    <option>Visualization theory, concepts and paradigms</option>
    <option>Empirical studies in visualization</option>
    <option>Visualization design and evaluation methods</option>
    <option>Accessibility</option>
    <option>Accessibility theory, concepts and paradigms</option>
    <option>Empirical studies in accessibility</option>
    <option>Accessibility design and evaluation methods</option>
    <option>Accessibility technologies</option>
    <option>Accessibility systems and tools</option>
    <option>Computing methodologies</option>
    <option>Symbolic and algebraic manipulation</option>
    <option>Symbolic and algebraic algorithms</option>
    <option>Combinatorial algorithms</option>
    <option>Algebraic algorithms</option>
    <option>Nonalgebraic algorithms</option>
    <option>Symbolic calculus algorithms</option>
    <option>Exact arithmetic algorithms</option>
    <option>Hybrid symbolic-numeric methods</option>
    <option>Discrete calculus algorithms</option>
    <option>Number theory algorithms</option>
    <option>Equation and inequality solving algorithms</option>
    <option>Linear algebra algorithms</option>
    <option>Theorem proving algorithms</option>
    <option>Boolean algebra algorithms</option>
    <option>Optimization algorithms</option>
    <option>Computer algebra systems</option>
    <option>Special-purpose algebraic systems</option>
    <option>Representation of mathematical objects</option>
    <option>Representation of exact numbers</option>
    <option>Representation of mathematical functions</option>
    <option>Representation of Boolean functions</option>
    <option>Representation of polynomials</option>
    <option>Parallel computing methodologies</option>
    <option>Parallel algorithms</option>
    <option>MapReduce algorithms</option>
    <option>Self-organization</option>
    <option>Shared memory algorithms</option>
    <option>Vector / streaming algorithms</option>
    <option>Massively parallel algorithms</option>
    <option>Parallel programming languages</option>
    <option>Artificial intelligence</option>
    <option>Natural language processing</option>
    <option>Information extraction</option>
    <option>Machine translation</option>
    <option>Discourse, dialogue and pragmatics</option>
    <option>Natural language generation</option>
    <option>Speech recognition</option>
    <option>Lexical semantics</option>
    <option>Phonology / morphology</option>
    <option>Language resources</option>
    <option>Knowledge representation and reasoning</option>
    <option>Description logics</option>
    <option>Semantic networks</option>
    <option>Nonmonotonic, default reasoning and belief revision</option>
    <option>Probabilistic reasoning</option>
    <option>Vagueness and fuzzy logic</option>
    <option>Causal reasoning and diagnostics</option>
    <option>Temporal reasoning</option>
    <option>Cognitive robotics</option>
    <option>Ontology engineering</option>
    <option>Logic programming and answer set programming</option>
    <option>Spatial and physical reasoning</option>
    <option>Reasoning about belief and knowledge</option>
    <option>Planning and scheduling</option>
    <option>Planning for deterministic actions</option>
    <option>Planning under uncertainty</option>
    <option>Multi-agent planning</option>
    <option>Planning with abstraction and generalization</option>
    <option>Robotic planning</option>
    <option>Evolutionary robotics</option>
    <option>Search methodologies</option>
    <option>Heuristic function construction</option>
    <option>Discrete space search</option>
    <option>Continuous space search</option>
    <option>Randomized search</option>
    <option>Game tree search</option>
    <option>Abstraction and micro-operators</option>
    <option>Search with partial observations</option>
    <option>Control methods</option>
    <option>Robotic planning</option>
    <option>Evolutionary robotics</option>
    <option>Computational control theory</option>
    <option>Motion path planning</option>
    <option>Philosophical/theoretical foundations of artificial intelligence</option>
    <option>Cognitive science</option>
    <option>Theory of mind</option>
    <option>Distributed artificial intelligence</option>
    <option>Multi-agent systems</option>
    <option>Intelligent agents</option>
    <option>Mobile agents</option>
    <option>Cooperation and coordination</option>
    <option>Computer vision</option>
    <option>Computer vision tasks</option>
    <option>Biometrics</option>
    <option>Scene understanding</option>
    <option>Activity recognition and understanding</option>
    <option>Video summarization</option>
    <option>Visual content-based indexing and retrieval</option>
    <option>Visual inspection</option>
    <option>Vision for robotics</option>
    <option>Scene anomaly detection</option>
    <option>Image and video acquisition</option>
    <option>Camera calibration</option>
    <option>Epipolar geometry</option>
    <option>Computational photography</option>
    <option>Hyperspectral imaging</option>
    <option>Motion capture</option>
    <option>3D imaging</option>
    <option>Active vision</option>
    <option>Computer vision representations</option>
    <option>Image representations</option>
    <option>Shape representations</option>
    <option>Appearance and texture representations</option>
    <option>Hierarchical representations</option>
    <option>Computer vision problems</option>
    <option>Interest point and salient region detections</option>
    <option>Image segmentation</option>
    <option>Video segmentation</option>
    <option>Shape inference</option>
    <option>Object detection</option>
    <option>Object recognition</option>
    <option>Object identification</option>
    <option>Tracking</option>
    <option>Reconstruction</option>
    <option>Matching</option>
    <option>Machine learning</option>
    <option>Learning paradigms</option>
    <option>Supervised learning</option>
    <option>Ranking</option>
    <option>Learning to rank</option>
    <option>Supervised learning by classification</option>
    <option>Supervised learning by regression</option>
    <option>Structured outputs</option>
    <option>Cost-sensitive learning</option>
    <option>Unsupervised learning</option>
    <option>Cluster analysis</option>
    <option>Anomaly detection</option>
    <option>Mixture modeling</option>
    <option>Topic modeling</option>
    <option>Source separation</option>
    <option>Motif discovery</option>
    <option>Dimensionality reduction and manifold learning</option>
    <option>Reinforcement learning</option>
    <option>Sequential decision making</option>
    <option>Inverse reinforcement learning</option>
    <option>Apprenticeship learning</option>
    <option>Multi-agent reinforcement learning</option>
    <option>Adversarial learning</option>
    <option>Multi-task learning</option>
    <option>Transfer learning</option>
    <option>Lifelong machine learning</option>
    <option>Learning under covariate shift</option>
    <option>Learning settings</option>
    <option>Batch learning</option>
    <option>Online learning settings</option>
    <option>Learning from demonstrations</option>
    <option>Learning from critiques</option>
    <option>Learning from implicit feedback</option>
    <option>Active learning settings</option>
    <option>Semi-supervised learning settings</option>
    <option>Machine learning approaches</option>
    <option>Classification and regression trees</option>
    <option>Kernel methods</option>
    <option>Support vector machines</option>
    <option>Gaussian processes</option>
    <option>Neural networks</option>
    <option>Logical and relational learning</option>
    <option>Inductive logic learning</option>
    <option>Statistical relational learning</option>
    <option>Learning in probabilistic graphical models</option>
    <option>Maximum likelihood modeling</option>
    <option>Maximum entropy modeling</option>
    <option>Maximum a posteriori modeling</option>
    <option>Mixture models</option>
    <option>Latent variable models</option>
    <option>Bayesian network models</option>
    <option>Learning linear models</option>
    <option>Perceptron algorithm</option>
    <option>Factorization methods</option>
    <option>Non-negative matrix factorization</option>
    <option>Factor analysis</option>
    <option>Principal component analysis</option>
    <option>Canonical correlation analysis</option>
    <option>Latent Dirichlet allocation</option>
    <option>Rule learning</option>
    <option>Instance-based learning</option>
    <option>Markov decision processes</option>
    <option>Partially-observable Markov decision processes</option>
    <option>Stochastic games</option>
    <option>Learning latent representations</option>
    <option>Deep belief networks</option>
    <option>Bio-inspired approaches</option>
    <option>Artificial life</option>
    <option>Evolvable hardware</option>
    <option>Genetic algorithms</option>
    <option>Genetic programming</option>
    <option>Evolutionary robotics</option>
    <option>Generative and developmental approaches</option>
    <option>Machine learning algorithms</option>
    <option>Dynamic programming for Markov decision processes</option>
    <option>Value iteration</option>
    <option>Q-learning</option>
    <option>Policy iteration</option>
    <option>Temporal difference learning</option>
    <option>Approximate dynamic programming methods</option>
    <option>Ensemble methods</option>
    <option>Boosting</option>
    <option>Bagging</option>
    <option>Spectral methods</option>
    <option>Feature selection</option>
    <option>Regularization</option>
    <option>Cross-validation</option>
    <option>Modeling and simulation</option>
    <option>Model development and analysis</option>
    <option>Modeling methodologies</option>
    <option>Model verification and validation</option>
    <option>Uncertainty quantification</option>
    <option>Simulation theory</option>
    <option>Systems theory</option>
    <option>Network science</option>
    <option>Simulation types and techniques</option>
    <option>Uncertainty quantification</option>
    <option>Quantum mechanic simulation</option>
    <option>Molecular simulation</option>
    <option>Rare-event simulation</option>
    <option>Discrete-event simulation</option>
    <option>Agent / discrete models</option>
    <option>Distributed simulation</option>
    <option>Continuous simulation</option>
    <option>Continuous models</option>
    <option>Real-time simulation</option>
    <option>Interactive simulation</option>
    <option>Multiscale systems</option>
    <option>Massively parallel and high-performance simulations</option>
    <option>Data assimilation</option>
    <option>Scientific visualization</option>
    <option>Visual analytics</option>
    <option>Simulation by animation</option>
    <option>Artificial life</option>
    <option>Simulation support systems</option>
    <option>Simulation environments</option>
    <option>Simulation languages</option>
    <option>Simulation tools</option>
    <option>Simulation evaluation</option>
    <option>Computer graphics</option>
    <option>Animation</option>
    <option>Motion capture</option>
    <option>Procedural animation</option>
    <option>Physical simulation</option>
    <option>Motion processing</option>
    <option>Collision detection</option>
    <option>Rendering</option>
    <option>Rasterization</option>
    <option>Ray tracing</option>
    <option>Non-photorealistic rendering</option>
    <option>Reflectance modeling</option>
    <option>Visibility</option>
    <option>Image manipulation</option>
    <option>Computational photography</option>
    <option>Image processing</option>
    <option>Texturing</option>
    <option>Image-based rendering</option>
    <option>Antialiasing</option>
    <option>Graphics systems and interfaces</option>
    <option>Graphics processors</option>
    <option>Graphics input devices</option>
    <option>Mixed / augmented reality</option>
    <option>Perception</option>
    <option>Graphics file formats</option>
    <option>Virtual reality</option>
    <option>Image compression</option>
    <option>Shape modeling</option>
    <option>Mesh models</option>
    <option>Mesh geometry models</option>
    <option>Parametric curve and surface models</option>
    <option>Point-based models</option>
    <option>Volumetric models</option>
    <option>Shape analysis</option>
    <option>Distributed computing methodologies</option>
    <option>Distributed algorithms</option>
    <option>MapReduce algorithms</option>
    <option>Self-organization</option>
    <option>Distributed programming languages</option>
    <option>Concurrent computing methodologies</option>
    <option>Concurrent programming languages</option>
    <option>Concurrent algorithms</option>
    <option>Applied computing</option>
    <option>Electronic commerce</option>
    <option>Digital cash</option>
    <option>E-commerce infrastructure</option>
    <option>Electronic data interchange</option>
    <option>Electronic funds transfer</option>
    <option>Online shopping</option>
    <option>Online banking</option>
    <option>Secure online transactions</option>
    <option>Online auctions</option>
    <option>Enterprise computing</option>
    <option>Enterprise information systems</option>
    <option>Intranets</option>
    <option>Extranets</option>
    <option>Enterprise resource planning</option>
    <option>Enterprise applications</option>
    <option>Data centers</option>
    <option>Business process management</option>
    <option>Business process modeling</option>
    <option>Business process management systems</option>
    <option>Business process monitoring</option>
    <option>Cross-organizational business processes</option>
    <option>Business intelligence</option>
    <option>Enterprise architectures</option>
    <option>Enterprise architecture management</option>
    <option>Enterprise architecture frameworks</option>
    <option>Enterprise architecture modeling</option>
    <option>Service-oriented architectures</option>
    <option>Event-driven architectures</option>
    <option>Business rules</option>
    <option>Enterprise modeling</option>
    <option>Enterprise ontologies, taxonomies and vocabularies</option>
    <option>Enterprise data management</option>
    <option>Reference models</option>
    <option>Business-IT alignment</option>
    <option>IT architectures</option>
    <option>IT governance</option>
    <option>Enterprise computing infrastructures</option>
    <option>Enterprise interoperability</option>
    <option>Enterprise application integration</option>
    <option>Information integration and interoperability</option>
    <option>Physical sciences and engineering</option>
    <option>Aerospace</option>
    <option>Avionics</option>
    <option>Archaeology</option>
    <option>Astronomy</option>
    <option>Chemistry</option>
    <option>Earth and atmospheric sciences</option>
    <option>Environmental sciences</option>
    <option>Engineering</option>
    <option>Computer-aided design</option>
    <option>Physics</option>
    <option>Mathematics and statistics</option>
    <option>Electronics</option>
    <option>Avionics</option>
    <option>Telecommunications</option>
    <option>Internet telephony</option>
    <option>Life and medical sciences</option>
    <option>Computational biology</option>
    <option>Molecular sequence analysis</option>
    <option>Recognition of genes and regulatory elements</option>
    <option>Molecular evolution</option>
    <option>Computational transcriptomics</option>
    <option>Biological networks</option>
    <option>Sequencing and genotyping technologies</option>
    <option>Imaging</option>
    <option>Computational proteomics</option>
    <option>Molecular structural biology</option>
    <option>Computational genomics</option>
    <option>Genomics</option>
    <option>Computational genomics</option>
    <option>Systems biology</option>
    <option>Consumer health</option>
    <option>Health care information systems</option>
    <option>Health informatics</option>
    <option>Bioinformatics</option>
    <option>Metabolomics / metabonomics</option>
    <option>Genetics</option>
    <option>Population genetics</option>
    <option>Proteomics</option>
    <option>Computational proteomics</option>
    <option>Transcriptomics</option>
    <option>Law, social and behavioral sciences</option>
    <option>Anthropology</option>
    <option>Ethnography</option>
    <option>Law</option>
    <option>Psychology</option>
    <option>Economics</option>
    <option>Sociology</option>
    <option>Computer forensics</option>
    <option>Surveillance mechanisms</option>
    <option>Investigation techniques</option>
    <option>Evidence collection, storage and analysis</option>
    <option>Network forensics</option>
    <option>System forensics</option>
    <option>Data recovery</option>
    <option>Arts and humanities</option>
    <option>Fine arts</option>
    <option>Performing arts</option>
    <option>Architecture (buildings)</option>
    <option>Computer-aided design</option>
    <option>Language translation</option>
    <option>Media arts</option>
    <option>Sound and music computing</option>
    <option>Computers in other domains</option>
    <option>Digital libraries and archives</option>
    <option>Publishing</option>
    <option>Military</option>
    <option>Cyberwarfare</option>
    <option>Cartography</option>
    <option>Agriculture</option>
    <option>Computing in government</option>
    <option>Voting / election technologies</option>
    <option>E-government</option>
    <option>Personal computers and PC applications</option>
    <option>Word processors</option>
    <option>Spreadsheets</option>
    <option>Computer games</option>
    <option>Microcomputers</option>
    <option>Operations research</option>
    <option>Consumer products</option>
    <option>Industry and manufacturing</option>
    <option>Supply chain management</option>
    <option>Command and control</option>
    <option>Computer-aided manufacturing</option>
    <option>Decision analysis</option>
    <option>Multi-criterion optimization and decision-making</option>
    <option>Transportation</option>
    <option>Forecasting</option>
    <option>Marketing</option>
    <option>Education</option>
    <option>Digital libraries and archives</option>
    <option>Computer-assisted instruction</option>
    <option>Interactive learning environments</option>
    <option>Collaborative learning</option>
    <option>Learning management systems</option>
    <option>Distance learning</option>
    <option>E-learning</option>
    <option>Computer-managed instruction</option>
    <option>Document management and text processing</option>
    <option>Document searching</option>
    <option>Document management</option>
    <option>Text editing</option>
    <option>Version control</option>
    <option>Document metadata</option>
    <option>Document capture</option>
    <option>Document analysis</option>
    <option>Document scanning</option>
    <option>Graphics recognition and interpretation</option>
    <option>Optical character recognition</option>
    <option>Online handwriting recognition</option>
    <option>Document preparation</option>
    <option>Markup languages</option>
    <option>Extensible Markup Language (XML)</option>
    <option>Hypertext languages</option>
    <option>Annotation</option>
    <option>Format and notation</option>
    <option>Multi / mixed media creation</option>
    <option>Image composition</option>
    <option>Hypertext / hypermedia creation</option>
    <option>Document scripting languages</option>
    <option>Social and professional topics</option>
    <option>Professional topics</option>
    <option>Computing industry</option>
    <option>Industry statistics</option>
    <option>Computer manufacturing</option>
    <option>Sustainability</option>
    <option>Management of computing and information systems</option>
    <option>Project and people management</option>
    <option>Project management techniques</option>
    <option>Project staffing</option>
    <option>Systems planning</option>
    <option>Systems analysis and design</option>
    <option>Systems development</option>
    <option>Computer and information systems training</option>
    <option>Implementation management</option>
    <option>Hardware selection</option>
    <option>Computing equipment management</option>
    <option>Pricing and resource allocation</option>
    <option>Software management</option>
    <option>Software maintenance</option>
    <option>Software selection and adaptation</option>
    <option>System management</option>
    <option>Centralization / decentralization</option>
    <option>Technology audits</option>
    <option>Quality assurance</option>
    <option>Network operations</option>
    <option>File systems management</option>
    <option>Information system economics</option>
    <option>History of computing</option>
    <option>Historical people</option>
    <option>History of hardware</option>
    <option>History of software</option>
    <option>History of programming languages</option>
    <option>History of computing theory</option>
    <option>Computing education</option>
    <option>Computational thinking</option>
    <option>Accreditation</option>
    <option>Model curricula</option>
    <option>Computing education programs</option>
    <option>Information systems education</option>
    <option>Computer science education</option>
    <option>CS1</option>
    <option>Computer engineering education</option>
    <option>Information technology education</option>
    <option>Information science education</option>
    <option>Computational science and engineering education</option>
    <option>Software engineering education</option>
    <option>Informal education</option>
    <option>Computing literacy</option>
    <option>Student assessment</option>
    <option>K-12 education</option>
    <option>Adult education</option>
    <option>Computing and business</option>
    <option>Employment issues</option>
    <option>Automation</option>
    <option>Computer supported cooperative work</option>
    <option>Economic impact</option>
    <option>Offshoring</option>
    <option>Reengineering</option>
    <option>Socio-technical systems</option>
    <option>Computing profession</option>
    <option>Codes of ethics</option>
    <option>Employment issues</option>
    <option>Funding</option>
    <option>Computing occupations</option>
    <option>Computing organizations</option>
    <option>Testing, certification and licensing</option>
    <option>Assistive technologies</option>
    <option>Computing / technology policy</option>
    <option>Intellectual property</option>
    <option>Digital rights management</option>
    <option>Copyrights</option>
    <option>Software reverse engineering</option>
    <option>Patents</option>
    <option>Trademarks</option>
    <option>Internet governance / domain names</option>
    <option>Licensing</option>
    <option>Treaties</option>
    <option>Database protection laws</option>
    <option>Secondary liability</option>
    <option>Soft intellectual property</option>
    <option>Hardware reverse engineering</option>
    <option>Privacy policies</option>
    <option>Censorship</option>
    <option>Pornography</option>
    <option>Hate speech</option>
    <option>Political speech</option>
    <option>Technology and censorship</option>
    <option>Censoring filters</option>
    <option>Surveillance</option>
    <option>Governmental surveillance</option>
    <option>Corporate surveillance</option>
    <option>Commerce policy</option>
    <option>Taxation</option>
    <option>Transborder data flow</option>
    <option>Antitrust and competition</option>
    <option>Governmental regulations</option>
    <option>Online auctions policy</option>
    <option>Consumer products policy</option>
    <option>Network access control</option>
    <option>Censoring filters</option>
    <option>Broadband access</option>
    <option>Net neutrality</option>
    <option>Network access restrictions</option>
    <option>Age-based restrictions</option>
    <option>Acceptable use policy restrictions</option>
    <option>Universal access</option>
    <option>Computer crime</option>
    <option>Social engineering attacks</option>
    <option>Spoofing attacks</option>
    <option>Phishing</option>
    <option>Identity theft</option>
    <option>Financial crime</option>
    <option>Malware / spyware crime</option>
    <option>Government technology policy</option>
    <option>Governmental regulations</option>
    <option>Import / export controls</option>
    <option>Medical information policy</option>
    <option>Medical records</option>
    <option>Personal health records</option>
    <option>Genetic information</option>
    <option>Patient privacy</option>
    <option>Health information exchanges</option>
    <option>Medical technologies</option>
    <option>Remote medicine</option>
    <option>User characteristics</option>
    <option>Race and ethnicity</option>
    <option>Religious orientation</option>
    <option>Gender</option>
    <option>Men</option>
    <option>Women</option>
    <option>Sexual orientation</option>
    <option>People with disabilities</option>
    <option>Geographic characteristics</option>
    <option>Cultural characteristics</option>
    <option>Age</option>
    <option>Children</option>
    <option>Seniors</option>
    <option>Adolescents</option>';

    $_SESSION['optionsCSV'] = preg_replace("/\r|\n/", "", $_SESSION['optionsCSV']);
}

if(!isset($_SESSION['arrayCSV']))
{
    $_SESSION['arrayCSV']=array('General and reference' ,
    'Document types' ,
    'Surveys and overviews' ,
    'Reference works' ,
    'General conference proceedings' ,
    'Biographies' ,
    'General literature' ,
    'Computing standards, RFCs and guidelines' ,
    'Cross-computing tools and techniques' ,
    'Reliability' ,
    'Empirical studies' ,
    'Measurement' ,
    'Metrics' ,
    'Evaluation' ,
    'Experimentation' ,
    'Estimation' ,
    'Design' ,
    'Performance' ,
    'Validation' ,
    'Verification' ,
    'Hardware' ,
    'Printed circuit boards' ,
    'Electromagnetic interference and compatibility' ,
    'PCB design and layout' ,
    'Communication hardware, interfaces and storage' ,
    'Signal processing systems' ,
    'Digital signal processing' ,
    'Beamforming' ,
    'Noise reduction' ,
    'Sensors and actuators' ,
    'Buses and high-speed links' ,
    'Displays and imagers' ,
    'External storage' ,
    'Networking hardware' ,
    'Printers' ,
    'Sensor applications and deployments' ,
    'Sensor devices and platforms' ,
    'Sound-based input / output' ,
    'Tactile and hand-based interfaces' ,
    'Touch screens' ,
    'Haptic devices' ,
    'Scanners' ,
    'Wireless devices' ,
    'Wireless integrated network sensors' ,
    'Electro-mechanical devices' ,
    'Integrated circuits' ,
    '3D integrated circuits' ,
    'Interconnect' ,
    'Input / output circuits' ,
    'Metallic interconnect' ,
    'Photonic and optical interconnect' ,
    'Radio frequency and wireless interconnect' ,
    'Semiconductor memory' ,
    'Dynamic memory' ,
    'Static memory' ,
    'Non-volatile memory' ,
    'Read-only memory' ,
    'Digital switches' ,
    'Transistors' ,
    'Logic families' ,
    'Logic circuits' ,
    'Arithmetic and datapath circuits' ,
    'Asynchronous circuits' ,
    'Combinational circuits' ,
    'Design modules and hierarchy' ,
    'Finite state machines' ,
    'Sequential circuits' ,
    'Reconfigurable logic and FPGAs' ,
    'Hardware accelerators' ,
    'High-speed input / output' ,
    'Programmable logic elements' ,
    'Programmable interconnect' ,
    'Reconfigurable logic applications' ,
    'Evolvable hardware' ,
    'Very large scale integration design' ,
    '3D integrated circuits' ,
    'Analog and mixed-signal circuits' ,
    'Data conversion' ,
    'Clock generation and timing' ,
    'Analog and mixed-signal circuit optimization' ,
    'Radio frequency and wireless circuits' ,
    'Wireline communication' ,
    'Analog and mixed-signal circuit synthesis' ,
    'Application-specific VLSI designs' ,
    'Application specific integrated circuits' ,
    'Application specific instruction set processors' ,
    'Application specific processors' ,
    'Design reuse and communication-based design' ,
    'Network on chip' ,
    'System on a chip' ,
    'Platform-based design' ,
    'Hard and soft IP' ,
    'Design rules' ,
    'Economics of chip design and manufacturing' ,
    'Full-custom circuits' ,
    'VLSI design manufacturing considerations' ,
    'On-chip resource management' ,
    'On-chip sensors' ,
    'Standard cell libraries' ,
    'VLSI packaging' ,
    'Die and wafer stacking' ,
    'Input / output styles' ,
    'Multi-chip modules' ,
    'Package-level interconnect' ,
    'VLSI system specification and constraints' ,
    'Power and energy' ,
    'Thermal issues' ,
    'Temperature monitoring' ,
    'Temperature simulation and estimation' ,
    'Temperature control' ,
    'Temperature optimization' ,
    'Energy generation and storage' ,
    'Batteries' ,
    'Fuel-based energy' ,
    'Renewable energy' ,
    'Reusable energy storage' ,
    'Energy distribution' ,
    'Energy metering' ,
    'Power conversion' ,
    'Power networks' ,
    'Smart grid' ,
    'Impact on the environment' ,
    'Power estimation and optimization' ,
    'Switching devices power issues' ,
    'Interconnect power issues' ,
    'Circuits power issues' ,
    'Chip-level power issues' ,
    'Platform power issues' ,
    'Enterprise level and data centers power issues' ,
    'Electronic design automation' ,
    'High-level and register-transfer level synthesis' ,
    'Datapath optimization' ,
    'Hardware-software codesign' ,
    'Resource binding and sharing' ,
    'Operations scheduling' ,
    'Hardware description languages and compilation' ,
    'Logic synthesis' ,
    'Combinational synthesis' ,
    'Circuit optimization' ,
    'Sequential synthesis' ,
    'Technology-mapping' ,
    'Transistor-level synthesis' ,
    'Modeling and parameter extraction' ,
    'Physical design (EDA)' ,
    'Clock-network synthesis' ,
    'Packaging' ,
    'Partitioning and floorplanning' ,
    'Placement' ,
    'Physical synthesis' ,
    'Power grid design' ,
    'Wire routing' ,
    'Timing analysis' ,
    'Electrical-level simulation' ,
    'Model-order reduction' ,
    'Compact delay models' ,
    'Static timing analysis' ,
    'Statistical timing analysis' ,
    'Transition-based timing analysis' ,
    'Methodologies for EDA' ,
    'Best practices for EDA' ,
    'Design databases for EDA' ,
    'Software tools for EDA' ,
    'Hardware validation' ,
    'Functional verification' ,
    'Model checking' ,
    'Coverage metrics' ,
    'Equivalence checking' ,
    'Semi-formal verification' ,
    'Simulation and emulation' ,
    'Transaction-level verification' ,
    'Theorem proving and SAT solving' ,
    'Assertion checking' ,
    'Physical verification' ,
    'Design rule checking' ,
    'Layout-versus-schematics' ,
    'Power and thermal analysis' ,
    'Timing analysis and sign-off' ,
    'Post-manufacture validation and debug' ,
    'Bug detection, localization and diagnosis' ,
    'Bug fixing (hardware)' ,
    'Design for debug' ,
    'Hardware test' ,
    'Analog, mixed-signal and radio frequency test' ,
    'Board- and system-level test' ,
    'Defect-based test' ,
    'Design for testability' ,
    'Built-in self-test' ,
    'Online test and diagnostics' ,
    'Test data compression' ,
    'Fault models and test metrics' ,
    'Memory test and repair' ,
    'Hardware reliability screening' ,
    'Test-pattern generation and fault simulation' ,
    'Testing with distributed and parallel systems' ,
    'Robustness' ,
    'Fault tolerance' ,
    'Error detection and error correction' ,
    'Failure prediction' ,
    'Failure recovery, maintenance and self-repair' ,
    'Redundancy' ,
    'Self-checking mechanisms' ,
    'System-level fault tolerance' ,
    'Design for manufacturability' ,
    'Process variations' ,
    'Yield and cost modeling' ,
    'Yield and cost optimization' ,
    'Hardware reliability' ,
    'Aging of circuits and systems' ,
    'Circuit hardening' ,
    'Early-life failures and infant mortality' ,
    'Process, voltage and temperature variations' ,
    'Signal integrity and noise analysis' ,
    'Transient errors and upsets' ,
    'Safety critical systems' ,
    'Emerging technologies' ,
    'Analysis and design of emerging devices and systems' ,
    'Emerging architectures' ,
    'Emerging languages and compilers' ,
    'Emerging simulation' ,
    'Emerging tools and methodologies' ,
    'Biology-related information processing' ,
    'Bio-embedded electronics' ,
    'Neural systems' ,
    'Circuit substrates' ,
    'III-V compounds' ,
    'Carbon based electronics' ,
    'Cellular neural networks' ,
    'Flexible and printable circuits' ,
    'Superconducting circuits' ,
    'Electromechanical systems' ,
    'Microelectromechanical systems' ,
    'Nanoelectromechanical systems' ,
    'Emerging interfaces' ,
    'Memory and dense storage' ,
    'Emerging optical and photonic technologies' ,
    'Reversible logic' ,
    'Plasmonics' ,
    'Quantum technologies' ,
    'Single electron devices' ,
    'Tunneling devices' ,
    'Quantum computation' ,
    'Quantum communication and cryptography' ,
    'Quantum error correction and fault tolerance' ,
    'Quantum dots and cellular automata' ,
    'Spintronics and magnetic technologies' ,
    'Computer systems organization' ,
    'Architectures' ,
    'Serial architectures' ,
    'Reduced instruction set computing' ,
    'Complex instruction set computing' ,
    'Superscalar architectures' ,
    'Pipeline computing' ,
    'Stack machines' ,
    'Parallel architectures' ,
    'Very long instruction word' ,
    'Interconnection architectures' ,
    'Multiple instruction, multiple data' ,
    'Cellular architectures' ,
    'Multiple instruction, single data' ,
    'Single instruction, multiple data' ,
    'Systolic arrays' ,
    'Multicore architectures' ,
    'Distributed architectures' ,
    'Cloud computing' ,
    'Client-server architectures' ,
    'n-tier architectures' ,
    'Peer-to-peer architectures' ,
    'Grid computing' ,
    'Other architectures' ,
    'Neural networks' ,
    'Reconfigurable computing' ,
    'Analog computers' ,
    'Data flow architectures' ,
    'Heterogeneous (hybrid) systems' ,
    'Self-organizing autonomic computing' ,
    'Optical computing' ,
    'Quantum computing' ,
    'Molecular computing' ,
    'High-level language architectures' ,
    'Special purpose systems' ,
    'Embedded and cyber-physical systems' ,
    'Sensor networks' ,
    'Robotics' ,
    'Robotic components' ,
    'Robotic control' ,
    'Evolutionary robotics' ,
    'Robotic autonomy' ,
    'External interfaces for robotics' ,
    'Sensors and actuators' ,
    'System on a chip' ,
    'Embedded systems' ,
    'Firmware' ,
    'Embedded hardware' ,
    'Embedded software' ,
    'Real-time systems' ,
    'Real-time operating systems' ,
    'Real-time languages' ,
    'Real-time system specification' ,
    'Real-time system architecture' ,
    'Dependable and fault-tolerant systems and networks' ,
    'Reliability' ,
    'Availability' ,
    'Maintainability and maintenance' ,
    'Processors and memory architectures' ,
    'Secondary storage organization' ,
    'Redundancy' ,
    'Fault-tolerant network topologies' ,
    'Networks' ,
    'Network architectures' ,
    'Network design principles' ,
    'Layering' ,
    'Naming and addressing' ,
    'Programming interfaces' ,
    'Network protocols' ,
    'Network protocol design' ,
    'Protocol correctness' ,
    'Protocol testing and verification' ,
    'Formal specifications' ,
    'Link-layer protocols' ,
    'Network layer protocols' ,
    'Routing protocols' ,
    'Signaling protocols' ,
    'Transport protocols' ,
    'Session protocols' ,
    'Presentation protocols' ,
    'Application layer protocols' ,
    'Peer-to-peer protocols' ,
    'OAM protocols' ,
    'Time synchronization protocols' ,
    'Network policy' ,
    'Cross-layer protocols' ,
    'Network File System (NFS) protocol' ,
    'Network components' ,
    'Intermediate nodes' ,
    'Routers' ,
    'Bridges and switches' ,
    'Physical links' ,
    'Repeaters' ,
    'Middle boxes / network appliances' ,
    'End nodes' ,
    'Network adapters' ,
    'Network servers' ,
    'Wireless access points, base stations and infrastructure' ,
    'Cognitive radios' ,
    'Logical nodes' ,
    'Network domains' ,
    'Network algorithms' ,
    'Data path algorithms' ,
    'Packet classification' ,
    'Deep packet inspection' ,
    'Packet scheduling' ,
    'Control path algorithms' ,
    'Network resources allocation' ,
    'Network control algorithms' ,
    'Traffic engineering algorithms' ,
    'Network design and planning algorithms' ,
    'Network economics' ,
    'Network performance evaluation' ,
    'Network performance modeling' ,
    'Network simulations' ,
    'Network experimentation' ,
    'Network performance analysis' ,
    'Network measurement' ,
    'Network properties' ,
    'Network security' ,
    'Security protocols' ,
    'Web protocol security' ,
    'Mobile and wireless security' ,
    'Denial-of-service attacks' ,
    'Firewalls' ,
    'Network range' ,
    'Short-range networks' ,
    'Local area networks' ,
    'Metropolitan area networks' ,
    'Wide area networks' ,
    'Very long-range networks' ,
    'Network structure' ,
    'Topology analysis and generation' ,
    'Physical topologies' ,
    'Logical / virtual topologies' ,
    'Network topology types' ,
    'Point-to-point networks' ,
    'Bus networks' ,
    'Star networks' ,
    'Ring networks' ,
    'Token ring networks' ,
    'Fiber distributed data interface (FDDI)' ,
    'Mesh networks' ,
    'Wireless mesh networks' ,
    'Hybrid networks' ,
    'Network dynamics' ,
    'Network reliability' ,
    'Error detection and error correction' ,
    'Network mobility' ,
    'Network manageability' ,
    'Network privacy and anonymity' ,
    'Network services' ,
    'Naming and addressing' ,
    'Cloud computing' ,
    'Location based services' ,
    'Programmable networks' ,
    'In-network processing' ,
    'Network management' ,
    'Network monitoring' ,
    'Network types' ,
    'Network on chip' ,
    'Home networks' ,
    'Storage area networks' ,
    'Data center networks' ,
    'Wired access networks' ,
    'Cyber-physical networks' ,
    'Sensor networks' ,
    'Mobile networks' ,
    'Overlay and other logical network structures' ,
    'Peer-to-peer networks' ,
    'World Wide Web (network structure)' ,
    'Social media networks' ,
    'Online social networks' ,
    'Wireless access networks' ,
    'Wireless local area networks' ,
    'Wireless personal area networks' ,
    'Ad hoc networks' ,
    'Mobile ad hoc networks' ,
    'Public Internet' ,
    'Packet-switching networks' ,
    'Software and its engineering' ,
    'Software organization and properties' ,
    'Contextual software domains' ,
    'E-commerce infrastructure' ,
    'Software infrastructure' ,
    'Interpreters' ,
    'Middleware' ,
    'Message oriented middleware' ,
    'Reflective middleware' ,
    'Embedded middleware' ,
    'Virtual machines' ,
    'Operating systems' ,
    'File systems management' ,
    'Memory management' ,
    'Virtual memory' ,
    'Main memory' ,
    'Allocation / deallocation strategies' ,
    'Garbage collection' ,
    'Distributed memory' ,
    'Secondary storage' ,
    'Process management' ,
    'Scheduling' ,
    'Deadlocks' ,
    'Multithreading' ,
    'Multiprocessing / multiprogramming / multitasking' ,
    'Monitors' ,
    'Mutual exclusion' ,
    'Concurrency control' ,
    'Power management' ,
    'Process synchronization' ,
    'Communications management' ,
    'Buffering' ,
    'Input / output' ,
    'Message passing' ,
    'Virtual worlds software' ,
    'Interactive games' ,
    'Virtual worlds training simulations' ,
    'Software system structures' ,
    'Embedded software' ,
    'Software architectures' ,
    'n-tier architectures' ,
    'Peer-to-peer architectures' ,
    'Data flow architectures' ,
    'Cooperating communicating processes' ,
    'Layered systems' ,
    'Publish-subscribe / event-based architectures' ,
    'Electronic blackboards' ,
    'Simulator / interpreter' ,
    'Object oriented architectures' ,
    'Tightly coupled architectures' ,
    'Space-based architectures' ,
    '3-tier architectures' ,
    'Software system models' ,
    'Petri nets' ,
    'State systems' ,
    'Entity relationship modeling' ,
    'Model-driven software engineering' ,
    'Feature interaction' ,
    'Massively parallel systems' ,
    'Ultra-large-scale systems' ,
    'Distributed systems organizing principles' ,
    'Cloud computing' ,
    'Client-server architectures' ,
    'Grid computing' ,
    'Organizing principles for web applications' ,
    'Real-time systems software' ,
    'Abstraction, modeling and modularity' ,
    'Software functional properties' ,
    'Correctness' ,
    'Synchronization' ,
    'Functionality' ,
    'Real-time schedulability' ,
    'Consistency' ,
    'Completeness' ,
    'Access protection' ,
    'Formal methods' ,
    'Model checking' ,
    'Software verification' ,
    'Automated static analysis' ,
    'Dynamic analysis' ,
    'Extra-functional properties' ,
    'Interoperability' ,
    'Software performance' ,
    'Software reliability' ,
    'Software fault tolerance' ,
    'Checkpoint / restart' ,
    'Software safety' ,
    'Software usability' ,
    'Software notations and tools' ,
    'General programming languages' ,
    'Language types' ,
    'Parallel programming languages' ,
    'Distributed programming languages' ,
    'Imperative languages' ,
    'Object oriented languages' ,
    'Functional languages' ,
    'Concurrent programming languages' ,
    'Constraint and logic languages' ,
    'Data flow languages' ,
    'Extensible languages' ,
    'Assembly languages' ,
    'Multiparadigm languages' ,
    'Very high level languages' ,
    'Language features' ,
    'Abstract data types' ,
    'Polymorphism' ,
    'Inheritance' ,
    'Control structures' ,
    'Data types and structures' ,
    'Classes and objects' ,
    'Modules / packages' ,
    'Constraints' ,
    'Recursion' ,
    'Concurrent programming structures' ,
    'Procedures, functions and subroutines' ,
    'Patterns' ,
    'Coroutines' ,
    'Frameworks' ,
    'Formal language definitions' ,
    'Syntax' ,
    'Semantics' ,
    'Compilers' ,
    'Interpreters' ,
    'Incremental compilers' ,
    'Retargetable compilers' ,
    'Just-in-time compilers' ,
    'Dynamic compilers' ,
    'Translator writing systems and compiler generators' ,
    'Source code generation' ,
    'Runtime environments' ,
    'Preprocessors' ,
    'Parsers' ,
    'Context specific languages' ,
    'Markup languages' ,
    'Extensible Markup Language (XML)' ,
    'Hypertext languages' ,
    'Scripting languages' ,
    'Domain specific languages' ,
    'Specialized application languages' ,
    'API languages' ,
    'Graphical user interface languages' ,
    'Window managers' ,
    'Command and control languages' ,
    'Macro languages' ,
    'Programming by example' ,
    'State based definitions' ,
    'Visual languages' ,
    'Interface definition languages' ,
    'System description languages' ,
    'Design languages' ,
    'Unified Modeling Language (UML)' ,
    'Architecture description languages' ,
    'System modeling languages' ,
    'Orchestration languages' ,
    'Integration frameworks' ,
    'Specification languages' ,
    'Development frameworks and environments' ,
    'Object oriented frameworks' ,
    'Software as a service orchestration system' ,
    'Integrated and visual development environments' ,
    'Application specific development environments' ,
    'Software configuration management and version control systems' ,
    'Software libraries and repositories' ,
    'Software maintenance tools' ,
    'Software creation and management' ,
    'Designing software' ,
    'Requirements analysis' ,
    'Software design engineering' ,
    'Software design tradeoffs' ,
    'Software implementation planning' ,
    'Software design techniques' ,
    'Software development process management' ,
    'Software development methods' ,
    'Rapid application development' ,
    'Agile software development' ,
    'Capability Maturity Model' ,
    'Waterfall model' ,
    'Spiral model' ,
    'V-model' ,
    'Design patterns' ,
    'Risk management' ,
    'Software development techniques' ,
    'Software prototyping' ,
    'Object oriented development' ,
    'Flowcharts' ,
    'Reusability' ,
    'Software product lines' ,
    'Error handling and recovery' ,
    'Automatic programming' ,
    'Genetic programming' ,
    'Software verification and validation' ,
    'Software prototyping' ,
    'Operational analysis' ,
    'Software defect analysis' ,
    'Software testing and debugging' ,
    'Fault tree analysis' ,
    'Process validation' ,
    'Walkthroughs' ,
    'Pair programming' ,
    'Use cases' ,
    'Acceptance testing' ,
    'Traceability' ,
    'Formal software verification' ,
    'Empirical software validation' ,
    'Software post-development issues' ,
    'Software reverse engineering' ,
    'Documentation' ,
    'Backup procedures' ,
    'Software evolution' ,
    'Software version control' ,
    'Maintaining software' ,
    'System administration' ,
    'Collaboration in software development' ,
    'Open source model' ,
    'Programming teams' ,
    'Search-based software engineering' ,
    'Theory of computation' ,
    'Models of computation' ,
    'Computability' ,
    'Lambda calculus' ,
    'Turing machines' ,
    'Recursive functions' ,
    'Probabilistic computation' ,
    'Quantum computation theory' ,
    'Quantum complexity theory' ,
    'Quantum communication complexity' ,
    'Quantum query complexity' ,
    'Quantum information theory' ,
    'Interactive computation' ,
    'Streaming models' ,
    'Concurrency' ,
    'Parallel computing models' ,
    'Distributed computing models' ,
    'Process calculi' ,
    'Timed and hybrid models' ,
    'Abstract machines' ,
    'Formal languages and automata theory' ,
    'Formalisms' ,
    'Algebraic language theory' ,
    'Rewrite systems' ,
    'Automata over infinite objects' ,
    'Grammars and context-free languages' ,
    'Tree languages' ,
    'Automata extensions' ,
    'Transducers' ,
    'Quantitative automata' ,
    'Regular languages' ,
    'Computational complexity and cryptography' ,
    'Complexity classes' ,
    'Problems, reductions and completeness' ,
    'Communication complexity' ,
    'Circuit complexity' ,
    'Oracles and decision trees' ,
    'Algebraic complexity theory' ,
    'Quantum complexity theory' ,
    'Proof complexity' ,
    'Interactive proof systems' ,
    'Complexity theory and logic' ,
    'Cryptographic primitives' ,
    'Cryptographic protocols' ,
    'Logic' ,
    'Logic and verification' ,
    'Proof theory' ,
    'Modal and temporal logics' ,
    'Automated reasoning' ,
    'Constraint and logic programming' ,
    'Constructive mathematics' ,
    'Description logics' ,
    'Equational logic and rewriting' ,
    'Finite Model Theory' ,
    'Higher order logic' ,
    'Linear logic' ,
    'Programming logic' ,
    'Abstraction' ,
    'Verification by model checking' ,
    'Type theory' ,
    'Hoare logic' ,
    'Separation logic' ,
    'Design and analysis of algorithms' ,
    'Graph algorithms analysis' ,
    'Network flows' ,
    'Sparsification and spanners' ,
    'Shortest paths' ,
    'Dynamic graph algorithms' ,
    'Approximation algorithms analysis' ,
    'Scheduling algorithms' ,
    'Packing and covering problems' ,
    'Routing and network design problems' ,
    'Facility location and clustering' ,
    'Rounding techniques' ,
    'Stochastic approximation' ,
    'Numeric approximation algorithms' ,
    'Mathematical optimization' ,
    'Discrete optimization' ,
    'Network optimization' ,
    'Optimization with randomized search heuristics' ,
    'Simulated annealing' ,
    'Evolutionary algorithms' ,
    'Tabu search' ,
    'Randomized local search' ,
    'Continuous optimization' ,
    'Linear programming' ,
    'Semidefinite programming' ,
    'Convex optimization' ,
    'Quasiconvex programming and unimodality' ,
    'Stochastic control and optimization' ,
    'Quadratic programming' ,
    'Nonconvex optimization' ,
    'Bio-inspired optimization' ,
    'Mixed discrete-continuous optimization' ,
    'Submodular optimization and polymatroids' ,
    'Integer programming' ,
    'Bio-inspired optimization' ,
    'Non-parametric optimization' ,
    'Genetic programming' ,
    'Developmental representations' ,
    'Data structures design and analysis' ,
    'Data compression' ,
    'Pattern matching' ,
    'Sorting and searching' ,
    'Predecessor queries' ,
    'Cell probe models and lower bounds' ,
    'Online algorithms' ,
    'Online learning algorithms' ,
    'Scheduling algorithms' ,
    'Caching and paging algorithms' ,
    'K-server algorithms' ,
    'Adversary models' ,
    'Parameterized complexity and exact algorithms' ,
    'Fixed parameter tractability' ,
    'W hierarchy' ,
    'Streaming, sublinear and near linear time algorithms' ,
    'Bloom filters and hashing' ,
    'Sketching and sampling' ,
    'Lower bounds and information complexity' ,
    'Random order and robust communication complexity' ,
    'Nearest neighbor algorithms' ,
    'Parallel algorithms' ,
    'MapReduce algorithms' ,
    'Self-organization' ,
    'Shared memory algorithms' ,
    'Vector / streaming algorithms' ,
    'Massively parallel algorithms' ,
    'Distributed algorithms' ,
    'MapReduce algorithms' ,
    'Self-organization' ,
    'Algorithm design techniques' ,
    'Backtracking' ,
    'Branch-and-bound' ,
    'Divide and conquer' ,
    'Dynamic programming' ,
    'Preconditioning' ,
    'Concurrent algorithms' ,
    'Randomness, geometry and discrete structures' ,
    'Pseudorandomness and derandomization' ,
    'Computational geometry' ,
    'Generating random combinatorial structures' ,
    'Random walks and Markov chains' ,
    'Expander graphs and randomness extractors' ,
    'Error-correcting codes' ,
    'Random projections and metric embeddings' ,
    'Random network models' ,
    'Random search heuristics' ,
    'Theory and algorithms for application domains' ,
    'Machine learning theory' ,
    'Sample complexity and generalization bounds' ,
    'Boolean function learning' ,
    'Unsupervised learning and clustering' ,
    'Kernel methods' ,
    'Support vector machines' ,
    'Gaussian processes' ,
    'Boosting' ,
    'Bayesian analysis' ,
    'Inductive inference' ,
    'Online learning theory' ,
    'Multi-agent learning' ,
    'Models of learning' ,
    'Query learning' ,
    'Structured prediction' ,
    'Reinforcement learning' ,
    'Sequential decision making' ,
    'Inverse reinforcement learning' ,
    'Apprenticeship learning' ,
    'Multi-agent reinforcement learning' ,
    'Adversarial learning' ,
    'Active learning' ,
    'Semi-supervised learning' ,
    'Markov decision processes' ,
    'Regret bounds' ,
    'Algorithmic game theory and mechanism design' ,
    'Social networks' ,
    'Algorithmic game theory' ,
    'Algorithmic mechanism design' ,
    'Solution concepts in game theory' ,
    'Exact and approximate computation of equilibria' ,
    'Quality of equilibria' ,
    'Convergence and learning in games' ,
    'Market equilibria' ,
    'Computational pricing and auctions' ,
    'Representations of games and their complexity' ,
    'Network games' ,
    'Network formation' ,
    'Computational advertising theory' ,
    'Database theory' ,
    'Data exchange' ,
    'Data provenance' ,
    'Data modeling' ,
    'Database query languages (principles)' ,
    'Database constraints theory' ,
    'Database interoperability' ,
    'Data structures and algorithms for data management' ,
    'Database query processing and optimization (theory)' ,
    'Data integration' ,
    'Logic and databases' ,
    'Theory of database privacy and security' ,
    'Incomplete, inconsistent, and uncertain databases' ,
    'Theory of randomized search heuristics' ,
    'Semantics and reasoning' ,
    'Program constructs' ,
    'Control primitives' ,
    'Functional constructs' ,
    'Object oriented constructs' ,
    'Program schemes' ,
    'Type structures' ,
    'Program semantics' ,
    'Algebraic semantics' ,
    'Denotational semantics' ,
    'Operational semantics' ,
    'Axiomatic semantics' ,
    'Action semantics' ,
    'Categorical semantics' ,
    'Program reasoning' ,
    'Invariants' ,
    'Program specifications' ,
    'Pre- and post-conditions' ,
    'Program verification' ,
    'Program analysis' ,
    'Assertions' ,
    'Parsing' ,
    'Abstraction' ,
    'Mathematics of computing' ,
    'Discrete mathematics' ,
    'Combinatorics' ,
    'Combinatoric problems' ,
    'Permutations and combinations' ,
    'Combinatorial algorithms' ,
    'Generating functions' ,
    'Combinatorial optimization' ,
    'Combinatorics on words' ,
    'Enumeration' ,
    'Graph theory' ,
    'Trees' ,
    'Hypergraphs' ,
    'Random graphs' ,
    'Graph coloring' ,
    'Paths and connectivity problems' ,
    'Graph enumeration' ,
    'Matchings and factors' ,
    'Graphs and surfaces' ,
    'Network flows' ,
    'Spectra of graphs' ,
    'Extremal graph theory' ,
    'Matroids and greedoids' ,
    'Graph algorithms' ,
    'Approximation algorithms' ,
    'Probability and statistics' ,
    'Probabilistic representations' ,
    'Bayesian networks' ,
    'Markov networks' ,
    'Factor graphs' ,
    'Decision diagrams' ,
    'Equational models' ,
    'Causal networks' ,
    'Stochastic differential equations' ,
    'Nonparametric representations' ,
    'Kernel density estimators' ,
    'Spline models' ,
    'Bayesian nonparametric models' ,
    'Probabilistic inference problems' ,
    'Maximum likelihood estimation' ,
    'Bayesian computation' ,
    'Computing most probable explanation' ,
    'Hypothesis testing and confidence interval computation' ,
    'Density estimation' ,
    'Quantile regression' ,
    'Max marginal computation' ,
    'Probabilistic reasoning algorithms' ,
    'Variable elimination' ,
    'Loopy belief propagation' ,
    'Variational methods' ,
    'Expectation maximization' ,
    'Markov-chain Monte Carlo methods' ,
    'Gibbs sampling' ,
    'Metropolis-Hastings algorithm' ,
    'Simulated annealing' ,
    'Markov-chain Monte Carlo convergence measures' ,
    'Sequential Monte Carlo methods' ,
    'Kalman filters and hidden Markov models' ,
    'Resampling methods' ,
    'Bootstrapping' ,
    'Jackknifing' ,
    'Random number generation' ,
    'Probabilistic algorithms' ,
    'Statistical paradigms' ,
    'Queueing theory' ,
    'Contingency table analysis' ,
    'Regression analysis' ,
    'Robust regression' ,
    'Time series analysis' ,
    'Survival analysis' ,
    'Renewal theory' ,
    'Dimensionality reduction' ,
    'Cluster analysis' ,
    'Statistical graphics' ,
    'Exploratory data analysis' ,
    'Stochastic processes' ,
    'Markov processes' ,
    'Nonparametric statistics' ,
    'Distribution functions' ,
    'Multivariate statistics' ,
    'Mathematical software' ,
    'Solvers' ,
    'Statistical software' ,
    'Mathematical software performance' ,
    'Information theory' ,
    'Coding theory' ,
    'Mathematical analysis' ,
    'Numerical analysis' ,
    'Computation of transforms' ,
    'Computations in finite fields' ,
    'Computations on matrices' ,
    'Computations on polynomials' ,
    'Gröbner bases and other special bases' ,
    'Number-theoretic computations' ,
    'Interpolation' ,
    'Numerical differentiation' ,
    'Interval arithmetic' ,
    'Arbitrary-precision arithmetic' ,
    'Automatic differentiation' ,
    'Mesh generation' ,
    'Discretization' ,
    'Mathematical optimization' ,
    'Discrete optimization' ,
    'Network optimization' ,
    'Optimization with randomized search heuristics' ,
    'Simulated annealing' ,
    'Evolutionary algorithms' ,
    'Tabu search' ,
    'Randomized local search' ,
    'Continuous optimization' ,
    'Linear programming' ,
    'Semidefinite programming' ,
    'Convex optimization' ,
    'Quasiconvex programming and unimodality' ,
    'Stochastic control and optimization' ,
    'Quadratic programming' ,
    'Nonconvex optimization' ,
    'Bio-inspired optimization' ,
    'Mixed discrete-continuous optimization' ,
    'Submodular optimization and polymatroids' ,
    'Integer programming' ,
    'Bio-inspired optimization' ,
    'Non-parametric optimization' ,
    'Genetic programming' ,
    'Developmental representations' ,
    'Differential equations' ,
    'Ordinary differential equations' ,
    'Partial differential equations' ,
    'Differential algebraic equations' ,
    'Differential variational inequalities' ,
    'Calculus' ,
    'Lambda calculus' ,
    'Differential calculus' ,
    'Integral calculus' ,
    'Functional analysis' ,
    'Approximation' ,
    'Integral equations' ,
    'Nonlinear equations' ,
    'Quadrature' ,
    'Continuous mathematics' ,
    'Calculus' ,
    'Lambda calculus' ,
    'Differential calculus' ,
    'Integral calculus' ,
    'Topology' ,
    'Point-set topology' ,
    'Algebraic topology' ,
    'Geometric topology' ,
    'Continuous functions' ,
    'Information systems' ,
    'Data management systems' ,
    'Database design and models' ,
    'Relational database model' ,
    'Entity relationship models' ,
    'Graph-based database models' ,
    'Hierarchical data models' ,
    'Network data models' ,
    'Physical data models' ,
    'Data model extensions' ,
    'Semi-structured data' ,
    'Data streams' ,
    'Data provenance' ,
    'Incomplete data' ,
    'Temporal data' ,
    'Uncertainty' ,
    'Inconsistent data' ,
    'Data structures' ,
    'Data access methods' ,
    'Multidimensional range search' ,
    'Data scans' ,
    'Point lookups' ,
    'Unidimensional range search' ,
    'Proximity search' ,
    'Data layout' ,
    'Data compression' ,
    'Data encryption' ,
    'Record and block layout' ,
    'Database management system engines' ,
    'DBMS engine architectures' ,
    'Database query processing' ,
    'Query optimization' ,
    'Query operators' ,
    'Query planning' ,
    'Join algorithms' ,
    'Database transaction processing' ,
    'Data locking' ,
    'Transaction logging' ,
    'Database recovery' ,
    'Record and buffer management' ,
    'Parallel and distributed DBMSs' ,
    'Key-value stores' ,
    'MapReduce-based systems' ,
    'Relational parallel and distributed DBMSs' ,
    'Triggers and rules' ,
    'Database views' ,
    'Integrity checking' ,
    'Distributed database transactions' ,
    'Distributed data locking' ,
    'Deadlocks' ,
    'Distributed database recovery' ,
    'Main memory engines' ,
    'Online analytical processing engines' ,
    'Stream management' ,
    'Query languages' ,
    'Relational database query languages' ,
    'Structured Query Language' ,
    'XML query languages' ,
    'XPath' ,
    'XQuery' ,
    'Query languages for non-relational engines' ,
    'MapReduce languages' ,
    'Call level interfaces' ,
    'Database administration' ,
    'Database utilities and tools' ,
    'Database performance evaluation' ,
    'Autonomous database administration' ,
    'Data dictionaries' ,
    'Information integration' ,
    'Deduplication' ,
    'Extraction, transformation and loading' ,
    'Data exchange' ,
    'Data cleaning' ,
    'Wrappers (data mining)' ,
    'Mediators and data integration' ,
    'Entity resolution' ,
    'Data warehouses' ,
    'Federated databases' ,
    'Middleware for databases' ,
    'Database web servers' ,
    'Application servers' ,
    'Object-relational mapping facilities' ,
    'Data federation tools' ,
    'Data replication tools' ,
    'Distributed transaction monitors' ,
    'Message queues' ,
    'Service buses' ,
    'Enterprise application integration tools' ,
    'Middleware business process managers' ,
    'Information storage systems' ,
    'Information storage technologies' ,
    'Magnetic disks' ,
    'Magnetic tapes' ,
    'Optical / magneto-optical disks' ,
    'Storage class memory' ,
    'Flash memory' ,
    'Phase change memory' ,
    'Disk arrays' ,
    'Tape libraries' ,
    'Record storage systems' ,
    'Record storage alternatives' ,
    'Heap (data structure)' ,
    'Hashed file organization' ,
    'Indexed file organization' ,
    'Linked lists' ,
    'Directory structures' ,
    'B-trees' ,
    'Vnodes' ,
    'Inodes' ,
    'Extent-based file structures' ,
    'Block / page strategies' ,
    'Slotted pages' ,
    'Intrapage space management' ,
    'Interpage free-space management' ,
    'Record layout alternatives' ,
    'Fixed length attributes' ,
    'Variable length attributes' ,
    'Null values in records' ,
    'Relational storage' ,
    'Horizontal partitioning' ,
    'Vertical partitioning' ,
    'Column based storage' ,
    'Hybrid storage layouts' ,
    'Compression strategies' ,
    'Storage replication' ,
    'Mirroring' ,
    'RAID' ,
    'Point-in-time copies' ,
    'Remote replication' ,
    'Storage recovery strategies' ,
    'Storage architectures' ,
    'Cloud based storage' ,
    'Storage network architectures' ,
    'Storage area networks' ,
    'Direct attached storage' ,
    'Network attached storage' ,
    'Distributed storage' ,
    'Storage management' ,
    'Hierarchical storage management' ,
    'Storage virtualization' ,
    'Information lifecycle management' ,
    'Version management' ,
    'Storage power management' ,
    'Thin provisioning' ,
    'Information systems applications' ,
    'Enterprise information systems' ,
    'Intranets' ,
    'Extranets' ,
    'Enterprise resource planning' ,
    'Enterprise applications' ,
    'Data centers' ,
    'Collaborative and social computing systems and tools' ,
    'Blogs' ,
    'Wikis' ,
    'Reputation systems' ,
    'Open source software' ,
    'Social networking sites' ,
    'Social tagging systems' ,
    'Synchronous editors' ,
    'Asynchronous editors' ,
    'Spatial-temporal systems' ,
    'Location based services' ,
    'Geographic information systems' ,
    'Sensor networks' ,
    'Data streaming' ,
    'Global positioning systems' ,
    'Decision support systems' ,
    'Data warehouses' ,
    'Expert systems' ,
    'Data analytics' ,
    'Online analytical processing' ,
    'Mobile information processing systems' ,
    'Process control systems' ,
    'Multimedia information systems' ,
    'Multimedia databases' ,
    'Multimedia streaming' ,
    'Multimedia content creation' ,
    'Massively multiplayer online games' ,
    'Data mining' ,
    'Data cleaning' ,
    'Collaborative filtering' ,
    'Association rules' ,
    'Clustering' ,
    'Nearest-neighbor search' ,
    'Data stream mining' ,
    'Digital libraries and archives' ,
    'Computational advertising' ,
    'Computing platforms' ,
    'World Wide Web' ,
    'Web searching and information discovery' ,
    'Web search engines' ,
    'Web crawling' ,
    'Web indexing' ,
    'Page and site ranking' ,
    'Spam detection' ,
    'Content ranking' ,
    'Collaborative filtering' ,
    'Social recommendation' ,
    'Personalization' ,
    'Social tagging' ,
    'Online advertising' ,
    'Sponsored search advertising' ,
    'Content match advertising' ,
    'Display advertising' ,
    'Social advertising' ,
    'Web mining' ,
    'Site wrapping' ,
    'Data extraction and integration' ,
    'Deep web' ,
    'Surfacing' ,
    'Search results deduplication' ,
    'Web log analysis' ,
    'Traffic analysis' ,
    'Web applications' ,
    'Internet communications tools' ,
    'Email' ,
    'Blogs' ,
    'Texting' ,
    'Chat' ,
    'Web conferencing' ,
    'Social networks' ,
    'Crowdsourcing' ,
    'Answer ranking' ,
    'Trust' ,
    'Incentive schemes' ,
    'Reputation systems' ,
    'Electronic commerce' ,
    'Digital cash' ,
    'E-commerce infrastructure' ,
    'Electronic data interchange' ,
    'Electronic funds transfer' ,
    'Online shopping' ,
    'Online banking' ,
    'Secure online transactions' ,
    'Online auctions' ,
    'Web interfaces' ,
    'Wikis' ,
    'Browsers' ,
    'Mashups' ,
    'Web services' ,
    'Simple Object Access Protocol (SOAP)' ,
    'RESTful web services' ,
    'Web Services Description Language (WSDL)' ,
    'Universal Description Discovery and Integration (UDDI)' ,
    'Service discovery and interfaces' ,
    'Web data description languages' ,
    'Semantic web description languages' ,
    'Resource Description Framework (RDF)' ,
    'Web Ontology Language (OWL)' ,
    'Markup languages' ,
    'Extensible Markup Language (XML)' ,
    'Hypertext languages' ,
    'Information retrieval' ,
    'Document representation' ,
    'Document structure' ,
    'Document topic models' ,
    'Content analysis and feature selection' ,
    'Data encoding and canonicalization' ,
    'Document collection models' ,
    'Ontologies' ,
    'Dictionaries' ,
    'Thesauri' ,
    'Information retrieval query processing' ,
    'Query representation' ,
    'Query intent' ,
    'Query log analysis' ,
    'Query suggestion' ,
    'Query reformulation' ,
    'Users and interactive retrieval' ,
    'Personalization' ,
    'Task models' ,
    'Search interfaces' ,
    'Collaborative search' ,
    'Retrieval models and ranking' ,
    'Rank aggregation' ,
    'Probabilistic retrieval models' ,
    'Language models' ,
    'Similarity measures' ,
    'Learning to rank' ,
    'Combination, fusion and federated search' ,
    'Information retrieval diversity' ,
    'Top-k retrieval in databases' ,
    'Novelty in information retrieval' ,
    'Retrieval tasks and goals' ,
    'Question answering' ,
    'Document filtering' ,
    'Recommender systems' ,
    'Information extraction' ,
    'Sentiment analysis' ,
    'Expert search' ,
    'Near-duplicate and plagiarism detection' ,
    'Clustering and classification' ,
    'Summarization' ,
    'Business intelligence' ,
    'Evaluation of retrieval results' ,
    'Test collections' ,
    'Relevance assessment' ,
    'Retrieval effectiveness' ,
    'Retrieval efficiency' ,
    'Presentation of retrieval results' ,
    'Search engine architectures and scalability' ,
    'Search engine indexing' ,
    'Search index compression' ,
    'Distributed retrieval' ,
    'Peer-to-peer retrieval' ,
    'Retrieval on mobile devices' ,
    'Adversarial retrieval' ,
    'Link and co-citation analysis' ,
    'Searching with auxiliary databases' ,
    'Specialized information retrieval' ,
    'Structure and multilingual text search' ,
    'Structured text search' ,
    'Mathematics retrieval' ,
    'Chemical and biochemical retrieval' ,
    'Multilingual and cross-lingual retrieval' ,
    'Multimedia and multimodal retrieval' ,
    'Image search' ,
    'Video search' ,
    'Speech / audio search' ,
    'Music retrieval' ,
    'Environment-specific retrieval' ,
    'Enterprise search' ,
    'Desktop search' ,
    'Web and social media search' ,
    'Security and privacy' ,
    'Cryptography' ,
    'Key management' ,
    'Public key (asymmetric) techniques' ,
    'Digital signatures' ,
    'Public key encryption' ,
    'Symmetric cryptography and hash functions' ,
    'Block and stream ciphers' ,
    'Hash functions and message authentication codes' ,
    'Cryptanalysis and other attacks' ,
    'Information-theoretic techniques' ,
    'Mathematical foundations of cryptography' ,
    'Formal methods and theory of security' ,
    'Trust frameworks' ,
    'Security requirements' ,
    'Formal security models' ,
    'Logic and verification' ,
    'Security services' ,
    'Authentication' ,
    'Biometrics' ,
    'Graphical / visual passwords' ,
    'Multi-factor authentication' ,
    'Access control' ,
    'Pseudonymity, anonymity and untraceability' ,
    'Privacy-preserving protocols' ,
    'Digital rights management' ,
    'Authorization' ,
    'Intrusion/anomaly detection and malware mitigation' ,
    'Malware and its mitigation' ,
    'Intrusion detection systems' ,
    'Artificial immune systems' ,
    'Social engineering attacks' ,
    'Spoofing attacks' ,
    'Phishing' ,
    'Security in hardware' ,
    'Tamper-proof and tamper-resistant designs' ,
    'Embedded systems security' ,
    'Hardware security implementation' ,
    'Hardware-based security protocols' ,
    'Hardware attacks and countermeasures' ,
    'Malicious design modifications' ,
    'Side-channel analysis and countermeasures' ,
    'Hardware reverse engineering' ,
    'Systems security' ,
    'Operating systems security' ,
    'Mobile platform security' ,
    'Trusted computing' ,
    'Virtualization and security' ,
    'Browser security' ,
    'Distributed systems security' ,
    'Information flow control' ,
    'Denial-of-service attacks' ,
    'Firewalls' ,
    'Vulnerability management' ,
    'Penetration testing' ,
    'Vulnerability scanners' ,
    'File system security' ,
    'Network security' ,
    'Security protocols' ,
    'Web protocol security' ,
    'Mobile and wireless security' ,
    'Denial-of-service attacks' ,
    'Firewalls' ,
    'Database and storage security' ,
    'Data anonymization and sanitization' ,
    'Management and querying of encrypted data' ,
    'Information accountability and usage control' ,
    'Database activity monitoring' ,
    'Software and application security' ,
    'Software security engineering' ,
    'Web application security' ,
    'Social network security and privacy' ,
    'Domain-specific security and privacy architectures' ,
    'Software reverse engineering' ,
    'Human and societal aspects of security and privacy' ,
    'Economics of security and privacy' ,
    'Social aspects of security and privacy' ,
    'Privacy protections' ,
    'Usability in security and privacy' ,
    'Human-centered computing' ,
    'Human computer interaction (HCI)' ,
    'HCI design and evaluation methods' ,
    'User models' ,
    'User studies' ,
    'Usability testing' ,
    'Heuristic evaluations' ,
    'Walkthrough evaluations' ,
    'Laboratory experiments' ,
    'Field studies' ,
    'Interaction paradigms' ,
    'Hypertext / hypermedia' ,
    'Mixed / augmented reality' ,
    'Command line interfaces' ,
    'Graphical user interfaces' ,
    'Virtual reality' ,
    'Web-based interaction' ,
    'Natural language interfaces' ,
    'Collaborative interaction' ,
    'Interaction devices' ,
    'Graphics input devices' ,
    'Displays and imagers' ,
    'Sound-based input / output' ,
    'Keyboards' ,
    'Pointing devices' ,
    'Touch screens' ,
    'Haptic devices' ,
    'HCI theory, concepts and models' ,
    'Interaction techniques' ,
    'Auditory feedback' ,
    'Text input' ,
    'Pointing' ,
    'Gestural input' ,
    'Interactive systems and tools' ,
    'User interface management systems' ,
    'User interface programming' ,
    'User interface toolkits' ,
    'Empirical studies in HCI' ,
    'Interaction design' ,
    'Interaction design process and methods' ,
    'User interface design' ,
    'User centered design' ,
    'Activity centered design' ,
    'Scenario-based design' ,
    'Participatory design' ,
    'Contextual design' ,
    'Interface design prototyping' ,
    'Interaction design theory, concepts and paradigms' ,
    'Empirical studies in interaction design' ,
    'Systems and tools for interaction design' ,
    'Wireframes' ,
    'Collaborative and social computing' ,
    'Collaborative and social computing theory, concepts and paradigms' ,
    'Social content sharing' ,
    'Collaborative content creation' ,
    'Collaborative filtering' ,
    'Social recommendation' ,
    'Social networks' ,
    'Social tagging' ,
    'Computer supported cooperative work' ,
    'Social engineering (social sciences)' ,
    'Social navigation' ,
    'Social media' ,
    'Collaborative and social computing design and evaluation methods' ,
    'Social network analysis' ,
    'Ethnographic studies' ,
    'Collaborative and social computing systems and tools' ,
    'Blogs' ,
    'Wikis' ,
    'Reputation systems' ,
    'Open source software' ,
    'Social networking sites' ,
    'Social tagging systems' ,
    'Synchronous editors' ,
    'Asynchronous editors' ,
    'Empirical studies in collaborative and social computing' ,
    'Collaborative and social computing devices' ,
    'Ubiquitous and mobile computing' ,
    'Ubiquitous and mobile computing theory, concepts and paradigms' ,
    'Ubiquitous computing' ,
    'Mobile computing' ,
    'Ambient intelligence' ,
    'Ubiquitous and mobile computing systems and tools' ,
    'Ubiquitous and mobile devices' ,
    'Smartphones' ,
    'Interactive whiteboards' ,
    'Mobile phones' ,
    'Mobile devices' ,
    'Portable media players' ,
    'Personal digital assistants' ,
    'Handheld game consoles' ,
    'E-book readers' ,
    'Tablet computers' ,
    'Ubiquitous and mobile computing design and evaluation methods' ,
    'Empirical studies in ubiquitous and mobile computing' ,
    'Visualization' ,
    'Visualization techniques' ,
    'Treemaps' ,
    'Hyperbolic trees' ,
    'Heat maps' ,
    'Graph drawings' ,
    'Dendrograms' ,
    'Cladograms' ,
    'Visualization application domains' ,
    'Scientific visualization' ,
    'Visual analytics' ,
    'Geographic visualization' ,
    'Information visualization' ,
    'Visualization systems and tools' ,
    'Visualization toolkits' ,
    'Visualization theory, concepts and paradigms' ,
    'Empirical studies in visualization' ,
    'Visualization design and evaluation methods' ,
    'Accessibility' ,
    'Accessibility theory, concepts and paradigms' ,
    'Empirical studies in accessibility' ,
    'Accessibility design and evaluation methods' ,
    'Accessibility technologies' ,
    'Accessibility systems and tools' ,
    'Computing methodologies' ,
    'Symbolic and algebraic manipulation' ,
    'Symbolic and algebraic algorithms' ,
    'Combinatorial algorithms' ,
    'Algebraic algorithms' ,
    'Nonalgebraic algorithms' ,
    'Symbolic calculus algorithms' ,
    'Exact arithmetic algorithms' ,
    'Hybrid symbolic-numeric methods' ,
    'Discrete calculus algorithms' ,
    'Number theory algorithms' ,
    'Equation and inequality solving algorithms' ,
    'Linear algebra algorithms' ,
    'Theorem proving algorithms' ,
    'Boolean algebra algorithms' ,
    'Optimization algorithms' ,
    'Computer algebra systems' ,
    'Special-purpose algebraic systems' ,
    'Representation of mathematical objects' ,
    'Representation of exact numbers' ,
    'Representation of mathematical functions' ,
    'Representation of Boolean functions' ,
    'Representation of polynomials' ,
    'Parallel computing methodologies' ,
    'Parallel algorithms' ,
    'MapReduce algorithms' ,
    'Self-organization' ,
    'Shared memory algorithms' ,
    'Vector / streaming algorithms' ,
    'Massively parallel algorithms' ,
    'Parallel programming languages' ,
    'Artificial intelligence' ,
    'Natural language processing' ,
    'Information extraction' ,
    'Machine translation' ,
    'Discourse, dialogue and pragmatics' ,
    'Natural language generation' ,
    'Speech recognition' ,
    'Lexical semantics' ,
    'Phonology / morphology' ,
    'Language resources' ,
    'Knowledge representation and reasoning' ,
    'Description logics' ,
    'Semantic networks' ,
    'Nonmonotonic, default reasoning and belief revision' ,
    'Probabilistic reasoning' ,
    'Vagueness and fuzzy logic' ,
    'Causal reasoning and diagnostics' ,
    'Temporal reasoning' ,
    'Cognitive robotics' ,
    'Ontology engineering' ,
    'Logic programming and answer set programming' ,
    'Spatial and physical reasoning' ,
    'Reasoning about belief and knowledge' ,
    'Planning and scheduling' ,
    'Planning for deterministic actions' ,
    'Planning under uncertainty' ,
    'Multi-agent planning' ,
    'Planning with abstraction and generalization' ,
    'Robotic planning' ,
    'Evolutionary robotics' ,
    'Search methodologies' ,
    'Heuristic function construction' ,
    'Discrete space search' ,
    'Continuous space search' ,
    'Randomized search' ,
    'Game tree search' ,
    'Abstraction and micro-operators' ,
    'Search with partial observations' ,
    'Control methods' ,
    'Robotic planning' ,
    'Evolutionary robotics' ,
    'Computational control theory' ,
    'Motion path planning' ,
    'Philosophical/theoretical foundations of artificial intelligence' ,
    'Cognitive science' ,
    'Theory of mind' ,
    'Distributed artificial intelligence' ,
    'Multi-agent systems' ,
    'Intelligent agents' ,
    'Mobile agents' ,
    'Cooperation and coordination' ,
    'Computer vision' ,
    'Computer vision tasks' ,
    'Biometrics' ,
    'Scene understanding' ,
    'Activity recognition and understanding' ,
    'Video summarization' ,
    'Visual content-based indexing and retrieval' ,
    'Visual inspection' ,
    'Vision for robotics' ,
    'Scene anomaly detection' ,
    'Image and video acquisition' ,
    'Camera calibration' ,
    'Epipolar geometry' ,
    'Computational photography' ,
    'Hyperspectral imaging' ,
    'Motion capture' ,
    '3D imaging' ,
    'Active vision' ,
    'Computer vision representations' ,
    'Image representations' ,
    'Shape representations' ,
    'Appearance and texture representations' ,
    'Hierarchical representations' ,
    'Computer vision problems' ,
    'Interest point and salient region detections' ,
    'Image segmentation' ,
    'Video segmentation' ,
    'Shape inference' ,
    'Object detection' ,
    'Object recognition' ,
    'Object identification' ,
    'Tracking' ,
    'Reconstruction' ,
    'Matching' ,
    'Machine learning' ,
    'Learning paradigms' ,
    'Supervised learning' ,
    'Ranking' ,
    'Learning to rank' ,
    'Supervised learning by classification' ,
    'Supervised learning by regression' ,
    'Structured outputs' ,
    'Cost-sensitive learning' ,
    'Unsupervised learning' ,
    'Cluster analysis' ,
    'Anomaly detection' ,
    'Mixture modeling' ,
    'Topic modeling' ,
    'Source separation' ,
    'Motif discovery' ,
    'Dimensionality reduction and manifold learning' ,
    'Reinforcement learning' ,
    'Sequential decision making' ,
    'Inverse reinforcement learning' ,
    'Apprenticeship learning' ,
    'Multi-agent reinforcement learning' ,
    'Adversarial learning' ,
    'Multi-task learning' ,
    'Transfer learning' ,
    'Lifelong machine learning' ,
    'Learning under covariate shift' ,
    'Learning settings' ,
    'Batch learning' ,
    'Online learning settings' ,
    'Learning from demonstrations' ,
    'Learning from critiques' ,
    'Learning from implicit feedback' ,
    'Active learning settings' ,
    'Semi-supervised learning settings' ,
    'Machine learning approaches' ,
    'Classification and regression trees' ,
    'Kernel methods' ,
    'Support vector machines' ,
    'Gaussian processes' ,
    'Neural networks' ,
    'Logical and relational learning' ,
    'Inductive logic learning' ,
    'Statistical relational learning' ,
    'Learning in probabilistic graphical models' ,
    'Maximum likelihood modeling' ,
    'Maximum entropy modeling' ,
    'Maximum a posteriori modeling' ,
    'Mixture models' ,
    'Latent variable models' ,
    'Bayesian network models' ,
    'Learning linear models' ,
    'Perceptron algorithm' ,
    'Factorization methods' ,
    'Non-negative matrix factorization' ,
    'Factor analysis' ,
    'Principal component analysis' ,
    'Canonical correlation analysis' ,
    'Latent Dirichlet allocation' ,
    'Rule learning' ,
    'Instance-based learning' ,
    'Markov decision processes' ,
    'Partially-observable Markov decision processes' ,
    'Stochastic games' ,
    'Learning latent representations' ,
    'Deep belief networks' ,
    'Bio-inspired approaches' ,
    'Artificial life' ,
    'Evolvable hardware' ,
    'Genetic algorithms' ,
    'Genetic programming' ,
    'Evolutionary robotics' ,
    'Generative and developmental approaches' ,
    'Machine learning algorithms' ,
    'Dynamic programming for Markov decision processes' ,
    'Value iteration' ,
    'Q-learning' ,
    'Policy iteration' ,
    'Temporal difference learning' ,
    'Approximate dynamic programming methods' ,
    'Ensemble methods' ,
    'Boosting' ,
    'Bagging' ,
    'Spectral methods' ,
    'Feature selection' ,
    'Regularization' ,
    'Cross-validation' ,
    'Modeling and simulation' ,
    'Model development and analysis' ,
    'Modeling methodologies' ,
    'Model verification and validation' ,
    'Uncertainty quantification' ,
    'Simulation theory' ,
    'Systems theory' ,
    'Network science' ,
    'Simulation types and techniques' ,
    'Uncertainty quantification' ,
    'Quantum mechanic simulation' ,
    'Molecular simulation' ,
    'Rare-event simulation' ,
    'Discrete-event simulation' ,
    'Agent / discrete models' ,
    'Distributed simulation' ,
    'Continuous simulation' ,
    'Continuous models' ,
    'Real-time simulation' ,
    'Interactive simulation' ,
    'Multiscale systems' ,
    'Massively parallel and high-performance simulations' ,
    'Data assimilation' ,
    'Scientific visualization' ,
    'Visual analytics' ,
    'Simulation by animation' ,
    'Artificial life' ,
    'Simulation support systems' ,
    'Simulation environments' ,
    'Simulation languages' ,
    'Simulation tools' ,
    'Simulation evaluation' ,
    'Computer graphics' ,
    'Animation' ,
    'Motion capture' ,
    'Procedural animation' ,
    'Physical simulation' ,
    'Motion processing' ,
    'Collision detection' ,
    'Rendering' ,
    'Rasterization' ,
    'Ray tracing' ,
    'Non-photorealistic rendering' ,
    'Reflectance modeling' ,
    'Visibility' ,
    'Image manipulation' ,
    'Computational photography' ,
    'Image processing' ,
    'Texturing' ,
    'Image-based rendering' ,
    'Antialiasing' ,
    'Graphics systems and interfaces' ,
    'Graphics processors' ,
    'Graphics input devices' ,
    'Mixed / augmented reality' ,
    'Perception' ,
    'Graphics file formats' ,
    'Virtual reality' ,
    'Image compression' ,
    'Shape modeling' ,
    'Mesh models' ,
    'Mesh geometry models' ,
    'Parametric curve and surface models' ,
    'Point-based models' ,
    'Volumetric models' ,
    'Shape analysis' ,
    'Distributed computing methodologies' ,
    'Distributed algorithms' ,
    'MapReduce algorithms' ,
    'Self-organization' ,
    'Distributed programming languages' ,
    'Concurrent computing methodologies' ,
    'Concurrent programming languages' ,
    'Concurrent algorithms' ,
    'Applied computing' ,
    'Electronic commerce' ,
    'Digital cash' ,
    'E-commerce infrastructure' ,
    'Electronic data interchange' ,
    'Electronic funds transfer' ,
    'Online shopping' ,
    'Online banking' ,
    'Secure online transactions' ,
    'Online auctions' ,
    'Enterprise computing' ,
    'Enterprise information systems' ,
    'Intranets' ,
    'Extranets' ,
    'Enterprise resource planning' ,
    'Enterprise applications' ,
    'Data centers' ,
    'Business process management' ,
    'Business process modeling' ,
    'Business process management systems' ,
    'Business process monitoring' ,
    'Cross-organizational business processes' ,
    'Business intelligence' ,
    'Enterprise architectures' ,
    'Enterprise architecture management' ,
    'Enterprise architecture frameworks' ,
    'Enterprise architecture modeling' ,
    'Service-oriented architectures' ,
    'Event-driven architectures' ,
    'Business rules' ,
    'Enterprise modeling' ,
    'Enterprise ontologies, taxonomies and vocabularies' ,
    'Enterprise data management' ,
    'Reference models' ,
    'Business-IT alignment' ,
    'IT architectures' ,
    'IT governance' ,
    'Enterprise computing infrastructures' ,
    'Enterprise interoperability' ,
    'Enterprise application integration' ,
    'Information integration and interoperability' ,
    'Physical sciences and engineering' ,
    'Aerospace' ,
    'Avionics' ,
    'Archaeology' ,
    'Astronomy' ,
    'Chemistry' ,
    'Earth and atmospheric sciences' ,
    'Environmental sciences' ,
    'Engineering' ,
    'Computer-aided design' ,
    'Physics' ,
    'Mathematics and statistics' ,
    'Electronics' ,
    'Avionics' ,
    'Telecommunications' ,
    'Internet telephony' ,
    'Life and medical sciences' ,
    'Computational biology' ,
    'Molecular sequence analysis' ,
    'Recognition of genes and regulatory elements' ,
    'Molecular evolution' ,
    'Computational transcriptomics' ,
    'Biological networks' ,
    'Sequencing and genotyping technologies' ,
    'Imaging' ,
    'Computational proteomics' ,
    'Molecular structural biology' ,
    'Computational genomics' ,
    'Genomics' ,
    'Computational genomics' ,
    'Systems biology' ,
    'Consumer health' ,
    'Health care information systems' ,
    'Health informatics' ,
    'Bioinformatics' ,
    'Metabolomics / metabonomics' ,
    'Genetics' ,
    'Population genetics' ,
    'Proteomics' ,
    'Computational proteomics' ,
    'Transcriptomics' ,
    'Law, social and behavioral sciences' ,
    'Anthropology' ,
    'Ethnography' ,
    'Law' ,
    'Psychology' ,
    'Economics' ,
    'Sociology' ,
    'Computer forensics' ,
    'Surveillance mechanisms' ,
    'Investigation techniques' ,
    'Evidence collection, storage and analysis' ,
    'Network forensics' ,
    'System forensics' ,
    'Data recovery' ,
    'Arts and humanities' ,
    'Fine arts' ,
    'Performing arts' ,
    'Architecture (buildings)' ,
    'Computer-aided design' ,
    'Language translation' ,
    'Media arts' ,
    'Sound and music computing' ,
    'Computers in other domains' ,
    'Digital libraries and archives' ,
    'Publishing' ,
    'Military' ,
    'Cyberwarfare' ,
    'Cartography' ,
    'Agriculture' ,
    'Computing in government' ,
    'Voting / election technologies' ,
    'E-government' ,
    'Personal computers and PC applications' ,
    'Word processors' ,
    'Spreadsheets' ,
    'Computer games' ,
    'Microcomputers' ,
    'Operations research' ,
    'Consumer products' ,
    'Industry and manufacturing' ,
    'Supply chain management' ,
    'Command and control' ,
    'Computer-aided manufacturing' ,
    'Decision analysis' ,
    'Multi-criterion optimization and decision-making' ,
    'Transportation' ,
    'Forecasting' ,
    'Marketing' ,
    'Education' ,
    'Digital libraries and archives' ,
    'Computer-assisted instruction' ,
    'Interactive learning environments' ,
    'Collaborative learning' ,
    'Learning management systems' ,
    'Distance learning' ,
    'E-learning' ,
    'Computer-managed instruction' ,
    'Document management and text processing' ,
    'Document searching' ,
    'Document management' ,
    'Text editing' ,
    'Version control' ,
    'Document metadata' ,
    'Document capture' ,
    'Document analysis' ,
    'Document scanning' ,
    'Graphics recognition and interpretation' ,
    'Optical character recognition' ,
    'Online handwriting recognition' ,
    'Document preparation' ,
    'Markup languages' ,
    'Extensible Markup Language (XML)' ,
    'Hypertext languages' ,
    'Annotation' ,
    'Format and notation' ,
    'Multi / mixed media creation' ,
    'Image composition' ,
    'Hypertext / hypermedia creation' ,
    'Document scripting languages' ,
    'Social and professional topics' ,
    'Professional topics' ,
    'Computing industry' ,
    'Industry statistics' ,
    'Computer manufacturing' ,
    'Sustainability' ,
    'Management of computing and information systems' ,
    'Project and people management' ,
    'Project management techniques' ,
    'Project staffing' ,
    'Systems planning' ,
    'Systems analysis and design' ,
    'Systems development' ,
    'Computer and information systems training' ,
    'Implementation management' ,
    'Hardware selection' ,
    'Computing equipment management' ,
    'Pricing and resource allocation' ,
    'Software management' ,
    'Software maintenance' ,
    'Software selection and adaptation' ,
    'System management' ,
    'Centralization / decentralization' ,
    'Technology audits' ,
    'Quality assurance' ,
    'Network operations' ,
    'File systems management' ,
    'Information system economics' ,
    'History of computing' ,
    'Historical people' ,
    'History of hardware' ,
    'History of software' ,
    'History of programming languages' ,
    'History of computing theory' ,
    'Computing education' ,
    'Computational thinking' ,
    'Accreditation' ,
    'Model curricula' ,
    'Computing education programs' ,
    'Information systems education' ,
    'Computer science education' ,
    'CS1' ,
    'Computer engineering education' ,
    'Information technology education' ,
    'Information science education' ,
    'Computational science and engineering education' ,
    'Software engineering education' ,
    'Informal education' ,
    'Computing literacy' ,
    'Student assessment' ,
    'K-12 education' ,
    'Adult education' ,
    'Computing and business' ,
    'Employment issues' ,
    'Automation' ,
    'Computer supported cooperative work' ,
    'Economic impact' ,
    'Offshoring' ,
    'Reengineering' ,
    'Socio-technical systems' ,
    'Computing profession' ,
    'Codes of ethics' ,
    'Employment issues' ,
    'Funding' ,
    'Computing occupations' ,
    'Computing organizations' ,
    'Testing, certification and licensing' ,
    'Assistive technologies' ,
    'Computing / technology policy' ,
    'Intellectual property' ,
    'Digital rights management' ,
    'Copyrights' ,
    'Software reverse engineering' ,
    'Patents' ,
    'Trademarks' ,
    'Internet governance / domain names' ,
    'Licensing' ,
    'Treaties' ,
    'Database protection laws' ,
    'Secondary liability' ,
    'Soft intellectual property' ,
    'Hardware reverse engineering' ,
    'Privacy policies' ,
    'Censorship' ,
    'Pornography' ,
    'Hate speech' ,
    'Political speech' ,
    'Technology and censorship' ,
    'Censoring filters' ,
    'Surveillance' ,
    'Governmental surveillance' ,
    'Corporate surveillance' ,
    'Commerce policy' ,
    'Taxation' ,
    'Transborder data flow' ,
    'Antitrust and competition' ,
    'Governmental regulations' ,
    'Online auctions policy' ,
    'Consumer products policy' ,
    'Network access control' ,
    'Censoring filters' ,
    'Broadband access' ,
    'Net neutrality' ,
    'Network access restrictions' ,
    'Age-based restrictions' ,
    'Acceptable use policy restrictions' ,
    'Universal access' ,
    'Computer crime' ,
    'Social engineering attacks' ,
    'Spoofing attacks' ,
    'Phishing' ,
    'Identity theft' ,
    'Financial crime' ,
    'Malware / spyware crime' ,
    'Government technology policy' ,
    'Governmental regulations' ,
    'Import / export controls' ,
    'Medical information policy' ,
    'Medical records' ,
    'Personal health records' ,
    'Genetic information' ,
    'Patient privacy' ,
    'Health information exchanges' ,
    'Medical technologies' ,
    'Remote medicine' ,
    'User characteristics' ,
    'Race and ethnicity' ,
    'Religious orientation' ,
    'Gender' ,
    'Men' ,
    'Women' ,
    'Sexual orientation' ,
    'People with disabilities' ,
    'Geographic characteristics' ,
    'Cultural characteristics' ,
    'Age' ,
    'Children' ,
    'Seniors' ,
    'Adolescents' );
}
 
?>