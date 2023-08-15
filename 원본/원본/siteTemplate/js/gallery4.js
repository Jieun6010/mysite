$(function () {

  $(window).load(function () { //load 는 로딩이 완전히 끝나는 시ㄱ점
    $(`.masonry_container`).masonry({ itemSelector: `.masonry_container li` })

  })

})