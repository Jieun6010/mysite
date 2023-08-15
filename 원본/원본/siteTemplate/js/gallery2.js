$(function () {

  hover_box('.float_container li a figure', '.float_container li a figure figcaption')
  $(`.float_container li a`).viewbox()
  var reqID
  function fnGetWInInfo() {
    $(`.flex_container li`).each(function () {
      var off = $(this).offset().top
      var winH = $(this).innerHeight()
      var meta = 1 + Math.abs(scrt - (off - winH * 0.5 + h * 0.5)) * -0.0004
      if (meta < 0) { meta = 0 }

      $(this).children('a').css({ 'transform': `scale(${meta})` })
    })
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })//scroll


})//ready