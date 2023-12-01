angular
    .module("angularApp")
    .controller("datosEstaticosController", ["$scope", "datosEstaticosService", "adminService", "$location", "$document",
        function ($scope, datosEstaticosService, adminService, $location, $document) {
            var vm = this;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            vm.busy.message = "Obteniendo datos...";

            vm.busy.promise = datosEstaticosService.GetSexo(
                function (response) { vm.sexos = response; },
                function (e) { console.log("ERROR datosEstaticosService", e); }
            );

            vm.busy.promise = datosEstaticosService.GetTipoDocumento(
                function (response) { vm.tipos = response; },
                function (e) { console.log("ERROR datosEstaticosService", e); }
            );

            vm.busy.promise = vm.promises;

        }]
    );