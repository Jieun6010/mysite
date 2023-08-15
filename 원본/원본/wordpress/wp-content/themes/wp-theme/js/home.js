$(function () {
  carousel3d(".carousel", 2000, 1000)
  var flipBook1 = new flipBook('.flip-book1')
  $('.home-section3 .bg').ripples({
    resolution: 512,
    dropRadius: 20,
    perturbance: 0.02,
  });
  
  var reqID
  function fnGetWInInfo() {
    var offT = $(`.flip-book1`).offset().top
    if (scrT >= offT - winH * 0.5) {
      flipBook1.flip(2)
    } else {
      flipBook1.flip(1)
    }
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })

})
