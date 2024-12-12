{include file="_cabecera.tpl"}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
        <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
        {if ($stSUPER_ADMIN == 'S')}
            <a href="{$stRUTAS.adm}adm.crear.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-user-plus fa-sm text-white-50"></i> criar novo administrador</a>
        {/if}
    </div>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>Apellido y Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Loja</th>
                    <th>Act.</th>
                    <th>Apagar</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Apellido y Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Loja</th>
                    <th>Act.</th>
                    <th>Apagar</th>
                </tr>
            </tfoot>
            <tbody>
                {foreach from=$stVALUES key=id item=value}
                    <tr id="Row_{$id}" class={if $value.enabled != "S"} "bg-gray-500 text-gray-100" {/if}>
                        <td>
                            <a href="{$stRUTAS.adm}adm.modificar.php?id={$id}" class="btn-sm
                        btn-primary btn-circle">
                                <i class="fas fa-user-edit" title="Editar"></i>
                            </a> &nbsp;
                        </td>
                        <td>
                            <p class="ta">{$value.apellido} {$value.nombre|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.email|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.telefono|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.loja|truncate:70:'...':true}</p>
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
                            <a href="{$stRUTAS.adm}adm.borrar.php?id={$id}" id="borrar{$id}"
                                class="btn-sm btn-danger btn-circle ta">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- Page level plugins -->
<script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
<script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
<script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $(document).ready(function() {
        $(document).on('click', "a[id^='borrar']", function(event) {
            // Prevenir el comportamiento predeterminado del enlace
            event.preventDefault();

            // Obtener la URL del enlace
            var url = $(this).attr("href");

            // Mostrar cuadro de diálogo de confirmación
            if (confirm(
                    "O Administrador ser\u00E1 removido permanentemente. Tem certeza de que deseja continuar?"
                )) {
                // Si el usuario acepta, redirigir a la URL del enlace
                window.location.href = url;
            } else {
                // Si el usuario cancela, no hacer nada
                return false;
            }
        });
        $(document).on('change', '.switch', function() {
            var id = $(this).attr('id').split('_')[1]; // Obtener el ID del checkbox
            var isChecked = $(this).is(':checked'); // Verificar si el checkbox está marcado
            var valueToSend = isChecked ? 'S' : 'N'; // Establecer el valor a enviar al servidor
            // Enviar datos al servidor usando AJAX
            $.ajax({
                url: '{$stRUTAS.adm}adm.listar.php', // URL del script en el servidor
                type: 'POST',
                data: {
                    Cid: id,
                    Cvalue: valueToSend
                }, // Datos a enviar al servidor

                success: function(response) {
                    // Acciones a realizar si la solicitud se completa exitosamente
                    if (response === 'ok') {
                        if (isChecked) {
                            // Si el checkbox está marcado, remover las clases bg-gray-500 y text-gray-100
                            $('#Row_' + id).removeClass(
                                'bg-gray-500 text-gray-100');
                            $('#Lab_' + id).text('Ativo');
                        } else {
                            // Si el checkbox está desmarcado, agregar las clases bg-gray-500 y text-gray-100
                            $('#Row_' + id).addClass(
                                'bg-gray-500 text-gray-100');
                            $('#Lab_' + id).text('Inat.');
                        }
                    } else {
                        console.log(response);
                        alert('Error al actualizar el estado del produto');
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
</script>
<!-- End of Main Content -->
{include file="_pie.tpl"}