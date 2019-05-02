<?php
session_start();
//code to download data to csv
// var csv = 'id,entryType,userSubmitted, proofName, proofType, Premise, Logic, Rules, proofCompleted, timeSubmitted, Conclusion\n';
// data.forEach(element => {
//   csv += element.id + ",";
//   csv += element.entryType + ",";
//   csv += element.userSubmitted + ",";
//   csv += element.proofName + ",";
//   csv += element.proofType + ",";
//   var pr = "["
//   for(var i = 0; i < element.premise.length; i++){
//     if(i + 1 === element.premise.length){
//       pr += element.premise[i];
//     }
//     else{
//       pr += element.premise[i] + "|"
//     }
//   }
//   pr += "]";
//   csv += pr  + ",";
//   var lo = "["
//   for(var i = 0; i < element.logic.length; i++){
//     if(i + 1 === element.logic.length){
//       lo += element.logic[i];
//     }
//     else{
//       lo += element.logic[i] + "|"
//     }
//   }
//   lo += "]";
//   csv += lo  + ",";
//   var ru = "["
//   for(var i = 0; i < element.rules.length; i++){
//     if(i + 1 === element.lorulesgic.length){
//       ru += element.rules[i];
//     }
//     else{
//       ru += element.rules[i] + "|"
//     }
//   }
//   ru += "]";
//   csv += ru  + ",";
//   csv += element.proofCompleted  + ",";
//   csv += element.timeSubmitted  + ",";
//   csv += element.conclusion  + ",";
// });
// var hiddenElement = document.createElement('a');
// hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
// hiddenElement.target = '_blank';
// hiddenElement.download = 'data.csv';
// hiddenElement.click();
?>
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
    <link rel="icon" href="/assets/logicproofchecker.png">
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
    var adminUsers = ["drbruns"];
    var proofsPulled;
    var repoproofsPulled;
    var finishedrepoproofsPulled
    var user = sessionStorage.getItem("userlogged");

    class User{
      id;
      entryType;
      username;
      email;
      password;

      constructor(id, entryType, username, email, password){
        this.id = id;
        this.entryType = entryType;
        this.username = username;
        this.email = email;
        this.password = password;
      }
    }
    
    function hasNumber(myString) {
      return /\d/.test(myString);
    }
    //unfinished proofs
    function loadSelect(){
        user = sessionStorage.getItem("userlogged");
        $.ajax({
          type: "GET",
          url: "https://proofsdb.herokuapp.com/user/" + user,
          success: function(data,status) {
            proofsPulled = data;
            console.log(proofsPulled);
            loadproofInnerHtml = "";
            loadproofInnerHtml += "<option>select one</option>"
            proofsPulled.forEach(element => {
              loadproofInnerHtml += "<option value='" + element.id + "'>" + element.proofName + "</option>"
            });
            $("#loadproof").html(loadproofInnerHtml);
          },
          error: function(data,status) { //optional, used for debugging purposes
              console.log(data);
          }
      });//ajax
    }
    //repo proofs
    function repoloadSelect(){
        user = sessionStorage.getItem("userlogged");
        $.ajax({
          type: "GET",
          url: "https://proofsdb.herokuapp.com/repo",
          success: function(data,status) {
            repoproofsPulled = data;
            console.log(repoproofsPulled);
            loadproofInnerHtml = "";
            loadproofInnerHtml += "<option>select one</option>"
            repoproofsPulled.forEach(element => {
              loadproofInnerHtml += "<option value='" + element.id + "'>" + element.proofName + "</option>"
            });
            $("#loadrepo").html(loadproofInnerHtml);
          },
          error: function(data,status) { //optional, used for debugging purposes
              console.log(data);
          }
      });//ajax
    }
    //finished repo proofs
    function finishedrepoloadSelect(){
        user = sessionStorage.getItem("userlogged");
        $.ajax({
          type: "GET",
          url: "https://proofsdb.herokuapp.com/completedrepo/" + user,
          success: function(data,status) {
            finishedrepoproofsPulled = data;
            console.log(finishedrepoproofsPulled);
            loadproofInnerHtml = "";
            loadproofInnerHtml += "<option>select one</option>"
            finishedrepoproofsPulled.forEach(element => {
              loadproofInnerHtml += "<option value='" + element.id + "'>" + element.proofName + "</option>"
            });
            $("#loadfinishedrepo").html(loadproofInnerHtml);
          },
          error: function(data,status) { //optional, used for debugging purposes
              console.log(data);
          }
      });//ajax
    }
    </script>

  </head>
  <body>
      <div id="top-menu" class="ui menu" style = "height : 60px;">
          <div class="header item">
            <h1 id="title" style = "color : white;">Proof Checker</h1>
            <!-- <img id="logo" src="/assets/applogo.png" alt="Italian Trulli" > -->
          </div>
          <a href="help.html" class="item" style = "color : white;">
            Help
          </a>
          <a class="item" style = "color : white;">
            About us
          </a>
          <a class="item" style = "color : white;">
            References
          </a>
          <div class="right menu">
  	        <p id="log-sign" class="item" style = "color : white;">
              
            </p>
	        </div>
      </div>

  <!-- middle stuff -->
      <div id="load-container" >
        <div style="float: left;"> 
          <label for="loadproof">load unfinished proofs: </label>
          <select id="loadproof">
            <option> waiting for server...</option>
          </select>
        </div>
        <!--  -->
        <div style="float: left; padding-left: .9rem;"> 
          <label for="loadrepo">load repository problems: </label>
          <select id="loadrepo" data-content="Loading repository problems will lock the 'name your proof', 'Premise', and 'Conclusion' inputs. To resart press the 'resart proof checking from scratch' button or refesh the page.">
            <option> waiting for server...</option>
          </select>
        </div>
         <!--  -->
         <div style="float: left; padding-left: .9rem;"> 
          <label for="loadfinshedrepo">finished repository problems: </label>
          <select id="loadfinishedrepo" data-content="Finished repository problems will lock the 'name your proof', 'Premise', and 'Conclusion' inputs. To resart press the 'resart proof checking from scratch' button or refesh the page.">
            <option> waiting for server...</option>
          </select>
        </div>
      </div>
      
      <div class="ui vertically divided grid" style="clear: both;">
          <div class="two column row" style="padding:1.5rem;padding-top:1rem;">
            <div class="column">
              
                    <h3 id="textarea-header" class="ui top attached header">
                      Check Your Proof:
                    </h3>
                    <div id="textarea-container" class="ui attached segment">

                        <div id="nameYourProof" style="padding-bottom: 14px;">
                          <label>name your proof:</label>
                          <div class="ui input" >
                            <input id="proofName" type="text" placeholder="proof name" data-content="Naming your proof will allow you to finish it later if it is incomplete 👍🏽">
                          </div>
                        </div>

                      <input type="radio" name="tflfol" id="tflradio" checked /> <label for="tflradio">Propositional </label>
                      <input type="radio" name="tflfol" id="folradio" /> <label for="folradio">First-Order</label><br /><br />
                      Premises (separate with “,” or “;”):<br />
                      <input id="probpremises" /><br /><br />
                      Conclusion:<br />
                      <input id="probconc" /><br /><br />
                      <button type="button" id="createProb">create problem</button><br /><br />
                        
                      <h3 id="problabel" style="display: none;">Proof:</h3>
                      <p id="proofdetails" style="display: none;"></p>
                      <div id="theproof"></div>
                      <br>
                      <br>
                      
                      <div id="insertToDB" hidden>
                        <label for="proof-name">Proof Name: </label>
                        <input id="proof-name" /> <br> <br>
                        <button class="button">Send Proof To Database</button>
                      </div>  
                        
                        
                    </div>

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

        <hr style="margin-bottom: 15px;">
        <img id="logo" src="/assets/logicproofchecker.png">
        <p id="bottom">Capstone 2019</p>
        <p id="bottom">Logic Proof Checker</p>
        <p id="bottom">Jay Arellano / Mustafa Al Asadi / Gautam Tata / Ben Lenz</p>
        <br>
        
      <div class="ui basic modal">
      <h1 class="ui top attached header" id="modal-head" style="text-align: center;margin-left: 0px;margin-right: 0px;background-color: white;color: #002A4E;">login / sign up</h1>    
      <div class="ui attached placeholder segment" id="modal-container" style="margin: 0 0 0 0;border-radius: 0 0 .28571429rem .28571429rem;max-width: 100%;">
        <div class="ui two column very relaxed stackable grid" style="margin:0;">
          <div class="column">
            <!--left container-->
            <div class="ui form">
              <div class="field">
                <label>Username</label>
                <div class="ui input">
                  <input id="uIN" type="text" placeholder="username">
                </div>
              </div>
              <div class="field">
                <label>Password</label>
                <div class="ui input">
                  <input id="pIN" type="password" placeholder="password">
                  <span toggle="#pIN" class="fa fa-fw fa-eye field-icon toggle-password">show</span>
                </div>
              </div>
              <div id="login-button" class="ui submit button" style="background-color: #002A4E; color:white;">login</div>
            </div>
          </div>
          <div class="middle aligned column" style="margin-left: 0px;"> 
          <!--right container-->
            <div class="ui form">
              <div class="field">
                <label>Username <span id="uUPspan">username is taken</span></label>
                <div class="ui input">
                  <input id="uUP" type="text" placeholder="username">
                </div>
              </div>
              <div class="field">
                <label>Email</label>
                <div class="ui input">
                  <input id="eUP" type="text" placeholder="email">
                </div>
              </div>
              <div class="field">
                <label>Password</label>
                <div class="ui input">
                  <input id="pUP" type="password" placeholder="password">
                  <span toggle="#pUP" class="fa fa-fw fa-eye field-icon toggle-password">show</span>
                </div>
              </div>
              <div class="field">
                <label>Re-Enter Password</label>
                <div class="ui input">
                  <input id="repUP" type="password" placeholder="password">
                  <span toggle="#repUP" class="fa fa-fw fa-eye field-icon toggle-password">show</span>
                </div>
              </div>
              <div id="signupButton" class="ui submit button" style="background-color: #002A4E; color:white;">sign up</div>
            </div>
          </div>
        </div>
        <div class="ui vertical divider">
          Or
        </div>
      </div>

      <div id="logoutmodal" class="ui basic modal segment">
        <div id="logoutUsername" class="ui icon header">
        </div>
        <div class="content" style="text-align: center;">
          Would like to log out?
        </div>
        <div class="actions" style="text-align: center;">
          <div class="ui basic cancel inverted button">
            cancel
          </div>
          <div id="logoutButton" class="ui red ok inverted button">
            logout
          </div>
        </div>
      </div>

      </div>
        
  </body>
  <script type="text/javascript">
      sessionStorage.setItem("repoProblem", "false")
      $('#logoutmodal').modal('hide');
      var signInGood = true;
      $("#uUPspan").hide();

      //login and sign up modal;
      $("#log-sign").click(function(){
        if(sessionStorage.getItem("userlogged") === null){
          $('.ui.basic.modal').modal('show');
        }else{
          $("#logoutUsername").html(sessionStorage.getItem("userlogged"));
          $('#logoutmodal').modal('show');
        }
      });

      //checking if there is a user logged in
      if(sessionStorage.getItem("userlogged") === null){
        $("#load-container").hide();
        $("#nameYourProof").hide();
        $("#log-sign").html("Login / Sign-up");
      }else{
        $("#load-container").show();
        $("#nameYourProof").show();
        if(sessionStorage.getItem("administrator") === true){
          $("#log-sign").html("Admin: " + sessionStorage.getItem("userlogged").toString());
        }else{
          $("#log-sign").html(sessionStorage.getItem("userlogged").toString());
        }
        loadSelect();
        repoloadSelect();
        finishedrepoloadSelect();
      }
      //end checking if there is a user logged in 

      //logout
      $("#logoutButton").click(function(){
        sessionStorage.clear();
        location.reload(); 
      });
      //end logout

      //logging in
      $("#login-button").click(function(){
        var u = $("#uIN").val();
        var p = $("#pIN").val();

        if(u === "" || p === ""){
          alert("LOGIN ERROR: username or password empty!");
        }
        else{
          $.ajax({
          type: "GET",
          url: "https://proofsdb.herokuapp.com/li/" + u,
          success: function(data,status) {
            console.log(adminUsers.length);
            if(u === data.username && p === data.password){
              for(var i = 0; i < adminUsers.length; i++){
                if(adminUsers[i] === data.username){
                  sessionStorage.setItem("administrator", true);
                  alert(sessionStorage.getItem("administrator"));
                  console.log("you are an administrator!");
                  break;
                }
              }
              sessionStorage.setItem("userlogged", data.username);
              $("#load-container").show();
              $("#log-sign").html(sessionStorage.getItem("userlogged"));
              loadSelect();
              repoloadSelect();
              finishedrepoloadSelect();
              $('.ui.basic.modal').modal('hide');
              //location.reload(); 
            }else{
              console.log(data);
              alert("username or password incorrect");
              sessionStorage.removeItem("userlogged");
              location.reload(); 
            }
          },
          error: function(data,status) { //optional, used for debugging purposes
            console.log(status);
            console.log(data);
          }
          });//ajax
        }
      });
      //end loggin in

      //checking if username is valid on signup
      $("#uUP").on("keyup paste", function(){
        if($("#uUP").val().includes("/") || $("#uUP").val().includes("\\")){
          alert("username cannot contail '/' or '\\'");
        }
        if($("#uUP").val() === ""){
          $("#uUP").css("background-color", "white");
        }else{
          var us = $("#uUP").val();
        $.ajax({
         type: "GET",
         url: "https://proofsdb.herokuapp.com/li/" + us,
         success: function(data,status) {
           console.log(data);
           if(data === ""){
            $("#uUP").css("background-color", "#e7ffdd");
            $("#uUPspan").hide();
            signInGood = true;
           }else{
            $("#uUP").css("background-color", "#ffdddd");
            $("#uUPspan").show();
            signInGood = false;
            }
         },
         error: function(data,status) { //optional, used for debugging purposes
         }
        });//ajax
        }
      });
      //end checking if username is valid on signup

      //signing up
      $("#signupButton").click(function () {
        if($("#uUP").val() === "" || $("#eUP").val() === "" || 
        $("#pUP").val() === "" || $("#repUP").val() === ""){
          alert("all fields must be filled!");
        }
        else if(signInGood === false){
          alert("CANNOT SIGN UP WITH TAKEN USERNAME");
        }
        else if($("#pUP").val().length < 7){
          alert("password must be at least 7 characters long");
        }
        else if(!hasNumber($("#pUP").val())){
          alert("password must have at least one number");
        }
        else if($("#pUP").val() !== $("#repUP").val()){
          alert("passwords do not match");
        }else{
          var id = null;
          var entryType = "user";
          var username = $("#uUP").val();
          var email = $("#eUP").val();
          var password = $("#pUP").val();

          var newUser = new User(id, entryType, username, email, password);

          //sending proof to database, still need user sign in
          $.ajax({
              type: "POST",
              url: "https://proofsdb.herokuapp.com/newuser",
              contentType: "application/json",
              dataType: "json",
              data: JSON.stringify(newUser),
              success: function(data,status) {
                sessionStorage.setItem("userlogged", username);
                location.reload(); 
              },
              error: function(data,status) { //optional, used for debugging purposes
                  
              }
          });//ajax
        }
      });
      //end signing up

    //hide proof loader if user is in insert mode
    var url_string =window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("mode");
    if(c==="insert"){
      $("#load-container").hide();
    }
            
    //creating a problem based on premise and conclusion
    $("#createProb").click( function() {
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
    
    
    //checking if there is a user logged in
  
    if(sessionStorage.getItem("userlogged") === null){

    }else{ //a user is logged in
      var url_string =window.location.href;
      var url = new URL(url_string);
      var c = url.searchParams.get("mode");
      if(c=="insert")
      $("#insertToDB").show();      
    }
      
      
    });
    //end creating a problem based on premise and conclusion
    
    //loading a proof
     $("#loadproof").change(function(){
      var proofId = $(this).children("option:selected").val();
      var proofwanted;

      proofsPulled.forEach(element => {
        if(element.id === proofId){
          proofwanted = element
        }
      });

      var premString = "";
      for(var i = 0; i < proofwanted.premise.length; i++){
        if(i+1 === proofwanted.premise.length){
          premString += proofwanted.premise[i];
        }
        else{
          premString += proofwanted.premise[i] + ", ";
        }
      }

      var sofar = [];
      for(var i = 0; i < proofwanted.premise.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.premise[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": "Pr"
          });
      }
      for(var i = 0; i < proofwanted.logic.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.logic[i]));
        //var r = parseIt(fixWffInputStr(proofwanted.rules[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": proofwanted.rules[i]
          });
      }
      var conc = fixWffInputStr(proofwanted.conclusion)
      var cw = parseIt(conc);
      var probstr = '';
      for (var k=0; k<sofar.length; k++) {
        probstr += prettyStr(sofar[k].wffstr);
          if ((k+1) != sofar.length) {
          probstr += ', ';
        }
      }
      document.getElementById("proofdetails").innerHTML = "Construct a proof for the argument: " + probstr + " ∴ " +  wffToString(cw, true);
      var tp = document.getElementById("theproof");
      $("#probpremises").val(premString);
      $("#probconc").val(proofwanted.conclusion);
      $("#proofName").val(proofwanted.proofName);
      if(proofwanted.proofType === "prop"){
        document.getElementById("tflradio").checked = true;
      }
      else{
        document.getElementById("folradio").checked = true;
      }
      $("#theproof").html("");
      $("#proofdetails").show();
      makeProof(tp, sofar, wffToString(cw, false));
     });
    /// end loading a proof

    //loading a proof from repo
    $("#loadrepo").change(function(){
      var proofId = $(this).children("option:selected").val();
      var proofwanted;

      repoproofsPulled.forEach(element => {
        if(element.id === proofId){
          proofwanted = element
        }
      });

      var premString = "";
      for(var i = 0; i < proofwanted.premise.length; i++){
        if(i+1 === proofwanted.premise.length){
          premString += proofwanted.premise[i];
        }
        else{
          premString += proofwanted.premise[i] + ", ";
        }
      }

      var sofar = [];
      for(var i = 0; i < proofwanted.premise.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.premise[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": "Pr"
          });
      }
      for(var i = 0; i < proofwanted.logic.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.logic[i]));
        //var r = parseIt(fixWffInputStr(proofwanted.rules[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": proofwanted.rules[i]
          });
      }
      var conc = fixWffInputStr(proofwanted.conclusion)
      var cw = parseIt(conc);
      var probstr = '';
      for (var k=0; k<sofar.length; k++) {
        probstr += prettyStr(sofar[k].wffstr);
          if ((k+1) != sofar.length) {
          probstr += ', ';
        }
      }
      document.getElementById("proofdetails").innerHTML = "Construct a proof for the argument: " + probstr + " ∴ " +  wffToString(cw, true);
      var tp = document.getElementById("theproof");
      $("#probpremises").val(premString);
      $("#probconc").val(proofwanted.conclusion);
      $("#proofName").val(proofwanted.proofName);
      document.getElementById("proofName").disabled = true;
      document.getElementById("probconc").disabled = true;
      document.getElementById("probpremises").disabled = true;
      if(proofwanted.proofType === "prop"){
        document.getElementById("tflradio").checked = true;
      }
      else{
        document.getElementById("folradio").checked = true;
      }
      $("#theproof").html("");
      $("#proofdetails").show();
      sessionStorage.setItem("repoProblem", "true");
      makeProof(tp, sofar, wffToString(cw, false));
     });
    ///end loading a proof from repo

    //loading a finished proof from repo
    $("#loadfinishedrepo").change(function(){
      var proofId = $(this).children("option:selected").val();
      var proofwanted;

      finishedrepoproofsPulled.forEach(element => {
        if(element.id === proofId){
          proofwanted = element
        }
      });

      var premString = "";
      for(var i = 0; i < proofwanted.premise.length; i++){
        if(i+1 === proofwanted.premise.length){
          premString += proofwanted.premise[i];
        }
        else{
          premString += proofwanted.premise[i] + ", ";
        }
      }

      var sofar = [];
      for(var i = 0; i < proofwanted.premise.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.premise[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": "Pr"
          });
      }
      for(var i = 0; i < proofwanted.logic.length; i++){
        var w = parseIt(fixWffInputStr(proofwanted.logic[i]));
        //var r = parseIt(fixWffInputStr(proofwanted.rules[i]));
        sofar.push({
            "wffstr": wffToString(w, false),
            "jstr": proofwanted.rules[i]
          });
      }
      var conc = fixWffInputStr(proofwanted.conclusion)
      var cw = parseIt(conc);
      var probstr = '';
      for (var k=0; k<sofar.length; k++) {
        probstr += prettyStr(sofar[k].wffstr);
          if ((k+1) != sofar.length) {
          probstr += ', ';
        }
      }
      document.getElementById("proofdetails").innerHTML = "Construct a proof for the argument: " + probstr + " ∴ " +  wffToString(cw, true);
      var tp = document.getElementById("theproof");
      $("#probpremises").val(premString);
      $("#probconc").val(proofwanted.conclusion);
      $("#proofName").val(proofwanted.proofName);
      document.getElementById("proofName").disabled = true;
      document.getElementById("probconc").disabled = true;
      document.getElementById("probpremises").disabled = true;
      if(proofwanted.proofType === "prop"){
        document.getElementById("tflradio").checked = true;
      }
      else{
        document.getElementById("folradio").checked = true;
      }
      $("#theproof").html("");
      $("#proofdetails").show();
      sessionStorage.setItem("repoProblem", "true");
      makeProof(tp, sofar, wffToString(cw, false));
     });
    ///end loading a finsshed proof from repo

    $(".toggle-password").click(function(){
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
        $(this).css("color", "black");
      } else {
        $(this).css("color", "rgb(160, 160, 160)");
        input.attr("type", "password");
      }
    });

    $('#proofName').popup({ 
      on: 'hover'
    });
    $('#loadrepo').popup({ 
      on: 'hover'
    });
    $('#loadfinishedrepo').popup({ 
      on: 'hover'
    });
  </script>
</html>
