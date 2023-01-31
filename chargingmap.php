<?php
include "func.php";
?>
<? include('connecttodb.php'); ?>
<? session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/85043e3807.js" crossorigin="anonymous"></script>



    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>找充電</title>

    <link rel="stylesheet" href="./leaflet/leaflet.css" />
    <script src="./leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="./leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <script src="./leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="./js/jquery-3.6.0.js"></script>

    <script src="./func.js"></script>

    <link rel="stylesheet" href="./頁面/leftnav2.css">




    <!-- from suggestion -->
    <link rel="stylesheet" href="foodrecomment.css">
    <script src="https://kit.fontawesome.com/85043e3807.js" crossorigin="anonymous"></script>



    <style>
        video {
            position: absolute;
            z-index: 601;
            top: 20%;
            right: 0%;


        }







        /* <!-- from suggestion --> */
        .btn {
            position: absolute;
            top: 430px;
            left: 10%;
            width: 100px;
            height: 100px;
            border: none;
            border-radius: 50px;
            outline: none;
            background-color: cornflowerblue;
            color: white;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            /* z-index: 3; */
            z-index: 601;
            display: none;
        }

        .content {
            width: 100px;
            height: 100px;
            border: none;
            border-radius: 50px;
            outline: none;
            background: #2B313F;
            color: white;
            cursor: pointer;
            font-size: large;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            position: absolute;
            /* z-index: 2; */
            z-index: 600;
        }

        /* .list{
        border: solid;
        position: relative;
        margin-top: -60px;
        height: 700px;
        width: 360px;
        
      } */

        .list {

            height: 10px;
            width: 0px;
            overflow: hidden;
            transition: all 0.1s;
            position: absolute;
            z-index: 600;
            left: 20%;
            top: 400px;
            /* border: solid; */



        }

        .list.active {

            /* border: solid; */
            position: absolute;
            z-index: 600;
            margin-top: 20%;
            margin-left: -40%;
            height: 84%;
            width: 400px;
            background-color: transparent;


        }

        .circle {
            width: 500px;
            height: 500px;
            border: 5px solid navy;
            border-radius: 50%;
            position: absolute;
            z-index: 599;
            right: 10%;
            top: 23%;
            overflow: hidden;

        }


        body {
            background-color: rgb(218, 226, 243);
            overflow-y: hidden;
        }



        /* 景點 */

        #overlay {
            /* display: none; */
            position: absolute;
            top: 0;
            left: 0;
            width: 390px;
            height: 844px;
            background-color: transparent;
            /* align-items: center; */
            justify-content: center;
            /* z-index: 4; */
            z-index: 600;
            /* border: solid; */
            transition: all 0.3s ease-out;
            transform: translateY(100%);
        }

        #overlay.open {
            transform: translateY(0);
            background-color: transparent;
            border-radius: 15px;
        }

        #card {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            width: 350px;
            max-height: 800px;
            background-color: rgb(248, 248, 253);
            border-radius: 10px;
            letter-spacing: 0.1em;
            color: rgb(43, 49, 63);
            font-weight: bold;
            /* overflow-x: hidden;
    overflow-y: scroll; */
        }

        #cardTitle {
            font-size: 30px;
            padding-top: 20px;
            text-align: center;
        }

        #card table {
            display: block;
            margin: 5px auto;
            color: rgb(43, 49, 63);
            /* border: 2px solid red; */
            width: 270px;
            font-size: 12px;
            overflow-x: hidden;
            /* overflow-y: scroll; */
            table-layout: fixed;
        }

        .overlay td:nth-child(1) {
            width: 50px;
        }

        .overlay td:nth-child(2) {
            width: 150px;
        }

        .overlay td:nth-child(3) {
            width: 70px;
        }

        .overlay td:nth-child(4) {
            width: 45px;
        }

        .overlay td {
            border-top: 0.3px solid rgb(43, 49, 63, 0.5);
            border-left: none;
            border-right: none;
            overflow-y: scroll;
        }

        .overlay thead {
            position: absolute;
            /* z-index: 11; */
            z-index: 600;
            background-color: rgb(235, 4, 4);
            width: 330px;
            justify-content: center;
        }


        .overlay button {
            background-color: rgb(43, 49, 63);
            border: none;
            border-radius: 15px;
            color: rgb(249, 239, 225);
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 6px 12px;
            font-size: 14px;
        }

        /* done */













        .active {
            position: relative;
            top: -10px;
        }

        ul {
            list-style-type: none;
            position: relative;

            margin: 0;
            padding: 0;
            height: 6%;
            overflow: hidden;
            background-color: RGB(43, 49, 63);
            z-index: 401;
        }

        li {
            float: left;
            /* border-right:1px solid #bbb; */
        }

        li:last-child {
            border-right: none;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .title {
            width: 100%;
        }

        /* li a:hover:not(.active) {
          background-color: #111;
        } */

        .active {
            background-color: RGB(43, 49, 63);
        }

        .search :hover {
            cursor: pointer;
        }



        form {
            display: none;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        button[type="button"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="button"]:hover {
            background-color: #45a049;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .search-container {
            position: relative;
            display: inline-block;
            width: 50%;
            max-width: 300px;
            animation: fadeIn 0.3s ease;
            z-index: 403;
        }

        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
            z-index: 403;
        }

        input[type=submit] {
            background-color: rgb(255, 79, 30);
            color: #fff;
            cursor: pointer;


        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 402;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;

        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }


        /* bottom nav */
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            overflow-y: hidden;
        }


        /* 底部選單 */
        .navbar {
            overflow: hidden;
            background-color: RGB(43, 49, 63);
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 401;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 3.6%;
            text-decoration: none;
            font-size: 16px;
        }

        /* .navbar a:hover {
  background: #f1f1f1;
  color: black;
} */

        .navbar a.active {
            background-color: RGB(43, 49, 63);
            color: white;
        }

        .main {
            padding: 16px;
            margin-bottom: 30px;
        }

        .half-screen-page {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background-color: #f3f4f5;
            /* background: rgb(20,69,238);
background: linear-gradient(90deg, rgba(20,69,238,0.8244339972317052) 0%, rgba(43,49,63,1) 100%);          z-index: 1; */
            transition: all 0.3s ease-out;
            transform: translateY(100%);

        }

        .half-screen-page.open {
            transform: translateY(0);
            background-color: #2b313ff9;
            border-radius: 15px;

            /* background: rgb(20,69,238);
background: linear-gradient(90deg, rgba(20,69,238,0.8244339972317052) 0%, rgba(43,49,63,1) 100%);         */
        }

        .close-btn {
            position: absolute;
            top: 70%;
            right: 41%;
            /* font-size: 18px; */
            cursor: pointer;


            width: 70px;
            height: 70px;
            padding: 10px 16px;
            font-size: 24px;
            line-height: 1.33;
            border-radius: 35px;

            background-color: transparent;
            color: rgb(249, 249, 249);
            border: solid;
        }



        .overlay-content a {
            color: rgb(255, 255, 255);
            font-size: x-large;
            margin-left: 11%;
        }

        .overlay-content {
            position: relative;
            top: 30%;
            left: -7%;



        }







        #map,
        #mmap,
        #tmap,
        #gmap,
        #cmap,
        #viewmap {
            position: relative;

            height: 123%;
            width: 100%;
            margin-top: -235px;
        }

        /* 地圖大小 */

        .popupCustom .leaflet-popup-tip,
        .popupCustom .leaflet-popup-content-wrapper {
            background: RGB(43, 49, 63, 0.9);
            color: white;
            font-weight: bold;
            font-size: 18px;
            width: 300px;

        }

        /* 彈出視窗的文字和背景 */

        #abtn {
            font-size: 24px;
        }

        /* 彈出視窗的按鈕樣式 */

        body {
            opacity: 100%;
        }
    </style>
