{include file="ementa2/header.tpl"}

<body style="background: rgba(238, 233, 225, 0.9) url('{$stRUTAS.assets2}images/bg-index-tow.jpeg') repeat;
background-position:top center; background-size: cover; background-blend-mode:overlay; height: 100vh;">

    {include file="ementa2/header_menu.tpl"}
    <main>
        <div class="container px-5 pt-0 pb-0 p-lg-5 w-100">

            <div class="row pt-4 pt-sm-5">
                <div class="col-sm-12 d-flex justify-content-center mt-5 mb-2 mb-sm-5 my-lg-3 my-xxl-5">
                    <a href="#">
                        <img src="{$stRUTAS.logos}{$stLOGO}" alt="Logo rest"
                            class="rounded-circle logo-size d-flex justify-content-center">
                        <p class="text-black fs-4 text-center mt-2">{$stNOMBRE_RESTO}</p>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 my-auto">
                    <a href="{$stRUTAS.ementa}menu.php" style="text-decoration: none;">
                        <div class="card d-flex justify-content-center px-2 py-4 py-sm-5 px-lg-2 py-lg-5 border-0 shadow menu-index-green mb-3"
                            style="border-radius: 12px;">
                            <div class="card-body" style="margin: 0 auto;">
                                <p class="text-white text-uppercase fs-6 fs-lg-4 fw-normal mb-0" style="margin: 0 auto">
                                    <i class="fa-solid fa-clipboard fs-3 text-white me-2"></i>
                                    {$stMENU}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 my-auto">
                    <a href="{$stRUTAS.ementa}bebidas.php" style="text-decoration: none;">
                        <div class="card d-flex justify-content-center px-2 py-4 py-sm-5 px-lg-2 py-lg-5 border-0 shadow menu-index-bege mb-3"
                            style="border-radius: 12px;">
                            <div class="card-body" style="margin: 0 auto;">
                                <p class="text-white text-uppercase fs-6 fs-lg-4 fw-normal mb-0" style="margin: 0 auto">
                                    <i class="fa-solid fa-wine-glass fs-3 text-white me-2"></i>
                                    {$stBEBIDAS}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 my-auto">
                    <a href="{$stRUTAS.ementa}sugestoes.php" style="text-decoration: none;">
                        <div class="card d-flex justify-content-center px-2 py-4 py-sm-5 px-lg-2 py-lg-5 border-0 shadow menu-index-gold mb-3"
                            style="border-radius: 12px;">
                            <div class="card-body" style="margin: 0 auto;">
                                <p class="text-white text-uppercase fs-6 fs-lg-4 fw-normal mb-0" style="margin: 0 auto">
                                    <i class="fa-solid fa-stroopwafel fs-3 text-white me-2"></i>
                                    {$stSUGESTOES}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
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

    <footer class="fixed-bottom w-100" style="z-index: 1;">
        <div class="container">
            <hr class="w-75 my-2" style="margin: 0 auto;">
            <p class="text-center text-white text-size-cl-m-f">
                <a href="{$stRUTAS.ementa}termos.html" class="link-dark fw-bold py-0"
                    style="color: #4e1d01; text-decoration: underline;">{$stTERMOSeCOND}</a>
            <p class="text-center text-dark fw-bold py-0 px-0" style="font-size: small;">{$stIVA}</p>
            </p>
        </div>
    </footer>
    <!--<footer-component></footer-component>-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{$stRUTAS.assets2}js/scripts-cl.js"></script>
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