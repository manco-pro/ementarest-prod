<!-- Modal MSN ADD Item msnalert-->
<div class="modal fade" id="msnalert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert" id="nuevoMensaje">
                    <strong>O Produto foi inserido com sucesso.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
          
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="{$stRUTAS.assets}js/scripts-cl.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>-->
<script>
    $(document).ready(function() {
        var mensajeDiv = $("#miMensaje");
        // Oculta el mensaje después de 3 segundos
        setTimeout(function() {
            mensajeDiv.fadeOut();
        }, 3000); // 3000 milisegundos = 3 segundos
    });
    //---------------------compartir
    $(document).ready(function() {
        $('[id^="compartir"]').on('click', function() {
            // Obtener los valores de los atributos de datos (data) del botón clicado
            const title = $(this).data('title');
            const text = $(this).data('text');
            const url = $(this).data('url');
            const shareData = {
                title: title,
                text: text,
                url: url,
            };
            console.log(shareData);
            // Verificar si el navegador admite la API de Web Share
            try {
                navigator.share(shareData);
                resultPara.textContent = "MDN shared successfully";
            } catch (err) {

            }
        });
    });
    //---------------------efecto add cart
    $(document).ready(function() {
        // Seleccionar todos los botones cuyo ID comienza con 'add'
        $('.ADD').on('click', function() {
            // Obtener el id del prodducto
            const ID = $(this).data('value');
            // Realizar la solicitud AJAX
            $.ajax({
                url: 'add.carrito.php', // URL de la página PHP
                method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
                data: { id: ID }, // Datos a enviar al servidor

                success: function(response) {
                    // Manejar la respuesta del servidor

                    if (response === "ok") {
                        $('#iconoCarrito')
                            .removeClass('fa-solid fa-cart-shopping')
                            .addClass('fa-solid fa-cart-shopping fa-shake');

                        // Esperar 2 segundos antes de realizar la siguiente acción
                        setTimeout(function() {
                            $('#iconoCarrito')
                                .removeClass('fa-solid fa-cart-shopping fa-shake')
                                .addClass('fa-solid fa-cart-shopping fa-beat');
                        }, 2000); // 2000 milisegundos = 3 segundos
                    }
                    console.log('Respuesta del servidor:', response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });
    });
    //--------cart minus----------------------------

    $(document).ready(function() {
        // eleminar la div del producto y alterar el total
        $('[id^="I_"]').on('click', function() {
            // Obtener los valores de los atributos de datos (data) del botón clicado
            var idstring = $(this).attr("id");
            var id = idstring.replace("I_", "");
            let ElementoCantidad = $("#Cantidad_" + id);

            let texto_numero = ElementoCantidad.text();
            let numero = parseFloat(texto_numero);
            let ElementoPRECIO = $("#PRECIO_" + id);
            let numero_PRECIO = parseFloat(ElementoPRECIO.text().slice(0, -1));
            var resultado = total(numero_PRECIO * numero, 'resta');
            for (var i = 0; i < numero; i++) {
                // Crear una cadena con el ID 
                $.ajax({
                    url: 'remove.carrito.php', // URL de la página PHP
                    method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
                    data: { id: id }, // Datos a enviar al servidor

                    success: function(response) {
                        // Manejar la respuesta del servidor

                        if (response === "ok") {

                        }
                        console.log('Respuesta del servidor:', response);
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores de la solicitud
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });

            }
            var divId = "DIV_" + id;
            // Selecciona la div por su ID y luego llama al método remove() para eliminarla
            $("#" + divId).fadeOut("slow", function() {
                $(this).remove();
            });
            var hrId = "HR_" + id;
            // Selecciona la div por su ID y luego llama al método remove() para eliminarla
            $("#" + hrId).fadeOut("slow", function() {
                $(this).remove();
            });
            


        });
        $('[id^="Menos_"]').on('click', function() {
            // Obtener los valores de los atributos de datos (data) del botón clicado
            var idstring = $(this).attr("id");
            var id = idstring.replace("Menos_", "");
            let ElementoCantidad = $("#Cantidad_" + id);

            let texto_numero = ElementoCantidad.text();
            let numero = parseFloat(texto_numero);
            let ElementoPRECIO = $("#PRECIO_" + id);
            let numero_PRECIO = parseFloat(ElementoPRECIO.text().slice(0, -1));

            if (numero > 1) {
                ElementoCantidad.text(numero - 1);

            } else {
                let ElementoDIV = $("#DIV_" + id);
                ElementoDIV.remove();
                let ElementoHR = $("#HR_" + id);
                ElementoHR.remove();
            }

            var resultado = total(numero_PRECIO, 'resta');
            $.ajax({
                url: 'remove.carrito.php', // URL de la página PHP
                method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
                data: { id: id }, // Datos a enviar al servidor

                success: function(response) {
                    // Manejar la respuesta del servidor

                    if (response === "ok") {

                    }
                    console.log('Respuesta del servidor:', response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud
                    console.error('Error en la solicitud AJAX:', error);
                }
            });



        });
        //--------cart plus----------------------------
        $('[id^="Mas_"]').on('click', function() {
            // Obtener los valores de los atributos de datos (data) del botón clicado
            var idstring = $(this).attr("id");
            var id = idstring.replace("Mas_", "");
            let ElementoCantidad = $("#Cantidad_" + id);

            let texto_numero = ElementoCantidad.text();
            let numero = parseFloat(texto_numero);
            let ElementoPRECIO = $("#PRECIO_" + id);
            let numero_PRECIO = parseFloat(ElementoPRECIO.text().slice(0, -1));
            ElementoCantidad.text(numero + 1);
            var resultado = total(numero_PRECIO, 'suma');
            $.ajax({
                url: 'add.carrito.php', // URL de la página PHP
                method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
                data: { id: id }, // Datos a enviar al servidor

                success: function(response) {
                    // Manejar la respuesta del servidor

                    if (response === "ok") {

                    }
                    console.log('Respuesta del servidor:', response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud
                    console.error('Error en la solicitud AJAX:', error);
                }
            });



        });
        //--------cart total----------------------------
        function total(precio, operacion) {
            let TOTAL = $("#TOTAL");
            //console.log(precio);
            let numero_total = parseFloat(TOTAL.text().slice(0, -1));

            if (operacion == 'resta') {
                precio_total = numero_total - precio;
            } else {
                precio_total = numero_total + precio;
            }
            let sumaConDecimales = precio_total.toFixed(2)
            //console.log(precio_total);
            TOTAL.html(sumaConDecimales + "&euro;");

            return precio_total;
        }


    });
    //--------cart QR----------------------------

    $(document).ready(function() {

        $('#QR').on('click', function() {

            var cadena = '{$stRUTAS.ped}ped.crear_emp.php?idsSeleccionados=';
            $('[id^="DIV_"]').each(function() {
                // Obtener el ID con el prefijo "DIV_"
                var idConPrefijo = $(this).attr('id');

                // Reemplazar "DIV_" con una cadena vacía para obtener solo el número
                var IDcolecccion = idConPrefijo.replace('DIV_', '');
                // Obtener la cantidad del producto
                var cantidad = $('#Cantidad_' + IDcolecccion).text();
                for (var i = 0; i < cantidad; i++) {
                    // Crear una cadena con el ID 
                    cadena = cadena + IDcolecccion + ",";
                }
            });
            cadena = cadena.slice(0, -1); // Eliminar el último carácter "|"
            var mesa = ''; // Obtener la mesa del pedido
            if ($('#mesa').length) {
                mesa = $('#mesa').val();
            }
            var MesasSelect = '';
            if (mesa != '') {
                MesasSelect = '%26MesasSelect=' + mesa; // Agregar la mesa a la cadena
            }
            //console.log(cadena);
            $('#QRcode').attr('src', 'https://qrcode.tec-it.com/API/QRCode?data=' + cadena +
                MesasSelect);
            $('#QRcode').fadeIn('slow');
            $('#QRcode').removeAttr('hidden');
        });



        $('#Pedir').click(function() {
            // Datos a enviar
            var cadena = '';
            $('[id^="DIV_"]').each(function() {
                // Obtener el ID con el prefijo "DIV_"
                var idConPrefijo = $(this).attr('id');

                // Reemplazar "DIV_" con una cadena vacía para obtener solo el número
                var IDcolecccion = idConPrefijo.replace('DIV_', '');
                // Obtener la cantidad del producto
                var cantidad = $('#Cantidad_' + IDcolecccion).text();
                for (var i = 0; i < cantidad; i++) {
                    // Crear una cadena con el ID 
                    cadena = cadena + IDcolecccion + ",";
                }
            });
            cadena = cadena.slice(0, -1); // Eliminar el último carácter "|"
            var mesa = $('#mesa').val(); // Obtener la mesa del pedido
            var MesasSelect = '';
            if (mesa != '') {
                MesasSelect = mesa; // Agregar la mesa a la cadena
            }
            var loja_id = $('#loja_id').val(); // Obtener la mesa del pedido

            var datos = {
                idsSeleccionados: cadena,
                MesasSelect: MesasSelect,
                Criar: '1',
                loja_id: loja_id,
                respuesta: 'ementa'
            };
            console.log(datos);
            //Realizar la solicitud AJAX con método POST
            $.ajax({
                type: 'POST',
                url: '{$stRUTAS.ped}ped.crear_ementa.php',
                data: datos,
                success: function(response) {
                    // Manejar la respuesta del servidor si es necesario
                    // Cambiar el contenido del modal al nuevo mensaje
                    $('div[id^="DIV_"]').each(function() {
                        // Eliminar cada div seleccionada
                        $(this).remove();
                    });
                    $('hr[id^="HR_"]').each(function() {
                        // Eliminar cada hr seleccionada
                        $(this).remove();
                    });
                    $('#TOTAL').text('0.00 €');

                    $('#nuevoMensaje strong').text('O pedido foi realizado com sucesso.');

                    // Deshabilita el botón de envío
                    // Mostrar el modal
                    $('#msnalert').modal('show');

                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                    console.error(error);
                }
            });
        });


    });





    //--------modal-------------------------------
    $(document).ready(function() {
        $('#modal{$stCOLECCION_ID|default:''}').modal('show');
    });

    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            event.preventDefault(); // Evita el envío predeterminado del formulario
            // Obtén los datos del formulario
            var formData = $(this).serialize();
            console.log($(this).attr('action'));
            // Envía los datos mediante AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr(
                    'action'), // Obtiene la URL del atributo action del formulario
                data: formData,
                success: function(response) {
                    $('#myForm').trigger('reset');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Maneja los errores si es necesario
                    console.error(error);
                }
            });
        });
    });
</script>

</body>

</html>