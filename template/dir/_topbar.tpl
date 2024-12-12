<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw" id="campana_alertas"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="AlertaCount"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown" id="alertas-container">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>

                <a class="dropdown-item text-center small text-gray-500" href="#">Sem mensagens para ler</a>
            </div>
        </li>
        <script>
            async function fetchAlertas() {
                try {
                    const response = await fetch('{$stRUTAS.ale}get_alertas.php');
                    const data = await response.json();
                    displayAlertas(data);
                } catch (error) {
                    console.error('Error fetching alertas:', error);
                }
            }


            function deleteAlertaFromDatabase(alertaId) {
                // Realizar la llamada AJAX utilizando fetch
                fetch(`{$stRUTAS.ale}{literal}ale.borrar.php?id=${alertaId}`, {
                    method: 'DELETE' // Método HTTP DELETE
                })
                .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al eliminar la alerta');
                        }
                        // Actualizar la lista de alertas después de eliminar la alerta de la base de datos
                        return response.json();
                    })

                    .catch(error => {
                        console.error('Error:', error);
                    });
                }



                function displayAlertas(alertas) {
                    const container = document.getElementById('alertas-container');
                    container.innerHTML = `<h6 class="dropdown-header">Alerts Center</h6>`;

                    Object.values(alertas).forEach(alerta => {
                        const alertaElement = createAlertaElement(alerta);
                        container.appendChild(alertaElement);
                        if (alerta.tipo_id == 1) {
                            var campana = document.getElementById("campana_alertas");
                            // Agregar la clase para la animación de rebote
                            campana.classList.add("bounce");
                            campana.classList.add("red");
                        }
                    });
                    if (Object.keys(alertas).length === 0) {
                        container.innerHTML +=
                            `<a class="dropdown-item text-center small text-gray-500" href="#">Sem mensagens para ler</a>`;
                    }
                    const alertaCountElement = document.getElementById('AlertaCount');
                    if (Object.keys(alertas).length === 0) {
                        alertaCountElement.textContent = '';
                    } else {
                        alertaCountElement.textContent = Object.keys(alertas).length + '+';
                    }

                    Object.values(alertas).forEach(alerta => {
                        const equisElement = document.getElementById(`equis_${alerta.id}`);
                        equisElement.addEventListener('click', () => {
                            const alertaElement = document.getElementById(`alerta-${alerta.id}`);
                            alertaElement.remove(); // Eliminar el elemento HTML
                            var campana = document.getElementById("campana_alertas");
                            campana.classList.remove("bounce");
                            // Llamar a la func para eliminar la alert de DB

                            deleteAlertaFromDatabase(alerta.id);
                            fetchAlertas();
                        });
                    });
                }

                function createAlertaElement(alerta) {
                    const alertaElement = document.createElement('a');
                    alertaElement.className = 'dropdown-item d-flex align-items-center';
                    alertaElement.href = '#';
                    alertaElement.id = `alerta-${alerta.id}`;
                    alertaElement.innerHTML = `
                                            <div class="mr-3">
<div class="icon-circle ${alerta.color}">
${alerta.tipo}
                                            </div>
                                            </div>
                                            <div>
<div class="small text-gray-500" id="fecha">${alerta.fecha}</div>
<span class="font-weight-bold" id="mensaje">${alerta.mensaje}</span>
                                            </div>
                                            <div>
<i id="equis_${alerta.id}" class="fas fa-times ps-2" style="color: gray; margin: -25px -10px 0 0; display:block"></i>
                                            </div>
                                            `;
                    return alertaElement;
                }


                function initDashboard() {
                    fetchAlertas();
                    setInterval(fetchAlertas, 5000); // Actualiza cada 5 segundos
                }

                window.onload = initDashboard;
            </script>
        {/literal}

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                {if $stCANT_MENSAJES > 0 }<span class="badge badge-danger badge-counter"> {$stCANT_MENSAJES}
                </span>{/if}
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                {foreach from=$stMENSAJES_DASHBOARD item=mensaje}
                    <a class="dropdown-item d-flex align-items-center" href="{$stRUTAS.men}men.listar.php">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{$stRUTAS.images}message.png" alt="...">
                            {*/}<div class="status-indicator bg-success"></div>{/*}
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">{$mensaje.mensaje|truncate:70:'...':true}</div>
                            <div class="small text-gray-500">{$mensaje.nombre} </div>
                        </div>
                    </a>
                {/foreach}
                {if $stCANT_MENSAJES > 0 }
                    <a class="dropdown-item text-center small text-gray-500" href="{$stRUTAS.men}men.listar.php">Leia mais
                        mensagens</a>
                {else}
                    <a class="dropdown-item text-center small text-gray-500" href="#">Sem mensagens para ler</a>
                {/if}
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{$Usuario|default:'&nbsp;'}</span>
                <img class="img-profile rounded-circle" src="{$stRUTAS.images}undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{$_PROFILE}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Meus dados
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{$_LOGOUT}" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>