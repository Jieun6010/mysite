$(function(){
  $(function(){
    var reqID
    function fn(){
      $(`.greet_section p, .greet_section img`).each(function(){
        var offT = $(this).offset().top
        if(scrT >= offT - winH * 0.8) 
        $(this).addClass(`active`)
        else 
        $(this).removeClass(`active`)
      })
    }
  
    $(window).scroll(function(){
      reqID = requestAnimationFrame(fn)
    }).resize(function(){
      reqID = requestAnimationFrame(fn)
    })
  })
})