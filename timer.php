<?php
include "func.php";
?>
<? include('connecttodb.php'); ?>
<? session_start(); ?>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/85043e3807.js" crossorigin="anonymous"></script>









    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>計時器</title>

    <link rel="stylesheet" href="./leaflet/leaflet.css" />
    <script src="./leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="./leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <script src="./leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="./js/jquery-3.6.0.js"></script>


    <style>

    body {
        background-color: #2B313F;
      }
      .title {
        position: relative;
        /* left: 13%; */
        top: 150px;
        font-size: 45px;
        /* border: solid; */
        width: 100%;
        color: rgb(255, 255, 255);
        text-align: center;
      }
      .stopwatch {
        position: relative;
        text-align: center;
        font-size: 45px;
        top: 120px;
        /* border: solid; */
      }
      .button button {
        position: relative;
        width: 30%;
        height: 110px;
        font-size: 20px;
        border-radius: 300px;
        color: rgb(255, 255, 255);
        background-color: transparent;
        border-color: white;
        border: solid;
      }
      .number {
        color: rgb(246, 245, 245);
      }
    </style>

<body>
    <div class="wrapper">
      <h1 class="title">STOPWATCH</h1>
      <div class="stopwatch">
        <p class="number"><span id="seconds">00</span>:<span id="tens">00</span></p>
        <span class="button">
          <button id="button-start">Start</button>
          <button id="button-stop">Stop</button>
          <button id="button-reset">Reset</button>
        </span>
      </div>
    </div>
    <script>
      window.onload = function () {
        var seconds = 00;
        var tens = 00;
        var appendTens = document.getElementById("tens");
        var appendSeconds = document.getElementById("seconds");
        var buttonStart = document.getElementById("button-start");
        var buttonStop = document.getElementById("button-stop");
        var buttonReset = document.getElementById("button-reset");
        var Interval;

        buttonStart.onclick = function () {
          clearInterval(Interval);
          Interval = setInterval(startTimer, 10);
        };

        buttonStop.onclick = function () {
          clearInterval(Interval);
        };

        buttonReset.onclick = function () {
          clearInterval(Interval);
          tens = "00";
          seconds = "00";
          appendTens.innerHTML = tens;
          appendSeconds.innerHTML = seconds;
        };

        function startTimer() {
          tens++;

          if (tens <= 9) {
            appendTens.innerHTML = "0" + tens;
          }

          if (tens > 9) {
            appendTens.innerHTML = tens;
          }

          if (tens > 99) {
            console.log("seconds");
            seconds++;
            appendSeconds.innerHTML = "0" + seconds;
            tens = 0;
            appendTens.innerHTML = "0" + 0;
          }

          if (seconds > 9) {
            appendSeconds.innerHTML = seconds;
          }
        }
      };
    </script>
  </body>
</head>