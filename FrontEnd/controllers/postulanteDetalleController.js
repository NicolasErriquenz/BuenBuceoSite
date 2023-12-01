angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("postulanteDetalleController", ["$routeParams", "datosEstaticosService", "adminService", "$scope", "urls", "$window", "$rootScope", "$location",
        function ($routeParams, datosEstaticosService, adminService, $scope, urls, $window, $rootScope, $location) {

            var vm = this;
            vm.postulanteData = [];

            // enable console.log
            vm.DEBUG = false;
            vm.consola = function (m) {
                if (vm.DEBUG) console.log(m);
            };

            vm.busy = {
                promise: [],
                message: "BUSCANDO DATOS DEL POSTULANTE..."
            };

            $scope.promises = [];

            vm.Estaturas = [];
            vm.Pesos = [];
            vm.Carreras = [];
            vm.Escalafones = [];
            vm.SubEscalafones = [];
            vm.OpcionesSelect = ["SI","NO"];

            for (var i = 140; i < 230; i++) {
                vm.Estaturas.push(i);
            }

            for (var i = 30; i < 200; i++) {
                vm.Pesos.push(i);
            }

            console.log($routeParams);

            vm.busy.promise = datosEstaticosService.GetCarreras(
                function (response) {
                    vm.Carreras = response;
                },
                function (e) { console.log("ERROR GetCarreras", e); }
            );

            vm.populateEscalafones = function () {
                vm.Escalafones = vm.GetEscalafones();
            };

            vm.GetEscalafones = function () {

                vm.resetHabilitarCargarAmbasCarreras();

                vm.Escalafones = [];
                angular.forEach(vm.Carreras,
                    function (carrera) {
                        if (vm.query.CarreraId == carrera.Id) {
                            angular.forEach(carrera.Escalafones,
                                function (escalafon) {
                                    vm.Escalafones.push(escalafon);
                                }
                            );
                        }
                    }
                );
            }

            vm.GetSubescalafones = function () {

                vm.resetHabilitarCargarAmbasCarreras();

                vm.SubEscalafones = [];
                angular.forEach(vm.Escalafones,
                    function (escalafon) {
                        if (vm.query.EscalafonId == escalafon.Id) {
                            angular.forEach(escalafon.SubEscalafones,
                                function (subescalafon) {
                                    vm.SubEscalafones.push(subescalafon);
                                }
                            );
                        }
                    }
                );
            }

            vm.resetHabilitarCargarAmbasCarreras = function () {
                vm.habilitadoCargaCarreraSuboficiales = true;
                vm.habilitadoCargaCarrera = true;
            };

            vm.resetHabilitarCargarAmbasCarreras();

            vm.cargarDatosPostulante = function () {
                vm.busy = {
                    promise: [],
                    message: "BUSCANDO DATOS DEL POSTULANTE..."
                };

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.GetPostulanteByDni(
                    { dni: $routeParams.dni },
                    function (response) { //SUCCESS

                        vm.postulanteCargado = true;

                        vm.postulanteData = response;
                        vm.postulanteData.FechaNacimiento = new Date(vm.postulanteData.FechaNacimiento);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulante = response;
                    },
                    function (error) {
                        showDialog("ocurrio un error al obtener los datos del postulante.")
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.cargarDatosPostulante();

            vm.volver = function () {
                $location.path("postulanteBuscarPorDni/" + $routeParams.dni);
            }

            vm.DescargarArchivo = function (doc) {
                var arch = doc.Archivo.replace('\\', '/');
                var urlDoc = urls._recursosDocumentacion + arch;
                $window.open(urlDoc);
            };

            vm.getDatosSelect = function () {
                vm.busy.promise = datosEstaticosService.GetSexo(
                    function (response) { vm.Sexos = response; },
                    function (e) { console.log("ERROR GetSexo", e); }
                );
                vm.busy.promise = datosEstaticosService.GetEstadosCiviles(
                    function (response) { vm.EstadosCiviles = response; },
                    function (e) { console.log("ERROR GetEstadosCiviles", e); }
                );
                vm.busy.promise = datosEstaticosService.GetProvincias(
                    function (response) { vm.Provincias = response; },
                    function (e) { console.log("ERROR GetProvincias", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoNacionalidades(
                    function (response) { vm.Nacionalidades = response; },
                    function (e) { console.log("ERROR GetTipoNacionalidades", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoLicenciaConducir(
                    function (response) { vm.TipoLicenciaConducir = response; },
                    function (e) { console.log("ERROR GetTipoLicenciaConducir", e); }
                );
                vm.busy.promise = datosEstaticosService.GetEstudiosTipo(
                    function (response) { vm.EstudiosTipo = response; },
                    function (e) { console.log("ERROR GetEstudiosTipo", e); }
                );
                vm.busy.promise = datosEstaticosService.GetEstudiostipoOrientacion(
                    function (response) { vm.EstudiostipoOrientacion = response; },
                    function (e) { console.log("ERROR GetEstudiostipoOrientacion", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoPostulacionesEpn(
                    function (response) { vm.TipoPostulacionesEpn = response; },
                    function (e) { console.log("ERROR GetTipoPostulacionesEpn", e); }
                );
            }

            vm.getDatosSelect();

            vm.ModificarDatosPostulante = function (accion, flag) {
                vm.postulanteData.accion = accion;

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.busy = {
                    promise: null,
                    message: "BUSCANDO DATOS DEL POSTULANTE..."
                };

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise = (adminService.ModificarDatosPostulante(
                    vm.postulanteData,
                    function (response) { //SUCCESS

                        eval("vm." + flag + " = false");
                        vm.mostrarLoadingDatosPostulante = false;

                        PNotify.success({
                            title: 'REGISTRO MODIFICADO',
                            text: 'El postulante se editó con éxito',
                            type: 'success',
                            delay: 3000
                        });

                    },
                    function (error) {

                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        //vm.postulanteCargado = false;
                    }
                ));
            };

            vm.cancelarEdicion = function (flag) {
                eval("vm." + flag + " = false");
                vm.cargarDatosPostulante();
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m.toUpperCase());
            };

        }]
    );