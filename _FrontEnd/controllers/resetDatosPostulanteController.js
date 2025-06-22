angular
    .module("angularApp")
    .controller("resetDatosPostulanteController", ["$scope", "datosEstaticosService", "adminService", "$location",
        function ($scope, datosEstaticosService, adminService, $location) {
            var vm = this;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            vm.query = {
                Documento: null,
                Template: null,
                Email: null
            };

            vm.procesandoReset = false;
            vm.BorrarPostulanteDatos = function () {
                console.log(vm.query);
                if (verifyNullUndefined(vm.query.Documento)) {
                    return;
                }

                if (vm.procesandoReset)
                    return;

                vm.procesandoReset = true;
                
                adminService.ResetPostulanteDatos(
                    {dni: vm.query.Documento},
                    function (response) { // SUCCESS
                        vm.procesandoReset = false;
                        showDialog("Postulante Reseteado");
                    },
                    function (e) { // ERROR
                        var mensaje = "";
                        mensaje = e.data.Message;
                        vm.procesandoReset = false;
                        showDialog(mensaje);
                    }
                );
            };

            vm.procesandoTestEmail = false;
            vm.TestEmail = function () {
                console.log(vm.query);
                if (verifyNullUndefined(vm.query.Template) || verifyNullUndefined(vm.query.Email)) {
                    showDialog("ingrese template e email");
                    return;
                }

                if (vm.procesandoTestEmail)
                    return;

                vm.procesandoTestEmail = true;
                
                adminService.TestEmail(
                    vm.query,
                    function (response) { // SUCCESS
                        vm.procesandoTestEmail = false;
                        showDialog("Mail enviado");
                    },
                    function (e) { // ERROR
                        var mensaje = "";
                        mensaje = e.data.Message;
                        vm.procesandoTestEmail = false;
                        showDialog(mensaje);
                    }
                );
            };

            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m.toUpperCase());
            };

            vm.checkKey = function ($event, metodo) {
                if ($event.keyCode === 13) {
                    if (metodo == 'resetusuario') {
                        vm.BorrarPostulanteDatos();
                    }
                }

            };
            
        }]
    );