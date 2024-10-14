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
					window.location = '/app';
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
						message.success(form, "Sucesso! Acesse o seu e-mail e clique no link para verificação e alteração da sua senha.");
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

	newPubli: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		
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
	}
};

App.init()