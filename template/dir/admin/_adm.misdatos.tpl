{include file="_cabecera.tpl"}

<div class="container-fluid">
    <div class="card-body ">
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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">informa&ccedil;&atilde;o de
                                contato
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="email" disabled class="form-control" id="InputEmail" name="email"
                                    placeholder="Email Address" value="{$stEMAIL}">
                            </div>
                            <div class="form-group">
                                <input type="text" disabled class="form-control" id="InputLoja" name="Loja"
                                    value="{$stLOJA}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="InputTelefono" name="telefono"
                                    placeholder="n&uacute;mero de telefone" value="{$stTELEFONO}">
                            </div>
                            <hr>
                            <input name="btn_action1" type="submit" value="Registrar altera&ccedil;&otilde;es"
                                class="btn btn-primary btn-user btn-block">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">alterar senha</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="password" class="form-control" name="old" id="old" id="InputOldPassword"
                                    placeholder="Senha Antiga">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="new" id="InputNewPassword"
                                    placeholder="Nova Senha">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirmation"
                                    id="InputConfirmationPassword" placeholder="Repita a senha">
                            </div>
                            <div class="form-group">
                                <input name="id" type="hidden" value="{$stID}">
                            </div>
                            <hr>
                            <input name="btn_action2" type="submit" value="Registrar altera&ccedil;&otilde;es"
                                class="btn btn-primary btn-user btn-block">
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>

{include file="_pie.tpl"}