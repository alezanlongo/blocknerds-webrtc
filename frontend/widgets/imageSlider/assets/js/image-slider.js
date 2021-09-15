(function ($) {

    $.imageSlider = function (elm) {
        var imageSliderModal = '<div class="modal fade" id="image-slider-modal"tabindex="-1" role="dialog" aria-labelledby="..." aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div>';
        var settings = {
            elm: $(elm),
            transition: false,
            cntElm: 0,
            elmWidth: 0,
            idx: 0,
            autoplay: false,
            autoplayInterval: null,
            autoplayBack: false
        };


        function bindControls() {
//            console.log(elm)
            $('.nav .l', settings.elm).on('click', function () {
                moveSlider('left')
            });
            $('.nav .r', settings.elm).on('click', function () {
                moveSlider('right')
            });
            $('li p', settings.elm).on('click', function () {
                $('#image-slider-modal').remove();
                $('body').prepend(imageSliderModal);
                $('.modal-content', '#image-slider-modal').html('<img src="' + $('img', $('ul', settings.elm).children('li').eq(settings.idx)).attr('src') + '"/>');
                $('#image-slider-modal').modal({keyboard: true});
            });
            $('.autoplay', settings.elm).on('click', function () {
                autoplay()
            }
            )

        }

        function moveSlider(dir) {
            if (settings.transition == true) {
                return false;
            }
            var moveTo;
            if (dir == 'left') {
                if (settings.idx == 0) {
                    return false
                }
                settings.idx--;
                moveTo = "+=" + settings.elmWidth + "px";
            } else {
                if (settings.idx == (settings.cntElm - 1)) {
                    return false
                }
                settings.idx++;
                moveTo = "-=" + settings.elmWidth + "px";
            }
            settings.transition = true

            $('ul li', settings.elm).animate({"left": moveTo}, {easing: 'swing', complete: function () {
                    setCounter();
                    settings.transition = false
                }});
        }

        function autoplay() {
            if (settings.autoplay === false) {
                settings.autoplay = true;
                $('.autoplay', settings.elm).removeClass('play').addClass('pause');
                settings.autoplayInterval = setInterval(function () {
                    if (settings.idx + 1 < settings.cntElm && settings.autoplayBack === false) {
                        moveSlider('right');
                    } else if (settings.idx + 1 > 1 && settings.autoplayBack === true) {
                        moveSlider('left');
                    }
                    if (settings.idx + 1 == settings.cntElm) {
                        if (settings.idx + 1 == 1) {
                            settings.autoplayBack = false
                        } else {
                            settings.autoplayBack = true
                        }
                    }
                    if (settings.autoplayBack == true && settings.idx + 1 == 1) {
                        settings.autoplayBack = false;
                    }
                }, 2000);
            } else {
                $('.autoplay', settings.elm).removeClass('pause').addClass('play');
                clearInterval(settings.autoplayInterval);
                settings.autoplay = false;
            }
        }

        function setCounter() {
            let cnt = settings.idx + 1 + "/" + settings.cntElm;
            $('.cnt', settings.elm).html(cnt);
        }

        function init() {
            settings.cntElm = $('ul li', elm).length;
            settings.elmWidth = elmWidth = $('ul', elm).width();
            $('ul', settings.elm).width((elmWidth * settings.cntElm) + 'px');
            bindControls();
            setCounter();
            autoplay()
        }
        init();


    }
    $.fn.imageSlider = function () {
        return this.each(function () {
            if (undefined == $(this).data('imageSlider')) {
                var plugin = new $.imageSlider(this);
                $(this).data('imageSlider', plugin);
            }
        });

    }
}
)(jQuery);
 