$(function () {
  $(window).load(function () {
    var wave1 = new displacmentWave(
      `.section1 .bg img`,
      `#ripple-filter1`,
      `./img/ripple/ripple.png`,
      4,
      4
    ) //wave1
    // 6초마다 웨이브 발생시키기
    setInterval(function () {
      wave1.wave()
    }, 6000)
  }) //load

  /* wave end */


  /* scroll motion & parallax */
  var reqID
  function fnGetWInInfo() {
    var offT
    var meta


    offT = $(`.section2`).offset().top
    if (scrT >= offT - winH * 0.5) {
      $(`.section1`).removeClass(`active`)
    } else {
      $(`.section1`).addClass(`active`)
    }


    offT = $(`.section1`).offset().top
    meta = 0 + (scrT - offT) * 0.3
    $(`.section1 .boy`).css({ 'transform': `translateY(${meta}px)` })
    meta = 1 + (scrT - offT) * 0.001
    $(`.section1 .bg`).css({ 'transform': `scale(${meta})` })
    meta = 0 + (scrT - offT) * 0.04
    $(`.section1 .bg`).css({ 'filter': `blur(${meta}px)` })

  } //fn
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })

}) //ready