$(function () {

  hover_box('.float_container li a figure','.float_container li a figure figcaption')
  $(`.float_container li a`).viewbox()

  var reqID
  function fnGetWInInfo() {
    $(`.float_container li a figure`).each(function(){
      var off = $(this).offset().top
      var winH = $(this).innerHeight()
      var meta = 0 + (scrt - (off - winh *0.5 + h *0.5))* 0.12
      if(meta > 15){meta = 15}
      if(meta < -15){meta = -15}
      $(this).children('img').css({'transform':`scale(1.4) translateY(${meta}%)`})
    })
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })//scroll


})//ready