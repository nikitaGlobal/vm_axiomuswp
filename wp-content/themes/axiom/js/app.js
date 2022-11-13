(function ($) {
	$(document).ready(function () {
		'use strict';
		$('html').removeClass('no-js');

		//--------------------------- ANCHOR LINK ---------------------------//
		$('a.anchor-trigger').bind("click", function(e){
			let anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $(anchor.attr('href')).offset().top-0
			}, 1000);
			e.preventDefault();
		});

		//--------------------------- SCROLL TO TOP ---------------------------//
		let scrollToTopBtn = document.getElementById("scrollToTopBtn");
		let rootElement = document.documentElement;

		function handleScroll() {
			let scrollTotal = rootElement.scrollHeight - rootElement.clientHeight;
			if((rootElement.scrollTop / scrollTotal) > 0.30) {
				scrollToTopBtn.classList.add("showBtn")
			} else {
				scrollToTopBtn.classList.remove("showBtn")
			}
		}

		function scrollToTop() {
			rootElement.scrollTo({
				top: 0,
				behavior: "smooth"
			});
		}

		scrollToTopBtn.addEventListener("click", scrollToTop);
		document.addEventListener('scroll', handleScroll);

		//--------------------------- YANDEX MAP ---------------------------//
		if(typeof ymaps !== "undefined") {
			ymaps.ready(function () {
				var myMap = new ymaps.Map('map', {
						center: [55.751574, 37.573856],
						zoom: 9
					}, {
						searchControlProvider: 'yandex#search'
					}),

					// Создаём макет содержимого.
					MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
						'<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
					),

					myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
						hintContent: 'Собственный значок метки',
						balloonContent: 'Это красивая метка'
					}, {
						// Опции.
						// Необходимо указать данный тип макета.
						iconLayout: 'default#image',
						// Своё изображение иконки метки.
						iconImageHref: 'images/myIcon.gif',
						// Размеры метки.
						iconImageSize: [30, 42],
						// Смещение левого верхнего угла иконки относительно
						// её "ножки" (точки привязки).
						iconImageOffset: [-5, -38]
					}),

					myPlacemarkWithContent = new ymaps.Placemark([55.661574, 37.573856], {
						hintContent: 'Собственный значок метки с контентом',
						balloonContent: 'А эта — новогодняя',
						iconContent: '12'
					}, {
						// Опции.
						// Необходимо указать данный тип макета.
						iconLayout: 'default#imageWithContent',
						// Своё изображение иконки метки.
						iconImageHref: 'images/ball.png',
						// Размеры метки.
						iconImageSize: [48, 48],
						// Смещение левого верхнего угла иконки относительно
						// её "ножки" (точки привязки).
						iconImageOffset: [-24, -24],
						// Смещение слоя с содержимым относительно слоя с картинкой.
						iconContentOffset: [15, 15],
						// Макет содержимого.
						iconContentLayout: MyIconContentLayout
					});

				myMap.geoObjects
					.add(myPlacemark)
					.add(myPlacemarkWithContent);
				myMap.behaviors.disable('scrollZoom');
			});
		}

		$('.menu-item-has-children').click(function(){
			$(".sub-menu").slideToggle();
		});

		$('.wpcf7-form br').css('display' , 'none');
		//--------------------------- ACCORDION MENU ---------------------------//
		/*
		$(".main-nav li").on("click", function(e) {
			e.preventDefault();
			let $this = $(this);

			if (!$this.hasClass("main-nav__link-container_active")) {
				$(".accordion__content").slideUp(400);
				$(".accordion__title").removeClass("main-nav__link-container_active");
			//	$('.accordion__arrow').removeClass('accordion__rotate');
			}

		//	$this.toggleClass("main-nav__link-container_active");
		//	$this.find($(".sub-menu")).slideToggle();
			//$('.accordion__arrow',this).toggleClass('accordion__rotate');
		});*/
	});
})(jQuery);