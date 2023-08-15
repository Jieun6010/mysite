$(function () {
  var reqID
  function fnGetWInInfo() {
    var offT = $(`.section2`).offset().top
    var meta = 0 + (scrT - (offT - 60)) * 0.05
    if (meta > 20) { meta = 20 }
    if (meta < -20) { meta = -20 }
    $(`.section2 .bg`).css({ 'transform': `scale(1.1) translateY(${meta}%) translateX(-50%)` })

  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })



  /* slider start*/
  var n = 1
  var timeoutID

  var intervalID = setInterval(function () {
    n++
    change()
    $(`.carousel .img`).stop().animate({ 'left': `-20`, 'opacity': '0' })
    $(`.carousel .img${n}`).css({ 'left': `20%` })
    $(`.carousel .img${n}`).stop().animate({ 'left': `0`, 'opacity': '1' })
  }, 2000)

  function change() {
    if (n > 2) { n = 1 }
    if (n < 1) { n = 2 }
  }

  function autoplay() {
    clearInterval(intervalID)
    crearTimeout(timeoutID)
    timeoutID = setTimeout(function () {
      intervalID = setInterval(function () {
        n++
        change()
        $(`.carousel .img`).stop().animate({ 'left': `-20%`, 'opacity': '0' })
        $(`.carousel .img${n}`).css({ 'left': `20%` })
        $(`.carousel .img${n}`).stop().animate({ 'left': `0`, 'opacity': '1' })
      }, 2000)
    }, 5000)
  }

  $(`.carousel .next`).click(function () {
    n++
    change()
    $(`.carousel .img`).stop().animate({ 'left': `-20%`, 'opacity': '0' })
    $(`.carousel .img${n}`).css({ 'left': `20%` })
    $(`.carousel .img${n}`).stop().animate({ 'left': `0`, 'opacity': '1' })

  })

  $(`.carousel .prev`).click(function () {
    n--
    change()
    $(`.carousel .img`).stop().animate({ 'right': `20%`, 'opacity': '0' })
    $(`.carousel .img${n}`).css({ 'right': `-20%` })
    $(`.carousel .img${n}`).stop().animate({ 'right': `0`, 'opacity': '1' })

  })
})