</head>

<body>
    <!-- from suggestion -->
    <button class="btn" id="parked">停好了</button>

    <div class="list">
        <button id="cam" target="_blank" onclick="activateCamera()" class="content " style="left:25%;top: 17%;">
            <div><i class="fa-solid fa-camera"></i></div>拍個照
        </button>
        <button id="timing" class="content" style="left:61%;top: 28%;">
            <a style="color: white; text-decoration: none;" href="timer.php">
                <div><i class="fa-solid fa-clock"></i></i></div>幫我計時
            </a></button>
        <button id="eat" class="content" style="left:75%;top: 51.5%;">
            <a style="color: white; text-decoration: none;" href="./afmap2.php">
                <div><i class="fa-solid fa-utensils"></i></div>附近美食
            </a></button>
        <button id="btnEditRec" class="content" style="left:60%;top: 74%;">
            <a style="color: white; text-decoration: none;" href="./afmap2.php">
                <div><i class="fa-solid fa-mountain-sun"></i></div>附近景點
            </a></button>
        <button id="rating" class="content" style="left:26%;top: 86%;">
            <div><i class="fa-solid fa-thumbs-up"></i></div>評價
        </button>
        <div class="circle"></div>
    </div>


    <!-- 景點 -->

    <div style="display: none;" id="overlay" class="overlay">
        <div id="card">
            <p id="cardTitle">附近美食推薦</p>
            contents here
            <button id="btnConfirmDel">確定刪除</button>
        </div>
    </div>

    <!-- done -->



















    <ul>
        <li>
            <a id="logo" href="." class="active">
                <img style="width: 120px;" src="./materials/logo/logoWithName-BlueBkg.png" alt="">
            </a>
        </li>
        <!-- <li><a href="#title" style="margin-left: -15%; font-size: 20px; position: relative;top: -1px;" class="title">找車位</a> -->
        </li>
        <li class="search" style="float:right;"><i href="#search" class="fa-solid fa-magnifying-glass"
                style="color: white; padding: 14px 16px; position: relative; top:2px;" onclick="toggleSearch()"></i>
        </li>

    </ul>

    <form autocomplete="off" action="/action_page.php" style="opacity: 100%;">
        <div class="autocomplete" style="width:100%; opacity: 100%; ">
            <input style="max-width: 300%;" class="search-container" id="myInput" type="text" name="myCountry"
                placeholder="Country">
        </div>
        <!-- <input type="submit"> -->
    </form>





    <!-- <form >
        <div class="autocomplete" style="width:300px;">
        <input action="/action_page.php" autocomplete="off" style="max-width: 100%;" class="search-container" type="text" placeholder="Search...">
      </div>
      </form> -->

    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.0145246911175!2d121.56163276405258!3d25.03358114446431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442abb6e9d93249%3A0xd508f7b3aa02d931!2sTaipei%20101%20Observation%20deck!5e0!3m2!1szh-TW!2stw!4v1672886288068!5m2!1szh-TW!2stw" 
      width="375" height="400" style="border:0; " allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->










    <!-- 左側選單 -->
    <input type="checkbox" name="" id="side-menu-switch">
    <div class="side-menu">
        <nav>
            <ul class="txt" style="height:120px">
                <!-- <li style="position:relative; top: -12px;">車種</li>           
            -->

                <li>
                    <input checked onclick="charge_parking()" type="radio" id="Scooter" name="category"><label
                        for="Scooter"></label>
                    <!-- <i class="fa-sharp fa-solid fa-motorcycle"></i> -->
                    一般充電
                </li><br>

                <!-- <li>
                    <input type="radio" id="MotorBus" name="category"><label for="MotorBus"></label>
                    <i class="fa-sharp fa-solid fa-bus"></i>
                    大客車
                </li><br> -->

                <li style="position:relative;">
                    <input onclick="tesla()" type="radio" id="Car" name="category">
                    <!-- <label for="Car"></label> -->
                    <!-- <i class="fa-sharp fa-solid fa-car"></i> -->
                    TESLA
                </li><br>

                <li>
                    <input onclick="gogoro()" type="radio" id="Scooter" name="category"><label for="Scooter"></label>
                    <!-- <i class="fa-sharp fa-solid fa-motorcycle"></i> -->
                    GOGORO
                </li><br>
            </ul>

            <div class="line"></div>
            <br>

            <!-- <ul class="txt">
                <li>特殊需求</li>
                <br>
                <li>
                    <input type="radio" id="" name="special"><label for=""></label>
                    <svg width="20" height="20" viewBox="0 0 15 15"><path fill="currentColor" d="M3 1.5a1.5 1.5 0 1 0 3 0a1.5 1.5 0 0 0-3 0ZM11.5 0a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3ZM3.29 4a1 1 0 0 0-.868.504L.566 7.752a.5.5 0 1 0 .868.496l1.412-2.472A345.048 345.048 0 0 0 1 11h2v2.5a.5.5 0 0 0 1 0V11h1v2.5a.5.5 0 0 0 1 0V11h2L6.103 5.687l1.463 2.561a.5.5 0 1 0 .868-.496L6.578 4.504A1 1 0 0 0 5.71 4H3.29ZM9 4.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v4a.5.5 0 0 1-1 0v-4h-1v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 1-1 0v-5Z" />
                    </svg>
                    親子
                </li><br>

                <li>
                    <input type="radio" id="" name="special"><label for=""></label>
                    <i class="fa-sharp fa-solid fa-wheelchair"></i>
                    身障
                </li><br>

                <li>
                    <input type="radio" id="" name="special"><label for=""></label>
                    <i class="fa-sharp fa-solid fa-car"></i>
                    一般
                </li><br>
            </ul> -->
        </nav>

        <!-- 左側選單按鈕 -->
        <label for="side-menu-switch">
            <i id="arrow" class="fa fa-angle-right"></i>
        </label>
    </div>












    <div class="navbar">
        <a style="position: relative; top: -0.3px;left:3px" href="parkinglotmap.php" class="active">
            <div><i class="fa-solid fa-square-parking"></i></div>找車位
        </a>
        <a style="color:aqua;" href="chargingmap.php">
            <div><i class="fa-solid fa-charging-station"></i></div>找充電
        </a>
        <a href="home.php">
            <div><i class="fa-solid fa-house-chimney"></i></div>回首頁
        </a>
        <a href="member.php">
            <div><i class="fa-solid fa-user"></i></div>會員中心
        </a>



        <a href="#more" id="toggle-button">
            <div>
                <i class="fa-solid fa-list-ul"></i>
            </div>
            更多
        </a>



        <div class="half-screen-page" id="half-screen-page">
            <button class="close-btn" id="close-btn">X</button>


            <div id="overlay-content" class="overlay-content">
                <a href="timer">
                    <div><i class="fa-regular fa-clock"></i></div>計時器
                </a>
                <a href="setting">
                    <div><i class="fa-sharp fa-solid fa-gear"></i></div> 設定
                </a>
                <a href="logout">
                    <div><i class="fa-solid fa-right-from-bracket"></i></div>登出
                </a>

            </div>
        </div>



    </div>
    </div>

    <script>
        // from suggestion
        const scene = document.getElementById('btnEditRec');
        // const scenePage = document.getElementById('overlay');
        const closeScene = document.getElementById('btnConfirmDel');

        scene.addEventListener('click', () => {
            scenePage.classList.toggle('open');
        });

        window.addEventListener('click', (event) => {
            if (event.target === scenePage) {
                scenePage.classList.remove('open');
            }
        });

        closeScene.addEventListener('click', (btn) => {
            if (btn.target === closeScene) {
                scenePage.classList.remove('open');
            }

        });




        // 景點

        //下面有bug 註解掉
        // const btnEditRec = document.getElementById('btnEditRec');
        // const overlay = document.getElementById('overlay');
        // // const card = document.getElementById('card');
        // const btnConfirmDel = document.getElementById('btnConfirmDel');

        // btnEditRec.addEventListener('click', () => {
        //   overlay.style.display = 'flex';
        // });


        //下面是舊的code
        // overlay.addEventListener('click', (event) => {
        // if (event.target == btnConfirmDel) {
        //     overlay.style.display = 'none';
        // }
        // });











        //trigger camera

        function activateCamera() {
            // const cameraWindow = window.open('', 'Camera', 'height=600,width=800');

            // check if the user's browser supports the getUserMedia method
            if (navigator.mediaDevices.getUserMedia) {
                // request access to the user's camera
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        // if access is granted, display the video stream on the page
                        var video = document.createElement('video');
                        video.srcObject = stream;
                        document.body.appendChild(video);
                        video.play();
                    })
                    .catch(function (error) {
                        // if there is an error, display an error message
                        console.log("Error: " + error);
                    });
            } else {
                // if the getUserMedia method is not supported, display an error message
                console.log("Your browser does not support the getUserMedia method");
            }
        }


















        getLocation();

        const toggleButton = document.getElementById('toggle-button');
        const halfScreenPage = document.getElementById('half-screen-page');
        const closeBtn = document.getElementById('close-btn');


        toggleButton.addEventListener('click', () => {
            halfScreenPage.classList.toggle('open');
        });

        window.addEventListener('click', (event) => {
            if (event.target === halfScreenPage) {
                halfScreenPage.classList.remove('open');
            }
        });

        closeBtn.addEventListener('click', (btn) => {
            if (btn.target === closeBtn) {
                halfScreenPage.classList.remove('open');
            }

        });





        function toggleSearch() {
            var search = document.querySelector("form");
            if (search.style.display === "block") {
                search.style.display = "none";
            } else {
                search.style.display = "block";
            }
        }




        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function (e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) { return false; }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function (e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        //關鍵字搜尋
        var countries = ["Tesla", "Gogoro"];

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("myInput"), countries);


        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }


        const button = document.querySelector('.btn');
        const list = document.querySelector('.list');
        button.addEventListener('click', () => {
            list.classList.toggle('active');
        });




        const eating = document.getElementById('eat');

        btnEditRec.addEventListener('click', () => {
            list.classList.toggle('active');
        });

        eating.addEventListener('click', () => {
            list.classList.toggle('active');
        });




        const rate = document.getElementById('rating');

        const time = document.getElementById('timing');

        const camera = document.getElementById('cam');

        rate.addEventListener('click', () => {
            list.classList.toggle('active');
        });

        time.addEventListener('click', () => {
            list.classList.toggle('active');
        });

        camera.addEventListener('click', () => {
            list.classList.toggle('active');
        });


    </script>





    <div style="display: none;" id="map" class="popupCustom"></div>
    <br>
    <div id="mmap" class="popupCustom"></div>
    <!-- 一般機車和汽車停車場地圖，其中一個已經預設隱藏 -->

    <br>

    <div id="tmap" class="popupCustom"></div>
    <div id="gmap" class="popupCustom"></div>
    <div id="cmap" class="popupCustom"></div>
    <!-- 充電地圖，已經預設2個隱藏 -->

    <!-- <button onclick="setMapView(24.161881630522924,120.64687488397529,17)">setview</button> -->
    <!-- 經緯度+縮放大小 -->


    <button onclick="charge_parking()">充電(一般)</button>
    <button onclick="tesla()">tesla</button>
    <button onclick="gogoro()">gogoro</button>
    <!-- 切換地圖 -->

    <script>
        map_ini();//一般地圖初始化
        cmap_ini();//充電地圖初始化
        getLocation();//得到現在位置
        // setMapView(24.161881630522924, 120.64687488397529,17); //設定地圖視野為,縮放程度
    </script>
    <?php
    tesladata();
    gogorodata();
    // 從資料庫取出資料並載入地圖
    ?>
</body>

</html>