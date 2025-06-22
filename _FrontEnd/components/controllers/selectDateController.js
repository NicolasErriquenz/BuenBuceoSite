angular
    .module("angularApp")
    .controller("selectDateController", ['constantData', selectDateController]);


function selectDateController(constantData) {
    var vm = this;
    vm.dias = constantData.dias;
    vm.meses = constantData.meses;
    vm.anios = constantData.anios;
    
    if (vm.isRequired == undefined) {
        vm.isRequired = false;
    }

    if (vm.fechaDefault != undefined) {
        var date = new Date(vm.fechaDefault);
        vm.customModel = date;
        vm.anio = date.getFullYear();
        vm.mes = date.getMonth();
        vm.dia = date.getDate();
        vm.hora = 12;
        vm.labelDate = date.toLocaleDateString();
    }
    vm.hora = 12;
    vm.onSelectDate = function () {
        vm.customModel = new Date(vm.anio, vm.mes, vm.dia,vm.hora);
        vm.labelDate = vm.customModel.toLocaleDateString();
    }

}

