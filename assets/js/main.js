$(document).ready(function(){

	$('.datepicker').datepicker({
		defaultDate : null
	});



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

	
	$('.order input[name="company"]').on('input',function(){
		if($(this).val() != ""){
			url = '../ajaxResponse/helpOrder.php?class=company&needle='+$(this).val();
			$.ajax({url : url,
					dataType: 'json',
					success : function(result){
					$('#proposition_company').html('');
					$.each(result,function(i,item){
						$('#proposition_company').append('<button type="button" class="list-group-item company-item" rel="'+result[i].billing_period_bis+'" alt="'+result[i].id+'">'+result[i].text+'</button>'); 
					});
					$('.company-item').click(function(e){
						$('input[name="id_company"]').val($(this).attr("alt"));
						$('input[name="company"]').val($(this).text());
						$('input[name="billing_period_bis"]').val($(this).attr("rel"));
						$('#proposition_company').html('');
						e.preventDefault();
					});
				}
			})
		} else {
			$('#proposition_company').html('');
		}
	});
	$('.order input[name="employee"]').on('input',function(){
		if($(this).val() != ""){
			url = '../ajaxResponse/helpOrder.php?class=employee&needle='+$(this).val();
			$.ajax({url : url,
				dataType: 'json',
				success : function(result){
					$('#proposition_employee').html('');
					console.log(result);
					$.each(result,function(i,item){
						$('#proposition_employee').append('<button type="button" class="list-group-item employee-item" alt="'+result[i].id+'">'+result[i].text+'</button>'); 
					});
					$('.employee-item').click(function(e){	
						$('input[name="id_employee"]').val($(this).attr("alt"));
						$('input[name="employee"]').val($(this).text());
						$('#proposition_employee').html('');
						e.preventDefault();
					});
				}
			});
		} else {
			$('#proposition_employee').html('');
		}
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




