   <!-- Modal MSN ADD Item msnalert-->
   <div class="modal fade" id="msnalert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog ">
           <div class="modal-content">
               <div class="modal-body">
                   <div class="alert alert-success alert-dismissible fade show mb-0" role="alert" id="nuevoMensaje">
                       <strong>{$stMENSAJE1}</strong>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal MSN ADD Item msnEmplegrado-->
   <div class="modal fade" id="msnEmplegrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog ">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title d-inline-flex align-items-center" id="exampleModalToggleLabel">
                       <img src="{$stRUTAS.images}croupier.png" class="btn-ic" alt="">
                       <span style="padding: 10px 0 0 10px;">{$stMENSAJE_TITULO_EMPLEADO}</span>
                   </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="alert alert-secondary alert-dismissible fade show mb-0">
                       <div class="" role="alert" id="nuevoMensaje">
                           <strong>{$stMENSAJE_EMPlEADO_MESA}</strong>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-danger"
                       data-bs-dismiss="modal">{$stMENSAJE_BOTON_CANCELAR}</button>
                   <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                       id="confirmarBtn">{$stMENSAJE_BOTON_CONFIRMAR}</button>
               </div>
           </div>
       </div>
   </div>
   <!-- btn campainha -->
   {if isset($stMESA)}
       <div class=" d-flex me-3"
           style="z-index: 9999; width: 45px; height: 45px; position: fixed; bottom: 80px; right: 15px ">
           <a href="#" class="rounded-circle bg-danger btn-an" id="Empregado_de_Mesa" style="width: 45px; height: 45px;">
               <img src="{$stRUTAS.images}croupier.png" class="btn-ic" alt="">
           </a>
       </div>
   {/if}
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"
       integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
       integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
   </script>
   <script src="{$stRUTAS.assets2}js/scripts-cl.js"></script>
   <script>
       $(document).ready(function() {
           var mensajeDiv = $("#miMensaje");
           // Oculta el mensaje después de 3 segundos
           setTimeout(function() {
               mensajeDiv.fadeOut();
           }, 3000); // 3000 milisegundos = 3 segundos
       });
       //----------empregado de mesa--------------------------
       $(document).ready(function() {
           $('#Empregado_de_Mesa').on('click', function() {
               // Seleccionar todos los botones cuyo ID comienza con 'add'
               $('#msnEmplegrado').modal('show');

           });
       });

       // Manejar el clic en el botón "Confirmar"
       $("#confirmarBtn").click(function() {
           empregado_mesa();
       });

       function empregado_mesa() {
           $.ajax({
               url: 'call.php', // URL de la página PHP
               method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
               data: { id: 'call' }, // Datos a enviar al servidor

               success: function(response) {

                   if (response === "ok") {
                       if ("vibrate" in navigator && "Audio" in window) {
                           // Hacer que el dispositivo vibre durante 1000 milisegundos (1 segundo)
                           navigator.vibrate(1000);

                           // Crear un nuevo elemento de audio
                           var audio = new Audio("{$stRUTAS.images}notification.wav"); 

                           // Reproducir el sonido
                           audio.play();
                       } else {
                           console.log(
                               "Lo siento, tu dispositivo no soporta la función de vibración o reproducción de audio."
                           );
                       }
                   }
                   console.log('Respuesta del servidor:', response);
               },
               error: function(xhr, status, error) {
                   // Manejar errores de la solicitud
                   console.error('Error en la solicitud AJAX:', error);
               }
           });
       }
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
                               .removeClass('fa-solid fa-basket-shopping')
                               .addClass('fa-solid fa-basket-shopping fa-shake');

                           // Esperar 2 segundos antes de realizar la siguiente acción
                           setTimeout(function() {
                               $('#iconoCarrito')
                                   .removeClass(
                                       'fa-solid fa-basket-shopping fa-shake')
                                   .addClass('fa-solid fa-basket-shopping fa-beat');
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
       //--------cart Comentarios----------------------------
       {literal}
           $(document).ready(function() {
               //añadir los productor a al modal para que inserte el comentario
               function comentarios_modal_pedidos(boton) {
                   //ocultar botones EnviarPedido y ConfirmarDetellesPedido 
                   $('#EnviarPedido').hide();
                   $('#ConfirmarDetellesPedido').hide();
                   //mostrar boton 
                   $('#' + boton + '').show();
                   // Obtener los productos de la lista
                   const comentariosDetalles = document.getElementById('listaPedidos');
                   comentariosDetalles.innerHTML = '';

                   const productos = document.querySelectorAll('[id^="DIV_"]');

                   productos.forEach(producto => {

                       const id = producto.id.split('_')[1];
                       const imagen = producto.querySelector('.bg-image').style.backgroundImage;
                       const nombre = producto.querySelector('h2').textContent;
                       const precio = producto.querySelector(`#PRECIO_${id}`).textContent;
                       const cantidad = producto.querySelector(`#Cantidad_${id}`).textContent;
                       for (var i = 0; i < cantidad; i++) {
                           // Crear los elementos de forma línea a línea
                           const nuevoElemento = document.createElement('div');
                           nuevoElemento.className = 'col-12 bg-white p-2 mb-3 pedido';
                           nuevoElemento.dataset.id = id;

                           const rowDiv = document.createElement('div');
                           rowDiv.className = 'row';

                           const col4Div = document.createElement('div');
                           col4Div.className = 'col-4';
                           const imageDiv = document.createElement('div');
                           imageDiv.className = 'bg-white bg-image';
                           imageDiv.style.borderRadius = '0.8rem';
                           imageDiv.style.width = '100px';
                           imageDiv.style.height = '75px';
                           imageDiv.style.backgroundImage = imagen;
                           imageDiv.style.backgroundRepeat = 'no-repeat';
                           imageDiv.style.backgroundPosition = 'center center';
                           imageDiv.style.backgroundSize = 'cover';
                           col4Div.appendChild(imageDiv);

                           const col6Div = document.createElement('div');
                           col6Div.className = 'col-6';
                           const dFlexDiv = document.createElement('div');
                           dFlexDiv.className =
                               'd-flex flex-column justify-content-around align-items-baseline';
                           const h2Element = document.createElement('h2');
                           h2Element.className = 'fs-4 fw-bold mb-0';
                           h2Element.textContent = nombre;
                           const pElement = document.createElement('p');
                           pElement.className = 'fs-5 my-2';
                           pElement.textContent = precio;
                           dFlexDiv.appendChild(h2Element);
                           dFlexDiv.appendChild(pElement);
                           col6Div.appendChild(dFlexDiv);

                           const col12Div = document.createElement('div');
                           col12Div.className = 'col-12';
                           const mt3Div = document.createElement('div');
                           mt3Div.className = 'mt-3 mb-2';
                           const textarea = document.createElement('textarea');
                           textarea.className = 'form-control comentario';
                           textarea.placeholder = 'Comentário aqui';
                           textarea.id = `message-text-${id}`;

                           mt3Div.appendChild(textarea);
                           col12Div.appendChild(mt3Div);

                           rowDiv.appendChild(col4Div);
                           rowDiv.appendChild(col6Div);
                           rowDiv.appendChild(col12Div);
                           nuevoElemento.appendChild(rowDiv);

                           comentariosDetalles.appendChild(nuevoElemento);
                       }
                       actualizarInputHidden();
                   });

               }
               $('#QR').on('click', function() {
                   comentarios_modal_pedidos('ConfirmarDetellesPedido');
               });
               $('#Pedir').on('click', function() {
                   comentarios_modal_pedidos('EnviarPedido');
               });

               $('#listaPedidos').on('input', '.comentario', function() {
                   actualizarInputHidden();
               });

               function actualizarInputHidden() {
                   var elementosSeleccionados = [];
                   $('#listaPedidos .pedido').each(function() {
                       var id = $(this).attr('data-id');
                       var comentario = $(this).find('.comentario').val()
                           .trim(); // Obtener el comentario del input
                       if (comentario !== '') { // Verificar si hay comentario
                           elementosSeleccionados.push(id + '|' + comentario);
                       } else {
                           elementosSeleccionados.push(id);
                       }
                   });
                   $('#idsSeleccionados').val(elementosSeleccionados.join(','));
               }
           });
       {/literal}
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
               if (precio_total == 0) {
                   //hacer desaparecer los botones con la clase "botones_pedido"
                   $('.botones_pedido').fadeOut('slow');
               }
               return precio_total;
           }


       });
       //--------cart QR----------------------------

       $(document).ready(function() {

           $('#ConfirmarDetellesPedido').on('click', function() {
               var cadena = '{$stRUTAS.ped}ped.crear_emp.php?idsSeleccionados=';
               var idsSeleccionados = $('#idsSeleccionados').val();
               cadena = cadena + encodeURIComponent(idsSeleccionados);
               var mesa = ''; // Obtener la mesa del pedido
               if ($('#mesa').length) {
                   mesa = $('#mesa').val();
               }
               var MesasSelect = '';
               if (mesa != '') {
                   MesasSelect = '%26MesasSelect=' + mesa; // Agregar la mesa a la cadena
               }
               URL = cadena + MesasSelect;
               $('#obsprod').modal('hide');
               $('#QRcode').attr('src', 'https://qrcode.tec-it.com/API/QRCode?data=' + URL);
               $('#qrcode').modal('show');
           });



           $('#EnviarPedido').click(function() {
               var idsSeleccionados = $('#idsSeleccionados').val();

               var mesa = ''; // Obtener la mesa del pedido
               if ($('#mesa').length) {
                   MesasSelect = $('#mesa').val();
               }
               var loja_id = $('#loja_id').val(); // Obtener la mesa del pedido

               var datos = {
                   idsSeleccionados: idsSeleccionados,
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

                       $('#nuevoMensaje strong').text(
                           'O pedido foi realizado com sucesso.');
                       $('#botones_pedido').fadeOut('slow');
                       $('#botones_pedido').remove();
                       $('#obsprod').slideUp('slow', function() {
                           $(this).modal('hide');
                       });
                       $('#msnalert').modal('show');

                       //console.log(response);
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
           $('#modalinfo{$stCOLECCION_ID|default:''}').modal('show');
       });

       $(document).ready(function() {
           $('#myForm').submit(function(event) {
               event.preventDefault(); // Evita el envío predeterminado del formulario
               // Obtén los datos del formulario
               var formData = $(this).serialize();
               // Envía los datos mediante AJAX
               $.ajax({
                   type: 'POST',
                   url: $(this).attr(
                       'action'), // Obtiene la URL del atributo action del formulario
                   data: formData,
                   success: function(response) {
                       $('#myForm').trigger('reset');
                       $('#msnform').modal('show');
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