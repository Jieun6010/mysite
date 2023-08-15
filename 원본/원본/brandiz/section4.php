<script src="./js/section4.js"></script>
<section class="section4">
  <script src="./js/app_particle_bubble.js"></script>
  <div id="particles-js2"></div>

  <h2 class="title" data-content="portfolio">
    <span>portfolio</span>
  </h2>

  <div class="btns">
    <button value="*">all</button>
    <button value=".web">1.Web</button>
    <button value=".app">2.Application</button>
    <button value=".etc">3.Etc</button>
  </div>

  <ul class="portfolio"></ul>

  <script>
    portfolioArr.forEach(function(v) {
      $(`.section4 .portfolio`).append(`
        <li class="${v.class}">
          <a href="./img/section4/${v.detail}.jpg">
            <figure>
              <div><img src="./img/section4/${v.thumbe}.jpg"></div>
                <figcaption style="filter:hue-rotate(${Math.random()*360}deg)">
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