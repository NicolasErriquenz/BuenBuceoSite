angular
    .module("angularApp")
    .controller("registroPostulanteController",
        ["$location", "$scope", "ngOidcClient", "homeService",
            function ($location, $scope, ngOidcClient, homeService) {
                var vm = this;

                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

            }]
    );