sessionStorage.setItem("repoProblem", "false")
$('#logoutmodal').modal('hide');
var signInGood = true;
$("#uUPspan").hide();

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

$("#downloadRepo").click(function(){
    $.ajax({
        type: "GET",
        url: "https://proofsdb.herokuapp.com/repodata",
        success: function(data,status) {
            var csv = 'id,entryType,userSubmitted, proofName, proofType, Premise, Logic, Rules, proofCompleted, timeSubmitted, Conclusion\n';
            data.forEach(element => {
                csv += element.id + ",";
                csv += element.entryType + ",";
                csv += element.userSubmitted + ",";
                csv += element.proofName + ",";
                csv += element.proofType + ",";
                var pr = "["
                for(var i = 0; i < element.premise.length; i++){
                    if(i + 1 === element.premise.length){
                        pr += element.premise[i];
                    }
                    else{
                        pr += element.premise[i] + "|"
                    }
                }
                pr += "]";
                csv += pr  + ",";
                var lo = "["
                for(var i = 0; i < element.logic.length; i++){
                    if(i + 1 === element.logic.length){
                        lo += element.logic[i];
                    }
                    else{
                        lo += element.logic[i] + "|"
                    }
                }
                lo += "]";
                csv += lo  + ",";
                var ru = "["
                for(var i = 0; i < element.rules.length; i++){
                    element.rules[i] = element.rules[i].replace(/,/, ' '); 
                    if(i + 1 === element.rules.length){
                        ru += element.rules[i];
                    }
                    else{
                        ru += element.rules[i] + "|"
                    }
                }
                ru += "]";
                csv += ru  + ",";
                csv += element.proofCompleted  + ",";
                csv += element.timeSubmitted  + ",";
                csv += element.conclusion  + ",\n";
            });
            var hiddenElement = document.createElement('a');
            hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
            hiddenElement.target = '_blank';
            hiddenElement.download = 'problem repository data.csv';
            hiddenElement.click();
        },
        error: function(data,status) { //optional, used for debugging purposes
            console.log(data);
        }
    });//ajax
});

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

//checking if there is a user logged in
if(sessionStorage.getItem("userlogged") === null){
  $("#load-container").hide();
  $("#nameyourproof").hide();
  $("#log-sign").html("Login / Sign-up");
}else{
  $("#load-container").show();
  $("#nameyourproof").show();
  if(sessionStorage.getItem("administrator") === "true"){
    $("#log-sign").html("Admin: " + sessionStorage.getItem("userlogged").toString());
  }else{
    $("#log-sign").html(sessionStorage.getItem("userlogged").toString());
  }
  loadSelect();
  repoloadSelect();
  finishedrepoloadSelect();
}
//end checking if there is a user logged in

//login and sign up modal;
$("#log-sign").click(function(){
  if(sessionStorage.getItem("userlogged") === null){
    $('.ui.basic.modal').modal('show');
  }else{
    if(sessionStorage.getItem("administrator") === "true"){
      $("#logoutUsername").html("Admin: " + sessionStorage.getItem("userlogged"));
    }else{
      $("#logoutUsername").html(sessionStorage.getItem("userlogged"));
      $("#optionsButton").html("options");
    }
    $('#logoutmodal').modal('show');
  }
}); 

$("#optionsButton").click(function(){
  if(sessionStorage.getItem("administrator") === "true"){
    window.location.replace("admin.html")
  }else{
    //
  }
});

//logout
$("#logoutButton").click(function(){
  sessionStorage.clear();
  window.location.replace("index.php") 
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
  //
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
