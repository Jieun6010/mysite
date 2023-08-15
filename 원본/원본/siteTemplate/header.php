<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icons/favicon.ico"> <!-- 주소창에 아이콘..? -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- 폰트는 가장 위쪽에 적용해줘야해 ! -->
    <link rel="stylesheet" href="./css/reset.css"><!-- 리젯을 먼저 걸어줘야해 아니면 글자가 깨진다거나 그런 렉이 걸릴 수 있어 -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/sub_layout.css">
    <link rel="stylesheet" href="./css/greet.css">
    <link rel="stylesheet" href="./css/biz-intro.css">
    <link rel="stylesheet" href="./css/board.css">
    <link rel="stylesheet" href="./css/contact.css">
    <link rel="stylesheet" href="./css/faq.css">
    <link rel="stylesheet" href="./css/location.css">
    <link rel="stylesheet" href="./css/video.css">
    <link rel="stylesheet" href="./css/biz-area.css">
    <link rel="stylesheet" href="./css/gallery1.css">
    <link rel="stylesheet" href="./css/gallery2.css">
    <link rel="stylesheet" href="./css/gallery3.css">
    <link rel="stylesheet" href="./css/gallery4.css">
    <link rel="stylesheet" href="./css/gallery5.css">
    <link rel="stylesheet" href="./css/viewbox.css">
    <link rel="stylesheet" href="./css/isotope.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/preloader.css">
    
    <script src="https://kit.fontawesome.com/a45f44bad8.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="./js/hoverBox.js"></script>
    <script src="./js/jquery.viewbox.js"></script>
    <script src="./js/masonry-docs.min.js"></script>
    <script src="./js/jquery.isotope.js"></script>
    <script src="./js/common.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include "preloader.php"?>
    <script src="./js/header.js"></script>
    <script src="./js/nav.js"></script>
    <header>
        <div class="top">
            <nav class="member"><!-- 메뉴를 넣어놓는곳들을 네비게이션이라고 함> -->
                <a href="./index.php">처음으로</a>
                <a href="#">로그인</a>
                <a href="#">회원가입</a>
            </nav>
        </div> <!-- top -->
        <div class="center">
            <h1> <!-- 대제목(로고) -->
                <a href="./index.php">
                    <img src="./img/icons/logo.png" alt=""> 
                    <!-- 이미지 크기를 바꾼다고생각하지말고 그 위에를 생각하자.
                    앵커는 인라인요소기때문에 인라인요소는 레이아웃에 아무런 영향도 주지 않는다. 그냥 글자니까 ! 
                    h1을 바꾸면 크기가 변한다고 생각하자. 액자 크기를 바꾸고 이미지는 그냥 꽉 차게 넣는다고 생각하자 
                    앵커는 인라인이라 액자가 될 수 없다. -->
                    <span class="hidden">선샤인</span>
                    <!--style="position: fixed;left:-100px" 
                        display를 객체 자체가 없어져서 읽지를 못한다. 
                    보이지는 않게 날려놓고 죽이지는 않은 ! 살려는 드릴게 하면서 화면 밖으로 날려버린다. -->
                    <!--문법에서 제목 안에는 글자를 꼭 넣어주길 권장한다. 섹션이나 아티클, 메인 등등에 글자가 들어가야한다. 
                    h1이나  -->
                </a>
                
            </h1>

            <nav class="gnb lg"><!-- 글로벌 네이게이션 바 라지사이즈-->
                <?php include "menu.php" ?>
            </nav>

            <nav class="gnb sm"><!-- 메뉴 누르면 나오는 X / 옆쪽 네이게이션 바 스몰사이즈-->
            <?php include "menu.php" ?>
            </nav>

            <button class="mbtn"> <!-- 모바일용 버튼 -->
                <i class="fa-solid fa-bars open"></i>
                <i class="fa-solid fa-xmark close"></i>
            </button>
        </div><!-- center -->
    </header>






    <!--
    <h2 class="serif">
        제목2
    </h2>

    <i style="color:red;font-size:500px;" class="fa-solid fa-whiskey-glass"></i>
    -->