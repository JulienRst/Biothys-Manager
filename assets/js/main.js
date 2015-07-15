$(document).ready(function(){
	$('.display').click(function(e){
		$('.overall').fadeIn();
		displayAddress($(this).attr('id'),$("input[name='id_address']").val(),$(this).attr('rel'));
		e.preventDefault();
		$('.remove').click(function(){
			$('.overall').fadeOut();
		});
	});
});

function displayAddress(url,id,idem){
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
					for(var i = 0; i < $(".setAddresstodb input").length; i++){
						url += $(".setAddresstodb input:eq("+i+")").attr('name');
						url += "="
						url += $(".setAddresstodb input:eq("+i+")").val();
						if(i < $(".setAddresstodb input").length - 1)
							url+="&";
					}
					$.ajax({
						url : url,
						success : function(result){
							console.log(result);
							$('#address').val(result["address"]);
							$('input [name="id_address"]').val(result["id"]);
							console.log(result);

							$('.overall').fadeOut();
						}
					})
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
}
