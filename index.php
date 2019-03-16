
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- standard metadata -->
    <meta charset="utf-8" />
    <meta name="description" content="Fitch-style proof editor and checker" />
    <meta name="author" content="Kevin C. Klement" />
    <meta name="copyright" content="© Kevin C. Klement" />
    <meta name="keywords" content="logic,proof,deduction" />
    
    <!-- facebook opengraph stuff -->
    <meta property="og:title" content="Fitch-style proof editor and checker" />
    <meta property="og:image" content="sample.png" />
    <meta property="og:description" content="Fitch-style proof proof editor and checker" />

    <!-- if mobile ready -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />

    <!-- web icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <title>proof checker</title>

    <!-- page style from https://github.com/dhg/Skeleton -->
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/skeleton.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">    
    <script 
    src="https://code.jquery.com/jquery-3.1.1.min.js" 
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" 
    crossorigin="anonymous">
    </script>
    <script src="../semantic/semantic.min.js"></script>
    
    <style>
      body {font-family: "Noto Sans";}
      a, a:hover, a:visited, a:focus, a:active {color: #0c1c8c; text-decoration: none; font-weight: bold ;}
      label, legend { display: inline-block; } 
    </style>
  
    <!-- css file -->
    <link rel="stylesheet" type="text/css" href="../css/proofs.css" />
    <!-- javascript file -->
    <script type="text/javascript" charset="utf-8" src="../js/ajax.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/syntax.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/proofs.js"></script>

    <script type="text/javascript">
      function createProb() {
      predicateSettings = (document.getElementById("folradio").checked);
      var pstr = document.getElementById("probpremises").value;
      pstr = pstr.replace(/^[,;\s]*/,'');
      pstr = pstr.replace(/[,;\s]*$/,'');
      var prems = pstr.split(/[,;\s]*[,;][,;\s]*/);
      var sofar = [];
      for (var a=0; a<prems.length; a++) {
        if (prems[a] != '') {
          var w = parseIt(fixWffInputStr(prems[a]));
          if (!(w.isWellFormed)) {
            alert('Premise ' + (a+1) + ' is not well formed.');
            return;
            }
          if ((predicateSettings) && (!(w.allFreeVars.length == 0))) {
            alert('Premise ' + (a+1) + ' is not closed.');
            return;
          }
          sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": "Pr"
          });
        }
      }
      var conc = fixWffInputStr(document.getElementById("probconc").value);
      var cw = parseIt(conc);
      if (!(cw.isWellFormed)) {
        alert('Conclusion is not well formed.');
        return;
      }
      if ((predicateSettings) && (!(cw.allFreeVars.length == 0))) {
        alert('The conclusion is not closed.');
        return;
      }
      document.getElementById("problabel").style.display = "block";
      document.getElementById("proofdetails").style.display = "block";
      var probstr = '';
      for (var k=0; k<sofar.length; k++) {
        probstr += prettyStr(sofar[k].wffstr);
          if ((k+1) != sofar.length) {
          probstr += ', ';
        }
      }
      document.getElementById("proofdetails").innerHTML = "Construct a proof for the argument: " + probstr + " ∴ " +  wffToString(cw, true);
      var tp = document.getElementById("theproof");
      tp.innerHTML = '';
      makeProof(tp, sofar, wffToString(cw, false));
      }
    </script>

  </head>
  <body>
      <div id="top-menu" class="ui menu" style = "height : 60px;">
          <div class="header item">
            <h1 id="title" style = "color : white;">Proof Checker</h1>
          </div>
          <a href="" class="item" style = "color : white;">
            Help
          </a>
          <a class="item" style = "color : white;">
            About us
          </a>
          <a class="item" style = "color : white;">
            References
          </a>

          
      </div>

  <!-- middle stuff -->
  
      <div class="ui vertically divided grid">
          <div class="two column row" style="padding:2rem">
            <div class="column">
              
                <!-- <div id="mid-container"> -->
                    <h3 id="textarea-header" class="ui top attached header">
                      Check Your Proof:
                    </h3>
                    <div id="textarea-container" class="ui attached segment">

                      <input type="radio" name="tflfol" id="tflradio" checked /> <label for="tflradio">Propositional </label>
                      <input type="radio" name="tflfol" id="folradio" /> <label for="folradio">First-Order</label><br /><br />
                      Premises (separate with “,” or “;”):<br />
                      <input id="probpremises" /><br /><br />
                      Conclusion:<br />
                      <input id="probconc" /><br /><br />
                      <button type="button" onclick="createProb();" >create problem</button><br /><br />
                        
                      <h3 id="problabel" style="display: none;">Proof:</h3>
                      <p id="proofdetails" style="display: none;"></p>
                      <div id="theproof"></div>
                      <br>
                      <br>
                      
                    </div>
                <!-- </div> -->

            </div>
            <div class="column" style="margin-left: 0;">

                <h3 id="textarea-header" class="ui top attached header">
                  How to Use the Checker:
                </h3>
                <div id="textarea-container" class="ui attached segment">

                  <strong><p style="text-decoration: underline;">Symbols:</p></strong>
                  <table id="symkey">
                      <tr><td>For negation you may use any of the symbols:</td><td> <span class="tt">¬ ~ ∼ - −</span></td></tr>
                      <tr><td>For conjunction you may use any of the symbols:</td><td> <span class="tt">∧ ^ &amp; . · *</span></td></tr>
                      <tr><td>For disjunction you may use any of the symbols:</td><td> <span class="tt">∨ v</span></td></tr>
                      <tr><td>For the biconditional you may use any of the symbols:</td><td> <span class="tt">↔ ≡ &lt;-&gt; &lt;&gt;</span> (or in TFL only: <span class="tt">=</span>)</td></tr>
                      <tr><td>For the conditional you may use any of the symbols:</td><td> <span class="tt">→ ⇒ ⊃ -&gt; &gt;</span></td></tr>
                      <tr><td>For the universal quantifier (FOL only), you may use any of the symbols:</td><td> <span class="tt">∀x (∀x) Ax (Ax) (x) ⋀x</span></tr>
                      <tr><td>For the existential quantifier (FOL only), you may use any of the symbols:</td><td> <span class="tt">∃x (∃x) Ex (Ex) ⋁x</span></tr>
                      <tr><td>For a contradiction you may use any of the symbols:</td><td> <span class="tt"> ⊥ XX #</span></td></tr>
                  </table>

                  <strong><p style="text-decoration: underline;">The following buttons do the following things:</p></strong><br>
                  <table id="key">
                          <tr><td><a>×</a></td><td>= delete this line</td></tr>
                          <tr><td><a><img src="../assets/new.png" alt="|+"/></a></td><td>= add a line below this one</td></tr>
                          <tr><td><a><img src="../assets/newsp.png" alt="||+" /></a></td><td>= add a new subproof below this line</td></tr>
                          <tr><td><a><img src="../assets/newb.png" alt="&lt;+" /></a></td><td>= add a new line below this subproof to the parent subproof</td></tr>
                          <tr><td><a><img src="../assets/newspb.png" alt="&lt;|+" /></a></td><td>= add a new subproof below this subproof to the parent subproof</td></tr>
                  </table>

                </div>

            </div>
          </div>
        </div>


	   <!-- <p>This is a demo of a proof checker for Fitch-style natural deduction systems found in many popular introductory logic textbooks. The specific system used here is the one found in <em><a href="http://forallx.openlogicproject.org/">forall x: Calgary Remix</a></em>. (Although based on <em><a href="https://www.fecundity.com/logic/">forall x: an Introduction to Formal Logic</a></em>, the proof system in that original version differs from the one used here and in the <em>Calgary Remix</em>. However, the system also supports the rules used in the <em><a href="http://people.ds.cam.ac.uk/tecb2/forallx.shtml">forall x: Cambridge</a></em> remix.)</p> 
	  
	   <h3>Create a new problem</h3>

	  <input type="radio" name="tflfol" id="tflradio" checked /> <label for="tflradio">Propositional </label>
	  <input type="radio" name="tflfol" id="folradio" /> <label for="folradio">First-Order</label><br />
	  Premises (separate with “,” or “;”):<br />
	  <input id="probpremises" /><br />
	  Conclusion:<br />
	  <input id="probconc" /><br />
	  <button type="button" onclick="createProb();" >create problem</button><br /><br />
      
	  <h3 id="problabel" style="display: none;">Proof:</h3>
	  <p id="proofdetails" style="display: none;"></p>
	  <div id="theproof"></div> 

	   <h3>Sample exercise sets</h3>

	  <ul>
            <li><a href="tfl-exs.html">Sample Truth-Functional Logic exercises</a> (Chap. 15, ex. C; Chap. 17, ex. B)</li>
            <li><a href="fol-exs.html">Sample First-Order Logic exercises</a> (Chap. 32, ex. E; Chap. 34, ex. A)</li>
	  </ul> 
      
  
	   <h3>Instructions</h3>
      
	  <table id="symkey">
            <tr><td>For negation you may use any of the symbols:</td><td> <span class="tt">¬ ~ ∼ - −</span></td></tr>
            <tr><td>For conjunction you may use any of the symbols:</td><td> <span class="tt">∧ ^ &amp; . · *</span></td></tr>
            <tr><td>For disjunction you may use any of the symbols:</td><td> <span class="tt">∨ v</span></td></tr>
            <tr><td>For the biconditional you may use any of the symbols:</td><td> <span class="tt">↔ ≡ &lt;-&gt; &lt;&gt;</span> (or in TFL only: <span class="tt">=</span>)</td></tr>
            <tr><td>For the conditional you may use any of the symbols:</td><td> <span class="tt">→ ⇒ ⊃ -&gt; &gt;</span></td></tr>
            <tr><td>For the universal quantifier (FOL only), you may use any of the symbols:</td><td> <span class="tt">∀x (∀x) Ax (Ax) (x) ⋀x</span></tr>
            <tr><td>For the existential quantifier (FOL only), you may use any of the symbols:</td><td> <span class="tt">∃x (∃x) Ex (Ex) ⋁x</span></tr>
            <tr><td>For a contradiction you may use any of the symbols:</td><td> <span class="tt"> ⊥ XX #</span></td></tr>
	  </table> 
	
	   <p>Apart from premises and assumptions, each line has a cell immediately to its right for entering the justifcation. Click on it to enter the justification as, e.g. “&I 1,2”.</p>
	  <p>Hopefully it is otherwise more or less obvious how to use it.</p>
             

	 <div class="four columns">
	  <h2>Rules</h2>
<h5>Basic rules</h5>
	      <img src="rules/ai.svg">
	      <img src="rules/ae.svg">
	      <img src="rules/oi.svg">
	      <img src="rules/oe.svg">
	      <img src="rules/ci.svg">
	      <img src="rules/ce.svg">
	      <img src="rules/ni.svg">
	      <img src="rules/ne.svg">
	      <img src="rules/xp.svg">
	      <img src="rules/ip.svg">
	      <img src="rules/Ai.svg">
	      <img src="rules/Ae.svg">
	      <img src="rules/Ei.svg">
	      <img src="rules/Ee.svg">
	      <h5>Derived rules</h5>
	      <img src="rules/r.svg">
	      <img src="rules/ds.svg">
	      <img src="rules/mt.svg">
	      <img src="rules/dne.svg">
	      <img src="rules/lem.svg">
	      <img src="rules/dem.svg">
	      <img src="rules/qc.svg">
	      <h5>Rules for Cambridge</h5>
	      <img src="rules/ri.svg">
	      <img src="rules/re.svg">
	      <img src="rules/tnd.svg"> -->
  </body>
</html>
