
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
				console.log(data)
				if(data.res == 1){
					
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
}
Checkout.init()