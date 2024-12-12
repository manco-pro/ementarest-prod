{include file="ementa1/header.tpl"}

<body class="w-100 vh-100" style="background: rgba(1, 8, 19, 0.7) url('{$stRUTAS.assets}images/bg-index-y.jpg') no-repeat;
background-position:50% 50%; background-size: cover; background-blend-mode:overlay; -webkit-backdrop-filter: blur(2px);
  backdrop-filter: blur(2px);">
    {include file="ementa1/header_menu.tpl"}
    <main>
        <div class="container overflow-hidden p-4">
            <div class="row">
                <img src="{$stRUTAS.logos}{$stLOGO}" alt="Logo Gato"
                    class="col-12 mt-5 mb-2 img-logo-m-cl rounded mx-auto d-block">
                <h1 class="col-12 mb-4 text-start text-white fs-1 fw-semibold text-center">{$stNOMBRE_RESTO}</h1>
                <p class="col-12 col-sm-12 mb-2 text-white text-center fs-6">
                    <i class="fa-solid fa-location-dot me-2"></i>
                    {$stMORADA}
                </p>
            </div>
        </div>
        <div class="container overflow-hidden pt-9-cl">
            <a class="btn btn-warning size-btn-cl fw-bold text-uppercase fs-se rounded mx-auto d-block"
                href="{$stRUTAS.ementa}menu.php" role="button">{$stMENU}</a>
            <a class="btn btn-danger size-btn-cl fw-bold text-uppercase fs-se w-auto rounded mx-auto d-block"
                href="{$stRUTAS.ementa}bebidas.php" role="button">{$stBEBIDAS}</a>
            <a class="btn btn-success size-btn-cl fw-bold text-uppercase fs-se w-auto rounded mx-auto d-block"
                href="{$stRUTAS.ementa}sugestoes.php" role="button">{$stSUGESTOES}</a>
        </div>
        {if isset($stMESA)}
            <div class=" d-flex me-3"
                style="z-index: 9999; width: 45px; height: 45px; position: fixed; bottom: 80px; right: 15px ">
                <a href="#" class="rounded-circle bg-danger btn-an" id="Empregado_de_Mesa"
                    style="width: 45px; height: 45px;">
                    <img src="{$stRUTAS.images}croupier.png" class="btn-ic" alt="">
                </a>
            </div>
        {/if}

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
    </main>
    <footer class="bg-black bg-opacity-25 fixed-bottom m-0 pt-3" style="z-index: 0;">
        <div class="container-fluid">
            <nav>
                <p class="text-center text-white text-size-cl-m-f">
                    <a href="{$stRUTAS.ementa}termos.html" class="link-light">{$stTERMOSeCOND}</a>
                <p class="text-center text-warning text-size-cl-m-f px-3">{$stIVA}</p>
                </p>
            </nav>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
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
    </script>
</body>

</html>