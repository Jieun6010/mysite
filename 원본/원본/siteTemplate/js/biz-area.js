$(function () {
  var reqID
  function fn() {
    $(`.biz_area_section p, .biz_area_section figure`).each(function () {
      var offT = $(this).offset().top
      if(scrT >= offT - winH * 0.8){
        $(this).addClass(`active`)
      }else{
        $(this).removeClass(`active`)

      }
    })

  }
  fn()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fn)
  }).resize(function () {
    reqID = requestAnimationFrame(fn)
  })
})

