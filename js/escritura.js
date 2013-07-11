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

$(document).ready(function(){
    $("select[name=lote]").change(function(){
    	idlt = $(this).val();
    	$.getJSON(path+'escrituras_controle/getqdlt/'+idlt, function(data){
    		var qdlt = new Array();

    		mquadrado=document.getElementById("mquadrado");
    		mq = data['mquadrado'];
    		mq = mq.toString();
    		mq = mq.replace(".",",");
    		mquadrado.innerHTML= mq+" m²";
    		
    		vlmquadrado=document.getElementById("vlmquadrado");
    		vlmq = data['mquadrado']*data['vlmquadrado'];
    		vlmq = vlmq.toFixed(2);
    		vlmq = vlmq.toString();
    		vlmq = vlmq.replace(".","");
    		vlmquadrado.innerHTML="R$ "+formatReal(vlmq);
    		
	    	situacao=document.getElementById("situacao");
	    	situacao.innerHTML="DISPONÍVEL";
	    	document.getElementById("comp1").focus();
    	});
    });
});


$(document).ready(function(){
	$("select[name=civil_comp1]").change(function(){
		idcivil = $(this).val();
		if(idcivil != 1){
			document.getElementById("escondeR").style.display = 'none';
			document.getElementById("escondeD").style.display = 'none';
			document.getElementById("escondeU").style.display = 'none';
			document.getElementById("dtcasam_comp1").style.display = 'none';
			document.getElementById("conjuge").style.display = 'none';
			document.getElementById("conjuge_DOC").style.display = 'none';
			document.getElementById("conjuge_FILIACAO").style.display = 'none';
			document.getElementById("conjuge_NACIDO").style.display = 'none';
			return false;
		}
		
		resetaCombo('regime_comp1', 'Escolha um regime');
			document.getElementById("escondeR").style.display = 'block';
			document.getElementById("escondeD").style.display = 'block';
			document.getElementById("escondeU").style.display = 'block';
			document.getElementById("dtcasam_comp1").style.display = 'block';
			document.getElementById("conjuge").style.display = 'block';
			document.getElementById("conjuge_DOC").style.display = 'block';
			document.getElementById("conjuge_FILIACAO").style.display = 'block';
			document.getElementById("conjuge_NACIDO").style.display = 'block';

		$.getJSON(path+'escrituras_controle/getregimes/'+idcivil, function(data){
			var option = new Array();
			$.each(data, function(i, obj) {
				option[i] = document.createElement('option');
				$(option[i]).attr({value:obj.id});
				$(option[i]).append(obj.regime);
				$("select[name='regime_comp1']").append(option[i]);
			});
		});
	});
});

$(document).ready(function(){
	document.getElementById("escondeR").style.display = 'none';
	document.getElementById("escondeD").style.display = 'none';
	document.getElementById("escondeU").style.display = 'none';
	document.getElementById("dtcasam_comp1").style.display = 'none';
	document.getElementById("conjuge").style.display = 'none';
	document.getElementById("conjuge_DOC").style.display = 'none';
	document.getElementById("conjuge_FILIACAO").style.display = 'none';
	document.getElementById("conjuge_NACIDO").style.display = 'none';
});










function resetaCombo(combo, msg){
	$("select[name='"+combo+"']").empty();
	var option = document.createElement('option');
	$(option).attr({value:''});
	$(option).append(msg);
	$("select[name='"+combo+"']").append(option);
}

function getMoney( str ){ //recebe uma string 'R$ 1.700,90' e retorna um inteiro
	return parseInt( str.replace(/[\D]+/g,'') );
}

function formatReal( int ){ //recebe um inteiro e devolve o múmero formatado segundo a nossa moeda.
	var tmp = int+'';
	var neg = false;
	
	if(tmp.indexOf("-") == 0){
		neg = true;
		tmp = tmp.replace("-","");
	}
	
	if(tmp.length == 1) tmp = "0"+tmp
		tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
	
	if( tmp.length > 6)
		tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
		
	if( tmp.length > 9)
		tmp = tmp.replace(/([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g,".$1.$2,$3");
		
	if( tmp.length > 12)
		tmp = tmp.replace(/([0-9]{3}).([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g,".$1.$2.$3,$4");
		
	if(tmp.indexOf(".") == 0) tmp = tmp.replace(".","");
	if(tmp.indexOf(",") == 0) tmp = tmp.replace(",","0,");
	
	return (neg ? '-'+tmp : tmp);
}