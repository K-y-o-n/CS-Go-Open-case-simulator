<?php
session_start();
$user = $_SESSION["user"];
$name = $user["login"];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Open Case</title>
  <style>
  body{
    margin: 0;
    padding: 0;
    width: 100vw;
    height: 100vh;
    margin: 0 auto;
    background: url(res/bgr2.jpg) no-repeat center/cover;
  }
  .container{
   margin: 0 auto;
   width: 1280px;
   height: 100%;
  }
  .container form{
    width: 200px;
    border: 2px solid white;
    position: absolute;
    left: calc(50% - 100px);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    background-color: rgb(55, 97, 120);
  }
  .container>div>form>*{
    width: 100%;
    box-sizing: border-box;
  }
  .container>div>form>input[type="submit"]{
    background-color: rgb(55, 235, 52);
  }
  .container>div>form>input[type="reset"]{
    background-color: rgb(235, 70, 52);
  }
  .container .alertReg,
  .container .alertAuth{
    position: absolute;
    top: -1.5em;
    color: red;
    font-weight: bold;
    align-items: center;
  }
  .form-reg{
    height: 90px;
    top: calc(50% - 45px);
  }
  .form-auth{
    height: 90px;
    top: calc(50% - 45px);
  }
  .container .play{
    width: 350px;
    height: 180px;
    background-color: rgb(55, 97, 120);
    border: 2px solid white;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: calc(50% - 90px);
    left: calc(50% - 175px);
  }
  .container .play>*{
    padding-left: 5px;
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="mainMenu">
      <div class="play">
        <span>Добро пожаловать в игру "Открытие кейсов CS:GO"<br>Зарегистрируйтесь, что бы вещи сохранялись в вашем инвентаре<br>Либо используйте общую учетку: player1 1234</span>
        <span>Пользователь: <?php print $name ?></span>
        <?php if($user) {?>
          <button class="exit">Выход</button>
        <?php }else { ?>
          <button class="btnAuth">Авторизация</button>
          <button class="btnReg">Регистрация</button>
        <?php } ?>
        <button class="btnPlay">Играть</button>
      </div>
    </div>
    <div class="auth" hidden>
      <form class="form-auth" action="controller/auth_obr.php">
        <span class="alertAuth"></span>
        <input type="text" name="login" placeholder="Имя(логин)" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Вход">
        <input type="reset" value="Отмена">
      </form>
    </div>
    <div class="reg" hidden>
      <form class="form-reg" action="controller/reg_obr.php">
        <span class="alertReg"></span>
        <input type="text" name="login" placeholder="Имя(логин)" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Зарегистрироваться">
        <input type="reset" value="Отмена">
      </form>
    </div>
  </div>
  <script>
    //кнопки главного меню
    let btnAuth = document.querySelector(".btnAuth");
    let btnReg = document.querySelector(".btnReg");
    let exit = document.querySelector(".exit");
    let bntPlay = document.querySelector(".btnPlay");
    let mainMenu = document.querySelector(".mainMenu");
    let divAuth = document.querySelector(".auth");
    let divReg = document.querySelector(".reg");
    
    if(btnAuth){
      btnAuth.addEventListener("click", function(){
        mainMenu.hidden = true;
        divAuth.hidden = false;
      });
    }
    if(btnReg){
      btnReg.addEventListener("click", function(){
        mainMenu.hidden = true;
        divReg.hidden = false;
      });
    }
    bntPlay.addEventListener("click", function(){
      document.location.href = "game.php";
    })
    
    // форма регистрации
    let regForm = document.querySelector(".form-reg");
    let regAlert = regForm.querySelector(".alertReg");
    regForm.addEventListener("submit", function(e){
      e.preventDefault();
      let p = sendData(this.action, new FormData(this));
      p.then(callbackReg);
    });
    
    function callbackReg(text){
      switch(text){
        case "REG_FALSE":
          regAlert.textContent = "имя занято";
          setTimeout(function(){
            regAlert.textContent = "";
          }, 4000);
          break;
        case "REG_OK":
          regAlert.textContent = "успешная регистрация";
          setTimeout(function(){
            regAlert.textContent = "";
            divReg.hidden = true;
            divAuth.hidden = false;
          }, 2000);
          break;
        default:
          console.log(text);
      }
    };
    
    //форма авторизации
    let authForm = document.querySelector(".form-auth");
    let authAlert = authForm.querySelector(".alertAuth");
    authForm.addEventListener("submit", function(e){
      e.preventDefault();
      let p = sendData(this.action, new FormData(this));
      p.then(callbackAuth);
    });
    
    function callbackAuth(text){
      switch(text){
        case "AUTH_FALSE":
          authAlert.textContent = "неверные данные";
          setTimeout(function(){
            authAlert.textContent = "";
          }, 4000);
          break;
        case "AUTH_OK":
          divAuth.hidden = true;
          mainMenu.hidden = false;
          location.reload();
          break;
        default:
          console.log(text);
      }
    };
    
    // кнопки отмены
    let cancel = document.querySelectorAll('input[type="reset"]');
    for (let elem of cancel){
      elem.addEventListener("click", function(){
        divAuth.hidden = true;
        divReg.hidden = true;
        mainMenu.hidden = false;
      })
    };
    
    // кнопка выхода
    if(exit){
      exit.addEventListener("click", function(){
        let prom = sendData("http://x91612y1.beget.tech/diplom/controller/exit.php", null);
        location.reload();
      });
    }
    
    
    async function sendData(url, data){
      let option = {
        method: "post", 
        body: data 
      }; 
      let responce = await fetch(url, option);
      let text = await responce.text();
      return text;
    }
  </script>
  <link href="controller/php_view.html" rel="help">
</body>
</html>