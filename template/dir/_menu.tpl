<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-utensils"></i>-->
            <img src="{$stRUTAS.images}EMENTA-LOGO-2.png" style="width: 100%;" alt="Logo EmentaRest">
        </div>
        <!-- <div class="sidebar-brand-text ">&nbsp; EmentaRest</div> -->
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    {foreach from=$_stCONTENT|default:' ' key=id item=label}
        {if !isset($label[1])}
            <li class="nav-item {$label.Active}">
                <a class="nav-link" href="{$label.Link}">
                    <i class="{$label.Img}"></i>
                    <span>{$label.Desc}</span>
                </a>
            </li>
        {else}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                    aria-controls="collapseTwo">
                    <i class="{$label.Img}"></i>
                    <span>{$label.Desc}</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{$label[1].Link}">{$label[1].Desc}</a>
                        <a class="collapse-item" href="{$label[2].Link}">{$label[2].Desc}</a>
                    </div>
                </div>
            </li>
        {/if}
        {/foreach}

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="{$_LOGOUT}" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>