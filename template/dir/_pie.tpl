

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>{$_FECHAPIE}</span>
                    </div>
                </div>
            </footer>
</div>
<!-- End of Content Wrapper -->

<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pronto para partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Sair" abaixo se estiver pronto para encerrar sua sess&atilde;o atual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{$stRUTAS.admin}logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div> 
    
    <script src="{$stRUTAS.vendor}bootstrap/js/bootstrap.bundle.js"></script>
   
    <!-- Core plugin JavaScript-->
    <script src="{$stRUTAS.vendor}jquery-easing/jquery.easing.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{$stRUTAS.js}sb-admin-2.js"></script>
    </body>
</html>