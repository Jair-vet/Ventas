$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

        if($("#foto_actual") && $("#foto_remove")){
            $("#foto_remove").val('img_producto.png');
        }

    });

    // Modal form Delete Product
    $('.add_product').click(function(e){  //funcion  para darle un click  AGREGAR

        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action,producto:producto},

        success: function(response){

             if(response != 'error'){ //si no manda el Error 

                var info = JSON.parse(response); //convertir el JSON en un objeto

                //$('#producto_id').val(info.codproducto); //metemos en el value que tenemos oculto en el formulario, metemos el id
                //$('.nameProducto').html(info.descripcion); //Lo mismo pero para meter el nombre del producto.

                $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+ 
                                        '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Agregar Producto</h1>'+        
                                        '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
                                        '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del Producto" required><br>'+
                                        '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del Producto" required>'+
                                        '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                        '<input type="hidden" name="action" value="addProduct" required>'+
                                        '<div class="alert alertAddProduct"></div>'+
                                        '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                                        '<a href="#" class="btn_ok closeModal" onclick="closeModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                    '</form>');
             }
        },

        error: function(error){
            console.log(error);
        }

        });


         $('.modal').fadeIn();
    });

     // Modal form Add Product
    $('.del_product').click(function(e){  //funcion  para darle un click  AGREGAR

        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action,producto:producto},

        success: function(response){

             if(response != 'error'){ //si no manda el Error 

                var info = JSON.parse(response); //convertir el JSON en un objeto

                //$('#producto_id').val(info.codproducto); //metemos en el value que tenemos oculto en el formulario, metemos el id
                //$('.nameProducto').html(info.descripcion); //Lo mismo pero para meter el nombre del producto.

                $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delProduct();">'+ 
                                        '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Eliminar Producto</h1>'+ 
                                        '<p>¿Seguro de Eliminar?</p>'+  
                                        '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
                                        '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                        '<input type="hidden" name="action" value="delProduct" required>'+
                                        '<div class="alert alertAddProduct"></div>'+
                                        '<a href="#.php" class="btn_cancel" onclick="closeModal();"><i class="far fa-window-close"></i> Cerrar</a>'+
                                        '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>'+
                                    '</form>');
             }
        },

        error: function(error){
            console.log(error);
        }

        });


         $('.modal').fadeIn();
    }); 

    $('#search_proveedor').change(function(e){
        e.preventDefault();
        var sistema = getUrl();
        location.href = sistema+'buscar_producto.php?proveedor='+$(this).val();
    });

}); // end Ready

function getUrl(){
    var loc = window.location;
    var pathName = loc.pathName.substring(0, loc.pathName.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.lenght - ((loc.pathName + loc.search + loc.hash).lenght - pathName.lenght));
}

function sendDataProduct(){

    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_add_product').serialize(), //Enviamos todos los campos del formulario, mandarlos de forma serial.

        success: function(response){
            if(response == 'error')
            {
                $('.alertAddProduct').html('<p style="color: red;">Error al agregar el producto</p>');
            }else{
                var info = JSON.parse(response);
                $('.row'+info.$producto_id+' .celPrecio').html(info.nuevo_precio);
                $('.row'+info.$producto_id+' .celExistencia').html(info.nueva_existencia);
                $('#txtCantidad').val('');
                $('#txtPrecio').val('');
                $('.alertAddProduct').html('<p>Producto Guardado</p>');

            }

        },

        error: function(error){
            console.log(error);
        }

    });

}

/// Boton de Eliminar Producto
function delProduct(){

    var pr = $('#producto_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_del_product').serialize(), //Enviamos todos los campos del formulario, mandarlos de forma serial.

        success: function(response){
            
            if(response == 'error')
            {
                $('.alertAddProduct').html('<p style="color: red;">Error al agregar el Producto</p>');
            }else{
                $('.row'+pr).remove();
                $('#form_del_product .btn_ok').remove();
                $('.alertAddProduct').html('<p>Producto Eliminado</p>');

            } 

        },

        error: function(error){
            console.log(error);
        }

    });

}
function closeModal(){

    $('.alertAddProduct').html('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.modal').fadeOut();
}