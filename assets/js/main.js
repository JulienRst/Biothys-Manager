$(document).ready(function(){
	$('.datepicker').datepicker({
		defaultDate : null,
		 weekStart: 1 
	});
	var isSettingsHidden = true;
	$('#show-settings').click(function(){
		if(isSettingsHidden){
			$('#hidden-settings').fadeIn();
			isSettingsHidden = false;
			$(this).html('Hide settings');
		} else {
			$('#hidden-settings').fadeOut();
			isSettingsHidden = true;
			$(this).html('Show settings');
		}
	})

	$('#nb_delivery').on('input',function(){
		console.log('aight');
		var n_href = $('#do_id').attr('href');
		console.log(n_href);
		n_href = n_href.substring(0,30);
		n_href = n_href+$(this).val();
		console.log(n_href);
		$('#do_id').attr('href',n_href);
	});

	$('#param_delivery').click(function(e){
		$('.overall').fadeIn();
		var idOrder = $(this).attr('rel');
		$.ajax({
			url:'../ajaxResponse/setParamDelivery.php?id='+idOrder,
			success: function(result){
				$('#result').html(result);
			}
		})
		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
		e.preventDefault();
	});

	$('.setDA').click(function(e){
		$('.overall').fadeIn();
		var idDA = $(this).attr('rel');
		var idC = $(this).attr('alt');
		$.ajax({
			url:'../ajaxResponse/printDA.php?idDA='+idDA+'&idC='+idC,
			success: function(result){
				$('#result').html(result);
			}
		});
		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
		e.preventDefault();
	});


	$('#searchProducts').on('input',function(){
		$('.products tr').css('display','table-row');
		var needle = $(this).val();
		for(var i in $('.products tr')){
			if($('.products tr:eq('+i+') td:eq(1)').html() !== undefined){
				if($('.products tr:eq('+i+') td:eq(1)').html().toLowerCase().indexOf(needle.toLowerCase()) == -1){
					$('.products tr:eq('+i+')').css('display','none');
				}
			}
		}
	});

	$('#searchOrder').on('input',function(){
		$('.order').css('display','table-row');
		var needle = $(this).val();
		for(var i in $('.order')){
			if($('.order:eq('+i+') td:eq(0)').html() !== undefined){
				if($('.order:eq('+i+') td:eq(0)').html().toLowerCase().indexOf(needle.toLowerCase()) == -1){
					$('.order:eq('+i+')').css('display','none');
				}
			}
		}
	});

	$('#searchEmployees').on('input',function(){
		$('.employee').css('display','table-row');
		var needle = $(this).val();
		for(var i in $('.employee')){
			if($('.employee:eq('+i+') td:eq(0)').html() !== undefined){
				if($('.employee:eq('+i+') td:eq(0)').html().toLowerCase().indexOf(needle.toLowerCase()) == -1 && $('.employee:eq('+i+') td:eq(1)').html().toLowerCase().indexOf(needle.toLowerCase()) == -1){
					$('.employee:eq('+i+')').css('display','none');
				}
			}
		}
	});

	$('.monitoring li').click(function(){
		var target = $(this).attr('role');
		var owned;
		for(var i in $('.subpanel')){
			if($('.subpanel:eq('+i+')').attr('rel') == target){
				owned = $('.subpanel:eq('+i+')');
				break;
			}
		}
		$('.subpanel.active').removeClass('active');
		owned.addClass('active');
		$('.monitoring li.active').removeClass('active');
		$(this).addClass('active');
	});

	$('.drop').click(function(){
		var target = $(this).attr('rel');
		var owned;
		for(var i in $('.sub-drop')){
			if($('.sub-drop:eq('+i+')').attr('alt') == target){
				owned = $('.sub-drop:eq('+i+')');
				break;
			}
		}
		if(owned.css('display') == "block"){
			$(this).removeClass('glyphicon-menu-up');
			$(this).addClass('glyphicon-menu-down');
			owned.css('display','none');
		} else {
			$(this).removeClass('glyphicon-menu-down');
			$(this).addClass('glyphicon-menu-up');
			owned.css('display','block');
		}
		
	});

	$('#searchCompany').on('input',function(){
		$('tr').css('display','table-row');
		var needle = $(this).val();
		for(var i in $('tr')){
			if($('tr:eq('+i+') td:eq(0)').html() !== undefined){
				if($('tr:eq('+i+') td:eq(0)').html().toLowerCase().indexOf(needle.toLowerCase()) == -1){
					$('tr:eq('+i+')').css('display','none');
				}
			}
			
		}
	});

	$('.setAlready_paid').click(function(){
		var id = $(this).attr('rel');
		$.ajax({
			url: "setAlready_paidOrder.php?id="+id+"&val="+$('input[name="already_paid"]').val(),
			success: function(){
				$('#resultAlreadyPaid').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Save</div>')
			}
		})
	});

	$('.sendLineMore').click(function(){
		var id = $(this).attr('rel');
		$.ajax({
			url: "setCustomerOrderId.php?id="+id+"&val="+$('input[name="line_more"]:eq(0)').val(),
			success: function(){
				$('#resultLineMore').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Save</div>')
			}
		});
	});

	$('.sendLineBellow').click(function(){
		var id = $(this).attr('rel');
		$.ajax({
			url: "setLineBellow.php?id="+id+"&val="+$('input[name="line_bellow"]:eq(0)').val(),
			success: function(){
				$('#resultLineBellow').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Save</div>')
			}
		});
	});

	$('.sendFalligkeit').click(function(){
		var id = $(this).attr('rel');
		$.ajax({
			url: "setFalligkeit.php?id="+id+"&val="+$('input[name="falligkeit"]:eq(0)').val(),
			success: function(){
				$('#resultFalligkeit').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Save</div>')
			}
		});
	});

	$('.checkbox').on('change',function(){
		var id = $(this).attr('rel');
		var nval = $(this).is(':checked');
		var tfor = $(this).attr('name');
		if(nval){
			$.ajax({url: "setOrderReady.php?for="+tfor+"&id="+id+"&val=yes"});
		} else {
			$.ajax({url: "setOrderReady.php?for="+tfor+"&id="+id+"&val=no"});
		}
	})

	// $('input[name="ready"]').on('change',function(){
	// 	var id = $(this).attr('rel');
	// 	var nval = $(this).is(':checked');
	// 	if(nval){
	// 		$.ajax({url: "setOrderReady.php?id="+id+"&val=yes"});
	// 	} else {
	// 		$.ajax({url: "setOrderReady.php?id="+id+"&val=no"});
	// 	}
	// });

	// $('input[name="finish"]').on('change',function(){
	// 	var id = $(this).attr('rel');
	// 	var nval = $(this).is(':checked');
	// 	if(nval){
	// 		$.ajax({url: "setOrderFinish.php?id="+id+"&val=yes"});
	// 	} else {
	// 		$.ajax({url: "setOrderFinish.php?id="+id+"&val=no"});
	// 	}
	// });

	$('#setBillingPeriodBis').click(function(e){
		var id = $("input[name='billing_period_bis']").attr('rel');
		var bpb = $("input[name='billing_period_bis']").val();
		$.ajax({
			url : "setBillingPeriodBis.php?id="+id+"&bpb="+bpb,
			success : function(result){
				result = $.parseJSON(result);
				$('#resultSetBpb').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Value is set</strong></div>');
			}
		});
		e.preventDefault();
	});

	$('#addProductToOrder').click(function(e){
		$('.overall').fadeIn();
		var id_order = $(this).attr("rel")

		$.ajax({
			url : "../ajaxResponse/addProductToOrder.php",
			success : function(result) {

				$('#result').html(result);
				$('input[name="id_order"]').attr('value',id_order);

				$('#searchProductInOrder').on('input',function(){
					if($(this).val() != ""){
						url = '../controller/searchProductInOrder.php?needle='+$(this).val();
						$.ajax({url : url,
							dataType: 'json',
							success : function(result){
								$('#list-product').html('');
								$.each(result,function(i,item){
									$('#list-product').append('<button type="button" class="list-group-item product-item" unit="'+result[i].unity+'" rel="'+result[i].price+'" alt="'+result[i].id+'" displayparameter="'+result[i].isParameter+'">'+result[i].text+'</button>');
									$('#list-product button').last().click(function(){
										var isParam = result[i].isParameter;
										var params = result[i].parameters;
										if(isParam == true){
											$('#parameter_product_add').fadeIn();
											$.each(params,function(i,item){
												$('#parameter_product_add select').append('<option value="'+item.id+'">'+item.name+'</option>')
											});
										} else {
											//do nothing ?
										}
									});
								});
								$('.product-item').click(function(e){	
									$('input[name="id_product"]').val($(this).attr("alt"));
									$('input[name="product"]').val($(this).text());
									$('input[name="price"]').val($(this).attr('rel'));
									$('span#unity').html($(this).attr('unit'));
									$('#list-product').html('');
									e.preventDefault();
								});
							}
						});
					} else {
						$('#list-product').html('');
					}
				});
			}
		});

		$('.remove').click(function(){
			$('.overall').fadeOut();
		});

		e.preventDefault();
	});

	$('.set-line-product').click(function(e){
		$('.overall').fadeIn();
		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
		e.preventDefault();
		var id_line = $(this).attr('rel');
		$.ajax({
			url: '../ajaxResponse/setLineOrder.php?id='+id_line,
			success: function(result){
				$('#result').html(result);
			}
		})

	})

	$('.add_delivery_address').click(function(e){
		$('.overall').fadeIn();
		var id_company = $(this).attr("rel");
		$.ajax({
			url: '../ajaxResponse/addAddress.php',
			success: function(result){
				$('#result').html(result);
				$('.sendNewAddress').click(function(e){
					var url = '../controller/addDeliveryAddress.php?';
					for(var i = 0; i < $(".addAddresstodb input").length; i++){
						url += $(".addAddresstodb input:eq("+i+")").attr('name');
						url += "=";
						url += $(".addAddresstodb input:eq("+i+")").val();
						url += "&";
					}
					url += 'id_company='+id_company;
					$.ajax({
						url :  url,
						success : function(result){
							$.ajax({
								url : '../ajaxResponse/viewDeliveryAddress.php?id='+id_company,
								success : function(result){
									$('#delivery_address').html(result);
									$('.overall').fadeOut();
								}
							})
						}
					});
					e.preventDefault();
				});
			}
		})

		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
		e.preventDefault();
	})

	$('.display').click(function(e){
		$('.overall').fadeIn();
		e.preventDefault();
		var address = new Address();
		address.for = $(this).attr('alt');
		address.idFor = $(this).attr('rel');
		address.step = $(this).attr('step');
		address.id = $('input[name="id_'+address.step+'"]').val();
		trigger = $(this).attr('id');
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
								result = $.parseJSON(result);
								$('#'+address.step).val(result["address"]);
								$('input[name="'+ address.step +'"]').val(result["idAddress"]);

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
								$('input[name="id_'+ addressB.step +'"]').val(result["idAddress"]);
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

						console.log(addressB);

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
								$('input[name="id_'+ address.step +'"]').val(result["idAddress"]);
								$('.overall').fadeOut();
							}
						})

						e.preventDefault();

					});
				} else if(trigger == "getContact"){
					$('.sendContact').click(function(e){
						var idCu = $(this).attr("alt");
						var idCo = $(this).attr("rel");
						console.log("company : "+idCo+" | customer : "+idCu);
						url = '../controller/setCompanyCustomer.php?idCo='+idCo+'&idCu='+idCu;
						console.log(url);
						$.ajax({
							url : url,
							success : function(result){
								result = $.parseJSON(result);
								$('#contact').val(result["contact"]);
								$('input[name="id_contact"]').val(result["idContact"]);
								$('.overall').fadeOut();
							}
						});
					});
				} else if(trigger == "getCompany"){
					$('#lookCompany').on('input',function(){
						$('.ctn-addresses').css('display','block');
						for(var i in $('.ctn-addresses')){
							if($('.ctn-addresses:eq('+i+') .ctn-address p').html() !== undefined){
								if($('.ctn-addresses:eq('+i+') .ctn-address p').html().indexOf($(this).val()) == -1){
									$('.ctn-addresses:eq('+i+')').css('display','none');
								}
							}
						}
					});
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

	// Les deux algo suivants concernent l'ajout d'une commande

	
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




