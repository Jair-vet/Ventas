var inicio=function () {
	$(".cantidad").keyup(function(e){
		if($(this).val()!=''){
			if(e.keyCode==13){ // Evento dar Enter
				var id=$(this).attr('data-id');
				var precio=$(this).attr('data-precio');
				var cantidad=$(this).val();

				$(this).parentsUntil('.producto').find('.subtotal').text('Subtotal: '+(precio*cantidad));
				$.post('./js/modificarDatos.php',{
					Id:id,
					Precio:precio,
					Cantidad:cantidad
				},function(e){
						$("#total").text('Total: $ '+e);
				});
			}
		}
	});
	$(".eliminar").click(function(e){
		e.preventDefault();
		let id=$(this).attr('data-id');
		$(this).parentsUntil('.edit2').remove();
		$.post('./js/eliminar.php',{
			Id:id
		},function(a){
			if(a=='0'){
				location.href= "./carrito.php";
			}
		});

	});
}	
$(document).on('ready',inicio);