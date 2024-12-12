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
            <div id="result"></div>
            <div class="row" id="dashboard">

            </div>
            <svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="gradientGauge">
                        <stop class="color-green" offset="50%" />
                        <stop class="color-yellow" offset="80%" />
                        <stop class="color-red" offset="100%" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- partial -->

        <div class="modal fade" id="DetallePedidoModalDiv" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="MesaPedidoModal"></h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="modal-title" id="exampleModalLabel">Detalhe do pedido</h6>
                    </div>
                    <div class="modal-body " id="DetallePedidoModal"> </div>
                    <div class="modal-body">
                        <hr>
                        <h6 class="modal-title " id="exampleModalLabel">Coment&aacute;rios:</h6>
                    </div>
                    <div class="modal-body" id="ComentariosPedidoModal"> </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">retornar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src='{$stRUTAS.vendor}jquery/jquery.min.js'>
</script>

<script src='{$stRUTAS.vendor}dist/dx.all.js'></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '[id^="PedidoModalLink"]', function() {
            var valordata_Comentarios = $(this).attr('data-Comentarios');
            var pedidoid = $(this).attr('data-id');
            if (valordata_Comentarios !== '') {
                $("#ComentariosPedidoModal").html(valordata_Comentarios);
            } else {
                $("#ComentariosPedidoModal").html('sem coment&aacute;rio');
            }
            var valordata_DetallePedido = $(this).attr('data-DetallePedido');
            $("#DetallePedidoModal").html(valordata_DetallePedido);
            var valordata_MesaPedido = $(this).attr('data-Mesa');
            var valordata_text = $(this).attr('data-text');
            //console.log(valordata_text);
            $("#MesaPedidoModal").html(valordata_MesaPedido);
            $("#ModalButtonLanzar").attr("data-id", pedidoid);
            $("#ModalButtonLanzar").html(valordata_text);

        });

        // Define la funci&oacute;n para crear la tarjeta gauge
        function crearGaugeCard(pedido, detalle_pedido, claseEstado) {
            // Crea toda la estructura HTML de la tarjeta gauge
            var $colDiv = $('<div>').addClass('col-xl-2 col-lg-3 divp').attr({
                'id': pedido.id
            });
            var $cardDiv = $('<div>').addClass(claseEstado + ' card shadow mb-1').attr({
                'id': pedido.id + 'GaugeStylo'
            });
            var $cardHeaderDiv = $('<div>').addClass(
                'card-header py-1 d-flex flex-row align-items-center justify-content-between'
            );
            var $headerTitle = $('<h6>').addClass('m-0 font-weight-bold text-primary').text(
                pedido
                .identificador);
            var $dropdownDiv = $('<div>').addClass('dropdown no-arrow');
            var $dropdownToggle = $('<a>').addClass('dropdown-toggle').attr({
                'href': 'javascript:void(0)',
                'role': 'button',
                'id': 'dropdownMenuLink',
                'data-toggle': 'dropdown',
                'aria-haspopup': 'true',
                'aria-expanded': 'false'
            });
            var $dropdownIcon = $('<i>').addClass(
                'fas fa-ellipsis-v fa-sm fa-fw text-gray-400');
            var $dropdownMenu = $('<div>').addClass(
                'dropdown-menu dropdown-menu-right shadow animated--fade-in').attr(
                'aria-labelledby', 'dropdownMenuLink');
            var $dropdownHeader = $('<div>').addClass('dropdown-header').text('Menu do ' +
                pedido
                .identificador + ':');
            if (pedido.estado === 'N') {
                button = 'Lan&ccedil;ar';

            } else {
                button = 'Finalizar';
            }
            var $dropdownItem1 = $('<a>')
                .addClass('dropdown-item')
                .attr('href', 'javascript:void(0)')
                .attr('id', 'PedidoModalLink' + pedido.id)
                .attr('data-toggle', 'modal')
                .attr('data-target', '#DetallePedidoModalDiv')
                .attr('data-Mesa', pedido.identificador)
                .attr('data-text', button)
                .attr('data-id', pedido.id)
                .attr('data-Comentarios', pedido.comentarios)
                .attr('data-DetallePedido', detalle_pedido)
                .text('Veja detalhes do pedido');
            var $dropdownItem2 = $('<a>')
                .addClass('dropdown-item')
                .attr('data-id', pedido.id)
                .attr('data-text', button)
                .attr('href', 'javascript:void(0)')
                .attr('id', "LanzarPedido" + pedido.id);
            var $dropdownItem3 = $('<a>').addClass('dropdown-item').attr('href',
                'javascript:void(0)').text(
                'Cancelar');
            var $dropdownDivider = $('<div>').addClass('dropdown-divider');
            $dropdownMenu.append($dropdownHeader, $dropdownItem1, $dropdownItem2,
                $dropdownDivider,
                $dropdownItem3);
            $dropdownToggle.append($dropdownIcon);
            $dropdownDiv.append($dropdownToggle, $dropdownMenu);
            $cardHeaderDiv.append($headerTitle, $dropdownDiv);
            $cardDiv.append($cardHeaderDiv);
            var $cardBodyDiv = $('<div>').addClass('card');
            var $gaugeContainerDiv = $('<div>').addClass('gauge-container');
            var $gaugeDiv = $('<div>').addClass('gauge').attr({
                'id': pedido.id + 'gauge'
            });
            $gaugeContainerDiv.append($gaugeDiv);
            $cardBodyDiv.append($gaugeContainerDiv);
            $cardDiv.append($cardBodyDiv);
            $colDiv.append($cardDiv);
            return $colDiv;
        }
        //reloj comidas
        // Define la funci&oacute;n para inicializar el gr&aacute;fico Gauge
        function inicializarGauge60(item, params) {
            class GaugeChart {
                constructor(element, params) {
                    this._element = element;
                    this._initialValue = params.initialValue;
                    this._higherValue = params.higherValue;
                    this._title = params.title;
                    this._subtitle = params.subtitle;
                }
                _buildConfig() {
                    let element = this._element;
                    return {
                        value: this._initialValue,
                        valueIndicator: {
                            color: '#26323a'
                        }, //aguja del velocimetro
                        geometry: {
                            startAngle: 180,
                            endAngle: 360
                        },
                        scale: {
                            startValue: 0,
                            endValue: this._higherValue,
                            customTicks: [0, 10, 20, 30, 40, 50, 60],
                            tick: {
                                length: 14
                            },

                            label: {
                                font: {
                                    color: '#26323a',
                                    //size: 12,
                                    //family: '"Open Sans", sans-serif'
                                }
                            }
                        },
                        title: {
                            verticalAlignment: 'bottom',
                            text: this._title,
                            font: {
                                //family: '"Open Sans", sans-serif',
                                color: '#26323a',
                                size: 13
                            },
                            subtitle: {
                                text: this._subtitle,
                                font: {
                                    //family: '"Open Sans", sans-serif',
                                    color: '#26323a',
                                    size: 11
                                }
                            }
                        },
                        onInitialized: function() {
                            let currentGauge = $(element);
                        }
                    };
                }
                init() {
                    $(this._element).dxCircularGauge(this._buildConfig());
                }
            }
            gauge = new GaugeChart(item, params);
            gauge.init();
        }
        //reloj bebidas
        function inicializarGauge5(item, params) {
            class GaugeChart {
                constructor(element, params) {
                    this._element = element;
                    this._initialValue = params.initialValue;
                    this._higherValue = params.higherValue;
                    this._title = params.title;
                    this._subtitle = params.subtitle;
                }
                _buildConfig() {
                    let element = this._element;
                    return {
                        value: this._initialValue,
                        valueIndicator: {
                            color: '#26323a'
                        }, //aguja del velocimetro
                        geometry: {
                            startAngle: 180,
                            endAngle: 360
                        },
                        scale: {
                            startValue: 0,
                            endValue: this._higherValue,
                            customTicks: [0, 1, 2, 3, 4, 5],
                            tick: {
                                length: 14
                            },

                            label: {
                                font: {
                                    color: '#26323a',
                                    //size: 12,
                                    //family: '"Open Sans", sans-serif'
                                }
                            }
                        },
                        title: {
                            verticalAlignment: 'bottom',
                            text: this._title,
                            font: {
                                //family: '"Open Sans", sans-serif',
                                color: '#26323a',
                                size: 13
                            },
                            subtitle: {
                                text: this._subtitle,
                                font: {
                                    //family: '"Open Sans", sans-serif',
                                    color: '#26323a',
                                    size: 11
                                }
                            }
                        },
                        onInitialized: function() {
                            let currentGauge = $(element);
                        }
                    };
                }
                init() {
                    $(this._element).dxCircularGauge(this._buildConfig());
                }
            }
            gauge = new GaugeChart(item, params);
            gauge.init();
        }
        // Funci&oacute;n para insertar el c&oacute;digo HTML del gauge y inicializarlo
        function insertarGauge(pedido, detalle_pedido) {

            var elemento = '#' + pedido.id + 'gauge';
            if (pedido.estado == 'N') {
                estado = 'Novo';
                var ClaseEstado = 'nuevoGauge';
            } else {
                estado = 'Em processo';
                var ClaseEstado = '';

            }

            if (!$(elemento).length) {
                $('#dashboard').append(crearGaugeCard(pedido, detalle_pedido, ClaseEstado));

            } else if (estado == 'Em processo') {
                //cambiar class de nuevoGauge por "" si el elemento tiene estado Em processo 
                LimpiarStyloNuevoGauge(pedido.id);
            }
            const d = new Date();
            //usada para sacar la diff de la hora de verano
            var ahora = new Date();
            var hora_inicio = new Date(pedido.hora_inicio)
            // Calcular la diferencia en milisegundos entre la fecha y hora actual y la fecha y hora de inicio
            ahora.setMinutes(ahora.getMinutes());
            var diferencia = ahora.getTime() - hora_inicio.getTime();
            //console.log(diferencia);
            // Convertir la diferencia de milisegundos a minutos
            var minutosTranscurridos = Math.floor(diferencia / 60000);
            //console.log(minutosTranscurridos);
            var item = $(elemento);
            if (pedido.template == '1') {
                params = {
                    initialValue: minutosTranscurridos,
                    higherValue: 60,
                    title: estado,
                    subtitle: `Tempo restante: ` + (60 - minutosTranscurridos) + ' min'
                };
                inicializarGauge60(item, params);
            } else {
                params = {
                    initialValue: minutosTranscurridos,
                    higherValue: 5,
                    title: estado,
                    subtitle: `Tempo restante: ` + (5 - minutosTranscurridos) + ' min'
                }
                inicializarGauge5(item, params);
            }

        }

        function LimpiarStyloNuevoGauge(id) {

            $('#' + id + 'GaugeStylo').removeClass('nuevoGauge');
        }

        function RemoverGauge(id) {
            $('#' + id).remove();
        }
        // Evento click del bot&oacute;n para insertar el gauge


        RefreshPedidos();
        setInterval(RefreshPedidos, 10000);

        function RefreshPedidos() {
            var loja_id = $("#loja_id").val();
          
            $.ajax({
                url: "{$stRUTAS.ped}status.pedidos.php?loja_id=" + loja_id, // URL de tu script o recurso del lado del servidor
                type: "GET", // M&eacute;todo HTTP (GET o POST)
                dataType: "json", // Tipo de datos esperado
                success: function(pedidos) {
                    if (!pedidos) {
                        $("#result").html(
                            "<h1 class='h2 mb-4 text-gray-800'>Nenhum pedido a ser listado</h1>"
                        );
                        $('.divp').remove();
                    } else {
                        //console.log(pedidos);
                        $.each(pedidos, function(index, pedido) {
                            $("#result").html("");
                            var codigoHTML = "";
                            $.each(pedido.detalles_pedido, function(index,
                                detalle) {
                                codigoHTML = codigoHTML + "<li>" +
                                    detalle
                                    .nombre_pt + " qtd : " + detalle
                                    .cantidad +
                                    "</li>";
                            });
                            var detalle_pedido = "<ul type='1'>" +
                                codigoHTML +
                                "</ul>";
                            insertarGauge(pedido, detalle_pedido);

                        });
                        var Activos = pedidos.map(function(pedido) {
                            return pedido.id;
                        });
                        //console.log(Activos);
                        var idsConGauge = [];
                        $("[id$='gauge']").each(function() {
                            // Agrega el ID del elemento al array
                            idsConGauge.push($(this).attr("id"));
                        });
                        var EnPantalla = idsConGauge.map(function(id) {
                            return id.replace('gauge', '');
                        });

                        // Muestra los IDs sin 'gauge' en la consola para verificar
                        //console.log(EnPantalla);
                        var arrayFiltrado = EnPantalla.filter(function(id) {
                            return !Activos.includes(id);
                        });

                        // Muestra los elementos filtrados en la consola para verificar
                        //console.log(arrayFiltrado);
                        arrayFiltrado.forEach(function(id) {
                            $("#" + id).remove();
                        });
                    }



                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.statusText);
                }
            });
        };


    });
</script>

<script src="{$stRUTAS.vendor}bootstrap/js/bootstrap.bundle.js"></script>
<!-- Core plugin JavaScript-->
<script src="{$stRUTAS.vendor}jquery-easing/jquery.easing.js"></script>
<!-- Custom scripts for all pages-->
<script src="{$stRUTAS.js}sb-admin-2.js"></script>


</html>