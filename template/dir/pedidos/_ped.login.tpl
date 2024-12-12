<!DOCTYPE html>
<html lang="PT">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{$stTITLE|default:'::Pedidos - Ementa Digital ::'}</title>

    <!-- Custom fonts for this template-->
    <link href="{$stRUTAS.vendor}fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{$stRUTAS.css}sb-admin-2.css" rel="stylesheet">
</head>

<body class="bg-gradient-secondary">
    <div class="container">
        <div class="row justify-content-center " style="position: relative; top: 50%; transform: translateY(20%);">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image-pedidos">

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{$stRUTAS.images}EMENTAREST-LOGO.png" alt="Ementarest">
                                        <h1 class="h4 text-gray-900 mb-4">{$stERROR|default:'Bem-vindo!'}</h1>
                                    </div>
                                    <form method="POST" class="user" action="{$stACTION}" id="frmLogin" name="frmLogin"
                                        accept-charset="utf-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="textHelp"
                                                placeholder="Digite seu e-mail..." value='{$stEMAIL}' name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Senha" name="password">
                                        </div>
                                        <div class="form-group">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" name="btnLogin" type="submit"
                                            value="Sign In" />
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{$stRUTAS.vendor}/jquery/jquery.js"></script>
    <script src="{$stRUTAS.vendor}/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="{$stRUTAS.vendor}/jquery-easing/jquery.easing.js"></script>
    <script src="{$stRUTAS.js}sb-admin-2.js"></script>
</body>

</html>