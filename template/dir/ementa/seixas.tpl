{include file="ementa/header.tpl"}

<body class="w-100 vh-100" style="background: rgba(1, 8, 19, 0.7) url('{$stRUTAS.assets}images/bg-index-y.jpg') no-repeat;
background-position:50% 50%; background-size: cover; background-blend-mode:overlay; -webkit-backdrop-filter: blur(2px);
  backdrop-filter: blur(2px);">

    <main>
        <div class="container overflow-hidden p-4">
            <div class="row">
                
                    <a href="seixas.php?loja=2">
                        <img src="{$stRUTAS.images}LOGO.png" alt="Logo Gato"
                            class="col-12 mt-5 mb-2 img-logo-m-cl rounded mx-auto d-block">
                        <h1 class="col-12 mb-4 text-start text-white fs-1 fw-semibold text-center">Aqui Ha Gato</h1>
                        <p class="col-12 col-sm-12 mb-2 text-white text-center fs-6">
                            <i class="fa-solid fa-location-dot me-2"></i>
                            Seixas, Portugal
                        </p>
                    </a>
                
                {*<div class="row">
                    <a href="start.php?loja=2">
                        <img src="{$stRUTAS.images}Ancora.png" alt="Logo Gato"
                            class="col-12 mt-5 mb-2 img-logo-m-cl rounded mx-auto d-block">
                        <h1 class="col-12 mb-4 text-start text-white fs-1 fw-semibold text-center">Aqui Ha Gato</h1>
                        <p class="col-12 col-sm-12 mb-2 text-white text-center fs-6">
                            <i class="fa-solid fa-location-dot me-2"></i>
                            Vila Praia de Âncora, Portugal
                        </p>
                    </a>
                </div>*}
            </div>
        </div>
        {*<div class="container overflow-hidden pt-9-cl">
            <a class="btn btn-warning size-btn-cl fw-bold text-uppercase fs-se rounded mx-auto d-block"
                href="{$stRUTAS.ementa}menu.php" role="button">Menu</a>
            <a class="btn btn-danger size-btn-cl fw-bold text-uppercase fs-se w-auto rounded mx-auto d-block"
                href="{$stRUTAS.ementa}bebidas.php" role="button">Bebidas</a>
            <a class="btn btn-success size-btn-cl fw-bold text-uppercase fs-se w-auto rounded mx-auto d-block"
                href="{$stRUTAS.ementa}sugestoes.php" role="button">Sugest&otilde;es</a>
        </div>*}
    </main>
    <footer class="bg-transparent  pt-0 pb-5 pb-md-3" style="z-index: 1;">
        <p class="text-center text-white text-size-cl-m-f mt-4 mb-5"><a href="{$stRUTAS.ementa}termos.html"
                class="link-light">Termos e condi&ccedil;&otilde;es</a></p>
    </footer>


    <!--<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>