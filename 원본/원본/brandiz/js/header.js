/* get section */
window.headerH;
window.offT1; window.offT2; window.offT3;
window.offT4; window.offT5; window.offT6;
window.offsetArr;
window.currentSection

$(function () {
  var reqID
  function fn() {

    if (window.matchMedia('screen and (min-width:1000px)').matches) headerH = 70
    else { headerH = 60 }

    offT1 = $(`.section1`).offset().top
    offT2 = $(`.section2`).offset().top - headerH
    offT3 = $(`.section3`).offset().top - headerH
    offT4 = $(`.section4`).offset().top - headerH
    offT5 = $(`.section5`).offset().top - headerH
    offT6 = $(`.section6`).offset().top - headerH
    offsetArr = [offT1, offT2, offT3, offT4, offT5, offT6]//배열은 0부터 시작 
  }
  fn()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fn)
  }).resize(function () {
    reqID = requestAnimationFrame(fn)
  })

})//ready


$(function () {
  /* header start */
  var reqID
  function fn() {
    if (scrT > 200) {
      $(`header`).addClass(`active`)
      TweenMax.to("header .line ", 1, { morphSVG: "header .zigzag", ease: Linear.easeNone })
    } else {
      $(`header`).removeClass(`active`)
      TweenMax.to("header .line ", 1, { morphSVG: "header .linecopy", ease: Linear.easeNone })
    }

    if (window.matchMedia(`screen and (max-width:1000px)`).matches) { /* 모바일이라면 */
      $(`header`).addClass(`active`)
    }

    var scrollRange = $(document).innerHeight() - winH
    var scrollRatio = scrT / scrollRange
    var dashOffset = - (1 - scrollRatio)
    $(`header .line`).css({ 'stroke-dashoffset': `${dashOffset}` })
  }

  fn()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fn)
  }).resize(function () {
    reqID = requestAnimationFrame(fn)
  })
  /* header end */
})//ready

$(function () {
  /* menu start*/
  $(`.mbtn`).click(function () {
    $(this).toggleClass(`active`)
    $(`.gnb-sm`).stop().slideToggle(`active`)
  })
  /* menu end*/

  
  $(`.gnb a`).click(function (e) {
    e.preventDefault() /* 링크기능x */
    $(`.gnb-sm`).stop().slideUp()
    $(`.mbtn`).removeClass(`active`)
    var n = parseInt($(this).attr(`href`))

    $(`body,html`).stop().animate({ 'scrollTop': offsetArr[n - 1] }) //제이쿼리 방법
    /* animate() : css를 부드럽게 transition대신 사용*/

    /* window.scrollTo({
       top: offsetArr[n-1],
       behavior:'smooth',
       })//바닐라 방법 */
  })

})//ready

$(function () {
  /* scrollspy */
  var reqID

  function fn() {

    if (scrT < offT2) { //T1
      currentSection = 1
    } else if (scrT >= offT2 - 1 && scrT < offT3 - 1) {
      currentSection = 2 //T2 스크롤이 오프셋2 보다 작으면서 스크롤3보다 클 때
    } else if (scrT >= offT3 - 1 && scrT < offT4 - 1) {
      currentSection = 3  //T3
    } else if (scrT >= offT4 - 1 && scrT < offT5 - 1) {
      currentSection = 4  //T4
    } else if (scrT >= offT5 - 1 && scrT < offT6 - 1) {
      currentSection = 5  //T5
    } else { //6
      currentSection = 6
    }
    $(`.gnb a`).removeClass(`active`)
    $(`.gnb .link${currentSection}`).addClass(`active`)
  }//fn

  fn()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fn)
  }).resize(function () {
    reqID = requestAnimationFrame(fn)
  })
})//ready


$(function () {
  /* side scrollspy */
  var reqID
  function fnGetWInInfo(){
    var scrollRange = docH - winH // 문서 전체 높이 - 브라우저 높이
    var scrRatio = scrT / scrollRange // 
    
    $(`.scrollspy .progress`).css({'stroke-dashoffset':`${1-scrRatio}px`})
    $(`.scrollspy .circle`).css({'offset-distance':`${scrRatio * 100}%`})

  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
}) //