{include file="template/dir/ementa2/header.tpl"}

<body style="background: rgba(238, 233, 225, 0.9) url('{$stRUTAS.assets2}images/bg-index-tow.jpeg') repeat;
background-position:top center; background-size: cover; background-blend-mode:overlay; height: 100vh;">
  {include file="template/dir/ementa2/header_menu.tpl"}
  <main>
    <div class="container" style="margin-top: 4rem; padding-bottom: 4rem;">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 p-2">
        {foreach from=$stCOLECCIONES key=id item=Coleccion}
          <div class="col icon-cl-effect">
            <div class="card h-80 " style="border-radius: 12px;">
              <img src="{$stRUTAS.images_col}{$Coleccion.imagen}" class="card-img-top" alt=""
                style="border-radius: 12px 12px 0 0;">
              <div class="card-body shadow" style="border-radius: 12px;">
                <h6 class="card-title fs-6">{$Coleccion[$NOMBRE]}</h6>
                <p class="card-text fs-6 fw-bold mb-0 pb-0">{$Coleccion.precio}€{if $Coleccion.unidad==2}/kg{/if}</p>

                <div class="position-absolute pe-2" style="top: 35%; right: -10px; float: right;">
                  <a href="#" class="link-underline link-underline-opacity-0" style="text-decoration: none;"
                    data-bs-toggle="modal" data-bs-target="#modalinfo{$Coleccion.id}" data-bs-whatever="@mdo">
                    <div class="badge text-wrap text-black me-3 shadow"
                      style="background-color: rgb(255, 255, 255); font-size: 1.1rem; border-radius: 50%; width: 40px; height: 40px; padding: 0.5rem 0.4rem;">
                      <i class="fa-solid fa-info text-black text-center m-0 p-0" style="font-size: 1.4rem;"></i>
                    </div>
                  </a>
                </div>

                <div class="position-absolute pe-2" style="top: 50%; right: 7px; float: right;">
                  <a href="#" class="link-underline link-underline-opacity-0 ADD" style="text-decoration: none;"
                    data-bs-toggle="modal" data-bs-target="#msnalert" data-value="{$Coleccion.id}">
                    <div class="badge text-wrap text-black shadow alertm"
                      style="background-color: rgb(255, 208, 0); font-size: 1.1rem; border-radius: 50%; width: 40px; height: 40px; padding: 0.6rem 0.4rem;">
                      <i class="fa-solid fa-plus text-black text-center m-0 p-0" style="font-size: 1.2rem;"></i>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        {/foreach}

      </div>
    </div>
    </div>

    <!-- Modal detalhes Itens-->
    {foreach from=$stCOLECCIONES key=id item=Coleccion}
      <div class="modal fade" id="modalinfo{$Coleccion.id}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{$stDETELLES_MENSAJE}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <!--Alerte add -->
              <div class="alert alert-success alert-dismissible fade show mmalert d-none" role="alert">
                <strong>{$stMENSAJE1}</strong>
                <button type="button" class="btn-close fechaemmodal"></button>
              </div>

              <div class="w-100 h-100 px-3 pt-sm-4 mb-3 border-r bg-danger"
                style="background-image: url('{$stRUTAS.images_col}{$Coleccion.imagen}'); background-repeat: no-repeat; background-position: 40% 60%; background-size:cover;">
                <div class="w-100 h-100 px-0 pb-3 m-0 d-flex justify-content-end" style="padding-top: 8.5rem;">

                  <a href="#" class="link-underline link-underline-opacity-0 ADD" data-value="{$Coleccion.id}"
                    style="text-decoration: none;" >
                    <div class="badge text-wrap text-black shadow alertemodal"
                      style="background-color: rgb(255, 208, 0); font-size: 1.1rem; border-radius: 50%; width: 40px; height: 40px; padding: 0.6rem 0.4rem;">
                      <i class="fa-solid fa-plus text-black text-center m-0 p-0" style="font-size: 1.2rem;"></i>
                    </div>
                  </a>
                </div>
              </div>
              <div class="mb-4 px-2 py-2" style="margin-top: -18px;">
                <div class="row">
                  <div class="col-6 text-start ps-3 fs-4 fw-bold mt-2">{$Coleccion[$NOMBRE]}</div>
                  <div class="col-6 text-end pe-3 mt-2 fs-3">{$Coleccion.precio} &euro;{if $Coleccion.unidad==2}/kg{/if}
                  </div>

                  <hr class="border-light mt-3 mb-3">
                  {if {$Coleccion[$DESCRIPCION]}!=''}
                    <div class="col-12 text-start ps-2">
                      <p>
                        <strong>{$stDESCRIPCION}</strong>
                      <p>{$Coleccion[$DESCRIPCION]}</p>
                      </p>
                    </div>
                  {/if}
                  <div class="col-12 h-100" style="border-radius: 8px; border: 1px solid #dddddd;">
                    <div class="row">
                      <div class="col-9 text-start m-0 p-0">
                        <p class="px-3 pt-3">
                          <strong>{$stRECOMENDAR}</strong>
                        </p>
                      </div>
                      <div class="col-3 text-end" id="compartir{$Coleccion.id}" data-title="{$Coleccion[$NOMBRE]}"
                        data-text="{htmlspecialchars($Coleccion[$DESCRIPCION]|default: $stMENSAJE_RECOMENDAR)}"
                        data-url="{$stLINKCOMPARTIR}&col={$Coleccion.id}">
                        <i class="fa-regular fa-thumbs-up text-success pt-3"
                          style="font-size: 2.6rem; cursor: pointer;"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- PRODUTOS SUGERIDO -->
              {if $Coleccion.sugerencias_colecciones_ids != ''}
                <div class="bg-light rounded my-4 p-2 fw-bold text-dark">
                  {$stBEBIDA_SUGERIDA}
                </div>
                {foreach from=$Coleccion.sugerencias_colecciones_ids item=coleccion}
                  <div class="container">
                    <div class="row mb-3">
                      <div class="col-3 me-3">
                        <img src="{$stRUTAS.images_col}S{$coleccion.imagen}" width="56" height="56" alt=""
                          class="rounded-circle">
                      </div>
                      <div class="col fs-6 lh-sm mt-2">
                        <p class="m-0 p-0 fw-bold"><a
                            class="link-dark text-decorado-none">{$coleccion[$NOMBRE]|default:$coleccion.nombre_pt}</a></p>
                        <p class="m-0 p-0">{$coleccion.precio}&euro;</p>
                      </div>
                    </div>
                  </div>
                  <hr>
                {/foreach}
              {/if}

            </div>
          </div>
        </div>
      </div>
    {/foreach}
  </main>



  {include file="ementa2/footer_menu.tpl"}

{include file="ementa2/footer.tpl"}