{include file="_cabecera.tpl"}
 <style>
    /* Estilo inicial del h1 */
    h1 {
      opacity: 1;
      transition: opacity 1s ease-in-out;
    }

    /* Clase para desvanecer el h1 */
    .hidden {
      opacity: 0;
    }
  </style>
<div class="card-body">
    <!-- Nested Row within Card Body -->
    
        <div class="text-center">
            {if ($stMENSAJE != '')}
                <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
            {/if}  
            {if ($stERROR != '')}
                <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
            {/if}
        </div>
        
        <form class="user" method="post" action="{$stACTION}" accept-charset="utf-8">
            <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                 
                    <div class="card-body">
                          <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class=" form-control" id="nombre" name="nombre" value="{$stNOMBRE}">
                        </div>
                        <div class="form-group">
                            <label>Sobrenome</label>
                            <input type="text" class=" form-control" id="apellido" name="apellido" value="{$stAPELLIDO}">
                        </div>
                       
                        <div class="form-group">
                            <label>Telefone</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="n&uacute;mero de telefone" value="{$stTELEFONO}" >
                        </div>
                        <div class="form-group">
                            <label>Freguesia</label>
                            <select  name="freguesia" id="freguesiaSelect" class="form-control bg-light border-0 small">
                                {$stFREGUESIA}
                            </select>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-lg-6">       
                <div class="card shadow mb-4">
                    
                    <div class="card-body">
                      <div class="form-group">
                            <label>Endere&ccedil;o</label>
                            <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Digite a nova Endere&ccedil;o de email" value="{$stEMAIL}" >
                        </div>
                        <label>Nova senha</label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="new" id="InputNewPassword" placeholder="Digite a nova senha">
                        </div>
                        <div class="form-group">
                             <label>Repita a nova senha</label>
                            <input type="password" class="form-control" name="confirmation" id="InputConfirmationPassword" placeholder="Repita a nova senha">
                        </div>
                        <div class="form-group">
                             <input name="id" type="hidden" value="{$stID}">
                        </div>
                        <div class="form-group">
                            <label>Habilitado</label><p></p>
                            <input value="ativado"  type="checkbox" name="enabled" {$stENABLED}>
                        </div>  
                        
                    </div>
                </div>        
                
            </div>
            </div>
            <input name="btn_modificar" type="submit" value="Registrar altera&ccedil;&otilde;es" class="btn btn-primary btn-user btn-block">
            <a name="btn_volver" type="submit" value="retornar" class="btn btn-primary btn-user btn-block" href="{$stRUTAS.adm}adm.listar.php">retornar</a>
        </form>
</div>

<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->  
<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>  
<script>
  // Espera 3 segundos y luego oculta el h1
  setTimeout(function() {
    var h1 = document.getElementById('mensaje');
    h1.classList.add('hidden');
  }, 3000);
</script>
{include file="_pie.tpl"}
