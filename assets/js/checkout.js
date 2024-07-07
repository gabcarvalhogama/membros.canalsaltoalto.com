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





const Checkout = {
	init: function(){
	},
	getCep: function(el){
		// if(el.value.length == 10){
		// 	$.ajax({
		// 		type: 'get',
		// 		contentType: false,
		// 		url: 'https://viacep.com.br/ws/'+el.value.replace(/[\.-]/g, "")+'/json/',
		// 		dataType: 'json', 
		// 		success: function(data){
		// 			console.log(data)
		// 			$('#f_states').find('option[data-uf="'+data.uf+'"]').attr("selected")
		// 		}
		// 	})
		// }
	},

	changeStep: function(from, to){
		if(from == null){
			$('form-step:visible').fadeOut('fast')
		}else{
			$(from).fadeOut('fast');
		}
		$(to).fadeIn('fast');
	},

	changePayment: function(el, method){
		$('.checkout__payment--item').removeClass('selected')
		$(el).addClass('selected')

		$('#f_payment_method').val(method)


		$('.checkout__creditcard:visible').fadeOut(400)

		if(method == "cc"){
			$('.checkout__creditcard').fadeIn(400)
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
					$('#f_city').html(html);
				}else{

				}

				$(el).removeAttr("disabled")

				$('#f_city').removeAttr("disabled")
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
			}
		})
	},

	payload: {},

	checkoutEnterpreneur: function(form){
		var object = this.payload;
		var formData = new FormData(form);
		formData.forEach(function(value, key){
			object[key] = value;
		})
		this.payload = object;

		this.changeStep('#enterpreneur', '#company')
	},
	checkoutCompany: function(form){
		var object = this.payload;
		var formData = new FormData(form);
		formData.forEach(function(value, key){
			object[key] = value;
		})
		this.payload = object;

		this.changeStep(null, '#payment')
	},
	checkoutPayment: function(form){
		$(form).addClass("inactive")
		message.warning(form, "Carregando, aguarde...");
		Checkout.changeStep(null, "#checkout__loading")
	
		var object = this.payload;
		var formData = new FormData(form);
		formData.forEach(function(value, key){
			object[key] = value;
		})
		this.payload = object;

		var data = this.payload;


		$.ajax({
			type: 'post',
			data: data,
			url: '/checkout',
			dataType: 'json',
			success: function(data){
				if(data.res == 1){
					if(data.qr_code != null){
						$('#pixImage').attr("src", data.qr_code_url)
						$('#pixField').val(data.qr_code)
						Checkout.changeStep(null, "#checkouting-pix_pending")
						Checkout.checkPix()
					}
				}else{
					Checkout.changeStep(null, "#"+data.step)
					alert(data.res);
				}
			},
			error: function(err){
				alert("Algo deu errado, verifique sua internet e tente novamente!")
			}
		})
	},
	copyPix: function(){
		// Seleciona o campo de texto
	    var textField = document.getElementById("pixField");
	    
	    // Seleciona o conteúdo do campo de texto
	    textField.select();
	    textField.setSelectionRange(0, 99999); // Para dispositivos móveis
	    
	    // Copia o texto selecionado para a área de transferência
	    document.execCommand("copy");
	},
	checkPix: function(){
		var intervalId = setInterval(function(){

			$.ajax({
				type: 'get',
				data: null,
				url: '/checkout/check-pix',
				dataType: 'json',
				success: function(data){
					if(data.res == 1 && data.status == 'paid'){
						console.log('Already Paid');
						clearInterval(intervalId)
						Checkout.changeStep(null, '#checkouting-pix_paid')
						setTimeout(function(){
							window.location = "/app/welcome";
						}, 7000)
					}else{
						console.log('Not paid yet');
					}
				},
				error: function(err){
					console.log(err)
					clearInterval(intervalId)
				}
			});

		}, 5000)



	}
}
Checkout.init()