$(document).ready(function(){
	$('.display').click(function(e){
		$('.overall').fadeIn();
		e.preventDefault();
		var address = new Address();
		address.for = $(this).attr('alt');
		address.idFor = $(this).attr('rel');
		address.step = $(this).attr('step');
		address.id = $('input[name="id_'+address.step+'"]').val();
		trigger = $(this).attr('id');
		console.log(trigger);
		url = "../ajaxResponse/"+$(this).attr('id')+".php";

		$.ajax({
			url : url+"?address="+address.getArray(),
			success : function(result){
				$('#result').html(result);
				if(trigger == "setAddress"){
					$('.setAddress').click(function(e){
						e.preventDefault();
						url = '../controller/setAddress.php?'
						for(var i = 0; i < $(".setAddresstodb input").length; i++){
							url += $(".setAddresstodb input:eq("+i+")").attr('name');
							url += "=";
							url += $(".setAddresstodb input:eq("+i+")").val();
							url += "&";
						}
						$.ajax({
							url : url,
							success : function(result){
								console.log(result);
								result = $.parseJSON(result);
								$('#'+address.step).val(result["address"]);
								$('input[name="id_address"]').val(result["idAddress"]);

								$('.overall').fadeOut();
							}
						})
					});
				} else if(trigger == "getAddress"){
					$('.sendAddress').click(function(e){
						var addressB = new Address();
						addressB.for = address.for
						addressB.idFor = address.idFor;
						addressB.step = address.step;
						addressB.id = $(this).attr("alt");

						url = '../controller/getAddress.php?address='+addressB.getArray();

						$.ajax({
							url : url,
							success : function(result){
								console.log(result);
								result = $.parseJSON(result);
								$('#'+address.step).val(result["address"]);
								$('input[name="id_address"]').val(result["idAddress"]);
								$('.overall').fadeOut();
							}
						})
						e.preventDefault();
					});
				} else if(trigger == "addAddress"){
					$('.sendNewAddress').click(function(e){
						var addressB = new Address();
						addressB.for = address.for
						addressB.idFor = address.idFor;
						addressB.step = address.step;
						addressB.id = 0;

						url = "../controller/addAddress.php?"

						for(var i = 0; i < $(".addAddresstodb input").length; i++){
							url += $(".addAddresstodb input:eq("+i+")").attr('name');
							url += "=";
							url += $(".addAddresstodb input:eq("+i+")").val();
							url += "&";
						}

						url += "address="+address.getArray();

						$.ajax({
							url : url,
							success : function(result){
								console.log(result);
								result = $.parseJSON(result);
								$('#'+address.step).val(result["address"]);
								$('input[name="id_address"]').val(result["idAddress"]);

								$('.overall').fadeOut();
							}
						})

						e.preventDefault();

					});
				} else if(trigger == "getContact"){
					$('.sendContact').click(function(e){
						var idCu = $(this).attr("rel");
						url = '../controller/setCompanyCustomer.php?idCo='+address.idFor+'&idCu='+idCu;
						console.log(url);
						$.ajax({
							url : url,
							success : function(result){
								result = $.parseJSON(result);
								$('#contact').val(result["customer"]);
								$('input[name="id_contact"]').val(result["idCustomer"]);
								$('.overall').fadeOut();
							}
						});
					});
				} else if(trigger == "getCompany"){
					$('.sendCompany').click(function(e){
						var idCu = $(this).attr("rel");
						var idCo = $(this).attr("alt");
						url = '../controller/setCustomerCompany.php?idCu='+idCu+'&idCo='+idCo;
						$.ajax({
							url : url,
							success : function(result){
								result = $.parseJSON(result);
								$('#company').val(result["contact"]);
								console.log(result);
								$('input[name="id_company"]').val(result["idContact"]);
								$('.overall').fadeOut();
							}
						});
					});
				}
			}
		})

		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
	});
});




var Address = function(){
	var a = this;
	a.id;
	a.for;
	a.step;
	a.idFor;

	a.getArray = function(){
		var res = "{";
		for(var i in a){
			if(i != "getArray"){
				res += "\""+i + "\" : \"" + a[i]+"\"";
				if(i != "id"){
					res += ",";
				}
			}
			
		}
		res += "}";
		return res;
	}
}




/*function displayAddress(url,id,idem){
	if (url == "addAddress") {
		$.ajax({
			url : '../ajaxResponse/'+url+'.php',
			success : function(result){
				$('#result').html(result);
				$('.sendNewAddress').click(function(e){
					e.preventDefault();
					var url = "../controller/addAddress.php?";
					for(var i = 0; i < $(".addAddresstodb input").length; i++){
						url += $(".addAddresstodb input:eq("+i+")").attr('name');
						url += "=";
						url += $(".addAddresstodb input:eq("+i+")").val();
						url += "&";

					}
					if(idem === 'undefined' || idem == ""){
						idem = 0;
					}
					url += "idem="+idem;
					$.ajax({
						url : url,
						success : function(result){
							console.log(result);
							result = $.parseJSON(result);
							$('#address').val(result["address"]);
							$('input [name="id_address"]').val(result["id"]);
							console.log(result);

							$('.overall').fadeOut();
						}
					})
					return false;
				});
			}
		});
	} else {
		$.ajax({
			url : '../ajaxResponse/'+url+'.php?id='+id+'&idem='+idem,
			success : function(result){
				$('#result').html(result);
				$('.setAddress').click(function(e){
					e.preventDefault();
					var url = "../controller/setAddress.php?";
					url += "class="+$(this).attr('alt')+"&";
					for(var i = 0; i < $(".setAddresstodb input").length; i++){
						url += $(".setAddresstodb input:eq("+i+")").attr('name');
						url += "="
						url += $(".setAddresstodb input:eq("+i+")").val();
						if(i < $(".setAddresstodb input").length - 1)
							url+="&";
					}
					console.log(url);
					// $.ajax({
					// 	url : url,
					// 	success : function(result){
					// 		console.log(result);
					// 		$('#address').val(result["address"]);
					// 		$('input [name="id_address"]').val(result["id"]);
					// 		console.log(result);

					// 		$('.overall').fadeOut();
					// 	}
					// })
					return false;
				});
				$('.sendAddress').click(function(e){
					$.ajax({
						url : '../controller/getAddress.php?idAddress='+$(this).attr('alt')+'&idEmployee='+$(this).attr('rel'),
						success : function(result){
							console.log(result);
							result = $.parseJSON(result);
							$('#address').val(result["address"]);
							$('input[name="id_address"]').val(result["idAddress"]);

							$('.overall').fadeOut();
						}
					})
				});
			}
		});
	}
}*/
