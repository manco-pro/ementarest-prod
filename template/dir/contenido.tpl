{include file="_cabecera.tpl"}
<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
<!-- partial:index.partial.html <input type="button" id="insertarGaugeBtn" value="test">-->
<div class="container-fluid">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Pedidos</button>
            <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Finalizar</button>

        </div>
    </nav>
    <div class="tab-content mt-4" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row" id="dashboard">
                <div id="result"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row" id="dashboard_final">
                <div id="result_final"></div>

            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="MesaModalDiv" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="MesaModal"></h4>
                <button class="close" type="button" data-dismiss="modal">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="ListaPedidosTabla">


                </div>



            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Sair</button>
                <button class="btn btn-primary" type="button" id="ModalButtonActionF">Finalizar</button>
            </div>
        </div>
    </div>
</div>




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

                    <div class="form-row">
                        <div class="form-group col-9" id='Sbebidas'>
                            <label for="PedidosSelectBebidas">Produtos</label>
                            <select class="form-control select2" style="max-width: 800px; width:500px"
                                id="PedidosSelectBebidas" name="PedidosSelectBebidas">
                                {$stCOLECCIONES_BEBIDAS}
                            </select>
                        </div>
                        <div class="form-group col-9" id='Scomidas'>
                            <label for="PedidosSelectComidas">Produtos</label>
                            <select class="form-control select2" style="max-width: 800px; width:500px"
                                id="PedidosSelectComidas" name="PedidosSelectComidas">
                                {$stCOLECCIONES_COMIDAS}
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="Cantidad">Cantidad</label>
                            <select class="form-control" id="Cantidad" name="Cantidad">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group col-1">
                            <label for="adicionar">Adicionar</label>
                            <button type="button" class="btn btn-primary btn-circle" name="adicionar" id="adicionar">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"> </i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <p><em>Produtos adicionados ao pedido:</em></p>
                    <div class="form-row d-sm-flex align-items-center justify-content-between mb-3 " id="listaPedidos">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idsSeleccionados" name="idsSeleccionados">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"
                    id="CancelarPedido">Cancelar</button>
                <button class="btn btn-primary" type="button" id="ModalButtonAction" data-id="">Lan&ccedil;ar</button>
            </div>
        </div>
    </div>
