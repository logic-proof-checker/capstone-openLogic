<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet" type="text/css">
    <link rel="icon" href="/assets/logicproofchecker.png">
    <link rel="stylesheet" type="text/css" href="/semantic/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">    
    <script
    src="https://code.jquery.com/jquery-3.1.1.min.js" 
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" 
    crossorigin="anonymous">
    </script>
    <script src="semantic/semantic.min.js"></script>
    
    <style>
      body {font-family: "Noto Sans";}
      a, a:hover, a:visited, a:focus, a:active {color: #0c1c8c; text-decoration: none; font-weight: bold ;}
      label, legend { display: inline-block; } 
    </style>
  
    <!-- css file -->
    <link rel="stylesheet" type="text/css" href="proofs.css" />
    <!-- javascript file -->
    <script type="text/javascript" charset="utf-8" src="ajax.js"></script>
    <script type="text/javascript" charset="utf-8" src="syntax.js"></script>
    <script type="text/javascript" charset="utf-8" src="proofs.js"></script>
    </head>
    <body>
    <div id="top-menu" class="ui menu" style = "height : 60px;">
          <div class="header item">
            <h1 id="title" style = "color : white;"><a href="index.php" style="color:white;">Proof Checker</a></h1>
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
      <div id="adminOptions" style="margin: 1.5rem;">
          <h3 id="header" class="ui top attached header">
            Administrator Options
          </h3>
          <div class="ui attached segment">
              
            <div id="optionsList" class="ui bulleted list">
              <div id="li" class="item"><a href="index.php?mode=insert" style="color:black; font-weight: 300;">Add Proofs</a></div>
              <div id="li" class="item"><a href="" style="color:black; font-weight: 300;">View Students</a></div>
              <div id="li" class="item"><a href="" style="color:black; font-weight: 300;">View Proof Stats</a></div>
            </div>
            <button id="downloadRepo" class="fluid ui button">download problem repository data</button>
          </div>
      </div>

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


      <div id="logoutmodal" class="ui basic modal">
        <div class="actions" style="text-align:center;">
          <div id="logoutUsername" class="ui icon header" style="color:white;">
          </div>
          <br>
          <div id="optionsButton" class="ui blue ok inverted button">
            admin options
          </div>
        </div>
        
        <div class="content" style="text-align: center;">
          or
        </div>
       
        <div class="actions" style="text-align: center;">
          <div class="ui icon small header" style="color:white; margin:0;">
            Would like to log out?
          </div>
          <br>
          <br>
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
    <script type="text/javascript" src="index.js"></script>
</html>
