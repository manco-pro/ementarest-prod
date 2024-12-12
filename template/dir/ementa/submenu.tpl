{include file="ementa/header.tpl"}

<body>
  {include file="ementa/header_menu.{$stLANG}.tpl"}
  <main>
    <div class="container" style="margin-top: 4.6rem; margin-bottom: 4rem;">
      <div class="row">
        {foreach from=$stCATALOGOS key=id item=Catalogo}
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="bg-image w-100 px-3 pt-sm-4 mb-3"
              style="background-image: url('{$stRUTAS.images_cat}{$Catalogo.imagen}'); background-repeat: no-repeat; background-position: 40% 60%; background-size:cover;">
              <a href="{$stRUTAS.ementa}{$stRUTA}.php?cat={$Catalogo.id}" class="link-underline link-underline-opacity-0"
                style="text-decoration: none;">
                <div class="w-100 h-100 px-0 pb-3 m-0" style="padding-top: 8.5rem;">
                  <div class="badge text-wrap text-start m-0 justify-content-start"
                    style="background-color: rgba(0, 0, 0, 0.8); font-size: 1.1rem; font-weight: 500; padding: 0.7rem;">
                    {$Catalogo[$A]|default:$Catalogo.nombre_pt }
                    
                    {*|default:$Catalogo.nombre_pt*}
                  </div>
                  <div class="badge text-wrap text-black justify-content-start"
                    style="background-color: rgb(255, 208, 0); font-size: 1.1rem; border-radius: 50%; width: 40px; height: 38px; padding: 0.5rem 0.4rem;">
                    <i class="fa-solid fa-eye text-black text-center m-0 p-0" style="font-size: 1.4rem;"></i>
                  </div>
                </div>
              </a>
            </div>
          </div>
        {/foreach}
      </div>
    </div>
  </main>
  {include file="ementa/footer_menu.tpl"}
{include file="ementa/footer.tpl"}