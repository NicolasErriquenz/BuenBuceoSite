angular
    .module("angularApp")
    .controller("envioCorreoPorDniController", ["$scope", "datosEstaticosService", "adminService", "$location", "$document", "$routeParams",
        function ($scope, datosEstaticosService, adminService, $location, $document, $routeParams) {
            var vm = this;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            $scope.promises = [];

            vm.procesandoConsulta = false;

            vm.busy.message = "Obteniendo datos...";
            vm.busy.promise = vm.promises;

            vm.query = {
                ResumenEnvioMails: null,
                Body: null,
                EnviarCopia: false,
                CorreoCopia: null,
                DniPorComas: null,
                Asunto: null,
            };
            
            vm.plantillasMails = [
                {
                    Id: 0,
                    Descripcion: "Fecha y Horario de Presentación a rendir Examen Psicotécnico (Primer Etapa) para la Carrera de Oficiales del Servicio Penitenciario Federal",
                    Content: '<p>Estimado/a {NOMBRE_POSTULANTE}: </p><p><br></p><p>Por medio del presente tengo el agradado de dirigirme a usted con el objeto de citarlo para rendir<strong> LA PRIMER ETAPA DEL EXAMEN PSICOTECNICO</strong>.</p><p><br></p><p>El mismo se llevará a cabo según el siguiente diagrama:</p><ul><li><strong>DÍA: XX/XX/2023</strong></li><li><strong>HORARIO: 09:00hs</strong></li></ul><p><br></p><p><strong style="color: rgb(255, 0, 0);">Con tiempo de tolerancia 10 Minutos</strong></p><p><strong>EL EXAMEN TENDRA UNA DURACIÓN MAXIMA DE UNA HORA, POR LO QUE SE EXIGE PUNTUALIDAD.</strong></p><p><br></p><ul><li><strong>Lugar</strong>: ESCUELA PENITENCIARIA DE LA NACIÓN DR. JUAN JOSE O’CCONOR situada en la ruta Jorge Newbery Km. 4,5 de la localidad de Ezeiza, provincia de Buenos Aires</li><li><strong>Ubicación</strong>: <a href="https://goo.gl/maps/tHWjFXqCvp5W7c6T6" rel="noopener noreferrer">Google Maps</a></li></ul><p><br></p><p>Para realizar el examen deberá traer consigo:</p><ul><li>D.N.I.,</li><li>CONSTANCIA DE RELACIONES FAMILIARES (<u>la constancia debe ser personal</u>), la cual puede adquirir a través de este <a href="https://servicioscorp.anses.gob.ar/clavelogon/logon.aspx?system=miansesv2" rel="noopener noreferrer">link</a>, ingresando al sistema de ANSES</li><li>LÁPIZ (no portaminas)</li><li>LAPICERA</li><li>GOMA</li><li>CORRECTOR.</li><li>VESTIMENTA: Su presencia es <strong>importante</strong>, por lo que deberá <strong>vestir formalmente</strong>, de ser posible <strong>colores sobrios</strong> (<u>recuerde que usted se encuentra postulando para un puesto laboral) y el examen al que asiste es una entrevista de trabajo</u>)</li><li>Se recomienda asistir con desayuno previo (o prevea traer un refrigerio).</li></ul><p><br></p><p style="text-align: center;"><strong>- NO RESPONDA ESTE CORREO –</strong></p><p style="text-align: center;">Quedamos a disposición mediante abonado telefónico (011) 15-37010999.</p><p style="text-align: right;">Sección Incorporaciones, E.P.N.</p>'
                },
                {
                    Id: 1,
                    Descripcion: "ULTIMO LLAMADO - Examen Psicotécnico (Primer Etapa) para la Carrera de Oficiales del Servicio Penitenciario Federal",
                    Content: '<p>Estimado/a {NOMBRE_POSTULANTE}:</p><p><br></p><p>Por medio del presente tengo el agradado de dirigirme a usted con el objeto de informarle que se <strong>REPROGRAMÓ </strong>por<strong> ÚNICA VEZ</strong>, la convocatoria para rendir <strong>LA PRIMER ETAPA DEL EXAMEN PSICOTÉCNICO</strong>. Tenga en cuenta que éste será el último llamado.</p><p><br></p><p>El mismo se llevará a cabo según el siguiente diagrama:</p><p>•	DÍA: <strong>05/05/2023</strong></p><p>•	HORARIO: <strong>09:00hs</strong></p><p><br></p><p><strong style="color: rgb(252, 8, 8);">Con tiempo de tolerancia 10 Minutos</strong></p><p><u>EL EXAMEN TENDRA UNA DURACIÓN MAXIMA DE UNA HORA, POR LO QUE SE EXIGE PUNTUALIDAD.</u></p><p><br></p><p>•	<strong>Lugar</strong>: ESCUELA PENITENCIARIA DE LA NACIÓN DR. JUAN JOSE O’CCONOR situada en la ruta Jorge Newbery Km. 4,5 de la localidad de Ezeiza, provincia de Buenos Aires</p><p>•	<strong>Ubicación</strong>: <a href="https://goo.gl/maps/tHWjFXqCvp5W7c6T6" rel="noopener noreferrer">Google Maps</a></p><p><br></p><p>Para realizar el examen deberá traer consigo:</p><p>•	D.N.I.,</p><p>•	CONSTANCIA DE RELACIONES FAMILIARES (la constancia debe ser personal -con su número de CUIL-, y del año en curso), la cual puede adquirir a través de este <a href="https://servicioscorp.anses.gob.ar/clavelogon/logon.aspx?system=miansesv2" rel="noopener noreferrer">link</a>, ingresando al sistema de ANSES</p><p>•	LÁPIZ (no portaminas)</p><p>•	LAPICERA</p><p>•	GOMA</p><p>•	CORRECTOR.</p><p>•	VESTIMENTA: Su presencia es <strong>importante</strong>, por lo que deberá <strong>vestir formalmente</strong>, de ser posible colores sobrios (recuerde que usted se encuentra postulando para un puesto laboral) y el examen al que asiste es una <strong>entrevista de trabajo</strong>)</p><p>•	Se recomienda asistir con desayuno previo (o prevea traer un refrigerio).</p><p><br></p><p style="text-align: center;">- NO RESPONDA ESTE CORREO –</p><p style="text-align: center;">Quedamos a disposición mediante abonado telefónico (011) 15-37010999.</p><p style="text-align: right;">Sección Incorporaciones, E.P.N.</p>'
                },
                {
                    Id: 2,
                    Descripcion: "ETAPA PSICOTECNICO – INGRESO A ESCUELA PENITENCIARIA DE LA NACION",
                    Content: '<p>Estimado/a {NOMBRE_POSTULANTE}</p><p><br></p><p style="text- align: justify; ">Me dirijo a usted con el fin de informar que <strong>NO HA SUPERADO</strong> la etapa del examen psicotécnico. </p><p style="text - align: justify; ">Podrá volver a inscribirse el año entrante para la Campaña de Incorporaciones ciclo<strong> 2025-2028</strong>.</p><p style="text - align: justify; ">Saludos Cordiales.</p>'
                },
                {
                    Id: 3,
                    Descripcion: "Fecha y Horario de Presentación a rendir Examen Psicotécnico (Segunda Etapa) y Examen Intelectual para la Carrera de Oficiales del Servicio Penitenciario Federal",
                    Content: '<p style="text-align: justify;">Estimado/a {NOMBRE_POSTULANTE}</p><p style="text-align: justify;"><br></p><p style="text-align: justify;">Habiendo superado la <strong>primera etapa </strong>del test <strong>psicotécnico</strong>, por medio del presente tengo el agrado de citarlo para continuar con los exámenes correspondientes al proceso de selección para postulante a cadete de 1er. año y futuro Oficial del Servicio Penitenciario Federal - Campaña 2024-2027.</p><p style="text-align: justify;"><br></p><p style="text-align: justify;">Es por ello que solicitamos se haga presente el<strong> xxxx     xx/xx/202x a las 09:00 horas.</strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;">Usted rendirá este día la <strong>segunda etapa del test psicotécnico </strong>y posteriormente un<strong> examen intelectual, </strong>el mismo se realizará en las instalaciones de la ESCUELA PENITENCIARIA DE LA NACIÓN DR. JUAN JOSE O’CCONOR situada en <strong>RUTA JORGE NEWBERY KM. 4,5 DE LA LOCALIDAD DE EZEIZA,</strong> <strong>PROVINCIA DE BUENOS DE BUENOS AIRES, a saber; </strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong>EXAMEN PSICOTÉCNICO:</strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;">Durante esta jornada usted realizará un examen psicotécnico, el mismo se llevará a cabo con indicaciones del personal del Gabinete Psicopedagógico las cuales lo/a guiarán en las actividades a realizar. Una vez finalizada la parte escrita le informarán respecto del desarrollo de una <strong><em>entrevista personal</em></strong> (de aproximadamente 20 minutos).</p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong>Deberá presentarse 10 minutos antes de lo acordado con el material que se indica a continuación: </strong></p><ul><li style="text-align: justify;"><strong>CONSTANCIA DE RELACIONES FAMILIARES (No podrá rendir sin haber presentado esta constancia)</strong> <u>La misma debe ser personal -con su número de CUIL-, traerla impresa, y actualizada (del año en curso)</u>, puede adquirirla a través de este <a href="https://servicioscorp.anses.gob.ar/clavelogon/logon.aspx?system=miansesv2" rel="noopener noreferrer" style="font-size: 10pt;">link</a><span style="font-size: 10pt;">, ingresando al sistema de ANSES.</span></li><li style="text-align: justify;"><strong style="font-size: 10pt;">D.N.I.</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">(04) HOJAS BLANCAS A4</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">LAPICERA AZUL</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">LÁPIZ NEGRO</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">GOMA DE BORRAR</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">CORRECTOR</strong></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">EXAMEN INTELECTUAL:</strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><span style="font-size: 10pt;">Texto de lectura el cual será de utilidad en instancia previa al examen como material de estudio, se adjunta </span>link<span style="font-size: 10pt;"> </span></p><ul><li style="text-align: justify;"><span style="font-size: 10pt;">destacar que </span><strong style="font-size: 10pt;">NO podrá ser utilizado durante la administración del examen. </strong></li><li style="text-align: justify;"><span style="font-size: 10pt;">El examen en cuestión está estructurado bajo la modalidad “múltiple choice”, y acompañado de una consigna a desarrollar, por lo que en la corrección del mismo se evaluará la gramática, la ortografía, la coherencia, la cohesión y la comprensión lectora.    </span></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><span style="font-size: 10pt;">Para realizar el examen deberá traer consigo:</span></p><ul><li style="text-align: justify;"><strong style="font-size: 10pt;">D.N.I.,</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">LAPICERA AZUL</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">CORRECTOR</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">4 HOJAS A4</strong></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">VESTIMENTA:</strong><span style="font-size: 10pt;"> Su presencia es importante, por lo que deberá vestir formalmente, de ser posible colores sobrios (recuerde que usted se encuentra postulándose para un puesto laboral, y el examen al que asiste es una entrevista de trabajo)</span></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">SE DESTACA QUE LA JORNADA TENDRA UNA DURACION APROXIMADA de 8:00 a 15:00 HORAS.</strong></p><p style="text-align: justify;"><span style="font-size: 10pt;">Debido a que la jornada es extensa, se recomienda que traiga algo para beber, y alimento que NO requiera ser conservado en el refrigerador. </span></p><ul><li style="text-align: justify;"><strong style="font-size: 10pt;">ASISTA CON DESAYUNO PREVIO.</strong></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">ES RELEVANTE QUE TENGA CONOCIMIENTO, DE NO CUMPLIMENTAR CON LOS REQUISITOS EXIGIDOS PARA EL INGRESO, QUEDARÁ DESAFECTADO DE LOS TRÁMITES DE INGRESO, QUEDARA DESAFECTADO DEL PROCESO DE SECCIÓN. </strong><span style="font-size: 10pt;">Finalmente, DEBERERÁ CONFIRMAR la recepción del presente y su CONCURRENCIA el día y horario determinado del siguiente modo:</span></p><ul><li style="text-align: justify;">DESTINATARIO: <a href="mailto:epnincorporaciones@spf.gob.ar" rel="noopener noreferrer" style="font-size: 10pt; color: rgb(90, 115, 142);">epnincorporaciones@spf.gob.ar</a></li><li style="text-align: justify;"><span style="font-size: 10pt;">ASUNTO: CONFIRMACION DE CONVOCATORIA</span></li><li style="text-align: justify;"><span style="font-size: 10pt;">CUERPO DE MENSAJE: ASISTIRÉ A LA CONVOCATORIA</span></li><li style="text-align: justify;"><span style="font-size: 10pt;">MENCIONANDO NOMBRE APELLIDO Y D.N.I.</span></li></ul><p><br></p><p style="text-align: center;"><strong>– NO RESPONDA ESTE CORREO –</strong></p><p style="text-align: center;"><strong style="font-size: 10pt; font-family: Calibri, sans-serif;">Quedamos a disposición mediante abonado telefónico (011) 15-37010999.</strong></p><p style="text-align: right;">Sección Incorporaciones, E.P.N.</p>'
                },
                {
                    Id: 4,
                    Descripcion: "Fecha y Horario de Examen Intelectual para la Carrera de Oficiales del Servicio Penitenciario Federal",
                    Content: '<p style="text-align: justify;">Estimado/a {NOMBRE_POSTULANTE}</p><p style="text-align: justify;"><span style="font-size: 10pt;"> </span></p><p style="text-align: justify;"><span style="font-size: 10pt;">Habiendo superado el examen psicotécnico, por medio del presente tengo el agrado de citarlo para continuar con el proceso de selección para postulante a cadete de 1er. año y futuro Oficial del Servicio Penitenciario Federal - Campaña 2024-2027.</span></p><p style="text-align: justify;"><span style="font-size: 10pt;">  </span></p><p style="text-align: justify;"><span style="font-size: 10pt;">Es por ello que solicitamos se haga presente el</span><strong style="font-size: 10pt;"> xxxxxx/xx/202x a las 9:00 horas.</strong></p><p style="text-align: justify;"><span style="font-size: 10pt;"> </span></p><p style="text-align: justify;"><span style="font-size: 10pt;">Usted rendirá este día un</span><strong style="font-size: 10pt;"> examen intelectual, </strong><span style="font-size: 10pt;">el mismo se realizará en las instalaciones de la ESCUELA PENITENCIARIA DE LA NACIÓN DR. JUAN JOSE O’CCONOR situada en </span><strong style="font-size: 10pt;">RUTA JORGE NEWBERY KM. 4,5 DE LA LOCALIDAD DE EZEIZA,</strong><span style="font-size: 10pt;"> </span><strong style="font-size: 10pt;">PROVINCIA DE BUENOS DE BUENOS AIRES, a saber;</strong></p><p style="text-align: justify;"><span style="font-size: 10pt;"> </span><strong style="font-size: 10pt;"> </strong><span style="font-size: 10pt;"> </span></p><p style="text-align: justify;"><strong style="font-size: 10pt;">Examen intelectual:</strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><span style="font-size: 10pt;">Texto de lectura el cual será de utilidad en instancia previa al examen como material de estudio, se adjunta link</span></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><span style="font-size: 10pt;">Cabe destacar que </span><strong style="font-size: 10pt;">NO podrá ser utilizado durante la administración del examen.</strong></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><span style="font-size: 10pt;">El examen en cuestión está estructurado bajo la modalidad “múltiple choice”, y acompañado de una consigna a desarrollar, por lo que en la corrección del mismo se evaluará la gramática, la ortografía, la coherencia, la cohesión y la comprensión lectora. </span></p><p style="text-align: justify;"><span style="font-size: 10pt;">Para realizar el examen deberá traer consigo:  </span></p><ul><li style="text-align: justify;"><strong style="font-size: 10pt;">D.N.I.,</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">LAPICERA AZUL</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">CORRECTOR</strong></li><li style="text-align: justify;"><strong style="font-size: 10pt;">4 HOJAS A4</strong></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">VESTIMENTA:</strong><span style="font-size: 10pt;"> Su presencia es importante, por lo que deberá vestir formalmente,  de ser posible colores sobrios (recuerde que usted se encuentra postulándose para un puesto laboral, y el examen al que asiste es una entrevista de trabajo)  </span></p><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">SE DESTACA QUE LA JORNADA TENDRA UNA DURACION APROXIMADA de 9:00 a 12:00 HORAS.</strong><span style="font-size: 10pt;"> </span></p><ul><li style="text-align: justify;"><strong style="font-size: 10pt;">ASISTA CON DESAYUNO PREVIO.</strong><span style="font-size: 10pt;"> </span></li></ul><p style="text-align: justify;"><br></p><p style="text-align: justify;"><strong style="font-size: 10pt;">ES RELEVANTE QUE TENGA CONOCIMIENTO, DE NO CUMPLIMENTAR CON LOS REQUISITOS EXIGIDOS PARA EL INGRESO, QUEDARÁ DESAFECTADO DE LOS TRÁMITES DE INGRESO, QUEDARA DESAFECTADO DEL PROCESO DE SECCIÓN.</strong><span style="font-size: 10pt;">  </span></p><p style="text-align: justify;"><br></p><p style="text-align: justify;">Finalmente, DEBERERÁ CONFIRMAR la recepción del presente y su CONCURRENCIA el día y horario determinado del siguiente modo:</p><ul><li style="text-align: justify;">DESTINATARIO: <a href="mailto:epnincorporaciones@spf.gob.ar" rel="noopener noreferrer" style="color: rgb(90, 115, 142); font-size: 10pt;">epnincorporaciones@spf.gob.ar</a></li><li style="text-align: justify;"><span style="font-size: 10pt;">ASUNTO: CONFIRMACION DE CONVOCATORIA</span></li><li style="text-align: justify;"><span style="font-size: 10pt;">CUERPO DE MENSAJE: ASISTIRÉ A LA CONVOCATORIA</span></li><li style="text-align: justify;"><span style="font-size: 10pt;">MENCIONANDO NOMBRE APELLIDO Y D.N.I.</span></li></ul><p style="text-align: justify;"><br></p><p style="text-align: center;"><strong>– NO RESPONDA ESTE CORREO –</strong></p><p style="text-align: center;"><strong style="font-family: Calibri, sans-serif; font-size: 10pt;">Quedamos a disposición mediante abonado telefónico (011) 15-37010999.</strong></p><p style="text-align: right;">Sección Incorporaciones, E.P.N.</p><p><br></p>'
                },
                //{
                //    Id: 5,
                //    Descripcion: "Cierre de campana",
                //    Content: "<h2>Título4 en H2</h2></br><b>text4</b></br><p>otro4</p>"
                //},
            ];

            vm.setPlantilla = function () {
                //console.log(vm.plantillasMails[vm.query.plantillasMails.Id].Content);
                vm.query.Asunto = vm.plantillasMails[vm.query.plantillasMails.Id].Descripcion;
                $scope.editorValue = vm.plantillasMails[vm.query.plantillasMails.Id].Content;
            };

            vm.ResumenEnvioMails = null;
            vm.ProcesarEnvioMasivoMails = function () {

                //console.log(vm.query);
                vm.busy = {
                    promise: [],
                    message: "PROCESANDO LISTADO DE DNI..."
                };

                if (verifyNullUndefined(vm.query.Asunto)) {
                    showDialog("Ingrese el asunto del mail");
                    return;
                }

                if (verifyNullUndefined(vm.query.Body)) {
                    showDialog("Redacte el cuerpo del mail");
                    return;
                }

                if (verifyNullUndefined(vm.query.DniPorComas)) {
                    showDialog("Debe ingresar al menos un documento valido para enviar");
                    return;
                }

                if (vm.query.CorreoCopia == "1" && verifyNullUndefined(vm.query.CorreoCopia)) {
                    showDialog("Debe especificar un correo válido para enviar copia");
                    return;
                }

                vm.DniPorComas = vm.query.DniPorComas.replace(/ /g, "");
                var listado = vm.DniPorComas;
                var aListados = listado.split(",");
                vm.DniPorComas = aListados[aListados.length - 1] !== ""
                    ? vm.DniPorComas
                    : vm.DniPorComas.slice(0, -1);

                vm.DniPorComas = vm.DniPorComas.replace(/(\r\n|\n|\r)/gm, "");
                vm.DniPorComas = vm.DniPorComas.replace(/\\n/g, '');
                vm.DniPorComas = vm.DniPorComas.replace(/\\r/g, '');
                vm.DniPorComas = vm.DniPorComas.trim();

                vm.query.DniPorComas = vm.DniPorComas;

                //vm.query.Body = JSON.stringify()(vm.query.Body);

                vm.busy.promise = adminService.ProcesarEnvioMasivoMails(
                    vm.query,
                    function (response) {
                        //console.log(response);
                        vm.ResumenEnvioMails = response;
                        $("#modalResumenEnvioMails").modal("show");

                        //vm.inicializarQuery();
                    },
                    function (e) {
                        //console.log("ERROR ProcesarEnvioMasivoMails", e);
                        showDialog(e.data.Message);
                    }
                );

            };

            $scope.htmlEditorOptions = {
                height: 600, //Alto del cuadro de texto
                toolbar: {
                    items: [
                        'undo', 'redo', 'separator',
                        {
                            name: 'size',
                            acceptedValues: ['8pt', '10pt', '12pt', '14pt', '18pt', '24pt', '36pt'],
                        },
                        {
                            name: 'font',
                            acceptedValues: ['Arial', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                        },
                        'separator',
                        'bold', 'italic', 'strike', 'underline', 'separator',
                        'link', 'separator',
                        'orderedList', 'bulletList', 'separator',
                        'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'separator',
                        'color', 'background', 'separator',
                        {
                            name: 'header',
                            acceptedValues: [1, 2, 3, 4, 5],
                        },
                    ],
                },
                bindingOptions: {
                    value: 'editorValue',
                    valueType: 'editorValueType',
                },
                onValueChanged: function(e) {
                    //console.log(e.value);
                    vm.query.Body = e.value;
                }
            };

            vm.setDniEnvioIndividual = function () {
                //console.log(adminService.dnisPorComas);
                if (!verifyNullUndefined($routeParams.dni))
                    vm.query.DniPorComas = $routeParams.dni;
                else
                    vm.query.DniPorComas = typeof (adminService.dnisPorComas) == "string" ? adminService.dnisPorComas : "";
            };

            vm.setDniEnvioIndividual();
            
            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m);
            };

            vm.checkPermiso = function (permiso) {
                return $scope.$parent.appCtrl.user().data ? $scope.$parent.appCtrl.user().data.profile.role.includes(permiso) : false;
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };
        }
    ]);