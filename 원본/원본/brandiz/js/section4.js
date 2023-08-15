window.portfolioArr = [
  {
    title:'title1',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb1',
    detail:'big1',
    class : 'web',
  },
  {
    title:'title2',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb2',
    detail:'big2',
    class : 'web app',
  },
  {
    title:'title3',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb3',
    detail:'big3',
    class : 'app etc',
  },
  {
    title:'title4',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb4',
    detail:'big4',
    class : 'web etc app',
  },
  {
    title:'title5',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb5',
    detail:'big5',
    class : 'web etc',
  },
  {
    title:'title6',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb6',
    detail:'big6',
    class : 'app',
  },
  {
    title:'title7',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb7',
    detail:'big7',
    class : 'etc',
  },
  {
    title:'title8',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb8',
    detail:'big8',
    class : 'app etc',
  },
  {
    title:'title9',
    desc: 'Lorem ipsum dolor sit amet ',
    thumbe:'thumb9',
    detail:'big9',
    class : 'web app',
  },
]


$(function(){
  hover_box(`.portfolio figure`, `figcaption`)
  var reqID
  function fnGetWInInfo(){
    $(`.portfolio li`).each(function(){
      var elT = $(this).offset().top
      var elH = $(this).innerHeight()
      var meta = 0 + (scrT - (elT - winH * 0.5 + elH * 0.5)) * 0.1
      $(this).find('img').css({'transform':`scale(1.2) translateY(${meta}px)`})
    })
  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }) // window event


  $(window).load(function(){
    var $container = $('.portfolio');
    var filterSelect ="*"
    fn_isotope()
    function fn_isotope(){
       $container.isotope({
          filter: filterSelect,
          animationOptions: {
             duration: 750,
             easing: 'linear',
             queue: false
          }//animationOptions
       })//isotope
    }//fn
    $('.section4 .btns button').click(function(){
       filterSelect = $(this).val()
       $('.section4 .btns button').removeClass(`active`)
       $(this).addClass(`active`)
       fn_isotope()
    })//click   

    $(window).resize(function(){
       fn_isotope()
    })//resize
 })//load

 $(`.portfolio li a`).click(function(e){
  e.preventDefault() // 기본 브라우저의 휠 기능을 제거
  $(`.modal`).fadeIn()
  $(`body`).css({'overflow':`hidden`}) 
  /* scss에 overflow:auto로 하면 클릭할때 스크롤바가 2개 생기는데 css로 hidden값을 주면 클릭할때 사라진다. */
  $(`.modal .loader`).show()

  $(`.modal`).append(`
  <img src="${$(this).attr('href')}" alt>
  `)
  $(`.modal img`).load(function(){
    $(this).fadeIn()
    $(`.modal .loader`).fadeOut()
  }) // 로딩이 끝났을 때

  $(`.modal img`).click(function(e){
    e.stopPropagation()
  })
}) // 클릭할때
  
 $(`.modal`).bind('mousewheel',function(e){
  e.stopPropagation() // 이거 해서 브라우저의 휠 기능이 다시 살아남.
 })

 $(`.modal`).click(function(){
  $(this).fadeOut()
  $(`.modal img`).remove()
  $(`body`).css({'overflow':`auto`})
 })


}) // ready
