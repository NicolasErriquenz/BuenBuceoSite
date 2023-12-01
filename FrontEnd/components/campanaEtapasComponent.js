angular.module("angularApp").component("campanaEtapas",
    {
        templateUrl: "components/templates/campanaEtapas.html",
        controller: "campanaEtapasComponentController",
        controllerAs: "campanaEtapasCtrl",
        bindings: {
            campana: "<",
        }
    });