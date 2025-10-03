const message = {
	warning: function(el, str){
		$(el).find('.message').fadeIn(200).html(`<div class="alert alert-warning" role="alert">${str}</div>`);
		this.goToMessage(el);
		this.timer(el);
		$('*:focus').blur();
	},
	success: function(el, str, removeInactive){
		$(el).find('.message').fadeIn(200).html(`<div class="alert alert-success" role="alert">${str}</div>`);
		this.goToMessage(el);
		this.timer(el);
		if(removeInactive == undefined) this.removeInactive(el)
			$('*:focus').blur();
	},
	error: function(el, str){
		$(el).find('.message').fadeIn(200).html(`<div class="alert alert-danger" role="alert">${str}</div>`);
		this.goToMessage(el);
		this.timer(el);
		this.removeInactive(el)
		$('*:focus').blur();
	},
	goToMessage: function(el){
		$([document.documentElement, document.body]).animate({
			scrollTop: $(el).find(".message").offset().top
		}, 400);
	},
	timer: function(el){
		setTimeout(function(){
			$(el).find('.message').fadeOut('200');
		}, 10000);
	},
	removeInactive: function(el){
		$(el).removeClass("inactive")
	}
}





const App = {
	init: function(){
		if(Swiper){
			const swiper = new Swiper('.swiper', {
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

			$(".swiper").each(function () {
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
						}
					},
					autoplay: optionsData.autoplay ? {
						delay: optionsData.autoplayDelay || 3000,
						disableOnInteraction: false
					} : false,
					pagination: optionsData.pagination ? {
						el: '.swiper-pagination',
						clickable: true
					} : false,
					navigation: optionsData.navigation ? {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev'
					} : false
				};
				
				new Swiper(web_slider, options);
			});
		}
	},
	login: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/login',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					// Google Tag Manager – login event
					dataLayer.push({
						event: 'login',
						method: 'email' // adjust if you track other login methods
					});
					const params = new URLSearchParams(window.location.search);
					const redirectUrl = params.get('redirect');

					if (redirectUrl && redirectUrl.startsWith('/')) {
						window.location.href = redirectUrl;
					} else {
						window.location.href = '/app';
					}
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	recover: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		if($(form).data("inprogress") == 1){
			$.ajax({
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				url: '/app/recover/updatepwd',
				dataType: 'json',
				success: function(data){
					if(data.res == 1){
						message.success(form, "Sucesso! Sua senha foi alterada com sucesso. Aguarde, você será redirecionada para entrar na conta.");
						$(form)[0].reset()
						setTimeout(function(){
							window.location = "/app/login";
						}, 7000);
					}else{
						message.error(form, data.res);
					}
				},
				error: function(err){
					message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
				}
			})
		}else{
			$.ajax({
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				url: '/app/recover',
				dataType: 'json',
				success: function(data){
					if(data.res == 1){
						message.success(form, "Sucesso! Acesse o seu e-mail ou WhatsApp e clique no link para verificação e alteração da sua senha.");
						$(form)[0].reset()
					}else{
						message.error(form, data.res);
					}
				},
				error: function(err){
					message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
				}
			})
		}
	},
	loadCities: function(el){
		$(el).attr("disabled");
		$.ajax({
			type: 'get',
			contentType: false,
			url: '/checkout/cities/' + el.value,
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					var html = "";
					data.cities.forEach(function(item, index){
						html += `<option value="${item.idcity}">${item.city}</option>`;
					})
					$('#address_city').html(html);
				}else{

				}

				$(el).removeAttr("disabled")

				$('#address_city').removeAttr("disabled")
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
			}
		})
	},
	updateUser: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);


		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/profile/update',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '';
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	updatePassword: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);


		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/profile/change-password',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '';
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	updateProfilePhoto: function(el){
		var formData = new FormData();
		formData.append("f_profile_photo", $(el)[0].files[0]);
		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/app/profile/update/photo',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$('#profile__header--photo-image').attr("src", "/"+data.path)
					alert("Sua imagem de perfil foi atualizada com sucesso!");
				}else{
					alert(data.res)
				}
			},
			error: function(err){
				alert("Desculpe, algo deu errado ao atualizar sua foto de perfil. Atualize a página e tente novamente!");
			}
		})
	},

	newCompany: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		formData.append("company_image", $('#company_image')[0].files[0]);

		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/companies/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Sua empresa foi criada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	newCompanyFromWelcome: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		formData.append("company_image", $('#company_image')[0].files[0]);

		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/companies/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '/app/welcome/success';
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	updateCompany: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		formData.append("company_image", $('#company_image')[0].files[0]);

		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/companies/edit/'+ $('#company_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location.reload();
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	newPubli: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		formData.append("publi_image", $('#publi_image')[0].files[0]);
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/publis/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Sua publi foi enviada para aprovação da administradora.");
				}else{
					message.error(form, data.res);
				}

				message.removeInactive(form);
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	likePubli: function(el, publi_id){
		$(el).addClass("inactive")
		$.ajax({
			type: 'post',
			data: {},
			processData: false,
			contentType: false,
			url: '/app/publis/'+publi_id+'/like',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					if(data.current == 1){
						$(el).addClass("active")
						$(el).find('i').removeClass('fa-regular fa-heart')
						$(el).find('i').addClass('fa-solid fa-heart')
						$(el).find('span').text("Curtido por você")
					}else{
						$(el).removeClass("active")
						$(el).find('i').removeClass('fa-solid fa-heart')
						$(el).find('i').addClass('fa-regular fa-heart')
						$(el).find('span').text('Toque para curtir')
					}
				}else{
					alert("NOT OK")
				}
				$(el).removeClass("inactive")
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
				$(el).removeClass("inactive")
			}
		})
	},
	commentPubli: function(form, publi_id){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/publis/'+publi_id+'/comment',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					window.location = ''
				}else{
					message.error(form, data.res);
				}

				message.removeInactive(form);
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	doEventCheckin: function(el, qrcode_uuid, user_id){
		$(el).addClass("inactive")
		
		$.ajax({
			type: 'post',
			data: {
				user_id: user_id
			},
			processData: false,
			contentType: false,
			url: '/app/events/checkin/'+qrcode_uuid,
			dataType: 'json',
			success: function(data){
				console.log(data)
				if(data.res == 1){
					window.location.reload();
				}else{
					alert(data.res)
				}
				$(el).removeClass("inactive")
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
				$(el).removeClass("inactive")
			}
		})
	},

	
	commentContent: function(form, content_id){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/app/content/'+content_id+'/comment',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					window.location = ''
				}else{
					message.error(form, data.res);
				}

				message.removeInactive(form);
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	}
};

App.init()