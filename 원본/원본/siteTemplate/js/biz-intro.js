$(function(){
  var reqID
  function fn(){
    $(`.biz_intro_section>p, .biz_intro_section li`).each(function(){
      var offT = $(this).offset().top
      if(scrT >= offT - winH  * 0.9)
      $(this).addClass(`active`)
      else
      $(this).removeClass(`active`)
    })
    $(`.biz_intro_section li div`).each(function(){
      var offT = $(this).offset().top
      var h = $(this).innerHeight()
      var meta = 0 + (scrT - (offT - winH * 0.5 + h * 0.5)) * 0.05
      if(meta > 15) meta = 15
      if(meta < -15) meta = -15
      $(this).children(`img`).css({'transform' : `scale(150%) translateY(${meta}%) `})
    })//each
  }//fn

  $(window).scroll(function(){
    reqID = requestAnimationFrame(fn)
  }).resize(function(){
    reqID = requestAnimationFrame(fn)
  })
})