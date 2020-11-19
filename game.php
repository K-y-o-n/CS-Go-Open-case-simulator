<?php
session_start();

error_reporting(-1);
ini_set("display_errors", 1);

if(isset($_SESSION['user']) == null){
  header ('Location: index.php');
}

include("controller/db.php");

$id = $_SESSION['user']['id'];
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
      background: url(res/bgr4.jpg) no-repeat center/cover;
    }
    .container{
     margin: 0 auto;
     width: 1280px;
     height: 100%;
    }
    .invDiv{
      width: 800px;
      height: 85%;
      overflow: auto;
      border: 2px solid white;
      box-sizing: border-box;
      border-radius: 10px;
      color: white;
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      background: rgba(156, 156, 160, 0.5);
      backdrop-filter: blur(5px);
      position: absolute;
      top: 10%;
      left: 5%;
    }
    .invDiv>div{
      width: 180px;
      height: 180px;
      box-sizing: border-box;
      border-radius: 10px;
    }
    .invDiv>div>img{
      width: 95%;
      height: 155px;
    }
    .invDiv>div>span{
      display: flex;
      justify-content: center;
    }
    button{
      border-radius: 10px;
      width: 250px;
      height: 40px;
      font-size: 16px;
      transition-duration: 0.4s;
      background-color: rgb(196, 196, 198);
    }
    button:hover{
      background-color: rgb(196, 196, 198);
      color: white;
      font-size: 17px;
    }
    .gameMenu{
      width: 800px;
      position: absolute;
      top: 5%;
      left: 5%;
      display: flex;
      justify-content: space-around;
    }
    .gameDiv{
      width: 800px;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      grid-row-gap: 5px;
      position: absolute;
      top: 15%;
      left: 5%;
    }
    .gameDiv>div{
      width: 180px;
      height: 150px;
      display: grid;
      cursor: pointer;
    }
    .gameDiv>div>span{
      color: white;
      align-self: end;
      justify-self: center;
    }
    .gameDiv>div>span::selection{ /* отключает ОТОБРАЖЕНИЕ выделения текста */
      background: transparent; 
    }
    div.phoenix{
      background: url(case/phoenix.png) no-repeat center/cover;
    }
    div.falchion{
      background: url(case/falchion.png) no-repeat center/cover;
    }
    div.huntsman{
      background: url(case/huntsman.png) no-repeat center/cover;
    }
    div.weapon{
      background: url(case/weapon.png) no-repeat center/cover;
    }
    .rulesDiv{
      width: 800px;
      height: 85%;
      border: 2px solid white;
      box-sizing: border-box;
      border-radius: 10px;
      color: white;
      font-size: 1.3em;
      background: rgba(156, 156, 160, 0.5);
      backdrop-filter: blur(20px);
      position: absolute;
      top: 10%;
      left: 5%;
    }
    .rulesDiv>p{
      padding-left: 5px;
    }
    .prize{
      width: 370px;
      height: 370px;
      position: absolute;
      z-index: 2;
      top: calc(50% - 180px);
      left: calc(50% - 180px);
      border: 2px solid white;
      box-sizing: border-box;
      border-radius: 10px;
      display: grid;
      grid-template-rows: 90%;
    }
    .prize>img{
      width: 360px;
      height: 360px;
    }
    .prize>span{
      font-size: 1.5em;
      display: flex;
      justify-content: center;
    }
    .prize>span::selection{
      background: transparent;
    }
    .caseView{
      width: 800px;
      height: 85%;
      overflow: auto;
      border: 2px solid white;
      box-sizing: border-box;
      border-radius: 10px;
      color: white;
      background: rgba(156, 156, 160, 0.5);
      backdrop-filter: blur(5px);
      position: absolute;
      top: 10%;
      left: 5%;
      z-index: 2;
    }
    [hidden]{
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="gameMenu">
      <button class="game">Игра</button>
      <button class="rules">Как играть</button>
      <button class="inv">Инвентарь</button>
    </div>
    <div class="gameDiv">
      <div class="phoenix"><span class="phoenix">Phoenix Case</span></div>
      <div class="falchion"><span class="falchion">Falchion Case</span></div>
      <div class="huntsman"><span class="huntsman">Huntsman Case</span></div>
      <div class="weapon"><span class="weapon">Weapon Case</span></div>
    </div>
    <div class="rulesDiv" hidden>
      <p>Этот сайт создан что бы дать возможность бесплатно попытать удачу в открытии кейсов CS:GO. Вывести полученные вещи не получится, но они сохраняются в инвентаре и вы всегда можете <strike>попускать на них слюни</strike> полюбоваться ими.<p>
      <p>Управление:<p>
      <ul>
        <li>Правая кнопка мыши на кейсе - посмотреть что внутри.</li>
        <li>Двойной клик по кейсу открывает его. Окно с вещью само закроется через 5 секунд.</li>
      </ul>
      <img src="res/bomb.png" alt="bomb.png">
    </div>
  </div>
  <script>
  // элементы страницы 
  let container = document.querySelector(".container");
  let btnGame = document.querySelector(".game");
  let btnInv = document.querySelector(".inv");
  let bntRules = document.querySelector(".rules");
  let gameDiv = document.querySelector(".gameDiv");
  let rulesDiv = document.querySelector(".rulesDiv");
  
  //кнопка игра
  btnGame.addEventListener("click", function(){
    gameDiv.hidden = false;
    rulesDiv.hidden = true;
    let invDiv = document.querySelector(".invDiv");
    if(invDiv){
      invDiv.remove();
    }
  });
  
  //кнопка инвентарь
  btnInv.addEventListener("click", function(){
    gameDiv.hidden = true;
    rulesDiv.hidden = true;
    let invDiv = document.querySelector(".invDiv");
    if(invDiv){
      invDiv.remove();
    }
    invDiv = document.createElement('iframe');
    invDiv.className = "invDiv";
    invDiv.setAttribute("src", "inventory.php");
    
    gameDiv.after(invDiv);
  });
  
  //кнопка как играть
  bntRules.addEventListener("click", function(){
    gameDiv.hidden = true;
    let invDiv = document.querySelector(".invDiv");
    if(invDiv){
      invDiv.remove();
    }
    rulesDiv.hidden = false;
  });
  
  // игра (php код в LINK ниже скрипта)
  gameDiv.addEventListener("dblclick", function(e){
    let caseName = e.target.className;
    let option = {
      method: "post",
      headers: {"content-type": "application/x-www-form-urlencoded"}, // задаем заголовок - способ указать серверу как получать данные от нас (в виде пар разделенных знаком $ где каждая пара это ключ и значение которые разделяются знаком = ) пример: ключ = значени & ключ = значение
      body: "name="+caseName // конкатинация пары ключ-значение как при get запросе
    };
    let p = sendData("controller/roll.php", option);
    p.then(function(text){
      let prizeArr = JSON.parse(text); //превращаю PHP массив в JS массив
      let prizeName = prizeArr[0];
      let prizeImg = prizeArr[1];
      let prizeRare = prizeArr[2];
      
      let prizeDiv = document.createElement('div');
      prizeDiv.className = "prize";
      prizeDiv.setAttribute("style", "background-color: "+prizeRare);
      prizeDiv.innerHTML = "<img src="+prizeImg+"><span>"+prizeName+"</span>";
      
      container.append(prizeDiv);
      setTimeout(() => prizeDiv.remove(), 5000);
    })
  });
  
  //просмотр вещей в кейсах 
  gameDiv.addEventListener("contextmenu", function(e){
    e.preventDefault();
    let caseName = e.target.className;
    if(caseName){
     let caseView = document.createElement('iframe');
     caseView.className = "caseView";
     caseView.setAttribute("src", "case_view.php?name="+caseName);
     
     container.append(caseView);
     setTimeout(() => caseView.remove(), 5000);
    }
  });
  
  

  
  async function sendData(url, option){
    let responce = await fetch(url, option);
    let text = await responce.text();
    return text;
  }
  
  </script>
  <link href="controller/php_view.html" rel="help">
</body>
</html>