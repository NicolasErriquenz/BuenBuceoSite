    <script type="text/javascript" src="assets/_con/js/_demo.js"></script>
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-requestAnimationFrame/dist/jquery.requestAnimationFrame.min.js"></script>
    <script type="text/javascript" src="bower_components/nanoscroller/bin/javascripts/jquery.nanoscroller.min.js"></script>
    <script type="text/javascript" src="bower_components/materialize/bin/materialize.js"></script>
    <script type="text/javascript" src="bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
    <script type="text/javascript" src="bower_components/d3/d3.min.js"></script>
    <script type="text/javascript" src="bower_components/nvd3/build/nv.d3.min.js"></script>
    <script type="text/javascript" src="bower_components/Sortable/Sortable.min.js"></script>
    <script type="text/javascript" src="assets/_con/js/_con.min.js"></script>
    <script type="text/javascript" src="bower_components/code-prettify/src/prettify.js"></script>
    <script>
        /*
         * Stacked Bar Chart
         */
        (function() {
            nv.addGraph(function() {
                var chart = nv.models.multiBarChart()
                    .color(["#64B5F6", "#42A5F5"])
                    .margin({
                        left: 20,
                        bottom: 20,
                        right: 20
                    })
                    .reduceXTicks(true) //If 'false', every single x-axis tick label will be rendered.
                    .rotateLabels(0) //Angle to rotate x-axis labels.
                    .showControls(true) //Allow user to switch between 'Grouped' and 'Stacked' mode.
                    .groupSpacing(0.1) //Distance between each group of bars.
                ;

                chart.xAxis
                    .tickFormat(d3.format(',f'));

                chart.yAxis
                    .tickFormat(d3.format(',.1f'));

                d3.select('#chart1').append('svg')
                    .datum(exampleData())
                    .call(chart);

                return chart;
            });


            /* Inspired by Lee Byron's test data generator. */
            function stream_layers(n, m, o) {
                if (arguments.length < 3) o = 0;

                function bump(a) {
                    var x = 1 / (.1 + Math.random()),
                        y = 2 * Math.random() - .5,
                        z = 10 / (.1 + Math.random());
                    for (var i = 0; i < m; i++) {
                        var w = (i / m - y) * z;
                        a[i] += x * Math.exp(-w * w);
                    }
                }
                return d3.range(n).map(function() {
                    var a = [],
                        i;
                    for (i = 0; i < m; i++) a[i] = o + o * Math.random();
                    for (i = 0; i < 5; i++) bump(a);
                    return a.map(stream_index);
                });
            }

            function stream_index(d, i) {
                return {
                    x: i,
                    y: Math.max(0, d)
                };
            }


            //Generate some nice data.
            function exampleData() {
                return stream_layers(2, 30, 50).map(function(data, i) {
                    return {
                        key: i ? 'Visitors' : 'New Posts',
                        values: data
                    };
                });
            }
        }());



        /*
         * Stacked Area Chart
         */
        (function() {
            /*Data sample:
            { 
                  "key" : "North America" , 
                  "values" : [ [ 1025409600000 , 23.041422681023] , [ 1028088000000 , 19.854291255832],
                   [ 1030766400000 , 21.02286281168], 
                   [ 1033358400000 , 22.093608385173],
                   [ 1036040400000 , 25.108079299458],
                   [ 1038632400000 , 26.982389242348]
                   ...

            */
            d3.json('assets/_con/nvd3/stackedAreaData.json', function(data) {
                nv.addGraph(function() {
                    var chart = nv.models.stackedAreaChart()
                        .margin({
                            bottom: 20
                        })
                        .color(["#E27272", "#64B5F6", "#FFD83C", "#81C784"])
                        .margin({
                            right: 40,
                            left: 40
                        })
                        .x(function(d) {
                            return d[0]
                        }) //We can modify the data accessor functions...
                        .y(function(d) {
                            return d[1]
                        }) //...in case your data is formatted differently.
                        .useInteractiveGuideline(true) //Tooltips which show all data points. Very nice!
                        .rightAlignYAxis(true) //Let's move the y-axis to the right side.
                        .showControls(true) //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
                        .clipEdge(true);

                    //Format x-axis labels with custom function.
                    chart.xAxis
                        .tickFormat(function(d) {
                            return d3.time.format('%x')(new Date(d))
                        });

                    chart.yAxis
                        .tickFormat(d3.format(',.2f'));

                    d3.select('#chart2').append('svg')
                        .datum(data)
                        .call(chart);

                    nv.utils.windowResize(chart.update);

                    return chart;
                });
            })
        }());


        /*
         * Pie Chart
         */
        (function() {
            //Donut chart example
            nv.addGraph(function() {
                var chart = nv.models.pieChart()
                    .color(["#E27272", "#64B5F6", "#FFD83C", "#81C784"])
                    .x(function(d) {
                        return d.label
                    })
                    .y(function(d) {
                        return d.value
                    })
                    .showLabels(true) //Display pie labels
                    .labelThreshold(.05) //Configure the minimum slice size for labels to show up
                    .labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
                    .donutRatio(0.35) //Configure how big you want the donut hole size to be.
                ;

                d3.select('#chart4').append('svg')
                    .datum(exampleData())
                    .transition().duration(350)
                    .call(chart);

                return chart;
            });

            //Pie chart example data. Note how there is only a single array of key-value pairs.
            function exampleData() {
                return [{
                    "label": "India",
                    "value": 29.765957771107
                }, {
                    "label": "USA",
                    "value": 13.4783623743534
                }, {
                    "label": "Russia",
                    "value": 32.807804682612
                }, {
                    "label": "Turkey",
                    "value": 56.45946739256
                }];
            }
        }());

    </script>