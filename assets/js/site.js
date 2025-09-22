function initSwiper() {
	if(Swiper){
		console.log("Swiper carregado");
		$(".swiper").each(function () {
			console.log("Iniciando swiper");
			let web_slider = $(this)[0];
			let optionsData = web_slider.dataset;
			if(!optionsData) return;
			let options = {
				loop: true,
				spaceBetween: optionsData.slidespace,
				breakpoints: {
					320: {
						slidesPerView: optionsData.smview
					},
					768: {
						slidesPerView: optionsData.mdview
					},
					1024: {
						slidesPerView: optionsData.lgview
					},
					1366: {
						slidesPerView: optionsData.xlview
					}
				},
				autoplay: optionsData.autoplay ? {
					delay: optionsData.autoplayDelay || 3000,
					disableOnInteraction: false
				} : false,
				pagination: optionsData.pagination ? {
					el: '.swiper-pagination'
				} : false,
				navigation: optionsData.navigation ? {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				} : false
			};

			console.log(options);	
			
			new Swiper(web_slider, options);
		});
	}
	
	const swiper_hero = new Swiper('.swiper_hero', {
		direction: 'horizontal',
		// loop: true,
		// pagination: {
		// 	el: '.swiper-pagination',
		// },
		observer: true, // adding this solve my issue
		observeParents: true,
		parallax:true,


		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		  },
	
		navigation: {
			nextEl: ".swiper_hero .swiper-button-next",
			prevEl: ".swiper_hero .swiper-button-prev",
		  },
	});
	
	const swiper_post_grid = new Swiper('.post-grid-slider', {
		direction: 'horizontal',
		slidesPerView: 1,
		loop: true,
		pagination: {
			el: '.swiper-pagination',
		},
	
		navigation: {
			nextEl: '.post-grid-slider .swiper-button-next',
			prevEl: '.post-grid-slider .swiper-button-prev',
		},
	});
	
	const swiper_companies = new Swiper('.swiper_companies', {
		direction: 'horizontal',
		loop: true,
		slidesPerView: 2,
		spaceBetween: 30,
	
		breakpoints: {
			798: {
				slidesPerView: 4
			}
		},
	});
	
	const swiper_members = new Swiper('.swiper_members', {
		direction: 'horizontal',
		loop: true,
		slidesPerView: 2,
		spaceBetween: 30,
	
		breakpoints: {
			798: {
				slidesPerView: 4
			}
		},
	
		navigation: {
			nextEl: '.swiper_members .swiper-button-next',
			prevEl: '.swiper_members .swiper-button-prev',
		}
	});
	
}
// Ou se estiver usando jQuery:
$(document).ready(function() {
    initSwiper();
});



const Post = {
	comment: function(form){
		var formData = new FormData(form);

		$.ajax({
			type: 'post',
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			url: '/post/comment',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
				}
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
			}
		})
	}
}
