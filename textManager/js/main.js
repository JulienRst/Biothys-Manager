$(document).ready(function(){
	$.getJSON("../assets/text.json", function(json) {
	    $.each(json.text,function(i,item){
	    	$("#printJson table").append("<tr><td>"+(item.id)+"</td><td>"+item.FR+"</td><td>"+item.EN+"</td><td>"+item.GER+"</td><td>"+item.ES+"</td><td><button class='modify' alt='"+item.id+"''><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></button></td></tr>");
	    })
	    $(".modify").click(function(){
	    	for(var i in json.text){
	    		if(json.text[i].id == $(this).attr('alt')){
	    			showItem(json.text[i],$(this).attr('alt'));
	    			break;
	    		}
	    	}
	    });
	});

	$("#close,#closeadd").click(function(event){
		$(this).parent().parent().parent().parent().fadeOut();
		event.preventDefault();
	});

	function showItem(data,id){
		console.log(data);
		$('#popup .container .jumbotron .page-header h1').html("Texte n&deg;"+data.id);
		$('#popup .container .jumbotron form #FR').attr('value',data.FR);
		$('#popup .container .jumbotron form #EN').attr('value',data.EN);
		$('#popup .container .jumbotron form #GER').attr('value',data.GER);
		$('#popup .container .jumbotron form #ES').attr('value',data.ES);
		$('#popup .container .jumbotron form #_id').attr('value',data.id);
		$('#popup').fadeIn(200).css('display','table');
	}

	$('#addJson').click(function(event){
		$('#popupadd').fadeIn(200).css('display','table');
		event.preventDefault();
	});

});