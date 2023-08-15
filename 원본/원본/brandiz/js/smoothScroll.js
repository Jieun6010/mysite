{
  let scrollSpeed = 0
  let fnSmoothScroll = () => {
    if (isMobile) return false // 모바일이면 엔진 가동 X
    /* 
    제이쿼리 방식
    $(window).scrollTop( $(window).scrollTop() + 10 
    */
    window.scrollTo({
      top: window.scrollY + scrollSpeed
    })
    scrollSpeed *= 0.9 // 브레이크 아주 살짝 계속 누르고 있는 기능
    requestAnimationFrame(fnSmoothScroll) //  최적화 ! fnSmoothScroll함수를 영원히 반복하기위해서 씀. 안하면 과부화걸리니까
  } // fnSmoothScroll

  fnSmoothScroll()

  /* 
  할일식사(){
    밥먹기()
    물먹기()
    
    최소하루에3번식사()} -> 제한한다
  } 식사()가 무한루트
  */

  /* 
  제이쿼리 방법 
  $(`section,main`).bind(`mousewheel`),function(e){
    e.preventDefault()
    scrollSpeed = e.originalEvent.wheelDelta / - 120 * 10
   })
 */


  /* 바닐라 방법 */
  let prevwheelDelta

  window.addEventListener(`mousewheel`, e => {

    if(e.wheelDelta !== prevwheelDelta) scrollSpeed = 0 // 현재 일어난 휠 값 != 아까 저장해놓은 휠 값이 다르다면  // 휠의 방향 감지 

    e.preventDefault()
    // console.log(e.wheelDelta);
    scrollSpeed += e.wheelDelta / - 120 * 10
    
    prevwheelDelta = e.wheelDelta // 현재 휠값을 prevwheelDelta에 적용하기. // 120  // 현재 휠값을 저장해놓고 다음에 또 휠을 하면 prevwheelDelta(현재 발생한 휠 값)을 if(e.wheelDelta != prevwheelDelta) scrollSpeed여기에 넣어서 ?
  }, { passive: false }) // 휠이 죽어버림! //mousewheel부분 


}



