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
        #modal p4{
        margin-left: 20%;
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
            <a class="nav-link" href="#">Champions <span class="sr-only">(current)</span> </a>
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
        <li><a>All</a></li>
        <li><a href="top.php" style="color:white;">Top</a></li>
        <li><a href="jg.php" style="color:white;">Jg</a></li>
        <li><a href="mid.php" style="color:white;">Mid</a></li>
        <li><a href="bot.php" class="last" style="color:white;">Bot</a></li>
        <li><a href="sup.php" style="color:white;">Sup</a></li>
    </ul>
<div class="wrap">
    <div class="content">
    <?php
    		$servername = "localhost";
        	$username = "clutchkingtest_root";
        	$password = "clutchking.gg";
        	$dbname="clutchkingtest_users";
        	
    		$conn=new mysqli($servername, $username, $password, $dbname);
    		
    		$sql="SELECT * FROM single_champion_stats s WHERE winrate = (SELECT MAX(winrate) FROM single_champion_stats WHERE s.name = name) GROUP BY name ORDER BY winrate DESC";
        	$result=$conn->query($sql);
        	
        	echo "<table><tr><th>Name</th><th>Win Rate</th><th>Pick Rate</th><th>Ban Rate</th><th>Role</th></tr>";
    		while($row = $result->fetch_assoc()){
    			echo "<tr><td>".$row["name"]."</td><td>".$row["winrate"]."</td><td>".$row["pick"]."</td><td>".$row["ban"]."</td><td>".$row["role"]."</td></tr>";
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
      <p style="color:white; margin-left:15%;">Favorite Position &nbsp;&nbsp;Favorite Champion</p>
      <p4>
             <select>
                 <option value="top">top</option>
                 <option value="jungle">jungle</option>
                 <option value="mid">mid</option>
                 <option value="bot">bot</option>
                 <option value="sup">sup</option>
             </select>
      </p4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <p5>
          <select>
              <option value="Aatrox">Aatrox</option>
              <option value="Ahri">Ahri</option>
              <option value="Akali">Akali</option>
              <option value="Alistar">Alistar</option>
              <option value="Amumu">Amumu</option>
              <option value="Anivia">Anivia</option>
              <option value="Annie">Annie</option>
              <option value="Ashe">Ashe</option>
              <option value="Aurelion Sol">Aurelion Sol</option>
              <option value="Azir">Azir</option>
              <option value="Bard">Bard</option>
              <option value="Blitzcrank">Blitzcrank</option>
              <option value="Brand">Brand</option>
              <option value="Braum">Braum</option>
              <option value="Caitlyn">Caitlyn</option>
              <option value="Camille">Camille</option>
              <option value="Cassiopeia">Cassiopeia</option>
              <option value="Cho'Gath">Cho'Gath</option>
              <option value="Corki">Corki</option>
              <option value="Darius">Darius</option>
              <option value="Diana">Diana</option>
              <option value="Dr.Mundo">Dr.Mundo</option>
              <option value="Draven">Draven</option>
              <option value="Ekko">Ekko</option>
              <option value="Elise">Elise</option>
              <option value="Evelynn">Evelynn</option>
              <option value="Ezreal">Ezreal</option>
              <option value="Fiddlesticks">Fiddlesticks</option>
              <option value="Fiora">Fiora</option>
              <option value="Fizz">Fizz</option>
              <option value="Galio">Galio</option>
              <option value="Gangplank">Gangplank</option>
              <option value="Garen">Garen</option>
              <option value="Gnar">Gnar</option>
              <option value="Gragas">Gragas</option>
              <option value="Graves">Graves</option>
              <option value="Hecarim">Hecarim</option>
              <option value="Heimerdinger">Heimerdinger</option>
              <option value="Illaoi">Illaoi</option>
              <option value="Irelia">Irelia</option>
              <option value="Ivern">Ivern</option>
              <option value="Janna">Janna</option>
              <option value="Jarvan IV">Jarvan IV</option>
              <option value="Jax">Jax</option>
              <option value="Jayce">Jayce</option>
              <option value="Jhin">Jhin</option>
              <option value="Jinx">Jinx</option>
              <option value="Kai'Sa">Kai'Sa</option>
              <option value="Kalista">Kalista</option>
              <option value="Karma">Karma</option>
              <option value="Karthus">Karthus</option>
              <option value="Kassadin">Kassadin</option>
              <option value="Katarina">Katarina</option>
              <option value="Kayle">Kayle</option>
              <option value="Kayn">Kayn</option>
              <option value="Kennen">Kennen</option>
              <option value="Kha'Zix">Kha'Zix</option>
              <option value="Kindred">Kindred</option>
              <option value="Kled">Kled</option>
              <option value="Kog'Maw">Kog'Maw</option>
              <option value="LeBlanc">LeBlanc</option>
              <option value="Lee Sin">Lee Sin</option>
              <option value="Leona">Leona</option>
              <option value="Lissandra">Lissandra</option>
              <option value="Lucian">Lucian</option>
              <option value="Lulu">Lulu</option>
              <option value="Lux">Lux</option>
              <option value="Malphite">Malphite</option>
              <option value="Malzahar">Malzahar</option>
              <option value="Maokai">Maokai</option>
              <option value="Master Yi">Master Yi</option>
              <option value="Miss Fortune">Miss Fortune</option>
              <option value="Mordekaiser">Mordekaiser</option>
              <option value="Morgana">Morgana</option>
              <option value="Nami">Nami</option>
              <option value="Nasus">Nasus</option>
              <option value="Nautilus">Nautilus</option>
              <option value="Neeko">Neeko</option>
              <option value="Nidalee">Nidalee</option>
              <option value="Nocturne">Nocturne</option>
              <option value="Nunu & Willump">Nunu & Willump</option>
              <option value="Olaf">Olaf</option>
              <option value="Orianna">Orianna</option>
              <option value="Ornn">Ornn</option>
              <option value="Pantheon">Pantheon</option>
              <option value="Poppy">Poppy</option>
              <option value="Pyke">Pyke</option>
              <option value="Qiyana">Qiyana</option>
              <option value="Quinn">Quinn</option>
              <option value="Rakan">Rakan</option>
              <option value="Rammus">Rammus</option>
              <option value="Rek'Sai">Rek'Sai</option>
              <option value="Renekton">Renekton</option>
              <option value="Rengar">Rengar</option>
              <option value="Riven">Riven</option>
              <option value="Rumble">Rumble</option>
              <option value="Ryze">Ryze</option>
              <option value="Sejuani">Sejuani</option>
              <option value="Shaco">Shaco</option>
              <option value="Shen">Shen</option>
              <option value="Shyvana">Shyvana</option>
              <option value="Singed">Singed</option>
              <option value="Sion">Sion</option>
              <option value="Sivir">Sivir</option>
              <option value="Skarner">Skarner</option>
              <option value="Sona">Sona</option>
              <option value="Soraka">Soraka</option>
              <option value="Swain">Swain</option>
              <option value="Sylas">Sylas</option>
              <option value="Syndra">Syndra</option>
              <option value="Tahm Kench">Tahm Kench</option>
              <option value="Taliyah">Taliyah</option>
              <option value="Talon">Talon</option>
              <option value="Taric">Taric</option>
              <option value="Teemo">Teemo</option>
              <option value="Thresh">Thresh</option>
              <option value="Tristana">Tristana</option>
              <option value="Trundle">Trundle</option>
              <option value="Tryndamere">Tryndamere</option>
              <option value="Twisted Fate">Twisted Fate</option>
              <option value="Twitch">Twitch</option>
              <option value="Udyr">Udyr</option>
              <option value="Urgot">Urgot</option>
              <option value="Varus">Varus</option>
              <option value="Vayne">Vayne</option>
              <option value="Veigar">Veigar</option>
              <option value="Vel'Koz">Vel'Koz</option>
              <option value="Vi">Vi</option>
              <option value="Viktor">Viktor</option>
              <option value="Vladimir">Vladimir</option>
              <option value="Volibear">Volibear</option>
              <option value="Warwick">Warwick</option>
              <option value="Wukong">Wukong</option>
              <option value="Xayah">Xayah</option>
              <option value="Xerath">Xerath</option>
              <option value="Xin Zhao">Xin Zhao</option>
              <option value="Yasuo">Yasuo</option>
              <option value="Yorick">Yorick</option>
              <option value="Yuumi">Yuumi</option>
              <option value="Zac">Zac</option>
              <option value="Zed">Zed</option>
              <option value="Ziggs">Ziggs</option>
              <option value="Zilean">Zilean</option>
              <option value="Zoe">Zoe</option>
              <option value="Zyra">Zyra</option>
          </select>
      </p5><br>
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
      </body>
</html>
