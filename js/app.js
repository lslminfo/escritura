;(function ($, window, undefined) {
  'use strict';

  var $doc = $(document),
      Modernizr = window.Modernizr;

  $(document).ready(function() {
    $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
    $.fn.foundationButtons          ? $doc.foundationButtons() : null;
    $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
    $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;
    $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;
    $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
    $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
    $.fn.foundationTabs             ? $doc.foundationTabs({callback : $.foundation.customForms.appendCustomMarkup}) : null;
    $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
    $.fn.foundationMagellan         ? $doc.foundationMagellan() : null;
    $.fn.foundationClearing         ? $doc.foundationClearing() : null;

    $.fn.placeholder                ? $('input, textarea').placeholder() : null;
  });

  // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
  // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
  // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
  // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
  // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

  // Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
  if (Modernizr.touch && !window.location.hash) {
    $(window).load(function () {
      setTimeout(function () {
        window.scrollTo(0, 1);
      }, 0);
    });
  }

})(jQuery, this);


$(document).ready(function(){
	$("select[name=quadra]").change(function(){
		quadra = $(this).val();
		
		if (quadra == 'Quadras'){ // Caso 'quadra' seja igual a "Quadras", zera combo e passa mensagem
			resetaCombo('lote', 'Escolha uma QD');
			return false;
		}

	// Linha para testar se esta pegando a QD
	$("select[name='lote']").empty();
	var option = document.createElement('option');
	$( option ).attr( {value : 'Lotes'} );
	$( option ).append( '"'+quadra+'"' );
	$("select[name='lote']").append( option );
		
	});
});

function resetaCombo( el, lt ) {
   $("select[name='"+el+"']").empty();
   var option = document.createElement('option');                                  
   $( option ).attr( {value : ''} );
   $( option ).append( lt );
   $("select[name='"+el+"']").append( option );
}

$(function(){
	$("select[name=estado]").change(function(){
		estado = $(this).val();
		
		if ( estado === '')
			return false;
		
		resetaCombo('cidade');
		
		$.getJSON('http://localhost/escritura/escrituras_controle/getCidades/' + estado, function(data){
			var option = new Array();
			
			$.each(data, function(i, obj){
				option[i] = document.createElement('option');
				$(option[i]).attr({value : obj.id});
				$(option[i]).append(obj.nome);
				
				$("select[name='cidade']").append(option[i]);
			
			});
		});
	});
});

function resetaCombo( el ){
	$("select[name='"+el+"']").empty();
	var option = document.createElement('option');
	$(option).attr({value : ''});
	$(option).append('Escolha'+estado);
	$("select[name='"+el+"']").append(option);
}









