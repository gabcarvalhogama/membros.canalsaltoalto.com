const swiper_hero = new Swiper('.swiper_hero', {
	direction: 'horizontal',
	loop: true,
	pagination: {
		el: '.swiper-pagination',
	},

	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
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
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
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
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	}
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
