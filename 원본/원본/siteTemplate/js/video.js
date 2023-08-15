$(function(){
  $(`.video_list button`).click(function(){
    var preSrc = $(`.youtube_wrap iframe`).attr(`src`)
    var a = $(this).val()
    var nextSrc = `https://www.youtube.com/embed/${a}`
    if(preSrc===nextSrc) return false
    $(`.youtube_wrap iframe`).attr(`src`, nextSrc)
    $(`.video_list button`).removeClass(`active`)
    $(this).addClass(`active`)
    
  })
})




