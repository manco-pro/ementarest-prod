<!DOCTYPE HTML>
<html lang="pt-PT">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <title>{$stTITLE|default:'::Pedidos Ementa-Digital::'}</title>

    <!-- Custom fonts for this template-->
    <link href="{$stRUTAS.vendor}fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{$stRUTAS.css}sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
</head>
<style>
    .mensaje {
        background-color: #f0f0f0;
        padding: 10px;
        border: 1px solid #ccc;
        margin: 20px;
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>
                {if ($stMENSAJE != '')}
                    <h1 id="miMensaje" class="h4 text-gray-900 mb-4 border-bottom-success mensaje">{$stMENSAJE}</h1>
                {/if}
                {if ($stERROR != '')}
                    <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
                {/if}
                <form method="post" id="form_pedidos" action="{$stACTION}" accept-charset="UTF-8">
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-body border-left-secondary">
                                    <div class="form-group">
                                        <label for="MesasSelect">Mesa</label>
                                        <select class="form-control" id="MesasSelect" name="MesasSelect">
                                            {$stMESAS}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="m-0 font-weight-bold text-primary">Pesquise e adicione produtos ao pedido da
                            mesa.</h6>
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-body border-left-secondary">
                                    <div class="form-row d-sm-flex align-items-center justify-content-between mb-3 ">
                                        <div class="form-group col-8 ">
                                            <select class="form-control select2" id="PedidosSelect"
                                                name="PedidosSelect">
                                                {$stCOLECCIONES}
                                            </select>
                                        </div>
                                        <div class="form-group col-1 ">
                                            <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                name="adicionar" id="adicionar">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus"> </i>
                                                </span>

                                            </button>
                                        </div>
                                        <div class="form-group col-2">
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
                                    </div>
                                    <div class="form-row d-sm-flex align-items-center justify-content-between mb-3 "
                                        id="listaPedidos">
                                        {if $stPEDIDO_DETALLE!=false}
                                            <p><em>Produtos adicionados ao pedido:</em></p>
                                            {foreach from=$stPEDIDO_DETALLE item=coleccion}
                                                <div class="pedido form-row mb-3 border-left-info  col-md-12"
                                                    data-id="{$coleccion.id}" data-cantidad="1">
                                                    <div class="form-group col-md-11 texto">
                                                        <label for="comentario">{$coleccion.nombre_pt}</label>
                                                        <input type="text" class="comentario form-control col-md-12"
                                                            placeholder="Insira um coment&aacute;rio" value="{$coleccion.comentario}">
                                                    </div>
                                                    <div class="eliminar-container form-group col-md-1"
                                                        style="align-content:flex-end;">
                                                        <button type="button" class="eliminar btn btn-info btn-circle"><span
                                                                class="icon text-white-80">
                                                                <i class="far fa-trash-alt"></i>
                                                            </span></button>
                                                    </div>
                                                </div>

                                            {/foreach}
                                        {/if}
                                        <input type="hidden" id="idsSeleccionados" name="idsSeleccionados"
                                            value="{$stID_SELECCIONADOS}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                                <button type="submit" class="btn btn-primary" name="{$stBTN_ACTION}">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"> </i>
                                    </span>
                                    <span class="text">{$stBTN_ACTION}</span>
                                </button>
                                <button type="submit" class="btn btn-primary" name="{$stBTN_REVERT}">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-history"></i>
                                    </span>
                                    <span class="text">{$stBTN_REVERT}</span>
                                </button>
                                <a href="{$stRUTAS.ped}ped.crear_emp.php" class="btn btn-danger">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-undo"></i>
                                    </span>
                                    <span class="text">Limpar dados</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>
<script src="{$stRUTAS.vendor}bootstrap/js/bootstrap.bundle.js"></script>
<script src="{$stRUTAS.vendor}jquery-easing/jquery.easing.js"></script>
<script src="{$stRUTAS.js}sb-admin-2.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });
        var mensajeDiv = $("#miMensaje");
        // Oculta el mensaje después de 3 segundos
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

        // Manejar el evento de envío del formulario
        $('#form_pedidos').submit(function(event) {
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
            // Si no se ha seleccionado un valor válido, evitar el envío del formulario


        });
    });
</script>

</html>