angular
    .module("angularApp")
    .controller("logoutController",
        ["$scope", "$location", "$anchorScroll", "urls", "$http", "$mdDialog", "ngOidcClient",
            function ($scope, $location, $anchorScroll, urls, $http, $mdDialog, ngOidcClient) {
                var vm = this;
                vm.bienvenida = "Bienvenidos";
                //document.element('#myselector').triggerHandler('click');
            }
        ]
    )