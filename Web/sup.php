<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
    body{
        background-image: url("./images/2-background.jpg");
      }
      .navbar-collapse{
        font-size: 200%;
      }
      .navbar-nav > li{
        padding-left: 30px;
        padding-right: 30px;
      }
            .hide{
            display: none;
        }
        .c1{
            position: fixed;
            top:0;
            bottom: 0;
            left:0;
            right: 0;
            background: rgba(0,0,0,.5);
            z-index: 2;
        }
        .c2{
            background-color: black;
            opacity: 0.8;
            position: fixed;
            width: 400px;
            height: 500px;
            top:50%;
            left: 50%;
            z-index: 3;
            margin-top: -150px;
            margin-left: -200px;
            border-radius: 30px;
        }
        .c2 img{
            margin-top: 10%;
        }
        #modal p {
          margin-top: 10%;
          margin-left: 15%;
          height: 20px;
        }
        #modal p2{
          margin-left: 16%;
        }
        #modal p3{
          margin-left: 15%;
        }
        .link {
        background-color: black;
        border: none;
        color: orange;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }
    .c3{
            background-color: black;
            opacity: 0.8;
            position: fixed;
            width: 400px;
            height: 470px;
            top:50%;
            left: 50%;
            z-index: 3;
            margin-top: -150px;
            margin-left: -200px;
            border-radius: 30px;
        }
    .c3 img{
      margin-top: 10%;
    }
    #loginadds p {
          margin-top: 10%;
          margin-left: 15%;
          height: 20px;
        }
    #loginadds p2{
          margin-left: 16%;
        }
        #loginadds p3{
      margin-left: 24%;
        }
        #loginadds p4{
          margin-left: 15%;
        }
      .wrap{
        height: 80%;
        width: 80%;
        margin-left: 10%;
        margin-top: 15%;
        background-color: rgba(255,255,255,0.5);
      }
      .content{
          text-align:center;
          margin-left:20%;
          font-size:30px;
      }
      #menu{
          margin-left:30%;
          margin-top:10%;
          
      }
      #menu li{
            margin-left:20px;
            margin-right:20px;
            list-style-image: none;
            list-style-type: none;
            border-right-width: 1px;
            border-right-style: solid;
            border-right-color: #000000;
            float: left;
            font-size:40px;
        }
    
        
    </style>
    <title>Champions</title>
  </head>
	<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="./images/symbol.png" width = 363 height = 63 alt = "">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="champion.php">Champions <span class="sr-only">(current)</span> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mailto:clutchking.gg@gmail.com">Contact Us </a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <button type="button" class="btn btn-dark" onclick = "HideLog();Show();">SIGN UP</button>
          <button type="button" class="btn btn-secondary" onclick="Hide();ShowLog();">LOG IN</button>
        </form>
      </div>
    </nav>
    <ul id = "menu">
        <li><a href="champion.php" style="color:white;">All</a></li>
        <li><a href="top.php" style="color:white;">Top</a></li>
        <li><a href="bot.php" style="color:white;">Jg</a></li>
        <li><a href="mid.php" style="color:white;">Mid</a></li>
        <li><a href="bot.php" style="color:white;">Bot</a></li>
        <li><a>Sup</a></li>
    </ul>
<div class="wrap">
    <div class="content">
    <?php
    		$servername = "localhost";
        	$username = "clutchkingtest_root";
        	$password = "clutchking.gg";
        	$dbname="clutchkingtest_users";
        	
    		$conn=new mysqli($servername, $username, $password, $dbname);
    		
    		$sql="SELECT name, winrate,pick,ban FROM single_champion_stats WHERE role='support' ORDER BY winrate DESC";
        	$result=$conn->query($sql);
        	
        	echo "<table><tr><th>Name</th><th>Win Rate</th><th>Pick Rate</th><th>Ban Rate</th></tr>";
    		while($row = $result->fetch_assoc()){
    			echo "<tr><td>".$row["name"]."</td><td>".$row["winrate"]."</td><td>".$row["pick"]."</td><td>".$row["ban"]."</td></tr>";
    		}
    		echo "</table>";
    ?>
         <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</div>
</div>
<div id="shade" class="c1 hide"></div>
    <div id="modal" class="c2 hide">
      <img src="./images/symbol.png">
      <form method="post" action="create_user.php">
      <p><input type="text" name="email" placeholder="Email Address" style="background-color:transparent; border-style: solid; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-color: white; width: 280px; color:white;" /></p>
      <p><input type="password" name="password" placeholder="Set A Password" style="background-color:transparent; border-style: solid; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-color: white; width: 280px; color:white;" /></p>
      <p><input type="text" name="summoner_name" placeholder="Summoner Name" style="background-color:transparent; border-style: solid; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-color: white; width: 280px; color:white;"  /></p>
      <p2>
        <input type="submit" value="Log In" style="margin-top: 30px; width: 120px;">
        <input type="button" value="Cancel" onclick="Hide();" style="margin-left: 30px; width: 120px;">
      </p2>
      </form>
      <p3>
        <button type="button" class = "link" onclick="Hide();ShowLog();" style="margin-top: 30px;">Already Have an Account? Log In Now</button>
      </p3>
    </div>

    <div id="loginadds" class="c3 hide">
      <img src="./images/symbol.png">
      <form method="post" action="login.php">
      <p><input type="text" name="login_email" placeholder="Enter Your Email Address" style="background-color:transparent; border-style: solid; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-color: white; width: 280px; color:white;" /></p>
      <p><input type="password" name="login_password" placeholder="Enter Your Password" style="background-color:transparent; border-style: solid; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px; border-color: white; width: 280px; color:white;" /></p>
      <p2>
        <input type="submit" value="Log In" style="margin-top: 30px; width: 120px;">
        <input type="button" value="Cancel" onclick="HideLog();" style="margin-left: 30px; width: 120px;">
      </p2>
      </form>
      <p3>
        <button type="button" class = "link" style="margin-top: 20px;">Forgot Your Password?</button>
      </p3>
      <p4>
        <button type="button" class = "link" onclick="HideLog();Show();">Haven't Registered Yet? Sign Up Today</button>
      </p4>
    </div>
      </body>
      <script>
        function Show(){
            document.getElementById('shade').classList.remove('hide');
            document.getElementById('modal').classList.remove('hide');
        }
         function Hide(){
            document.getElementById('shade').classList.add('hide');
            document.getElementById('modal').classList.add('hide');
        }
        function ShowLog(){
            document.getElementById('shade').classList.remove('hide');
            document.getElementById('loginadds').classList.remove('hide');
        }
        function HideLog(){
            document.getElementById('shade').classList.add('hide');
            document.getElementById('loginadds').classList.add('hide');
        }
        </script>
</html>
