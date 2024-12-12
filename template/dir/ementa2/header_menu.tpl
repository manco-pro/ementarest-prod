<header-component>
<div class="container-fluid fixed-top menu-translate d-none translate-menu"
    style="width: 100%; height: 100vh; z-index: 9999;">
    <div class=" container">
        <div class="row">
            <div class="col-12 p-4">
                <i class="fa-solid fa-xmark fs-1 float-end close-translate-btn" style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="container">
            <h2 class="fs-5">{$stMENSAJE_BIEN_TRAD}</h2>
            <p class="fs-6">{$stMENSAJE_BIEN_TRAD2}</p>
            <hr>
        </div>
        <div class="row pt-3 d-flex align-items-start justify-content-center justify-content-lg-center">

            <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                <a href="{$CURRENT_PAGE}?lang=pt{if $GET != ''}{$GET}{/if}"
                    class="d-flex justify-content-start left-ajuste">
                    <img src="{$stRUTAS.assets2}images/icon/portugal.png" alt="Português" width="28"
                        class="item me-2 p-0 me-lg-2">
                    <span class="text-center pt-1">Português</span>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                <a href="{$CURRENT_PAGE}?lang=es{if $GET != ''}{$GET}{/if}"
                    class="d-flex justify-content-start left-ajuste">
                    <img src="{$stRUTAS.assets2}images/icon/espanha.png" alt="Español" width="28"
                        class="item me-2 p-0 me-lg-2">
                    <span class="text-center pt-1">Español</span>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                <a href="{$CURRENT_PAGE}?lang=en{if $GET != ''}{$GET}{/if}"
                    class="d-flex justify-content-start left-ajuste">
                    <img src="{$stRUTAS.assets2}images/icon/reino-unido.png" alt="English" width="28"
                        class="item me-2 p-0 me-lg-2">
                    <span class="text-center pt-1">English</span>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                <a href="{$CURRENT_PAGE}?lang=fr{if $GET != ''}{$GET}{/if}"
                    class="d-flex justify-content-start left-ajuste">
                    <img src="{$stRUTAS.assets2}images/icon/franca.png" alt="Français" width="28"
                        class="item me-2 p-0 me-lg-2">
                    <span class="text-center pt-1">Français</span>
                </a>
            </div>

            <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                <a href="{$CURRENT_PAGE}?lang=de{if $GET != ''}{$GET}{/if}"
                    class="d-flex justify-content-start left-ajuste">
                    <img src="{$stRUTAS.assets2}images/icon/alemao.png" alt="Deutsch" width="28"
                        class="item me-2 p-0 me-lg-2">
                    <span class="text-center pt-1">Deutsch</span>
                </a>
            </div>

        </div>
    </div>
