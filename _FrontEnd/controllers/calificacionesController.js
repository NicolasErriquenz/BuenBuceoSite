angular
    .module("angularApp")
    .controller("calificacionesController",
        ["$rootScope", "$scope", "datosEstaticosService",
            function ($rootScope, $scope, datosEstaticosService ) {
                var vm = this;

                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm.Usuario = $scope.$parent.appCtrl.Usuario;

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

                function showDialog(m) {
                    $scope.$parent.appCtrl.showDialog(m.toUpperCase());
                };

                vm.inicializarQuery = function () {
                    vm.query = {
                        CarreraId: null,
                        EscalafonId: null,
                        SubEscalafonId: null,
                    };
                }

                vm.inicializarQuery();

                function verifyNullUndefined(str) {
                    return str === null || str === undefined || str === "";
                };

            }]
    );