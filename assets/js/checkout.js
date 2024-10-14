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

		if(method == "credit_card"){
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
	changeLabel: function(text){
		$(".checkout__header h2").fadeOut(200, function() {
		    $(this).html(text).fadeIn(200);
		});

		$([document.documentElement, document.body]).animate({
	        scrollTop: $(".checkout__header h2").offset().top
	    }, 400);
	},

	payload: {},

	processData: function(form){
		var object = this.payload;
		var formData = new FormData(form);
		formData.forEach(function(value, key){
			object[key] = value;
		})
		this.payload = object;
	},


	checkoutAuth: function(form){
		// var object = this.payload;
		// formData.forEach(function(value, key){
		// 	object[key] = value;
		// })
		// this.payload = object;
		var formData = new FormData(form);
		const email = $('#f_auth_email').val()

		if($('#f_auth_email').val() == ""){
			message.error(form, 'Por favor, informe o seu e-mail para começar.')
			return false;
		}


		if($('#f_auth_password').is(':visible')){
			if($('#f_auth_password').val() == ""){
				message.error(form, 'Por favor, informe a sua senha para avançar.')
				return false;
			}

			$.ajax({
				type: 'post',
				data: formData,
	            contentType: false,
	            cache: false,
	            processData:false,
				url: '/checkout/login',
				dataType: 'json',
				success: function(data){
					if(data.res == 1){
						Checkout.changeLabel("Perfeito! Se você tiver um cupom de desconto, informe abaixo.")
						Checkout.changeStep(null, '#payment')
					}else{
						message.error(form, data.res)
					}
				},
				error: function(err){
					console.log(err)
					message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
				}
			});

		}else{
			$.ajax({
				type: 'post',
				data: formData,
	            contentType: false,
	            cache: false,
	            processData:false,
				url: '/checkout/check-email',
				dataType: 'json',
				success: function(data){
					if(data.res == 1 && data.has_email == 1){
						$('#f_auth_password').fadeIn('fast')
						$('#f_auth_password').focus()
						Checkout.changeLabel("Seja bem-vinda de volta! <br />Informe sua senha.")
					}else{
						$('#f_email').val(email)
						Checkout.changeStep(null, '#enterpreneur')

						Checkout.changeLabel("Fale um pouco mais <br/>sobre você!")
					}
				},
				error: function(err){
					message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
				}
			})
		}
	},


	checkoutEnterpreneur: function(form){
		var object = this.payload;
		var formData = new FormData(form);
		formData.forEach(function(value, key){
			object[key] = value;
		})
		this.payload = object;

		Checkout.changeLabel("Perfeito! Se você tiver um cupom de desconto, informe abaixo.")

		this.changeStep('#enterpreneur', '#payment')
	},


	checkoutCoupon: function(form){
		this.processData(form)
		$(form).addClass("inactive")
		message.warning(form, "Verificando cupom, aguarde...");

		// $.ajax({
		// 	type: 'post',
		// 	data: formData,
  //           contentType: false,
  //           cache: false,
  //           processData:false,
		// 	url: '/checkout/check-coupon',
		// 	dataType: 'json',
		// 	success: function(data){
		// 		if(data.res == 1){
					
		// 		}else{
		// 			message.error(form, data.res)
		// 		}
		// 	},
		// 	error: function(err){
		// 		console.log(err)
		// 		message.error(form, "Algo deu errado, verifique sua internet e tente novamente!");
		// 	}
		// });

	},
	checkoutPayment: function(form){
		// $(form).addClass("inactive")
		// message.warning(form, "Carregando, aguarde...");
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

						Checkout.changeLabel("Agora é só fazer o pagamento do <br/>Pix abaixo e aguardar!")
					}else{

					}
					Checkout.checkPayment()

				}else{
					Checkout.changeStep(null, "#"+data.step)
					alert(data.res);
				}

			},
			error: function(err){
				Checkout.changeStep(null, "#payment")
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
	checkPayment: function(){
		var intervalId = setInterval(function(){

			$.ajax({
				type: 'get',
				data: null,
				url: '/checkout/check-payment',
				dataType: 'json',
				success: function(data){
					if(data.res == 1 && data.status == 'paid'){
						console.log('Already Paid');
						clearInterval(intervalId)
						Checkout.changeStep(null, '#checkouting-pix_paid')

						Checkout.changeLabel("Sucesso! Seu pagamento <br />foi confirmado.")

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
	},

	updateExpirationDates: function(value){
		const dateExpiration = value.split("/");

		document.querySelector('#f_cc_expirationdate_month').value = dateExpiration[0];
		document.querySelector('#f_cc_expirationdate_year').value = dateExpiration[1];
	}
}
Checkout.init()