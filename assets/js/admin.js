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


const Admin = {
	init: function(){
		
	},

	newMember: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		// formData.append("member_photo", $('#member_photo')[0].files[0]);


		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/members/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "A membro foi criada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	updateMember: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);

		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/members/edit/'+$('#member_iduser').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					message.success(form, "A membro foi atualizada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
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
					$('select[data-address="city"]').html(html);
				}else{

				}

				$(el).removeAttr("disabled")

				$('select[data-address="city"]').removeAttr("disabled")
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
			}
		})
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
			url: '/admin/login',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '/admin';
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	addNotice: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("notice_title", $('#notice_title').val())
		formData.append("notice_content", $('#notice_content').val());
			
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/admin/notices/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Seu aviso foi criado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	addContent: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("content_title", $('#content_title').val())
		formData.append("content_excerpt", $('#content_excerpt').val());
		formData.append("content_content", tinyMCE.get()[0].getContent());
		formData.append("content_featured_image", $('#content_featured_image')[0].files[0]);
		formData.append("content_featured_video_url", $('#content_featured_video_url').val());
		formData.append("content_status", $('#content_status').val());
		formData.append("content_publish_date", $('#content_publish_date').val());
		
		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/contents/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Seu conteúdo foi criado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	updateContent: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("content_id", $('#content_id').val())
		formData.append("content_title", $('#content_title').val())
		formData.append("content_excerpt", $('#content_excerpt').val());
		formData.append("content_content", tinyMCE.get()[0].getContent());
		formData.append("content_featured_image", $('#content_featured_image')[0].files[0]);
		formData.append("content_featured_image_actual", $('#content_featured_image_actual').val());
		formData.append("content_featured_video_url", $('#content_featured_video_url').val());
		formData.append("content_status", $('#content_status').val());
		formData.append("content_publish_date", $('#content_publish_date').val());
		
		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/contents/edit/'+$('#content_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = ''
					message.success(form, "Seu aviso foi atualizado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	deleteContent: function(content_id){
		if(confirm("Você realmente deseja apagar este conteúdo?") != true)
			return false;

		$.ajax({
			type: 'post',
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/contents/delete/'+content_id,
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '/admin/contents'
					alert("Sucesso! O seu conteúdo foi apagado definitivamente.");
				}else{
					alert(data.res);
				}
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
				console.log(err)
			}
		})
	}
};

Admin.init()


const Club = {
	new: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("club_title", $('#club_title').val());
		formData.append("club_description", tinyMCE.get()[0].getContent());
		formData.append("club_image", $('#club_image')[0].files[0]);


		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/clubs/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Seu clube foi criado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	update: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("club_id", $('#club_id').val());
		formData.append("club_title", $('#club_title').val());
		formData.append("club_description", tinyMCE.get()[0].getContent());
		formData.append("club_image", $('#club_image')[0].files[0]);
		formData.append("club_actual_image", $('#club_image').data("actualimage"));


		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/clubs/edit/'+$('#club_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					message.success(form, "Seu clube foi atualizado com sucesso! A página será atualiza em breve...");
					setTimeout(function(){
						window.location = "";
					}, 5000)
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	delete: function(club_id){
		if(confirm("Você realmente deseja apagar este clube?") != true)
			return false;

		$.ajax({
			type: 'post',
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/clubs/delete/'+club_id,
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					alert("Sucesso! O seu CLUBE foi apagado definitivamente.");
					window.location = '/admin/clubs'
				}else{
					alert(data.res);
				}
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
				console.log(err)
			}
		})
	}
}



const Companies = {
	new: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("company_image", $('#company_image')[0].files[0]);

		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/companies/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "A empresa foi criada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

	update: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("company_image", $('#company_image')[0].files[0]);
		formData.append("actual_company_image", $('#company_image').data("actual_company_image"))

		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/companies/edit/'+$('#company_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					message.success(form, "A empresa foi atualizada com sucesso!");
					setTimeout(function(){
						window.location = "";
					}, 5000)
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},


	delete: function(company_id){
		if(confirm("Você realmente deseja apagar esta empresa?") != true)
			return false;

		$.ajax({
			type: 'post',
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/companies/delete/'+company_id,
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					window.location = '/admin/companies'
					alert("Sucesso! A empresa foi apagada definitivamente.");
				}else{
					alert(data.res);
				}
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
				console.log(err)
			}
		})
	}


}



const CSAEvent = {
	create: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("event_poster", $('#event_poster')[0].files[0]);
		formData.append("event_content", tinyMCE.get()[0].getContent());

		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/events/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "O evento foi criado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	update: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("event_poster", $('#event_poster')[0].files[0]);
		formData.append("event_poster_actual", $('#event_poster').data("poster"))
		formData.append("event_content", tinyMCE.get()[0].getContent());

		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/events/edit/' + $('#idevent').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					// $(form)[0].reset()
					message.success(form, "O evento foi atualizado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	}
}


const Publi = {
	create: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("publi_content", tinyMCE.get()[0].getContent());
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/admin/publis/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Sua publi foi criada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	update: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData(form);
		formData.append("publi_content", tinyMCE.get()[0].getContent());
		
		$.ajax({
			type: 'post',
			data: formData,
			processData: false,
			contentType: false,
			url: '/admin/publis/edit/'+$('#publi_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					message.success(form, "Sua publi foi atualizada com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

}


const Post = {
	create: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("post_title", $('#post_title').val())
		formData.append("post_excerpt", $('#post_excerpt').val());
		formData.append("post_content", tinyMCE.get()[0].getContent());
		formData.append("post_featured_image", $('#post_featured_image')[0].files[0]);
		formData.append("post_status", $('#post_status').val());
		formData.append("post_publish_date", $('#post_publish_date').val());
		
		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/posts/new',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					$(form)[0].reset()
					message.success(form, "Seu post foi criado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},
	update: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		var formData = new FormData();

		formData.append("post_title", $('#post_title').val())
		formData.append("post_excerpt", $('#post_excerpt').val());
		formData.append("post_content", tinyMCE.get()[0].getContent());
		formData.append("post_featured_image", $('#post_featured_image')[0].files[0]);
		formData.append("post_actual_featured_image", $('#post_featured_image').data("actualimage"))
		formData.append("post_status", $('#post_status').val());
		formData.append("post_publish_date", $('#post_publish_date').val());
		
		$.ajax({
			type: 'post',
			data: formData,
            contentType: false,
            cache: false,
            processData:false,
			url: '/admin/posts/edit/'+$('#post_id').val(),
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					message.success(form, "Seu post foi atualizado com sucesso!");
				}else{
					message.error(form, data.res);
				}
			},
			error: function(err){
				message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
			}
		})
	},

}