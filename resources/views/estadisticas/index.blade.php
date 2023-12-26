@extends('layouts.app')

@section('content')
@section('title', 'Graficas del Sistema')

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

{{-- Titulo --}}
<div class="card mb-3" style="border: ridge 1px #ff1620;">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">📊 Graficas del Sistema 📊</h1>
                <p class="mt-4 mb-4 text-center">En esta sección podrás encontrar las graficas del sitema, donde podras encontrar graficos de ventas, productos, usuarios, etc.</p>
            </div>
        </div>
    </div>
</div>

{{-- Grafica de ventas por semana --}}
<div class="card mb-3" style="border: ridge 1px #ff1620;">
    <div class="card-header">
        <div class="row mt-1">
            <div class="col-6 col-lg-12">
                <h3 class="">Grafico de ventas por mes.</h3>
                <span>Conoce la cantidad monetaria de ventas que se han realizado durante el mes.</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label for="start_date">Fecha de Inicio:</label>
                <input class="form-select" type="date" id="start_date">
            </div>
            <div class="col-2">
                <label for="end_date">Fecha de Fin:</label>
                <input class="form-select" type="date" id="end_date">
            </div>
            <div class="col-2">
                <button class="btn btn-primary mt-4" onclick="filterSales()">Filtrar grafica de ventas</button>
            </div>
            <div class="col-2">
                <button class="btn btn-primary mt-4" onclick="getMonthlySalesChart()">Limpiar filtro</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mt-3" style="height: 300px;" id="chart_ventas_por_mes"></div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
                <div class="row mt-1">
                    <div class="col-6 col-lg-12">
                        <h3 class="">Grafico estados pedidos durante el mes.</h3>
                        <span>Este grafico la cantidad de pedidos por estados que se han realizado (Por defecto muestra información del mes actual).</span>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label for="start_date">Fecha de Inicio:</label>
                        <input class="form-select" type="date" id="start_date_2">
                    </div>
                    <div class="col-4">
                        <label for="end_date">Fecha de Fin:</label>
                        <input class="form-select" type="date" id="end_date_2">
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary mt-4" onclick="filterOrderStatusCount()">Filtrar grafica de ventas</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary mt-4" onclick="getOrderStatusCount()">Limpiar filtro</button>
                    </div>
                </div>
                <div class="mt-3" style="height: 300px;" id="chart_pedidos_estado"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
                <div class="row mt-1">
                    <div class="col-6 col-lg-12">
                        <h3 class="">Conoce la cantidad de nuevos clientes por mes</h3>
                        <span>Este grafico muestra la cantidad de nuevos clientes que se han registrado en el sistema. (Por defecto muestra información del mes actual).</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label for="start_date">Fecha de Inicio:</label>
                        <input class="form-select" type="date" id="start_date_3">
                    </div>
                    <div class="col-4">
                        <label for="end_date">Fecha de Fin:</label>
                        <input class="form-select" type="date" id="end_date_3">
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary mt-4" onclick="filterNewCustomersChart()">Filtrar grafica de ventas</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary mt-4" onclick="getNewCustomersChart()">Limpiar filtro</button>
                    </div>
                </div>
                <div class="mt-3" style="height: 300px;" id="chart_nuevos_clientes"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
                <div class="row mt-1">
                    <div class="col-6 col-lg-12">
                        <h3 class="">Productos con menos stock</h3>
                        <span>Muestra un top 20 de productos que tienen menos stock en el sistema.</span>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- <div class="mt-3" style="height: 500px;" id="chart_menos_stock"></div> -->
                <table class="table table-dashboard mb-0 table-borderless fs--1 border-200" id="low_stock_products_table">
                    <thead class="bg-light">
                        <tr class="text-900">
                            <th>Nombre</th>
                            <th>Unidad por Caja</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
                <div class="row mt-1">
                    <div class="col-6 col-lg-12">
                        <h3 class="">Productos con más stock</h3>
                        <span>Muestra un top 10 de productos que tienen más stock en el sistema.</span>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mt-3" style="height: 300px;" id="chart_mas_stock"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function getMonthlySalesChart(startDate, endDate) {
        $.ajax({
            url: '/api/getMonthlySalesChart',
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                let result = JSON.parse(JSON.stringify(response));
                //console.log(result);
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create('chart_ventas_por_mes', am4charts.XYChart);
                    chart.data = result.yearly_sales;

                    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                    dateAxis.dataFields.category = 'date';

                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                    var series = chart.series.push(new am4charts.LineSeries());
                    series.dataFields.dateX = 'date';
                    series.dataFields.valueY = 'total_sales';
                    series.tooltipText = '{valueY.value}';
                    series.strokeWidth = 2;
                    series.fillOpacity = 0.5;
                    series.tensionX = 0.9;
                    series.stroke = am4core.color('rgba(255, 14, 25, 0.7)');
                    series.fill = am4core.color('rgba(255, 14, 25, 0.7)');

                    chart.cursor = new am4charts.XYCursor();
                    chart.cursor.xAxis = dateAxis;

                    var scrollbarX = new am4core.Scrollbar();
                    chart.scrollbarX = scrollbarX;
                });
            },
        });
    }

    function filterSales() {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        //validar que las fechas no esten vacias
        if (startDate == '' || endDate == '') {
            alert('Por favor selecciona un rango de fechas');
            return false;
        }
        getMonthlySalesChart(startDate, endDate);
    }

    function filterOrderStatusCount() {
        var startDate = document.getElementById('start_date_2').value;
        var endDate = document.getElementById('end_date_2').value;

        //validar que las fechas no esten vacias
        if (startDate == '' || endDate == '') {
            alert('Por favor selecciona un rango de fechas');
            return false;
        }
        getOrderStatusCount(startDate, endDate);
    }

    function filterNewCustomersChart() {
        var startDate = document.getElementById('start_date_3').value;
        var endDate = document.getElementById('end_date_3').value;

        //validar que las fechas no esten vacias
        if (startDate == '' || endDate == '') {
            alert('Por favor selecciona un rango de fechas');
            return false;
        }
        getNewCustomersChart(startDate, endDate);
    }

    function getOrderStatusCount(startDate, endDate) {
        $.ajax({
            url: '/api/getOrderStatusCount',
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                let result = JSON.parse(JSON.stringify(response));
                //console.log(result);
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create('chart_pedidos_estado', am4charts.XYChart);
                    chart.data = result.order_status_count;

                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = 'estado';
                    categoryAxis.renderer.grid.template.location = 0;

                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                    var series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.valueY = 'count';
                    series.dataFields.categoryX = 'estado';
                    series.name = 'Cantidad de Pedidos';
                    series.columns.template.tooltipText = '{categoryX}: [bold]{valueY}[/]';
                    series.columns.template.fill = am4core.color('rgba(255, 14, 25, 0.7)');

                    chart.cursor = new am4charts.XYCursor();
                });
            },
        });
    }

    function getNewCustomersChart(startDate, endDate) {
        $.ajax({
            url: '/api/getNewCustomersChart',
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                let result = JSON.parse(JSON.stringify(response));

                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create('chart_nuevos_clientes', am4charts.XYChart);
                    chart.data = result.new_customers_count;

                    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                    dateAxis.dataFields.date = 'date'; // Usar 'date' en lugar de 'category'

                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                    var series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.valueY = 'count';
                    series.dataFields.dateX = 'date'; // Usar 'date' en lugar de 'category'
                    series.name = 'Nuevos Clientes Registrados';
                    series.stroke = am4core.color('rgba(255, 14, 25, 0.7)');
                    series.fill = am4core.color('rgba(255, 14, 25, 0.7)');

                    chart.cursor = new am4charts.XYCursor();
                });
            },
        });
    }

    function getLowStockProductsChart() {
        $.ajax({
            url: '/api/getLowStockProductsChart',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let result = JSON.parse(JSON.stringify(response));
                console.log(result);
                //create a table with the data
                var table = $('#low_stock_products_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    data: result.low_stock_products,
                    columns: [{
                            data: 'nombre'
                        },
                        {
                            //validar que si es null poner 0 unidades
                            data: 'unidad_por_caja',
                            render: function(data, type, row) {
                                if (data == null) {
                                    return "0 Unidades";
                                } else {
                                    return data;
                                }
                            }

                        },
                    ],
                    columnDefs: [{
                        targets: [0, 1], // Corregir los índices de las columnas
                        className: 'text-center',
                    }],
                    //translate the table
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "<i class='fa fa-angle-right'></i>",
                            "sPrevious": "<i class='fa fa-angle-left'></i>"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        buttons: {
                            copyTitle: 'Copiado al portapapeles',
                            copySuccess: {
                                _: '%d filas copiadas',
                                1: '1 fila copiada'
                            }
                        }
                    }
                });
            },
        });
    }

    function getTopStockProductsChart() {
        $.ajax({
            url: '/api/getTopStockProductsChart',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let result = JSON.parse(JSON.stringify(response));
                console.log(result);
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);

                    var chart = am4core.create('chart_mas_stock', am4charts.PieChart);
                    chart.data = result.top_stock_products;

                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = 'unidad_por_caja';
                    pieSeries.dataFields.category = 'nombre';
                    pieSeries.slices.template.tooltipText = '{category}: [bold]{value}[/]';
                    pieSeries.colors.step = 3; // Ajusta el esquema de colores aquí

                    // Oculta la leyenda
                    chart.legend = new am4charts.Legend();
                    chart.legend.disabled = true;

                    // Resto del código para configurar el gráfico de pastel
                    // ...
                });
            },
        });
    }

    $(document).ready(function() {
        getMonthlySalesChart();
        getOrderStatusCount();
        getNewCustomersChart();
        getLowStockProductsChart();
        getTopStockProductsChart();
    });
</script>
@endsection