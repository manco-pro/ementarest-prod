{include file="template/dir/ementa2/header.tpl"}

<body>
  {include file="template/dir/ementa2/header_menu.tpl"}
  <main>
    <div class="container" style="margin-top: 3rem; padding: 1.8rem;">

      <div class="row">
        <div class="col-12 bg-dark bg-opacity-75 w-100 h-100 px-3 pt-3 pb-1 mb-3 rounded-3 msnisert">
          <p class="fs-6 fw-normal text-white initmsn"><strong>Cart</strong> controle e rapidez dos seus pedidos.
            Confira sempre com atenção o pedidos.</p>
        </div>
        {if isset($stPRODUCTOS)}
          <form id="Formcart">



            <!--Item -->
            {foreach from=$stPRODUCTOS item=producto key=key }
              <div class="col-12 bg-white p-2 mb-3" style="border-radius: 0.6rem;" id="DIV_{$producto.id}">
                <div class="row">
                  <div class="col-4 col-sm-2 col-lg-1">
                    <div class="bg-white w-100 h-100 bg-image"
                      style="border-radius: 0.6rem; background-image: url('{$stRUTAS.images_col}{$producto.imagen}'); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                    </div>
                  </div>
                  <div class="col m-0 p-0">
                    <div class="d-flex flex-column justify-content-around align-items-baseline">
                      <h2 class="fs-6 fw-bold mb-0">{$producto.nombre_pt}</h2>
                      <p class="fs-6 mb-0" id="PRECIO_{$producto.id}">{$producto.precio} &euro;</p>
                    </div>
                  </div>
                  <div class="col col-sm-3 col-lg-2">
                    <div class="float-end position-relative"><i id="I_{$producto.id}" class="fa-solid fa-xmark pe-2"
                        style="color: gray;"></i></div>
                    <div class="d-flex flex-row flex-nowrap justify-content-around align-items-baseline h-100 pt-5">
                      <i class="fa-solid fa-circle-minus fs-4 m-0 align-middle" style="color: #cccccc;"
                        id="Menos_{$producto.id}"></i>
                      <p class="fs-6 fw-bold" id="Cantidad_{$producto.id}">{$producto.cantidad}</p>
                      <i class="fa-solid fa-circle-plus fs-4 m-0" id="Mas_{$producto.id}"></i>
                    </div>
                  </div>
                </div>
              </div>
              <hr id="HR_{$producto.id}">
            {/foreach}
          </form>
        {/if}


        <div class="col-12 mt-3 mb-5">
          <!-- Campo cupom de desconto 
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Cupom de desconto" aria-label="Recipient's username"
              aria-describedby="button-addon2">
            <button class="btn btn-dark" type="button" id="button-addon2">Aplicar</button>
          </div>-->

          <!-- Valor toral -->
          <div class="container mt-4 mb-4" style="padding-left: 0px; padding-right: 0px;">
            <div class="row">
              <div class="col fs-5 fw-bold">{$stTOTAL_LEYENDA}</div>
              <div class="col text-end fs-4 fw-bold" id="TOTAL">{$stTOTAL|default:'0.00'} &euro;</div>
              <div class="col-12">
                {IF $stHAY_PEDIDO > 0}
                <div class="d-grid gap-2 mt-3">
                  <div class="d-grid gap-2 mt-3" id="botones_pedido">
                    <button id="QR" class="btn text-white fw-bold botones_pedido" style="background-color: #279EFF;"
                      type="button" data-bs-toggle="modal" data-bs-target="#obsprod">{$stBOTON1}
                    </button>
                    <input type="hidden" id="idsSeleccionados" name="idsSeleccionados">
                    {if isset($stMESA)}
                      <input type="hidden" id="mesa" name="mesa" value="{$stMESA|default:''}">
                      <input type="hidden" id="loja_id" name="loja_id" value="{$stLOJA|default:''}">
                      {if $stMESA_ENABLED=='enabled'}
                        <button class="btn btn-success botones_pedido" id="Pedir" type="button" data-bs-toggle="modal"
                          data-bs-target="#obsprod">{$stBOTON2}</button>
                      {/if}
                    {/if}
                  </div>
                  {/if}
                </div>
              </div>
            </div>


          </div>
        </div>
  </main>
  <!-- Modal MSN ADD Item msnform -->
  <div class="modal fade" id="qrcode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex justify-content-center">
      <div class="modal-content w-50">
        <div class="modal-body">
          <h6 class="text-center">{$stLEYENDA}</h6>
          <div class="alert alert-success alert-dismissible fade show m-0 p-0" role="alert">
            <img class="d-flex justify-content-center" hidden id="QRcode" src="" style="width: 100% ;" />

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Insert OBS Prod -->
  <div class="modal fade" id="obsprod" tabindex="-1" aria-labelledby="modalobsprod" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{$stOBSERVACION}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body overflow-auto px-4" style="height: 600px; scrollbar-width: thin;
            scrollbar-color: #eee #ffffff; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <div class="row" id="ComentariosDetalles">
            <div class="col-8 bg-primary bg-opacity-75 w-100 h-100 px-3 pt-3 pb-1 mb-3 rounded-3 msnisert">
              <p class="fs-5 fw-normal text-white initmsn">{$stCASO_QUIERA}</p>
            </div>
            <div id="listaPedidos">
              <!--Item 01-->
              <div class="col-12 bg-white p-2 mb-3">
                <div class="row">
                  <div class="col-4">
                    <div class="bg-white bg-image"
                      style="border-radius: 0.8rem; width: 100px; height: 75px; background-image: url('./assets/images/azeite.jpg'); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex flex-column justify-content-around align-items-baseline">
                      <h2 class="fs-4 fw-bold mb-0">Azeite de coco</h2>
                      <p class="fs-5 my-2">2.65€</p>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mt-3 mb-2">
                      <textarea class="form-control" placeholder="Comentário aqui" id="message-text"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{$stTITULO_PAGINA}</button>
          <button type="button" class="btn btn-success" id="ConfirmarDetellesPedido">{$stCONFIRMAR}</button>
          <button type="button" class="btn btn-success" id="EnviarPedido">{$stCONFIRMAR}</button>
        </div>
      </div>
    </div>
  </div>

  {include file="template/dir/ementa2/footer_menu.tpl"}
{include file="template/dir/ementa2/footer.tpl"}