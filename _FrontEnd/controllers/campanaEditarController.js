angular
    .module("angularApp")
    .controller("campanaEditarController", ["$scope", "datosEstaticosService", "adminService", "$routeParams", "$document",
        function ($scope, datosEstaticosService, adminService, $routeParams, $document) {
            var vm = this;

            vm.busy = {
                promise: null,
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
                    CampanaEstadosId: null,
                };
            }

            vm.busy.promise = datosEstaticosService.GetEstadosCampana(
                function (response) {
                    vm.EstadosCampana = response;
                },
                function (e) { console.log("ERROR GetEstadosCampana", e); }
            );

            vm.inicializarQuery();

            vm.Campana = [];
            vm.Carreras = [];
            vm.Escalafones = [];
            vm.SubEscalafones = [];
            vm.EstadosCampana = [];

            vm.busy.promise = adminService.GetCampana(
                { campanaId: $routeParams.id },
                function (response) {
                    vm.Campana = response;
                    vm.Campana.FechaInicio = new Date(vm.Campana.FechaInicio);
                    vm.Campana.FechaFinalizacion = vm.Campana.FechaFinalizacion ? new Date(vm.Campana.FechaFinalizacion) : null;
                },
                function (e) { console.log("ERROR GetCampana", e); }
            );


            vm.ValidarDatosFormulario = function () {

                if (verifyNullUndefined(vm.Campana.FechaInicio)) {
                    showDialog("DEBe ingresar la fecha de inicio de la campaña");
                    return;
                }

                if (verifyNullUndefined(vm.Campana.Nombre)) {
                    showDialog("DEBe ingresar el nombre de la campaña. Estos datos seran los que el usuario visualizará en la plataforma");
                    return;
                }


                vm.busy.message = "GUARDANDO...";

                vm.busy.promise = adminService.EditarCampana(
                    vm.Campana,
                    function (response) {
                        var campanaId = response.data;
                        vm.seleccionarRuta("/campanaDetalle/" + campanaId);
                    },
                    function (e) {
                        console.log("ERROR GuardarCampana", e);
                        showDialog(e.data.Message);
                    }
                );
            };


            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            vm.volver= function () {
                vm.seleccionarRuta('campanaDetalle/' + $routeParams.id)
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m.toUpperCase());
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

        }]
    );