$.fn.extend({faceMocion: function(opciones) {
	
	var faceMocion=this;
	var NombreSelector="Selector";		
	var DescripcionFace="--";
	defaults = { emociones:[
    {"emocion":"face-love","TextoEmocion":"I love"},
    {"emocion":"face-angry","TextoEmocion":"It bothers me"},
    {"emocion":"face-scare","TextoEmocion":"It scares"},
    {"emocion":"face-enjoy","TextoEmocion":"I enjoy"},
    {"emocion":"face-like","TextoEmocion":"I like"},
    {"emocion":"face-sad","TextoEmocion":"It sadness"},
    {"emocion":"face-amaze","TextoEmocion":"It amazes me"},
    {"emocion":"face-glad","TextoEmocion":"I am glad"}
    ]};
	var opciones = $.extend({}, defaults, opciones);
    
       $(faceMocion).each(function( index ) {
           var UnicoID = Date.now();
           $(this).attr("class",$(faceMocion).attr("class")+" "+UnicoID);
           var EstadoInicial="alegre";
           if($(this).val()!=""){
               EstadoInicial=$(this).val(); 
           }else{
               $(this).val('alegre');
           }
           DescripcionFace=EstadoInicial;
           ElementoIniciar='';
           ElementoIniciar=ElementoIniciar+'<div dato-descripcion="'+DescripcionFace+'" ';
           ElementoIniciar=ElementoIniciar+'id-referencia="'+UnicoID;
           ElementoIniciar=ElementoIniciar+'"  class="'+NombreSelector;
           ElementoIniciar=ElementoIniciar+' selectorFace '+EstadoInicial+'"></div>';
           $(this).before(ElementoIniciar);
    });
    
    
    $(document).ready(function() {
        BarraEmociones='<div class="faceMocion">';
        $.each(opciones.emociones, function(index,emo ){
           BarraEmociones=BarraEmociones+'<div dato-descripcion="'+emo.TextoEmocion;    
           BarraEmociones=BarraEmociones+'" class="'+emo.emocion+'"></div>';
        });
          BarraEmociones=BarraEmociones+'</div>';
        $(document.body).append(BarraEmociones);
        $('.faceMocion div').hover(function(){
            var title = $(this).attr('dato-descripcion');
            $(this).data('tipText', title).removeAttr('dato-descripcion');
            $('<p class="MensajeTexto"></p>').text(title).appendTo('body').fadeIn('slow');
	    },function() {
            $(this).attr('dato-descripcion', $(this).data('tipText'));
            $('.MensajeTexto').remove();
        }).mousemove(function(e) {
            var RatonX = e.pageX - 20;var RatonY = e.pageY - 60;
            $('.MensajeTexto').css({ top: RatonY, left: RatonX })
        });
	});
    $( '.'+NombreSelector ).hover(function(e) {
			SelectorEmocion= $(this);
            var RatonX = e.pageX - 20;var RatonY = e.pageY - 60;
            $( ".faceMocion" ).css({ top: RatonY, left: RatonX });
            $( ".faceMocion" ).show();           
            $( ".faceMocion div" ).click(function() { 
                
			SelectorEmocion.attr("class",NombreSelector+" selectorFace  "+$(this).attr('class'));
            
                ElInputSeleccionado=SelectorEmocion.attr("id-referencia");
                $("."+ElInputSeleccionado).val($(this).attr('class'));
                
			});
	});
    $(document).mouseup(function (e){  $( ".faceMocion" ).hide();});
      $(faceMocion).hide();
    
}
});