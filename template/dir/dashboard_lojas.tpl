{include file="_header.tpl"}

<body id="page-top">
    <!-- Main Content -->
    <h1 class="h3 mb-0 text-gray-800">{$stTITLE}</h1>
    <input hidden id="loja_id" value="{$stLOJA}">
    <hr>

    <div id="content">

        <link rel="stylesheet" href="{$stRUTAS.vendor}dist/style.css">

        <!-- partial:index.partial.html <input type="button" id="insertarGaugeBtn" value="test">-->
        <div class="container-fluid">
            <div class="row" id="dashboard">
                <div id="result"></div>
            </div>
        </div>

        <!-- partial -->

        <div class="modal fade" id="DetallePedidoModalDiv" role="dialog">
            <div class="modal-dialog" style="max-width: 800px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="MesaPedidoModal"></h4>
                        <button class="close" type="button" data-dismiss="modal">
                            <span>x</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="card-body">
                            <p><em>Produtos adicionados ao pedido:</em></p>
                            <div class="form-row d-sm-flex align-items-center justify-content-between mb-3 "
                                id="listaPedidos">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="idsSeleccionados" name="idsSeleccionados">
                        <!--  <button class="btn btn-secondary" type="button" data-dismiss="modal" id="CancelarPedido">Cancelar</button>-->
                        <button class="btn btn-primary" type="button" id="ModalButtonAction" data-id="">Pronto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src='{$stRUTAS.vendor}jquery/jquery.min.js'></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });

        //cargar modal con los detalles del pedido
        $(document).on('click', '[id^="Card_"]', function () {
            var id = $(this).data('id');
            var array = $(this).data('array');
            //console.log(array);

            var comentarios = $(this).data('comentarios');
            var mesa = $(this).data('mesa');
            var EstadoPedido = $(this).data('estadopedido');
            var template = $(this).data('template');


            $('#listaPedidos').html('');

            $('#MesaPedidoModal').html(mesa + ' - ' + EstadoPedido);

            $('#ModalButtonAction').data('id', id);


            console.log(EstadoPedido);
            if (EstadoPedido == 'Novo') {
                $('#ModalButtonAction').text('Lan\u00E7ar Pedido');
                $('#ModalButtonAction').prop('disabled', true);
            } else {
                $('#ModalButtonAction').text('Pronto');
                $('#ModalButtonAction').prop('disabled', false);
            }
            //console.log(array);
            $.each(array, function (index, value) {
                agregarElementoPedido(value.coleccion_id, value.nombre_pt, value.comentario);
            });
            actualizarInputHidden();

            $('#DetallePedidoModalDiv').modal('show');
        });



        $('#ModalButtonAction').click(function () {
            var id = $(this).data('id');
            var Accion = $(this).text();
            if (Accion != 'Lan\u00E7ar Pedido') {
                ProntoPedido(id);
            }

            $('#DetallePedidoModalDiv').modal('hide');
        });




        function ProntoPedido(id) {
            //obtener id de la loja
            var loja_id = $('#loja_id').val();
            console.log('pronto pedido');
            var idsSeleccionados = $("#idsSeleccionados").val();
            var Card = $('#Card_' + id);
            //console.log(idsSeleccionados);
            //console.log(id);
            $.ajax({
                url: "{$stRUTAS.ped}ped.pronto.php",
                method: 'POST',
                data: { id: id, idsSeleccionados: idsSeleccionados, loja_id: loja_id },
                dataType: "text",
                success: function (resultado) {
                    console.log('esto es el resultado:' + resultado);
                    //
                    if (resultado == 'ok') {
                        RefreshPedidos();
                    } else if (resultado == 'bad1') {
                        alert('n&atilde;o selecionou nenhum produto');
                    } else if (resultado == 'bad2') {
                        alert('Erro ao lan\u00E7ar o pedido "em curso"');
                    }
                    //
                },
                error: function (xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        }

        /////////////////////////
        RefreshPedidos();

        setInterval(RefreshPedidos, 5000);

        //////////////////////////
        function RefreshPedidos() {
            var loja_id = $('#loja_id').val();
            $.ajax({
                url: "{$stRUTAS.ped}status.pedidos.php", // URL de tu script o recurso del lado del servidor
                type: "POST", // M&eacute;todo HTTP (GET o POST)
                data: { loja_id: loja_id },
                dataType: "json", // Tipo de datos esperado
                success: function (pedidos) {

                    //console.log(pedidos);
                    if (!pedidos) {
                        $("#result").html(
                            "<h1 class='h2 mb-4 text-gray-800'>Nenhum pedido a ser listado</h1>"
                        );
                        $('div[id^="Card_"]').fadeOut(1000, function () {
                            $(this).remove();
                        });

                    } else {

                        $.each(pedidos, function (index, pedido) {
                            $("#result").html("");
                            if (pedido.template == 1) {
                                pedido.template = 'Comidas';

                                MaxTiempo = 60;
                            } else {
                                pedido.template = 'Bebidas';

                                MaxTiempo = 5;
                            }
                            //console.log(pedido);
                            EstadoPedido = Estado_Pedido(pedido.estado);
                            ColorCard = Color_Card(EstadoPedido);
                            //
                            MinutosTranscurrido = Minutos_Transcurrido(pedido.hora_inicio);
                            PorcentajeTranscurrido = Porcentaje_Transcurrido(
                                MinutosTranscurrido, MaxTiempo);
                            let hora_inicio = new Date(pedido.hora_inicio);
                            let hora_formateada = hora(hora_inicio);
                            const cardExists = $('#Card_' + pedido.id).length > 0;
                            //console.log(pedido.id);
                            //console.log(cardExists);
                            if (cardExists) {
                                // console.log('actualizar');
                                ActualizarTarjeta(
                                    pedido.id,
                                    pedido.identificador,
                                    pedido.template,
                                    hora_formateada,
                                    MinutosTranscurrido,
                                    PorcentajeTranscurrido,
                                    JSON.stringify(pedido.detalles_pedido),
                                    pedido.comentarios,
                                    EstadoPedido,
                                    ColorCard
                                );

                            } else {
                                // console.log('creando tarjeta');
                                crearTarjeta(
                                    pedido.id,
                                    pedido.identificador,
                                    pedido.template,
                                    hora_formateada,
                                    MinutosTranscurrido,
                                    PorcentajeTranscurrido,
                                    JSON.stringify(pedido.detalles_pedido),
                                    pedido.comentarios,
                                    EstadoPedido,
                                    ColorCard
                                );

                            }

                            RemoverCards(pedidos);

                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        };

        function Color_Card(estado) {
            switch (estado) {
                case 'Novo':
                    return 'border-bottom-success';
                    break;
                case 'Em curso':
                    return 'border-bottom-warning';
                    break;
                case 'Pronto':
                    return 'border-bottom-info';
                    break;
            }
        }

        function Estado_Pedido(estado) {
            switch (estado) {
                case 'N':
                    return 'Novo';
                    break;
                case 'E':
                    return 'Em curso';
                    break;
                case 'P':
                    return 'Pronto';
                    break;
                case 'F':
                    return 'Finalizado';
                    break;
                case 5:
                    return 'Cancelado';
                    break;
            }
        }

        function hora(hora_inicio) {
            let horas = hora_inicio.getHours();
            let minutos = hora_inicio.getMinutes();

            // Asegurarse de que las horas y los minutos sean de dos d&iacute;gitos
            horas = horas < 10 ? '0' + horas : horas;
            minutos = minutos < 10 ? '0' + minutos : minutos;

            let hora_formateada = horas + ':' + minutos;
            return hora_formateada;
        }

        function Minutos_Transcurrido(hora_inicio) {
            var hora_actual = new Date();
            var hora_inicio = new Date(hora_inicio);
            var diferencia = hora_actual - hora_inicio;
            var minutos = Math.floor(diferencia / 60000);
            return minutos;

        }

        function Porcentaje_Transcurrido(minutos, MaxTiempo) {
            return parseFloat(Math.min(100, (minutos / MaxTiempo) * 100).toFixed(0));
        }

        function Color(porcentaje) {
            if (porcentaje <= 60) {
                color = 'success';
            } else if (porcentaje <= 80 && porcentaje > 60) {
                color = 'warning';
            } else {
                color = 'danger';
            }
            return color;
        }

        function Icono(categoria) {
            if (categoria == 'Comidas') {
                icono = 'fa-utensils';
            } else {
                icono = 'fa-wine-bottle';
            }
            return icono;
        }

        function agregarElementoPedido(id, producto, comentario) {
            // Crear el elemento de pedido con jQuery
            var pedido = $('<div>').addClass('pedido form-row mb-3 col-md-12').attr({
                'data-id': id,
                'data-cantidad': 1
            });
            var formGroupText = $('<div>').addClass('form-group col-md-11 texto');
            var labelProducto = $('<label>').attr('id', 'producto').text(producto);
            var inputComentario = $('<input>').attr({
                'type': 'text',
                'class': 'comentario form-control col-md-12',
                'placeholder': 'Insira um coment\u00E1rio',
                'value': comentario,
                'disabled': true
            });
            formGroupText.append(labelProducto, inputComentario);
            pedido.append(formGroupText);
            $('#listaPedidos').append(pedido);
        }

        function RemoverCards(pedidos) {
            let idsPedidos = pedidos.map(function (pedido) {
                return pedido.id;
            });
            //console.log(idsPedidos);
            // Seleccionar todas las tarjetas
            let cards = $('div[id^="Card_"]');
            //console.log(cards);
            // Reemplaza '.tarjeta' con la clase o el id de tus tarjetas
            cards.each(function () {
                let idcard = $(this).attr('id').replace('Card_', '');
                //console.log(idcard);
                // Comprobar si el id de la tarjeta est&aacute; en el array de id de los pedidos
                if (!idsPedidos.includes(idcard)) {
                    // Si no est&aacute;, eliminar la tarjeta
                    //console.log('Eliminando tarjeta con id: ' + idcard);
                    $(this).fadeOut(1000, function () {
                        $(this).remove();
                    });

                }
            });

        }

        function crearTarjeta(id, mesa, categoria, hora, tiempo, porcentaje, detalle_pedido, comentarios,
            EstadoPedido, ColorCard) {
            // Function implementation goes here

            // Crear la tarjeta y agregarla al contenedor
            var color = '';
            color = Color(porcentaje);
            icono = Icono(categoria);

            var card = $('<div>').addClass('col-xl-3 col-md-5 mb-4').attr({
                'id': 'Card_' + id,
                'data-id': id,
                'data-comentarios': comentarios,
                'data-array': detalle_pedido,
                'data-mesa': mesa,
                'data-categoria': categoria,
                'data-hora': hora,
                'data-tiempo': tiempo,
                'data-porcentaje': porcentaje,
                'data-estadopedido': EstadoPedido,
                'data-template': categoria

            });
            var cardInner = $('<div>').addClass('card ' + ColorCard + ' shadow h-100 py-2').appendTo(card);
            var cardBody = $('<div>').addClass('card-body').appendTo(cardInner);
            var row = $('<div>').addClass('row no-gutters align-items-center').appendTo(cardBody);
            var colLeft = $('<div>').addClass('col mr-2').appendTo(row);
            var title = $('<div>').addClass('text-xs font-weight-bold text-uppercase mb-1').html(
                '<i class="fas ' + icono + ' fa-2x text-gray-400"></i><span class="ps-2">' + mesa + ' - ' +
                hora + ' hs - ' + EstadoPedido + '</span>'
            ).appendTo(colLeft);
            var innerRow = $('<div>').addClass('row no-gutters align-items-center').appendTo(colLeft);
            var colAuto = $('<div>').addClass('col-auto').appendTo(innerRow);
            var time = $('<div>').addClass('h5 mb-0 mr-3 font-weight-bold text-gray-800').text(tiempo + ' min')
                .appendTo(colAuto);
            var col = $('<div>').addClass('col').appendTo(innerRow);
            var progressBar = $('<div>').addClass('progress progress-sm mr-2').appendTo(col);
            var progressBarInner = $('<div>').addClass('progress-bar progress-bar-' + color).css('width',
                porcentaje + '%')
                .appendTo(progressBar);
            var colRight = $('<div>').addClass('col-auto').appendTo(row);
            var icon = $('<i>').addClass('fas fa-clipboard-list fa-2x text-gray-400').appendTo(colRight);

            // Agregar la tarjeta al contenedor


            // Agregar la tarjeta al contenedor
            card.hide();
            $('#dashboard').append(card);
            card.fadeIn('slow');
        }

        function ActualizarTarjeta(id, mesa, categoria, hora, tiempo, porcentaje, detalle_pedido, comentarios,
            EstadoPedido, ColorCard) {
            // Actualizar la tarjeta
            var color = '';
            color = Color(porcentaje);
            icono = Icono(categoria);

            var card = document.getElementById('Card_' + id);
            var cardParent = card.parentNode;

            // Crear el nuevo elemento tarjeta
            var nuevaCard = document.createElement('div');
            nuevaCard.className = 'col-xl-3 col-md-5 mb-4';
            nuevaCard.id = 'Card_' + id;
            nuevaCard.setAttribute('data-array', detalle_pedido);
            nuevaCard.setAttribute('data-id', id);
            nuevaCard.setAttribute('data-comentarios', comentarios);
            nuevaCard.setAttribute('data-estadopedido', EstadoPedido);
            nuevaCard.setAttribute('data-template', categoria);
            nuevaCard.setAttribute('data-mesa', mesa);

            var cardInner = document.createElement('div');
            cardInner.className = 'card ' + ColorCard + ' shadow h-100 py-2';

            var cardBody = document.createElement('div');
            cardBody.className = 'card-body';

            var row = document.createElement('div');
            row.className = 'row no-gutters align-items-center';

            var colLeft = document.createElement('div');
            colLeft.className = 'col mr-2';

            var title = document.createElement('div');
            title.className = 'text-xs font-weight-bold text-uppercase mb-1';
            title.innerHTML = '<i class="fas ' + icono + ' fa-2x text-gray-400"></i><span class="ps-2">' +
                mesa +
                ' - ' + hora + ' hs - ' + EstadoPedido + '</span>';

            var innerRow = document.createElement('div');
            innerRow.className = 'row no-gutters align-items-center';

            var colAuto = document.createElement('div');
            colAuto.className = 'col-auto';

            var time = document.createElement('div');
            time.className = 'h5 mb-0 mr-3 font-weight-bold text-gray-800';
            time.textContent = tiempo + ' min';

            var col = document.createElement('div');
            col.className = 'col';

            var progressBar = document.createElement('div');
            progressBar.className = 'progress progress-sm mr-2';
            var progressBarInner = document.createElement('div');
            progressBarInner.className = 'progress-bar progress-bar-' + color;
            progressBarInner.style.width = porcentaje + '%';
            progressBar.appendChild(progressBarInner);

            var colRight = document.createElement('div');
            colRight.className = 'col-auto';
            var icon = document.createElement('i');
            icon.className = 'fas fa-clipboard-list fa-2x text-gray-400';

            // Construir la estructura del DOM
            colAuto.appendChild(time);
            col.appendChild(progressBar);
            colRight.appendChild(icon);
            innerRow.appendChild(colAuto);
            innerRow.appendChild(col);
            colLeft.appendChild(title);
            colLeft.appendChild(innerRow);
            row.appendChild(colLeft);
            row.appendChild(colRight);
            cardBody.appendChild(row);
            cardInner.appendChild(cardBody);
            nuevaCard.appendChild(cardInner);

            // Reemplazar la tarjeta original con la nueva
            cardParent.replaceChild(nuevaCard, card);

        }
        //menejo modal



        // Actualizar input hidden cuando se modifica el comentario


        // Funci&oacute;n para actualizar el valor del input hidden
        function actualizarInputHidden() {
            var elementosSeleccionados = [];
            $('#listaPedidos .pedido').each(function () {
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
</script>

<script src="{$stRUTAS.vendor}bootstrap/js/bootstrap.bundle.js"></script>
<!-- Core plugin JavaScript-->
<script src="{$stRUTAS.vendor}jquery-easing/jquery.easing.js"></script>
<!-- Custom scripts for all pages-->
<script src="{$stRUTAS.js}sb-admin-2.js"></script>


</html>