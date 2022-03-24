var mySwiper = new Swiper('#swiper-menu', {
  slidesPerView: 2,
  loop: true,
  spaceBetween: 30,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  grabCursor: true
});