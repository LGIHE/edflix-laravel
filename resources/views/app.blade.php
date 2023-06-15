@include('components.header')

    <body class="{{ $bodyClass }}" style="background-color:#f8f9fa!important">
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="install_pwa">
            <div class="modal-dialog" id="install_pwa_dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Install EDPLAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-dark">
                        <p>Install EDPLAN for Easy access and Offline use.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="install_button">Install</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        {{ $slot }}

        @include('components.footer')

        <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js"></script>

        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
        <script type="text/javascript"src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

        @stack('js')
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }

        </script>

        <script>
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bflrtip',
                pageLength: 5,
                buttons: [
                    // 'excel', 'pdf', 'print'
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible(:not(.not-export-col))'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible(:not(.not-export-col))'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible(:not(.not-export-col))'
                        }
                    },
                    // 'colvis'
                ]
            });
            $('#table td .d-flex').css('white-space','initial');
        } );
        </script>
        <script>
            $(window).on('load', function() {

                    if(navigator.userAgent.match(/Android/i) ||
                        navigator.userAgent.match(/iPhone|iPad|iPod/i)
                        // && window.matchMedia('(display-mode: standalone)').matches === false
                        ){

                            $('#install_pwa').modal('show');

                        }
            });

            let deferredPrompt; // Allows to show the install prompt
            const installButton = document.getElementById("install_button");

            window.addEventListener("beforeinstallprompt", e => {
                console.log("beforeinstallprompt fired");
                // Prevent Chrome 76 and earlier from automatically showing a prompt
                e.preventDefault();
                // Stash the event so it can be triggered later.
                deferredPrompt = e;
                // Show the install button
                installButton.hidden = false;
                installButton.addEventListener("click", installApp);
            });

            function installApp() {
                // Show the prompt
                deferredPrompt.prompt();
                installButton.disabled = true;

                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then(choiceResult => {
                    if (choiceResult.outcome === "accepted") {
                        console.log("PWA setup accepted");
                        installButton.hidden = true;
                    } else {
                        console.log("PWA setup rejected");
                        installButton.hidden = false;
                    }
                    deferredPrompt = null;
                });
            }
        </script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
    </body>
</html>
