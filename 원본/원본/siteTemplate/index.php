<?php include "header.php" ?>
<script src="./store/store.js"></script>
<script src="./js/home.js"></script>

<section class="home_visual">
    <!-- particles.js container -->
    <script src="js/particles.js"></script>
    <script src="js/app_particle_star.js"></script>
    <div id="particles-js"></div>
    <!-- particles.js container -->
</section>
<script>
    homeVisualArr.forEach(function(v) {
        $(`.home_visual`).append(`
        <figure>
        <img src=${v.path} alt="">
        <figcaption>
            <h5>${v.title}</h5>
            <p>${v.desc} 
            </p>
        </figcaption>
    </figure>
        `)
    })
</script>
<section class="feature">
    <h2 class="hidden"></h2>
    <ul></ul>
    <script>
        featureArr.forEach(function(v) {
            $(`.feature ul`).append(`
        <li>
            <a href="${v.link}">
                <figure>
                    <img src=${v.path} alt="">
                        <figcaption>
                            <h3>${v.title}</h3>
                            <p>${v.desc}</p>
                        </figcaption>
                </figure>
            </a>
        </li>             
            `)
        })
    </script>
</section>

<section class="latest">
    <h2 class="hidden">recently</h2>
    <article class="news">
        <div class="center">
            <h3><i class="fa-solid fa-microphone-lines"></i> LATEST NEWS</h3>
            <div class="rolling">
                <ul>
                    <li>뉴스 게시판 최신글 테스트 1번</li>
                    <li>뉴스 게시판 최신글 테스트 2번</li>
                    <li>뉴스 게시판 최신글 테스트 3번</li>
                    <li>뉴스 게시판 최신글 테스트 4번</li>
                </ul>
            </div><!-- rolling -->
            <script>
                $(`.rolling ul`).clone().appendTo(`.rolling`) // append랑 appendTo랑 쓰임이 다르니 잘 구분하자
                /*  바닐라로는 이렇게 하면 돼!
                let ulCopy = document.querySelector(`.rolling ul`).cloneNode(true)
                document.querySelector(`.rolling ul`).append(ulCopy)
                */
            </script>
        </div><!-- center -->
    </article>

    <div class="bottom">
        <article class="notice">
            <h3>notice</h3>
            <ul></ul>
            <script>
                noticeArr.forEach(function(v) {
                    $(`.notice ul`).append(`
                    <li>
                    <a href="#">${v.desc}</a>
                    <time>${v.date}</time>
                    </li>
                    `)
                })
            </script>
            <a href="./notice.php" class="more">more+</a>
        </article>

        <article class="customer">
            <h3>customer</h3>
            <p>문의 전화를 주시면 친절히 상담하여 드립니다.</p>
            <a class="tel" href="tel:010-0000-0000">
                <i class="fa-solid fa-phone-volume"></i>
                010.1234.5678
            </a>
        
            <a class="mail" href="./contact.php">
            <i class="fa-solid fa-envelope"></i>
            contact us</a>
        </article>

        <article class="gallery">
            <h3>gallery</h3>
            <ul></ul>
            <script>
                for (var i = 1; i <= 4; i++) {
                    $(`.gallery ul`).append(`
                    <li>
                        <a href="#">
                            <img src="./img/sub3/${i}.jpg" alt>
                    </li>
                    `)
                }
            </script>
            <a href="./gallery1.php" class="more">more+</a>
        </article>

    </div>

</section>
<?php include "footer.php" ?>