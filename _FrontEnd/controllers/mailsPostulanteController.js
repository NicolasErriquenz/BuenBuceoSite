angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("mailsPostulanteController", ["$scope", "adminService", "urls", "$window", "$location", "$routeParams", "$timeout", "$rootScope",
        function ($scope, adminService, urls, $window, $location, $routeParams, $timeout, $rootScope) {
            var vm = this;

            vm.postulanteData = [];
            vm.ResumenEnvioMails = [];

            vm.postulanteCargado = false;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            vm.query = {
                Documento: null,
            };

            vm.query.Documento = $routeParams.dni;

            vm.EnvioActual = null;
            vm.seleccionarElemento = function (e) {
                vm.EnvioActual = e;
            }

            $scope.promises = [];

            vm.procesandoConsulta = false;
            vm.mostrarTodosLosCampos = false;
            vm.errorSistema = "HUBO UN ERROR AL CONSEGUIR LOS DATOS DE LOS POSTULANTE. INTENTE NUEVAMENTE EN UNOS INSTANTES. SI EL PROBLEMA PERSISTE FAVOR DE COMUNICARSE AL DEPTO DE INFORMATICA A SOPORTEDESARROLLO@SPF.GOB.AR";

            vm.busy.promise = new Array();

            vm.usuario = $scope.$parent.appCtrl.user().data.profile;

            vm.getMailsAgente = function () {
                vm.busy.promise.push(adminService.GetReporteMailsAgente(
                    { dni: $routeParams.dni },
                    function (response) {
                        vm.ResumenEnvioMails = response;
                        vm.postulanteCargado = true;
                    },
                    function (e) {
                        console.log("ERROR ReporteMailsAgente", e);
                        showDialog(e.data.Message);
                        vm.postulanteCargado = false;
                    }
                ));
                console.log("valor: " + vm.postulanteCargado);
            };

            vm.getDatosPostulante = function () {
                vm.busy.promise.push(adminService.GetPostulanteByDniDatosMinimos(
                    { dni: $routeParams.dni },
                    function (response) {
                        vm.postulanteCargado = true;
                        vm.postulanteData = response;
                        vm.postulanteData.FechaNacimiento = new Date(vm.postulanteData.FechaNacimiento);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulante = response;
                        vm.getMailsAgente();
                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.Volver = function () {
                $location.path("postulanteBuscarPorDni/" + $routeParams.dni);
            };

            vm.getDatosPostulante();
           
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