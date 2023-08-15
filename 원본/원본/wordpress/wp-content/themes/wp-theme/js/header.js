$(function () {
  var reqID
  function fnGetWInInfo() {
    if(scrT >= 35){
      $(`header`).addClass(`active`)
    }else{
      $(`header`).removeClass(`active`)

    }
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })

  $(`.gnb-lg>div>ul>li>a`).click(function (e) {
    e.preventDefault()
  })
  $(`.gnb-lg>div>ul>li`).mouseenter(function () {
    $(this).children(`ul`).stop().slideDown()
  }).mouseleave(function () {
    $(this).children('ul').stop().slideUp()
  })

  $(`.mbtn-open`).click(function () {
    $(`.gnb-sm`).fadeIn(500, function () {
      $(`.gnb-sm video`)[0].play()
    })
    $('body').append(`
      <script src="/wp-content/themes/wp-theme/js/app_particle_star.js"></script>
    `) 
  })

  $(`.mbtn-close`).click(function () {
    $(`.gnb-sm`).fadeOut(500)

    $(`.gnb-sm>div>ul>li>a`).removeClass(`active`)
    $(`.gnb-sm>div>ul>li>a`).stop().slideUp()
    $(`body script:last-child`).remove()
  })

  $(`.gnb-sm div>ul>li>a`).click(function (e) {
    e.preventDefault()
    $(`.gnb-sm div>ul>li>a`).siblings(`ul`).stop().slideUp()
    $(this).siblings(`ul`).stop().slideToggle()
    $(`.gnb-sm div>ul>li>a`).not($(this)).removeClass(`active`)
    $(this).toggleClass(`active`)
  })
})