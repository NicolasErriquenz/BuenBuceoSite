angular
    .module("angularApp")
    .controller("campanaAgregarController", ["$scope", "datosEstaticosService", "adminService", "$location", "$document",
        function ($scope, datosEstaticosService, adminService, $location, $document) {
            var vm = this;

            vm.busy = {
                promise: [],
                message: "Cargando..."
            };

            vm.inicializarQuery = function () {
                vm.query = {
                    Nombre: null,
                    Descripcion: null,
                    FechaInicio: null,
                    FechaFinalizacion: null,
                    CarrerasId: null,
                    EscalafonId: null,
                    SubescalafonId: null,
                };
            }

            vm.inicializarQuery();

            vm.Carreras = [];
            vm.Escalafones = [];
            vm.SubEscalafones = [];
            vm.Anios = [];

            for (var i = 2022; i < 2050; i++) {
                vm.Anios.push(i);
            }

            vm.Postulantes = null;

            vm.busy.promise.push(adminService.GetCarreras(
                function (response) {
                    vm.Carreras = response;
                },
                function (e) { console.log("ERROR GetCarreras", e); }
            ));

            vm.GetEscalafones = function () {
                vm.Escalafones = [];
                angular.forEach(vm.Carreras,
                    function (carrera) {
                        if (vm.query.CarrerasId == carrera.Id) {
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

            vm.ValidarDatosFormulario = function () {

                if (verifyNullUndefined(vm.query.FechaInicio)) {
                    showDialog("DEBe ingresar la fecha de inicio de la campaña");
                    return;
                }

                //if (verifyNullUndefined(vm.query.Nombre)) {
                //    showDialog("DEBe ingresar el nombre de la campaña. Estos datos seran los que el usuario visualizará en la plataforma");
                //    return;
                //}

                if (vm.query.CarreraId == 1) {
                    if (verifyNullUndefined(vm.query.CarreraId) ||
                        verifyNullUndefined(vm.query.EscalafonId)) {
                        showDialog("DEBe SELECCIONAR TODOS LOS DATOS de carrera/escalafon/subescalafon REQUERIDOS PARA CONTINUAR");
                        return;
                    }
                }

                if (vm.query.CarreraId == 2) {
                    if (vm.query.EscalafonId != 3 && verifyNullUndefined(vm.query.SubEscalafonId)) {
                        showDialog("DEBÉS SELECCIONAR TODOS LOS DATOS de carrera/escalafon/subescalafon REQUERIDOS PARA CONTINUAR");
                        return;
                    }
                }

                vm.busy.message = "GUARDANDO...";

                vm.busy.promise = adminService.CrearCampana(
                    vm.query,
                    function (response) {
                        var campanaId = response.data;
                        vm.seleccionarRuta("/campanaDetalle/" + campanaId);
                    },
                    function (e) {
                        console.log("ERROR CrearCampana", e);
                        showDialog(e.data.Message);
                    }
                );
            };


            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m.toUpperCase());
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

        }]
    );