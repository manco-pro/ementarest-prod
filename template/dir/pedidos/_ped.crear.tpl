{include file="_cabecera.tpl"}
<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>

    {if ($stMENSAJE != '')}
        <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
    {/if}
    {if ($stERROR != '')}
        <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
    {/if}
    <form method="POST" id="form_pedidos" action="{$stACTION}" accept-charset="utf-8">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    {if $stBTN_ACTION_D == ''}
                        <p class='mb-0 small'>Escolha a mesa para fazer a ordem <br>Pesquise e adicione produtos ao pedido
                            da mesa.</p>
                    {else}
                        <p class='mb-0 small'>Adicionar ou remover coment&aacute;rios/produtos.</p>
                    {/if}
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-group">
                            <label for="MesasSelect">Mesa</label>
                            <select class="form-control select2" id="MesasSelect" name="MesasSelect">
                                {$stMESAS}
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label for="PedidosSelect">Produtos</label>
                                <select class="form-control select2" id="PedidosSelect" name="PedidosSelect">
                                    {$stCOLECCIONES}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
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
                            <div class="form-group col-md-1">
                                <label for="adicionar">Adicionar</label>
                                <button type="button" class="btn btn-primary btn-circle" name="adicionar"
                                    id="adicionar">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"> </i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row d-sm-flex align-items-center justify-content-between mb-3 "
                            id="listaPedidos">
                            {if $stPEDIDO_DETALLE!=false}
                                <p><em>Produtos adicionados ao pedido:</em></p>
                                {foreach from=$stPEDIDO_DETALLE item=coleccion}

                                    <div class="pedido form-row mb-3 border-left-info  col-md-12"
                                        data-id="{$coleccion.coleccion_id}" data-cantidad="1">
                                        <div class="form-group col-md-11 texto">
                                            <label for="comentario">{$coleccion.nombre_pt}</label>
                                            <input type="text" class="comentario form-control col-md-12"
                                                placeholder="Insira um coment&aacute;rio" value="{$coleccion.comentario}">
                                        </div>
                                        <div class="eliminar-container form-group col-md-1" style="align-content:flex-end;">
                                            <button type="button" class="eliminar btn btn-info btn-circle"><span
                                                    class="icon text-white-80">
                                                    <i class="far fa-trash-alt"></i>
                                                </span></button>
                                        </div>
                                    </div>

                                {/foreach}
                            {/if}
                        </div>
                        <input type="hidden" id="idsSeleccionados" name="idsSeleccionados">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3"></div>
            </div>
            <div class="col-lg-8">
                <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                    <div><button type="submit" class="btn btn-primary" id="buttonForm" name="{$stBTN_ACTION}">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"> </i>
                            </span>
                            <span class="text">{$stBTN_ACTION}</span>
                        </button>
                        <a href="{$stRUTAS.ped}ped.listaract.php?loja_id={$stLOJA_ID}" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.ped}ped.borrar.php?id={$stID}" class="btn btn-danger" id="borrar"
                                name="{$stBTN_ACTION_D}">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash-alt"> </i>
                                </span>
                                <span class="text">{$stBTN_ACTION_D}</span>
                            </a>
                        {/if}
                    </div>

                </div>

            </div>
        </div>
        <input name="id" type="hidden" value="{$stID|default:''}">
        <input name="loja_id" type="hidden" value="{$stLOJA_ID}">
    </form>
</div>
<!-- /.container-fluid -->





</div>

<!-- End of Page Wrapper -->
<!-- scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });
        var mensajeDiv = $("#mensaje");
        // Oculta el mensaje despu&eacute;s de 3 segundos
        setTimeout(function() {
            mensajeDiv.fadeOut();
        }, 3000); // 3000 milisegundos = 3 segundos
    });

    $(document).ready(function() {
        // Agregar elemento seleccionado al hacer clic en el bot&oacute;n "Adicionar"
        $("#adicionar").click(function() {
            var valorSeleccionado = $('#PedidosSelect').val();
            if (valorSeleccionado) {
                var texto = $('#PedidosSelect option:selected').text();
                if (texto != "Produtos") {
                    var valorCantidad = $('#Cantidad').val();
                    for (var i = 1; i <= valorCantidad; i++) {
                        $('#listaPedidos').append(
                            '<div class="pedido form-row mb-3 border-left-info  col-12" data-id="' +
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

        // Remover elemento al hacer clic en "Eliminar"
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

        // Manejar el evento de envio del formulario
        $('#form_pedidos').submit(function(event) {
            actualizarInputHidden();
            // Obtener el valor seleccionado en el select
            var valorSeleccionado = $('#MesasSelect').val();
            var Seleccionados = $('#idsSeleccionados').val();
            var mensaje = '';
            console.log(Seleccionados);
            // Verificar si el valor seleccionado es diferente de -1
            if (Seleccionados === '') {
                mensaje = 'Adicione um produto para fazer o pedido \n';
            }
            if (valorSeleccionado === "-1") {
                mensaje = mensaje + 'Selecione uma mesa para o pedido';

            }
            if (mensaje !== '') {
                event.preventDefault();
                // Mostrar un mensaje de alerta
                alert(mensaje);
            } else {
                return true;
            }

            // Si no se ha seleccionado un valor v&aacute;lido, evitar el env&iacute;o del formulario


        });
        actualizarInputHidden();
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