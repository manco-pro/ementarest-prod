{include file="ementa/header.tpl"}

<body>
  {include file="ementa/header_menu.{$stLANG}.tpl"}
  <main>
    <div class="container p-4" style="margin-top: 3rem;">
      <div class="row">
        <!--Item 01-->
        {if isset($stPRODUCTOS)}
          {foreach from=$stPRODUCTOS item=producto key=key }
            <div class="col-12 bg-white rounded-1 p-2 mb-2" id="DIV_{$producto.id}">
              <div class="row">
                <div class="col-4 col-sm-2 col-lg-1">
                  <div class="bg-white w-100 h-100 bg-image"
                    style="background-image: url('{$stRUTAS.images_col}{$producto.imagen}'); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                  </div>
                </div>
                <div class="col m-0 p-0">
                  <div class="d-flex flex-column justify-content-around align-items-baseline">
                    <h2 class="fs-6 fw-bold mb-0">{$producto.nombre_de|default:$producto.nombre_pt}</h2>
                    <p class="fs-6 mb-0" id="PRECIO_{$producto.id}">{$producto.precio} &euro;</p>
                  </div>
                </div>
                <div class="col col-sm-3 col-lg-2" >
                  <div class="float-end position-relative"></div>
                  <div class="float-end position-relative"><i id="I_{$producto.id}" class="fa-solid fa-xmark pe-2" style="color: gray;"></i></div>
                    <i class="fa-solid fa-circle-minus fs-4 m-0 align-middle" style="color: #cccccc;" id="Menos_{$producto.id}" ></i>
                    <p class="fs-6 fw-bold" id="Cantidad_{$producto.id}">{$producto.cantidad}</p>
                    <i class="fa-solid fa-circle-plus fs-4 m-0" id="Mas_{$producto.id}"></i>
                  </div>
                </div>
              </div>
            </div>
            <hr id="HR_{$producto.id}">
          {/foreach}
        {/if}
  

        <div class="mt-3 mb-5">
          <!-- Campo cupom de desconto -->
          {*<div class="input-group">
            <input type="text" class="form-control" placeholder="Cupom de desconto" aria-label="Recipient's username"
              aria-describedby="button-addon2">
            <button class="btn btn-secondary" type="button" id="button-addon2">Toepassen</button>
          </div>*}

          <!-- Valor toral
          <div class="container mt-4 mb-4">
            <div class="row">
              <div class="col fs-5 fw-bold">Totaal:</div>
              <div class="col text-end fs-4 fw-bold" id="TOTAL" >{$stTOTAL|default:'0.00'} &euro;</div>
              <div class="col-12">
                {*<div class="d-grid gap-2 mt-3">
                  <button class="btn btn-dark" type="button">Bevestig bestelling</button>
                  <button class="btn btn-danger" type="button">Annuleer bestelling</button>
                </div>*}
              </div> -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  {include file="ementa/footer_menu.tpl"}

{include file="ementa/footer.tpl"}