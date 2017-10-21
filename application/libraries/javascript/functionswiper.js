function reponSwiper(class_container, nexbtn, prebtn) {
    if (!jQuery(class_container).length) {
        return false;
    }
    var swipername = new Swiper (class_container, {
        // Optional parameters Swiper
        nextButton: nexbtn,
        prevButton: prebtn
    });

    function resizeswp(obj) {
        if (jQuery(window).width() >= 767) {
            obj.params.slidesPerView = 4;
        }
        if (jQuery(window).width() < 767) {
            obj.params.slidesPerView = 2;
        }
        if (jQuery(window).width() <= 480) {
            obj.params.slidesPerView = 1;
        }
        obj.update();
    }

    resizeswp(swipername);
    jQuery(window).resize(function(){
        resizeswp(swipername);
    });
}
function makeswiper(swipercontainer, swiperslide){
    jQuery(swipercontainer).find(swiperslide).addClass('swiper-slide').wrapAll('<div class="swiper-wrapper"></div>');
}

// reponSwiper('.swiper-container','.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-next', '.produktet-anvendt >.mod_reditem_items_wrapper .swiper-button-prev');