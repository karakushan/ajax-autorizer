jQuery(document).ready(function($) {
	$("#aa-register-form").validate({
		rules:{
			aa_username: {
				required:true,
				minlength: 4,
				remote:{
					url:aa_ajax.url,
					type: "post",
					data: {
						action:"check_user",
						check:1
					} 
				}
			},
			aa_email:  {
				required: true,
				email: true,
				remote:{
					url:aa_ajax.url,
					type: "post",
					data: {
						action:"check_user",
						check:2
					} 
				}
			},
			aa_password:{
				required: true,
				minlength: 6,
				maxlength:30
			} 
			,
			aa_repassword:{
				required: true,
				equalTo: "#aa_rpassword"
			} ,
		},
		messages:{
			aa_username: {
				required: "это поле обязательное",
				minlength: "минимальная длина 4 символа",
				remote: "это имя пользователя уже занято"
			},
			aa_email:  {
				required: "это поле обязательное",
				email: "поле e-mail имеет неправильный формат",
				remote: "такой email уже зарегистрирован на сайте"
			},
			aa_password:{
				required: "это поле обязательное",
				minlength: "минимальная длина 6 символа",
				maxlength:"максимальная длина 30 символов"
			}, 
			aa_repassword:{
				required: "это поле обязательное",
				equalTo: "Пароль и повтор пароля не совпадают"
			}
		},
		submitHandler: function(form) {
			$.ajax({
				url: aa_ajax.url,
				type: 'GET',
				dataType: 'html',
				data: $("#aa-register-form").serialize(),
			})
			.done(function(data) {
				console.log(data);
				$("#aa-register-form").fadeOut('slow', function() {
				});
				if (data=='true') {
					
					$('.aa-form-info').html('Поздравляем!.Вы удачно прошли регистрацию. <a href="#" data-dismiss="modal" aria-hidden="true">Закрыть окно</a>.');
				}else{
					$('.aa-form-info').html('К сожалению возникли ошибки при регистрации. Возможно имя пользователя уже существует. При возникновении повторной ошибки напишите в поддержку сайта.');
				}
				
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

			return false;
		}
	});	
	$("#aa-login-form").validate({
		rules:{
			aa_username: {
				required:true,	
			},
			aa_password:{
				required: true,
			} ,
		},
		messages:{
			aa_username: {
				required: "это поле обязательное",
			},
			aa_password:{
				required: "это поле обязательное",
			}, 
		},
		submitHandler: function(form) {
			$.ajax({
				url: aa_ajax.url,
				type: 'GET',
				dataType: 'html',
				data: $("#aa-login-form").serialize(),
			})
			.done(function(data) {
				var dataJson=$.parseJSON(data);
				if (dataJson.status==1) {
					if (dataJson.redirect!=false && dataJson.redirec.length>0) {
						document.location.href=dataJson.redirect;
					}else{
						document.location.reload();
					}
				}else{
					$('.aa-form-info').html(dataJson.error);
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

			return false;
		}
	});
});