{include file="_cabecera.tpl"}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div class="card shadow mb-4">
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
                        <a href="{$stRUTAS.ped}ped.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Pedido</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.ped}ped.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Pedido</a>
            </div>
        {/if}
    </form>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active " id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">vendas
            </button>
            <button class="nav-link " id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Graficos
            </button>
        </div>
    </nav>

    <div class="tab-content mt-4" id="nav-tabContent">
        <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefechas"
                aria-expanded="false" aria-controls="collapsefechas" style="color: inherit; text-decoration: none;">
                <i class="far fa-calendar-alt"></i>
                <span>Filtrar datas</span>
            </a>
            <div id="collapsefechas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"
                style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <div class="form-row">
                        <div class="form-group col-lg-1">
                            <label for="min">Desde: </label>
                            <input class="form-control " type="text" id="min" name="min">
                        </div>
                        <div class="form-group col-lg-1">
                            <label for="max">At&eacute;: </label>
                            <input class="form-control" type="text" id="max" name="max">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Venta n&deg;</th>
                            <th>Data/hora</th>
                            <th>Mesa</th>
                            <th>Montante &euro;</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Pedido n&deg;</th>
                            <th>Data/hora</th>
                            <th>Mesa</th>
                            <th>Montante &euro;</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        {if $stVALUES != false}
                            {foreach from=$stVALUES key=id item=value}
                                <tr>
                                    <td>
                                        <a href="#" id="ver{$id}" class="btn-sm btn-primary btn-circle ta">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="ta">{$id}</p>
                                    </td>
                                    <td>
                                        <p class="ta">{$value.fecha}</p>
                                    </td>
                                    <td>
                                        <p class="ta">{$value.mesa}</p>
                                    </td>
                                    <td>
                                        <p class="ta">{$value.total} </p>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade show  " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="container-fluid">
                <!-- inicio CARDS -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-dark shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            volume de vendas do m&ecirc;s</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <strong>{$stVENTASCANT}</strong>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-concierge-bell fa-2x" style="color: #5a5c69;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Tempo m&eacute;dio de atendimento x mesa </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <strong>{$stTIEMPO_PROMEDIO}</strong> min.
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x" style="color: #3F72AF;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Vendas acumuladas do m&ecirc;s</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <strong>{$stVENTASMES}</strong>
                                            &euro;
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-euro-sign fa-2x" style="color: #1CC88A;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Distribui&ccedil;&atilde;o de Vendas: Comidas vs. Bebidas
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Comidas: %
                                            <strong>{$stPORCENTAJE_COMIDAS}</strong> / Bebidas: %
                                            <strong>{$stPORCENTAJE_BEBIDAS}</strong>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x" style="color: #F6C23E;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin CARDS -->
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Vendas Mensais</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="myAreaChart" width="428" height="128"
                                        style="display: block; height: 160px; width: 536px;"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                                <hr>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="meses" id="meses6" value="6">
                                    <label class="form-check-label" for="meses6">6 meses</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="meses" id="meses12" value="12"
                                        checked>
                                    <label class="form-check-label" for="meses12">12 meses</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">TOP 12 Produtos com Stock Baixo </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {if $stSTOCK_FALTANTE != false}
                                        {foreach from=$stSTOCK_FALTANTE item=stock}
                                            <div class="col-6">
                                                <h4 class="small font-weight-bold">{$stock.nombre} - quant. {$stock.cantidad}
                                                    <span class="float-right">{$stock.porc}%</span>
                                                </h4>
                                                <div class="progress mb-4">
                                                    <div class="progress-bar bg-{$stock.color1}" role="progressbar"
                                                        style="width: {$stock.porc}%" aria-valuenow="40" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        {/foreach}
                                    {else}
                                        <div class="col-12">
                                            <h4 class="small font-weight-bold">N&atilde;o h&aacute; produtos com stock baixo
                                            </h4>
                                        </div>

                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Top 7 produtos mais vendidos</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="myPieChart" width="428" height="128"
                                        style="display: block; height: 160px; width: 536px;"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                                <hr>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="top" id="topnow" value="topnow"
                                        checked>
                                    <label class="form-check-label" for="topnow">m&ecirc;s em curso</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="top" id="top3meses"
                                        value="top3meses">
                                    <label class="form-check-label" for="top3meses">&uacute;ltimos 3 meses</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- modal -->
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
                    <div id="ListaVendaTabla">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Sair</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="loja_id" name="loja_id" value="{$stLOJA_ID}">
    <!-- Page level plugins -->
    <script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
    <script src="{$stRUTAS.vendor}chart.js/Chart.min.js"></script>
    <script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
    <script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{$stRUTAS.js}chart-area.js"></script>
    <script src="{$stRUTAS.js}chart-pie.js"></script>

    <!-- Page level custom scripts -->
    <script>
        //modal
        $(document).ready(function() {
            $("[id^='ver']").on('click', function() {
                var id = $(this).attr('id').substring(3);
                var loja_id = $('#loja_id').val();
                $.ajax({
                    url: '{$stRUTAS.ven}fac.getdetalle.php',
                    type: 'POST',
                    data: {
                        id: id,
                        loja_id: loja_id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#ListaVendaTabla').html(data);
                        $('#MesaModal').html('Venda n&deg; ' + id);
                        $('#MesaModalDiv').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores
                        console.error(xhr.statusText);
                    }
                });
            });
        });

        //chart area
        document.getElementById("meses6").addEventListener("click", function() {
            createOrUpdateChart(initialData6);
        });
        document.getElementById("meses12").addEventListener("click", function() {
            createOrUpdateChart(initialData12);
        });
        var initialData12 = {
            labels: {$stMESES12},
            data: {$stTOTALES12},
        };
        var initialData6 = {
            labels: {$stMESES6},
            data: {$stTOTALES6},
        };
        createOrUpdateChart(initialData12);
        //chart pie
        var datos = {$stCANTIDAD12};
        var etiquetas = {$stNOMBRES12};
        var datos3 = {$stCANTIDAD12_3MESES};
        var etiquetas3 = {$stNOMBRES12_3MESES};
        generarGrafico(datos, etiquetas);

        document.getElementById("topnow").addEventListener("click", function() {
            generarGrafico(datos, etiquetas);
        });
        document.getElementById("top3meses").addEventListener("click", function() {
            generarGrafico(datos3, etiquetas3);
        });

        $(document).ready(function() {
            // Inicializar Datepickers
            $("#min").datepicker({ dateFormat: 'yy-mm-dd' });
            $("#max").datepicker({ dateFormat: 'yy-mm-dd' });

            // DataTable inicializaci&oacute;n
            var table = $('#dataTable').DataTable({
                "order": [
                    [2, "DESC"]
                ],
                "stateSave": true
            });

            // Filtro de rango de fechas
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var date = new Date(data[2]); // Columna con la fecha

                    if (
                        (min === null && max === null) ||
                        (min === null && date <= max) ||
                        (min <= date && max === null) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            // Event listener para los filtros de fecha
            $('#min, #max').change(function() {
                table.draw();
            });
        });

        $(document).ready(function() {
            $('select#lojasSelect').on('change', function() {
                $('form#lojas_select').submit();
            });

        });
    </script>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
{include file="_pie.tpl"}