</div>
</div>
<script src='{$stRUTAS.vendor}jquery/jquery.min.js'></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });

        //tabla de Finalizar

        function RefreshFinalizar() {
            $.ajax({
                url: "{$stRUTAS.ped}finalizar.pedidos.php", // URL de tu script o recurso del lado del servidor
                type: "POST", // M&eacute;todo HTTP (GET o POST)
                data: { dashboard: true },
                dataType: "json", // Tipo de datos esperado
                success: function(Mesas) {
                    //console.log('finalizar');
                    //console.log(Mesas);
                    if (!Mesas) {
                        $("#result_final").html(
                            "<h1 class='h2 mb-4 text-gray-800'>Nenhum mesa a ser finalizada</h1>"
                        );
                        $('div[id^="CardF_"]').fadeOut(1000, function() {
                            $(this).remove();
                        });

                    } else {

                        $.each(Mesas, function(index, mesa) {
                            $("#result_final").html("");
                            let id = mesa.id;
                            let identificador = mesa.identificador;
                            let total = mesa.total;
                            //console.log(id);
                            //console.log(identificador);
                            //console.log(total);
                            //console.log(mesa.Pedidos);
                            //
                            const cardFExists = $('#CardF_' + mesa.id).length > 0;
                            const funcion = cardFExists ? ActualizarTarjetaFinalizar :
                                crearTarjetaFinalizar;

                            funcion(
                                mesa.id,
                                mesa.identificador,
                                mesa.total,
                                JSON.stringify(mesa.Pedidos)
                            );

                            RemoverCardsFinalizar(Mesas);

                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        };



        function ActualizarTarjetaFinalizar(id, identificador, total, pedidos) {
            // Obtener la contenedor donde se insertarán las tarjetas
            var contenedor = document.getElementById("dashboard_final");

            // Obtener la tarjeta existente por su ID
            var tarjetaExistente = document.getElementById("CardF_" + id);

            // Verificar si la tarjeta existe y el contenedor está presente
            if (tarjetaExistente && contenedor) {
                // Crear una nueva tarjeta con los datos actualizados
                var nuevaTarjeta = document.createElement("div");
                nuevaTarjeta.className = "col-xl-3 col-md-5 mb-4";
                nuevaTarjeta.id = "CardF_" + id;
                nuevaTarjeta.setAttribute("data-id", id);
                nuevaTarjeta.setAttribute("data-pedidos", pedidos);
                nuevaTarjeta.setAttribute("data-mesa", identificador);

                var card = document.createElement("div");
                card.className = "card border-left-success shadow h-100 py-2";

                var cardBody = document.createElement("div");
                cardBody.className = "card-body";

                var cardRow = document.createElement("div");
                cardRow.className = "row no-gutters align-items-center";

                var identificadorContainer = document.createElement("div");
                identificadorContainer.className = "col mr-2";
                var identificadorText = document.createElement("div");
                identificadorText.className = "text-xs font-weight-bold text-success text-uppercase mb-1";
                identificadorText.textContent = identificador;
                var precioText = document.createElement("div");
                precioText.className = "h5 mb-0 font-weight-bold text-gray-800";
                precioText.innerHTML = "\u20AC" + total;
                identificadorContainer.appendChild(identificadorText);
                identificadorContainer.appendChild(precioText);

                var icono = document.createElement("div");
                icono.className = "col-auto";
                var iconoI = document.createElement("i");
                iconoI.className = "fas fa-euro-sign fa-2x text-gray-300";
                icono.appendChild(iconoI);

                cardRow.appendChild(identificadorContainer);
                cardRow.appendChild(icono);
                cardBody.appendChild(cardRow);
                card.appendChild(cardBody);
                nuevaTarjeta.appendChild(card);

                // Reemplazar la tarjeta existente con la nueva tarjeta
                contenedor.replaceChild(nuevaTarjeta, tarjetaExistente);
                //tarjetaExistente.remove();
            }
        }


        function crearTarjetaFinalizar(id, identificador, total, pedidos) {
            // Crear el contenedor de la card
            var cardContainer = document.createElement("div");
            cardContainer.className = "col-xl-3 col-md-5 mb-4";
            cardContainer.id = "CardF_" + id;
            cardContainer.setAttribute("data-id", id);
            cardContainer.setAttribute("data-pedidos", pedidos);
            cardContainer.setAttribute("data-mesa", identificador);

            // Crear la card
            var card = document.createElement("div");
            card.className = "card border-left-success shadow h-100 py-2";

            // Crear el cuerpo de la card
            var cardBody = document.createElement("div");
            cardBody.className = "card-body";

            // Crear la fila de la card
            var cardRow = document.createElement("div");
            cardRow.className = "row no-gutters align-items-center";

            // Crear el contenedor del identificador
            var identificadorContainer = document.createElement("div");
            identificadorContainer.className = "col mr-2";
            var identificadorText = document.createElement("div");
            identificadorText.className = "text-xs font-weight-bold text-success text-uppercase mb-1";
            identificadorText.textContent = identificador;
            var precioText = document.createElement("div");
            precioText.className = "h5 mb-0 font-weight-bold text-gray-800";
            precioText.innerHTML = "\u20AC" + total;
            identificadorContainer.appendChild(identificadorText);
            identificadorContainer.appendChild(precioText);

            // Crear el icono de la card
            var icono = document.createElement("div");
            icono.className = "col-auto";
            var iconoI = document.createElement("i");
            iconoI.className = "fas fa-euro-sign fa-2x text-gray-300";
            icono.appendChild(iconoI);

            // Agregar los elementos al &aacute;rbol DOM
            cardRow.appendChild(identificadorContainer);
            cardRow.appendChild(icono);
            cardBody.appendChild(cardRow);
            card.appendChild(cardBody);
            cardContainer.appendChild(card);

            // Obtener el contenedor donde se insertar&aacute;n las cards
            var contenedor = document.getElementById("dashboard_final");

            // Agregar la card al contenedor utilizando appendChild()
            //console.log(cardContainer);
            contenedor.appendChild(cardContainer);
        }

        function RemoverCardsFinalizar(Mesas) {
            let idsMesas = Mesas.map(function(mesa) {
                return mesa.id;
            });
            //console.log(idsPedidos);
            // Seleccionar todas las tarjetas
            let cards = $('div[id^="CardF_"]');
            //console.log(cards);
            // Reemplaza '.tarjeta' con la clase o el id de tus tarjetas
            cards.each(function() {
                let idcard = $(this).attr('id').replace('CardF_', '');
                //console.log(idcard);
                // Comprobar si el id de la tarjeta est&aacute; en el array de id de los pedidos
                if (!idsMesas.includes(idcard)) {
                    // Si no est&aacute;, eliminar la tarjeta
                    console.log('Eliminando tarjeta con id: ' + idcard);
                    $(this).fadeOut(1000, function() {
                        $(this).remove();
                    });

                }
            });

        }


        function generarTablaPedidos(datos) {
            var tabla = '<table class="table ">';
            tabla += '<thead ><tr>';
            tabla += '<th>Pedido</th>';
            tabla += '<th>Producto</th>';
            tabla += '<th>Precio unitario</th>';
            tabla += '<th>Cantidad</th>';
            tabla += '<th>Precio total</th>';
            tabla += '</tr></thead>';
            tabla += '<tbody>';

            // Agrupar los pedidos por ID de pedido
            var pedidosPorID = {};
            datos.forEach(function(pedido) {
                if (!pedidosPorID.hasOwnProperty(pedido.id)) {
                    pedidosPorID[pedido.id] = [];
                }
                pedidosPorID[pedido.id].push(pedido);
            });

            var totalMesa = 0;

            // Generar las filas de la tabla
            Object.keys(pedidosPorID).forEach(function(idPedido, index) {
                var pedidos = pedidosPorID[idPedido];
                var totalPedido = 0;

                pedidos.forEach(function(pedido, innerIndex) {
                    totalPedido += parseFloat(pedido.cantidad) * parseFloat(pedido.precio);

                    tabla += '<tr class="border-bottom">';

                    if (innerIndex === 0) {
                        tabla += '<th scope="row" rowspan="' + pedidos.length +
                            '"><p class="ta">' + idPedido + '</p></td>';
                    }

                    tabla += '<td><p class="ta">' + pedido.nombre_pt + '</p></td>';
                    tabla += '<td><p class="ta">&euro; ' + parseFloat(pedido.precio).toFixed(
                        2) + '</p></td>';
                    tabla += '<td><p class="ta">' + pedido.cantidad + '</p></td>';
                    tabla += '<td><p class="ta">&euro; ' + (parseFloat(pedido.cantidad) *
                            parseFloat(pedido.precio))
                        .toFixed(2) + '</p></td>';

                    tabla += '</tr>';
                });

                // Calcular el total del pedido y a&ntilde;adir al total de la mesa
                totalMesa += totalPedido;

            });


            // Mostrar el total de la mesa
            tabla += '<tr style="background-color: #eee; margin:0; padding:0">';
            tabla += '<td colspan="4" style="text-align: right;"><b class="ta"><h5>Total :</h5></b></td>';
            tabla += '<td><b class="ta">&euro; ' + totalMesa.toFixed(2) + '</b></td>';

            tabla += '</tr>';

            tabla += '</tbody>';
            tabla += '</table>';

            return tabla;
        }
        //cargar modal con los detalles del pedido

        $(document).on('click', '[id^="CardF_"]', function() {

            var id = $(this).data('id');
            //console.log(id);
            var pedidos = $(this).data('pedidos');
            console.log(pedidos);
            var mesa = $(this).data('mesa');


            $('#ListaPedidosTabla').html('');

            $('#MesaModal').html(mesa + ' - Detalhes do pedido');
            var card = document.getElementById("ModalButtonActionF");
            card.setAttribute("data-id", id);
            card.setAttribute("data-pedidos", JSON.stringify(pedidos));

            //console.log(pedidos);

            var tablaGenerada = generarTablaPedidos(pedidos);
            var card1 = document.getElementById("ListaPedidosTabla");
            card1.innerHTML = tablaGenerada;
            // $('#ListaPedidosTabla').html(tablaGenerada);


            $('#MesaModalDiv').modal('show');
        });

        $(document).on('click', '#ModalButtonActionF', function() {
            var card = document.getElementById("ModalButtonActionF");
            var id = card.getAttribute("data-id");
            var pedidos = card.getAttribute("data-pedidos");

            FinalizarMesa(pedidos);
            RefreshFinalizar();
            // $(this).removeAttribute('data-id');
            // $(this).removeAttribute('data-pedidos');
            $('#MesaModalDiv').modal('hide');
        });

        function FinalizarMesa(pedidos) {
            $.ajax({
                url: "{$stRUTAS.ped}ped.finalizar.php", 
                method: 'POST',
                data: { pedidos: pedidos },
                dataType: "text",
                success: function(resultado) {
                    console.log('esto es el resultado:' + resultado);
                    //
                    if (resultado == 'ok') {
                        RefreshFinalizar();
                    } else if (resultado == 'bad1') {
                        alert('Erro ao finalizar a mesa');
                    }
                    //
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });

        }

        //tabla de pedidos///////////////////////////////////////////////////////

        //cargar modal con los detalles del pedido
        $(document).on('click', '[id^="Card_"]', function() {
            var id = $(this).data('id');
            var array = $(this).data('array');
            //console.log(array);

            var comentarios = $(this).data('comentarios');
            var mesa = $(this).data('mesa');
            var EstadoPedido = $(this).data('estadopedido');
            var template = $(this).data('template');
            $('#Scomidas').hide();
            $('#Sbebidas').hide();

            if (template == 'Comidas') {
                $('#Scomidas').show();
            } else {
                $('#Sbebidas').show();
            }

            $('#listaPedidos').html('');

            $('#MesaPedidoModal').html(mesa + ' - ' + EstadoPedido);

            $('#ModalButtonAction').data('id', id);
            $('#CancelarPedido').data('id', id);

            console.log(EstadoPedido);
            if (EstadoPedido == 'Novo') {
                $('#ModalButtonAction').text('Lan\u00E7ar Pedido');
            } else {
                $('#ModalButtonAction').text('Pronto');
            }
            //console.log(array);
            $.each(array, function(index, value) {
                agregarElementoPedido(value.coleccion_id, value.nombre_pt, value.comentario);
            });
            actualizarInputHidden();
            $('.select2').val($('.select2 option:eq(0)').val()).trigger('change');
            $('#DetallePedidoModalDiv').modal('show');
        });



        $('#ModalButtonAction').click(function() {
            var id = $(this).data('id');
            var Accion = $(this).text();
            if (Accion == 'Lan\u00E7ar Pedido') {
                LanzarPedido(id);
                RefreshPedidos();
            } else {
                ProntoPedido(id);
            }

            $('#DetallePedidoModalDiv').modal('hide');
        });

        $('#CancelarPedido').click(function() {
            var id = $(this).data('id');

            CancelarPedido(id);
            $('#DetallePedidoModalDiv').modal('hide');
        });

        function CancelarPedido(id) {
            console.log('cancelar pedido');

            var Card = $('#Card_' + id);
            //console.log(idsSeleccionados);
            //console.log(id);
            $.ajax({
                url: "{$stRUTAS.ped}ped.cancelar.php", 
                method: 'POST',
                data: { id: id },
                dataType: "text",
                success: function(resultado) {
                    console.log('esto es el resultado:' + resultado);
                    //
                    if (resultado == 'ok') {
                        RefreshPedidos();
                    } else if (resultado == 'bad1') {
                        alert('n&atilde;o selecionou nenhum produto');
                    } else if (resultado == 'bad2') {
                        alert('Erro ao cancelar o pedido');
                    }
                    //
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });

        }


        function LanzarPedido(id) {

            var idsSeleccionados = $("#idsSeleccionados").val();
            var Card = $('#Card_' + id);
            //console.log(idsSeleccionados);
            //console.log(id);
            $.ajax({
                url: "{$stRUTAS.ped}ped.lanzar.php", 
                method: 'POST',
                data: { id: id, idsSeleccionados: idsSeleccionados },
                dataType: "text",
                success: function(resultado) {
                    //console.log('esto es el resultado:' + resultado);
                    //
                    if (resultado == 'ok') {
                        RefreshPedidos();
                    } else if (resultado == 'bad1') {
                        alert('n&atilde;o selecionou nenhum produto');
                    } else if (resultado == 'bad2') {
                        alert('Erro ao lan\u00E7ar o pedido');
                    }
                    //
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        }

        function ProntoPedido(id) {
            console.log('pronto pedido');
            var idsSeleccionados = $("#idsSeleccionados").val();
            var Card = $('#Card_' + id);
            //console.log(idsSeleccionados);
            //console.log(id);
            $.ajax({
                url: "{$stRUTAS.ped}ped.pronto.php", 
                method: 'POST',
                data: { id: id, idsSeleccionados: idsSeleccionados },
                dataType: "text",
                success: function(resultado) {
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
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        }

/////////////////////////
        RefreshPedidos();
        RefreshFinalizar();
        setInterval(RefreshPedidos, 5000);
        setInterval(RefreshFinalizar, 5000);
//////////////////////////
        function RefreshPedidos() {
            $.ajax({
                url: "{$stRUTAS.ped}status.pedidos.php", // URL de tu script o recurso del lado del servidor
                type: "POST", // M&eacute;todo HTTP (GET o POST)
                data: { dashboard: true },
                dataType: "json", // Tipo de datos esperado
                success: function(pedidos) {

                    //console.log(pedidos);
                    if (!pedidos) {
                        $("#result").html(
                            "<h1 class='h2 mb-4 text-gray-800'>Nenhum pedido a ser listado</h1>"
                        );
                        $('div[id^="Card_"]').fadeOut(1000, function() {
                            $(this).remove();
                        });

                    } else {

                        $.each(pedidos, function(index, pedido) {
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
                error: function(xhr, status, error) {
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
                'value': comentario
            });
            formGroupText.append(labelProducto, inputComentario);
            var eliminarContainer = $('<div>').addClass('eliminar-container form-group col-md-1').css(
                'align-content', 'flex-end');
            var btnEliminar = $('<button>').attr('type', 'button').addClass('eliminar btn btn-info btn-circle');
            var iconoEliminar = $('<span>').addClass('icon text-white-80').html(
                '<i class="far fa-trash-alt"></i>');
            btnEliminar.append(iconoEliminar);
            eliminarContainer.append(btnEliminar);
            pedido.append(formGroupText, eliminarContainer);
            $('#listaPedidos').append(pedido);
        }

        function RemoverCards(pedidos) {
            let idsPedidos = pedidos.map(function(pedido) {
                return pedido.id;
            });
            //console.log(idsPedidos);
            // Seleccionar todas las tarjetas
            let cards = $('div[id^="Card_"]');
            //console.log(cards);
            // Reemplaza '.tarjeta' con la clase o el id de tus tarjetas
            cards.each(function() {
                let idcard = $(this).attr('id').replace('Card_', '');
                //console.log(idcard);
                // Comprobar si el id de la tarjeta est&aacute; en el array de id de los pedidos
                if (!idsPedidos.includes(idcard)) {
                    // Si no est&aacute;, eliminar la tarjeta
                    //console.log('Eliminando tarjeta con id: ' + idcard);
                    $(this).fadeOut(1000, function() {
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
        $("#adicionar").click(function() {

            var select = 'PedidosSelectBebidas';
            var valorSeleccionado = $('#PedidosSelectBebidas').val();
            //console.log(valorSeleccionado);
            if (valorSeleccionado === null || valorSeleccionado === undefined || valorSeleccionado ===
                '-1') {
                valorSeleccionado = $('#PedidosSelectComidas').val();
                var select = 'PedidosSelectComidas';
            }

            //var valorSeleccionado = $('#PedidosSelect').val();
            if (valorSeleccionado) {
                var texto = $('#' + select + ' option:selected').text();
                if (texto != "Produtos") {
                    var valorCantidad = $('#Cantidad').val();
                    for (var i = 1; i <= valorCantidad; i++) {
                        $('#listaPedidos').append(
                            '<div class="pedido form-row mb-3 col-12" data-id="' +
                            valorSeleccionado + '" data-cantidad="1" >' +
                            '<div class="texto form-group col-md-11"><label for="comentario">' +
                            texto + '</label>' +
                            '<input type="text" class="comentario form-control col-12" placeholder="Insira um coment&aacute;rio">' +
                            '</div>' +
                            //'<div class="form-group col-md-1">' +
                            //'<label for="precio">Pre&ccedil;o:</label>' +
                            //'<input type="text" disabled class="form-control" id="precio" name="precio" value="XXXX">' +
                            //'</div>' +
                            '<div class="eliminar-container form-group col-1" style="align-content:flex-end;">' +
                            '<button type="button" class="eliminar btn btn-info btn-circle"><span class="icon text-white-80">' +
                            '<i class="far fa-trash-alt"></i></span></button>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                    actualizarInputHidden();
                } else {
                    alert("Por favor Selecione um produto.");
                }
            } else {
                alert("Por favor Selecione um produto.");
            }
        });
        $('#listaPedidos').on('click', '.eliminar', function() {
            var $pedido = $(this).closest('.pedido');
            // Si solo hay un elemento, elimina el pedido completo
            $pedido.remove();
            actualizarInputHidden();
        });

        // Actualizar input hidden cuando se modifica el comentario
        $('#listaPedidos').on('input', '.comentario', function() {
            actualizarInputHidden();
        });

        // Funci&oacute;n para actualizar el valor del input hidden
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


        $("#borrar").click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");
            if (confirm(
                    "O Pedido e os Detalhes a ele associados ser\u00E3o exclu\u00EDdos permanentemente. Voc\u00EA tem certeza que quer continuar?"
                )) {
                window.location.href = url;
            } else {
                return false;
            }
        });

    });
</script>
{include file="_pie.tpl"}