</div>
<header class="fixed-top">
    <div class="container-fluid position-absolute align-middle pt-menu-geral w-100">
        <p class="titulo-page text-white text-center fw-normal" style="z-index: 1; position: relative">{$stTITULO_PAGINA}</p>
    </div>
    <nav class="navbar">
        <div class="container-fluid ps-4 pe-3 pt-1 pb-1">

            <button class="btn btl-cl d-none newbtnnav"
                style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999"></button>
                {if $stTITULO_PAGINA == '' || $stTITULO_PAGINA == 'Menu' }            
            <button class="btn btl-cl btnclnew re" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft" aria-expanded="false"
                aria-label="Toggle navigation"
                style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999">
                <i class="fa-solid fa-bars icon-bar-color fs-4"></i>
            </button>
            {else}
                <button class="btn btl-cl newbtnnav"
                style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999">
                <a href="{$stRUTAS.ementa}menu.php"><i class="fa-solid fa-arrow-left-long fs-5 text-white"></i></a>
            </button>
           {/if}

            <!-- Menu Idiomas -->
            <div id="btn-translate" style="z-index:999">
                <a href="#" class="navbar-brand" role="button">
                    <i class="fa-solid fa-globe fs-4 float-end me-2 p-0 text-white" title="Idiomas"></i>
                    <span class="fs-6 fw-normal m-0 p-0 text-white">{strtoupper($stLANG)}</span>
                </a>
            </div>

            <!-- Menu principal item -->
            <div class="offcanvas offcanvas-start offcanvas-width-cl d-flex flex-column flex-shrink-0 pt-3 p-5 menu-lateral w-cl-100"
                tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel">

                <div class="offcanvas-header">
                    <button type="button"
                        class="btn-close btn-close-black position-absolute top-0 end-0 mt-3 me-2 focus-none"
                        data-bs-dismiss="offcanvas" aria-label="Close" style="z-index:9999;"></button>
                </div>
                <div class="d-flex justify-content-center align-content-center">
                    <a href="#">
                        <img src="{$stRUTAS.logos}{$stLOGO}" class="rounded-circle" width="100" alt="Logo">
                    </a>
                </div>
                <div>
                    <h3 class="m-0 pt-2 text-center">{$stNOMBRE_RESTO}</h3>
                    <p class="m-0 p-0 text-center">{$stMORADA}</p>
                    <hr class="bg-dark my-2 py-0">
                </div>

                <!-- Menu left scrolling -->
                <div class="mt-2 d-flex justify-content-center">
                    <ul class="nav nav-pills flex-column mb-auto largura">

                        <li class="nav-item my-1">
                            <a href="{$stRUTAS.ementa}index.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-house fs-5 pe-none me-2 text-white"></i>
                                {$stINICIO}
                            </a>
                        </li>

                        <li class="nav-item my-1 h-cl rounded-1">
                            <a href="{$stRUTAS.ementa}menu.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-file pe-none fs-5 me-2 text-white h-cl"></i>
                                {$stMENU}
                            </a>
                        </li>


                        <li class="my-1">
                            <a href="{$stRUTAS.ementa}bebidas.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-wine-glass fs-5 text-white me-2"></i>
                                {$stBEBIDAS}
                            </a>
                        </li>
                        <li class="my-1">
                            <a href="{$stRUTAS.ementa}cart.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-cart-shopping pe-none fs-5 text-white me-2"></i>
                                {$stCART}
                            </a>
                        </li>
                        <li class="mt-0">
                        <a href="{$stRUTAS.ementa}eventos.php" class="nav-link text-white fw-normal active"
                            aria-current="page">
                            <i class="fa-solid fa-calendar-days fs-4 pe-none me-2"></i>
                            {$stEVENTOS}
                        </a>
                    </li>
                        <li class="my-1">
                            <a href="{$stRUTAS.ementa}sugestoes.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-utensils fs-5 pe-none text-white me-2"></i>
                                {$stSUGESTOES}
                            </a>
                        </li>

                        <li class="my-1">
                            <a href="{$stRUTAS.ementa}opiniao.php" class="nav-link text-white fw-normal active"
                                aria-current="page">
                                <i class="fa-solid fa-comments fs-5 pe-none text-white me-2"></i>
                                {$stOPINIAO}
                            </a>
                        </li>
                    </ul>

                </div>

                <!-- Siga-nos -->
                <div class="container">
                    <hr class="bg-dark">
                    <div class="d-flex justify-content-center">
                        {if isset($stFACEBOOK)}
                            <a href="{$stFACEBOOK}"
                                class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                <i class="fa-brands fa-facebook fs-2 p-0 me-2 color-primary rede-s-hover"></i>
                            </a>
                        {/if}
                        {if isset($stINSTAGRAM)}
                            <a href="{$stINSTAGRAM}"
                                class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                <img id="instagrambtn" src="{$stRUTAS.assets2}images/icon/instagram.png" alt="Português" width="32"
                                    class="me-2">
                            </a>
                        {/if}
                        {if isset($stTRIPADVISOR)}
                            <a href="{$stTRIPADVISOR}"
                                class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                <img id="tripadvisor" src="{$stRUTAS.assets2}images/icon/tripadvisor.png" alt="Português" width="32"
                                    class="me-2">
                            </a>
                        {/if}
                        {if isset($stGOOGLEMAPS)}
                            <a href="{$stGOOGLEMAPS}"
                                class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                <img id="google-maps" src="{$stRUTAS.assets2}images/icon/google-maps.png" alt="Português" width="32"
                                    class="me-2">
                            </a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
</header-component>