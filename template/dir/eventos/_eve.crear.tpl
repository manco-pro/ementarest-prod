{include file="_cabecera.tpl"}

<script src="{$stRUTAS.vendor}/cropperjs/cropper.min.js"></script>
<link rel="stylesheet" href="{$stRUTAS.vendor}/cropperjs/cropper.min.css">

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>

    {if ($stMENSAJE != '')}
        <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
    {/if}
    {if ($stERROR != '')}
        <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
    {/if}
    <form method="POST" action="{$stACTION}" accept-charset="utf-8">
        <!-- Content Row -->
        <div class="row ">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    <p class='mb-0 small'>Insira o nome da categoria.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="">
                            <div class="form-group" id="campoPt">
                                <label for="textoPt">Nome</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{$stNOMBRE}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Imagens</h6>
                    <p class="mb-0 small">adicione uma imagem para promover seu evento.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-group">
                            <div class="form-group">
                                <a href="javascript:void(0)" id="botonArchivo" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-file-image"></i>
                                    </span>
                                    <span class="text">Adicionar foto</span>
                                </a>
                                <input type="file" name='imagen' class="form-control-file" name="inputImage"
                                    id="inputImage" value="{$stIMAGEN}" accept="image/*" style="display: none">
                            </div>
                            <div class="form-group">
                                <img id="imageB" src="{if ($stIMAGEN != '')}{$stRUTAS.images_eve}{$stIMAGEN}{/if}"
                                    alt="" style="max-width: 720px; max-height: auto;">
                                <input id="imageBdata" name="imageB" type="hidden" value="">

                            </div>

                        </div>
                        <div class="form-group" id="CropperDiv" style="display:none">
                            <a href="javascript:void(0)" id="guardar" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="far fa-save"></i>
                                </span>
                                <span class="text">Concluir a edi&ccedil;&atilde;o</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Outras Informa&ccedil;&otilde;es</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="horaInactivo">Data de In&iacute;cio:</label>
                                <input type="date" class="form-control" id="inicio" name="inicio"
                                    value="{$stINICIO}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="horaFin">Data de finaliza&ccedil;&atilde;o:</label>
                                <input type="date" class="form-control" id="fin" name="fin"
                                    value="{$stFIN}">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="enabled">Habilitado</label>
                            <input type="checkbox" name="enabled" id="enabled" {$stENABLED}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                    <div><button type="submit" class="btn btn-primary" id="buttonForm" name="{$stBTN_ACTION}">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"> </i>
                            </span>
                            <span class="text">{$stBTN_ACTION}</span>
                        </button>
                        <a href="{$stRUTAS.eve}eve.listar.php?loja_id={$stLOJA_ID}" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.eve}eve.borrar.php?id={$stID}&loja_id={$stLOJA_ID}" class="btn btn-danger"
                                id="borrar" name="{$stBTN_ACTION_D}">
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
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
{literal}<script>
        $(document).ready(function() {
            var $imageB = $('#imageB');
            var $imageBdata = $('#imageBdata');

            var cropper;
            $('#botonArchivo').on('click', function() {
                // Simular clic en el input file oculto
                $('#inputImage').click();
            });
            $('#inputImage').on('change', function(event) {
                var files = event.target.files;
                var reader = new FileReader();

                if (files && files.length > 0) {
                    reader.onload = function() {
                        $imageB.attr('src', reader.result);

                        // Destruir el cropper si ya existe
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Crear un nuevo cropper
                        cropper = new Cropper($imageB[0], {
                            zoomable: true,
                            zoomOnWheel: true,
                            zoomOnTouch: true,
                            movable: true,
                            rotatable: true,
                            viewMode: 3,
                            aspectRatio: 16 /
                                9, // Puedes ajustar esto seg&uacute;n tus necesidades
                        });
                        $('#CropperDiv').show();
                    };

                    reader.readAsDataURL(files[0]);
                }
            });

            // Configuraci&oacute;n de los botones
            $('#guardar').on('click', function() {
                // Obtener la imagen editada en base64
                var editedImageB = cropper.getCroppedCanvas({maxWidth: 1920, maxHeight: 1024}).toDataURL();

                // Aqu&iacute; puedes enviar la imagen a tu servidor o hacer cualquier otra acci&oacute;n
                // Por ejemplo, puedes crear un nuevo elemento de imagen para mostrar la imagen editada
                //var editedImageElement = document.createElement('img');
                //editedImageElement.src = editedImage;
                //document.body.appendChild(editedImageElement);
                $imageB.attr('src', editedImageB);
                $imageBdata.attr('value', editedImageB);
                $imageB.show();

                $('#CropperDiv').hide();
                cropper.destroy();
            });
        });

        $(document).ready(function() {
            $("#borrar").click(function(event) {
                event.preventDefault();
                var url = $(this).attr("href");
                if (confirm(
                        "O evento ser\u00E3o exclu\u00EDdo permanentemente. Voc\u00EA tem certeza que quer continuar?"
                    )) {
                    window.location.href = url;
                } else {
                    return false;
                }
            });
            // Manejar clics en los elementos de lista de idiomas

        });
</script>{/literal}
{include file="_pie.tpl"}