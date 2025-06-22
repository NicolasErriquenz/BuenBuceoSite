angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("documentacionPostulanteController", ["$scope", "adminService", "urls", "$window", "$location", "$routeParams", "$timeout", "$rootScope",
        function ($scope, adminService, urls, $window, $location, $routeParams, $timeout, $rootScope) {
            var vm = this;

            vm.postulanteData = [];

            vm.postulanteCargado = false;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            vm.query = {
                motivo: null,
                tipoAccion: null,
            };

            vm.OpcionesSelectMotivosRechazoDocs = [
                "Archivo no pertinente",
                "Poca calidad en la imagen",
                "No se aprecian todos los datos",
            ];

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
                        
            vm.getDatosPostulante = function () {
                vm.busy.promise.push(adminService.GetPostulanteByDniDatosMinimos(
                    { dni: $routeParams.dni },
                    function (response) {
                        vm.postulanteCargado = true;
                        vm.postulanteData = response;
                        vm.postulanteData.FechaNacimiento = new Date(vm.postulanteData.FechaNacimiento);
                        vm.mostrarLoadingDatosPostulante = false;
                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.ValidarDocumento = function (doc, tipo) {

                vm.query = doc;
                vm.query.tipoAccion = tipo;

                vm.busy.message = "GUARDANDO...";

                vm.busy.promise = adminService.ValidarDocumentosPostulante(
                    vm.query,
                    function (response) {
                        PNotify.success({
                            title: 'DOCUMENTO VALIDADO', //
                            text: `El documento se ${tipo == 'aceptarDocumentacion' ? 'aceptó' : 'rechazó'} correctamente`,
                            type: 'success',
                            delay: 3000
                        });

                        vm.getDatosPostulante();
                    },
                    function (e) {
                        console.log("ERROR CrearCampana", e);
                        showDialog(e.data.Message);
                    }
                );
            };

            vm.getDatosPostulante();

            vm.Volver = function () {
                $location.path("postulanteBuscarPorDni/" + $routeParams.dni);
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