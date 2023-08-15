$(function () {
  var reqID
  function fnGetWInInfo() {

    var offT = $(`.section3`).offset().top
    var meta = 0 + (scrT - (offT)) * 0.1
    if (meta < -40) meta = -40
    if (meta > 40) meta = 40
    $(`.section3 .bg`).css({ 'transform': `scale(1.3) translateY(${meta}%)` })
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })


  $('.section3 .bg').ripples({
    resolution: 512,
    dropRadius: 20,
    perturbance: 0.04,
  });


})