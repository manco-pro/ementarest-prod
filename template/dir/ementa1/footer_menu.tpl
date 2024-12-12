<!--<footer-component></footer-component>-->
<footer class="bg-dark fixed-bottom" style="z-index:0">
    <nav class="navbar px-md-5">
        <div class="container-fluid align-middle ps-4">
            <a class="navbar-brand text-center link-light" href="{$stRUTAS.ementa}index.php">
                <i class="fa-solid fa-house fs-5 icon-cl icon-cl-effect"></i>
            </a>
            <a class="navbar-brand text-center link-light" href="{$stRUTAS.ementa}menu.php">
                <img src="{$stRUTAS.assets}images/icon/{if $stACTIVA eq 'Menu'}menu-yellow.png{else}menu-w.png{/if}"
                    alt="" width="17px" class="icon-cl icon-cl-effect mImg" style="margin-top: -6px;">
            </a>
            <a class="navbar-brand text-center link-light" href="{$stRUTAS.ementa}bebidas.php">
                <i class="fa-solid fa-wine-bottle fs-5 icon-cl icon-cl-effect"
                    {if $stACTIVA eq 'Bebidas'}style="color: #ffd700;" {/if}></i>
            </a>
            <a class="navbar-brand text-center link-light" href="{$stRUTAS.ementa}sugestoes.php">
                <i class="fa-solid fa-utensils fs-5 icon-cl icon-cl-effect"
                    {if $stACTIVA eq 'Sugestoes'}style="color: #ffd700;" {/if}></i>
            </a>
            <a class="navbar-brand text-center link-light" href="{$stRUTAS.ementa}cart.php">
                <i id="iconoCarrito"
                    class="fa-solid fa-cart-shopping fs-5 {if $stCARRITOACTIVO== 'S'}fa-beat{else}icon-cl icon-cl-effect{/if} "
                    {if $stACTIVA eq 'Cart'}style="color: #ffd700;" {/if}></i>
            </a>
        </div>
    </nav>
</footer>