$(`body`).css({'overflow':`hidden`})
// body는 레디ㅁ이벤트에 안넣어두된대 

// 로딩이 완료되면
$(window).load(function(){
  $(`.preloader .loader`).fadeOut(function(){
    //fadeOut(똥글뱅이)가  완전히 끝나면 할 일!
    $(`.preloader`).addClass(`active`) // 문이 열리고 
    $(`body`).css({'overflow':`auto`}) // 로딩아이콘이 사라지고 
    setTimeout(function(){
      $(`.preloader`).hide() 
    },500) // 문이 다 열리고나서 할 일
  })

})  