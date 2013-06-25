// função para combo dependentes

$(function(){
	$("select[name=corretor1]").change(function(){
		idcorr1 = $(this).val();
		
		if (idcorr1 === ''){
			resetaCombo('corretor2', 'Selecione corretor 1');
			return false;
		}
		
		resetaCombo('corretor2', 'Selecione');
			
			
		$.getJSON(path+'escrituras_controle/getCorretor2/'+idcorr1, function(data){
			var option = new Array();
			
			$.each(data, function(i, obj) {
				option[i] = document.createElement('option');
				$(option[i]).attr({value:obj.id});
				$(option[i]).append(obj.nome);
				$("select[name='corretor2']").append(option[i]);			  
			});
		});
	});
});


$(function(){
	$("select[name=quadra]").change(function(){
		idqd = $(this).val();
		
		if (idqd === ''){
			resetaCombo('lote', 'Selecione QD');
			return false;
		}
		
		resetaCombo('lote', 'Lts');
			
		$.getJSON(path+'escrituras_controle/getLote/'+idqd, function(data){
			var option = new Array();
			
			$.each(data, function(i, obj) {
				option[i] = document.createElement('option');
				$(option[i]).attr({value:obj.lote});
				$(option[i]).append(obj.lote);
				$("select[name='lote']").append(option[i]);
			  
			});
		});
	});
});

$(function(){
	$("select[name=lote]").change(function(){
		idlt = $(this).val();
		
		var qdlt = new Array(idqd, idlt);
			console.log(qdlt);
			
	});
});




function resetaCombo(combo, msg){
	$("select[name='"+combo+"']").empty();
	var option = document.createElement('option');
	$(option).attr({value:''});
	$(option).append(msg);
	$("select[name='"+combo+"']").append(option);

}
