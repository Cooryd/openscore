<?

function dispHeader($title){

	?>
	<!doctype html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500&display=swap" rel="stylesheet">
<meta charset="UTF-8">
<title><?= $title ?></title>
<style>
  * { font-family:Montserrat;}
  a{color:#4e9ead;}
body{
    background:#fff;
    color:white;
    font-family:sans-serif;
    padding:0; margin:0;}
  }
#outer_wrapper{background:#fff; margin:0; padding-top:10px;}
#wrapper 
    {  
      color:black;
    width:980px;  
    padding-left:40px;
    padding-right:40px;
    text-align:left;   
    margin-left:auto;  
    margin-right:auto;  
    background-color: #FFF; 
    padding-bottom:40px;
}

h1{margin:1em; 
margin-left:0;}
h2 a{color:#273e81}
h2{margin-top:2em;}
h3{margin-top:1em;}
h2#paper_title{margin-top: 2em;
    font-weight: lighter;
    font-size: 30px;
    text-align: center;
    color: #303030;}

    h2#paper_title a{margin-top: 2em;
    font-weight: lighter;
    font-size: 30px;
    text-align: center;
    color: #303030;
    text-decoration: none;
    margin-bottom:17px}

    h2#paper_title a:hover{
    text-decoration: underline;
    }
    div#meta{color: #505050; text-align:center;}
    a.doi{color: #505050; }
#main_header{background:#fff;}

 h3.question-title{
    margin-top: 30px;
    font-weight: normal;
    color: #505050;
    font-size: 23px;
    margin-bottom: 7px;
  } 
div#authors{text-align:center; margin-bottom:42px;}
 div.bar{}
 div.bar_gradient{ 
  padding:5px; background:linear-gradient(rgba(255,255,255,0.02),rgba(0,0,0,0.02));color:#505050;
  padding-left: 10px;
    font-size: 10px;
     }
     button{background:#FFF;}
     div.error{margin-top:20px;}
     span.question_text{color:#101010;}
     div.recent_update{margin-bottom:20px; color:#505050;}

</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
  <div id="main_header">
  <a href="/"><img src="openscore_dark.svg" style="height:40px; margin-left:30px; margin-top:30px;margin-bottom: 13px;" /></a>
  <div style="box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.1), 0px 4px 5px 0px rgba(0,0,0,0.0), 0px 1px 10px 0px rgba(0,0,0,0.06); height:5px"></div>
</div>

  <div id="outer_wrapper">
  <div id="wrapper">
	<?

}


function dispFooter(){
?>
</div>

</div>
<script>
  $( function() {
    $( document ).tooltip();
  } );
  </script>
</body>
</html>
<?

	}
?>