{include file="_cabecera.tpl"}
<div class="card shadow">
    <form method="POST" name="lojas_select" id="lojas_select" action="{$stACTION}" accept-charset="utf-8">
        {if ($stSUPER_ADMIN == 'S')}

            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <div class="col-lg-4">
                    <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                    <select class="form-control" id="lojasSelect" name="loja_id">
                        {$stLOJAS_SELECT}
                    </select>
                </div>
                <div>
                    {if $stLOJA_ID !=-1}
                        <a href="{$stRUTAS.eve}eve.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Evento</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.eve}eve.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Evento</a>
            </div>
        {/if}
    </form>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>Evento</th>
                    <th>Data inicio</th>
                    <th>Data de finaliza&ccedil;&atilde;o</th>
                    <th>Act.</th>
                    <th>editar</th>
                    <th>apagar</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Evento</th>
                    <th>Data inicio</th>
                    <th>Data de finaliza&ccedil;&atilde;o</th>
                    <th>Act.</th>
                    <th>editar</th>
                    <th>apagar</th>
                </tr>
            </tfoot>
            <tbody>
                {foreach from=$stVALUES key=id item=value}
                    <tr id="Row_{$value.id}" class= {if $value.enabled != "S"} "bg-gray-200 text-gray-900" {/if}>
                        <td>
                            <img class="ta" style="max-width: 60px; max-height: auto;"
                                src="{$stRUTAS.images_eve}{$value.imagen}">
                        </td>
                        <td>
                            <p class="ta">{$value.nombre}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.inicio}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.fin}</p>
                        </td>
                        <td>
                            <div class="checkbox-wrapper-14 ta">
                                <input id="Check_{$id}" type="checkbox" class="switch"
                                    {if $value.enabled == 'S'}checked{/if}>
                                <label id="Lab_{$id}" for="Check_{$id}">
                                    {if $value.enabled == 'S'}Ativo{else}Inat.{/if}
                                </label>
                            </div>
                        </td>
                        <td>
                            <a href="{$stRUTAS.eve}eve.modificar.php?id={$id}" class="btn-sm
                            btn-primary btn-circle ta">
                                <i class="fas fa-edit" title="Editar"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{$stRUTAS.eve}eve.borrar.php?id={$id}" id="borrar_{$id}" class="btn-sm
                            btn-danger btn-circle ta">
                                <i class="fas fa-trash" title="Apagar"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
<!-- Page level plugins -->
<script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
<script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
<script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "asc"]
            ],
            "stateSave": true
        });
    });

    $(document).ready(function() {
        $(document).on('change', 'select#lojasSelect', function() {
            $('form#lojas_select').submit();
        });

        $(document).on('click', "a[id^='borrar']", function(event) {
            event.preventDefault();
            var url = $(this).attr("href");
            if (confirm(
                    "O Evento ser\u00E3o exclu\u00EDdo permanentemente. Voc\u00EA tem certeza que quer continuar?"
                )) {
                window.location.href = url;
            } else {
                return false;
            }
        });
        $(document).ready(function() {
            $(document).on('change', '.switch', function() {
                var id = $(this).attr('id').split('_')[1]; // Obtener el ID del checkbox
                var isChecked = $(this).is(':checked'); // Verificar si el checkbox está marcado
                var valueToSend = isChecked ? 'S' :
                    'N'; // Establecer el valor a enviar al servidor

                // Enviar datos al servidor usando AJAX
                $.ajax({
                    url: '{$stRUTAS.eve}eve.listar.php', // URL del script en el servidor
                    type: 'POST',
                    data: {
                        Cid: id,
                        Cvalue: valueToSend
                    }, // Datos a enviar al servidor

                    success: function(response) {
                        // Acciones a realizar si la solicitud se completa exitosamente
                        if (response == 'ok') {
                            if (isChecked) {
                                // Si el checkbox está marcado, remover las clases bg-gray-500 y text-gray-100
                                $('#Row_' + id).removeClass(
                                    'bg-gray-200 text-gray-900');
                                $('#link_' + id).removeClass(
                                    'text-gray-900');
                                $('#Lab_' + id).text('Ativo');
                            } else {
                                // Si el checkbox está desmarcado, agregar las clases bg-gray-500 y text-gray-100
                                $('#Row_' + id).addClass(
                                    'bg-gray-200 text-gray-900');
                                $('#link_' + id).addClass(
                                    'text-gray-900');
                                $('#Lab_' + id).text('Inat.');
                            }
                        } else {
                            alert('Error al actualizar el estado del evento');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Acciones a realizar si la solicitud falla
                        console.log('Error al enviar la solicitud AJAX');
                        console.log('Estado: ' + status);
                        console.log('Error: ' + error);
                    }
                });
            });
        });
    });
</script>

<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
{include file="_pie.tpl"}