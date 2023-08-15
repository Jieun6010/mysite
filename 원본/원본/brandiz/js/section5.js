$(function () {
  var start = false

  $(`.progress-num`).each(function(){
    var c = 0
    var el = $(this) // this를 밑에 중괄호 안에 또 넣을 수 없으니까 변수에 넣어주고 밑에 넣자.
  
    setInterval(function () {
      if(start === true){
        var t = parseInt(el.attr('data-t'))
      }else{
        var t = 0
      }
      //땀을 흘리면서 팔을 왼쪽으로 뻗는 모양으로 외워보장 1에 가까울수록 천천히변하고 0에 가까울수록 빨리 변함
      c += (t - c) * 0.05 // 맨 뒤에 숫자는 숫자가 바뀌는 속도 /  소수점이반드시필요하니 parseInt는 x 다만 출력할때는 parseInt해줘야함.
      el.text(Math.round(c))
    }, 50) // 반복해서 찍히는 속도
  }) // each



  var reqID
  function fnGetWInInfo() {
    var elT
    var elH
    var meta
    // progressing
    var elT = $(`.dummy-scroll`).offset().top
    if (scrT >= elT - winH) {
      start = true
      $(`.section5 .progress li`).addClass(`active`)
      TweenMax.to(".section5 .poly-circle", 0.5, { morphSVG: ".section5 .badge", ease: Linear.easeNone })
    } else {
      start = false
      $(`.section5 .progress li`).removeClass(`active`)
      TweenMax.to(".section5 .poly-circle", 0.5, { morphSVG: ".section5 .poly-circle-copy", ease: Linear.easeNone })
    } 
    // sticy ratio 구현
    var stickystart = $(`.section5`).offset().top + winH// 회전이 시작되는 지점
    var stickyend = $(`.section6`).offset().top - winH
    var scrollRange = stickyend - stickystart // 스크롤 범위가 나옴
    var scrRatio =  (scrT - stickystart) / scrollRange
    if(scrRatio <  0) scrRatio = 0
    if(scrRatio >  1) scrRatio = 1
    var n = parseInt(scrRatio * 47) + 1
    
    $(`.section5 .img`).hide()
    $(`.section5 .img`+n).show()
  } // fn
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })

})
