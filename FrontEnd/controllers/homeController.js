angular
    .module("angularApp")
    .controller("homeController",
        ["$location", "$scope", "ngOidcClient", "homeService",
            function ($location, $scope, ngOidcClient, homeService) {
                var vm = this;

                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm.usuario = $scope.$parent.appCtrl.user();
                console.log(vm.usuario);

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

            }]
    );