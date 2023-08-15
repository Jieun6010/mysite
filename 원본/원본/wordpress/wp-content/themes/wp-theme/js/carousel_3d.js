function carousel3d(el, interval_delay, rotate_duration) {
  var el = $(el)
  var face_cnt = $(el).find(".polygon3d").children("*").size()
  var face_width
  var degree
  var ab
  var delta
  var radian
  var bc

  function set_polygon() {
    face_width = $(el).find(".polygon3d").children("*").innerWidth()
    ab = face_width * 0.5
    degree = (360 / face_cnt)
    delta = (180 - degree) * 0.5
    radian = delta / 180 * Math.PI
    bc = Math.tan(radian) * ab 
    for (i = 1; i <= face_cnt; i++) {
      $(el).find(".polygon3d").children("*:nth-child(" + i + ")").css({
        "transform": "rotateY(" + (i - 1) * -degree + "deg) translateZ(" + bc + "px)",
      }).addClass("imgbox"+i)
      $(el).find(".polygon3d").children("*:first-child").addClass("active")
      $(el).find(".polygon3d").css({ "transform": "translateZ(" + -bc + "px)" })
      $(".indicator button:nth-child("+i+")").addClass("btn"+i).attr("data-n",i)
      $(".indicator button:first-child").addClass("active")
    } 
  }
  set_polygon()
  $(window).resize(function () {
    set_polygon()
  })

  var n = 1
  var flag = false
  var rotate_degree
  var interval_delay = interval_delay
  var rotate_duration = rotate_duration
  var intervalID
  var timeoutID
  $(el).find(".polygon3d").css({ "transition": "transform " + rotate_duration * 0.001 + "s" })
  intervalID = setInterval(function () {
    n++
    change()
  }, interval_delay)

  function change(){
    rotate_degree = (n - 1) * degree
    $(el).find(".polygon3d").css({
      "transform": "translateZ(" + -bc + "px)  " + "rotateY(" + rotate_degree + "deg)"
    })//css
    $(el).find(".polygon3d").children("*").removeClass("active")
    $(el).find(".polygon3d").children(".imgbox"+n).addClass("active")
    $(el).find(".indicator button").removeClass("active")
    $(el).find(".btn"+n).addClass("active") 
    if(n > face_cnt){
      $(el).find(".polygon3d").children("*").removeClass("active")
      $(el).find(".polygon3d").children(".imgbox1").addClass("active")
      $(el).find(".indicator button").removeClass("active")
      $(el).find(".btn1").addClass("active") 
    }
    if(n < 1){
      $(el).find(".polygon3d").children("*").removeClass("active")
      $(el).find(".polygon3d").children(".imgbox"+face_cnt).addClass("active")
      $(el).find(".indicator button").removeClass("active")
      $(el).find(".btn"+face_cnt).addClass("active") 
    }
    setTimeout(function () {
      flag = true
      if (n > face_cnt || n < 1) {
        if(n > face_cnt){n = 1}
        if(n < 1){n = face_cnt}
        rotate_degree = (n - 1) * degree
        $(el).find(".polygon3d").css({
          "transition-duration": "0s",
          "transform": "translateZ(" + -bc + "px)  " + "rotateY(" + rotate_degree + "deg)"
        })
        $(el).find(".polygon3d").css("transform")
        $(el).find(".polygon3d").css({ "transition": "transform " + rotate_duration * 0.001 + "s" })
      }
    }, rotate_duration)
  }//fn change

  function autoplay(){
    clearInterval(intervalID)
    clearTimeout(timeoutID)
    timeoutID = setTimeout(function(){
      intervalID = setInterval(function () {
        n++
        change()
      }, interval_delay)
    })
  }

  $(".indicator button").click(function(){
    if(flag === false){return false}
    flag = false
    n = $(this).attr("data-n")
    change()
    autoplay()
  })

  $(".next").click(function(){
    if(flag === false){return false}
    flag = false
    n ++
    change()
    autoplay()
  })
  $(".prev").click(function(){
    if(flag === false){return false}
    flag = false
    n --
    change()
    autoplay()
  })
}//fn 




