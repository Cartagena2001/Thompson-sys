  
  @section('title', 'Inicio')

  <?php
    
    $catalog_mode = 0;
    $url = '';

    if ( isset($cat_mod) ) { $catalog_mode = $cat_mod; }

    if ( $catalog_mode == 0 ) {
      
      if ( Auth::user()->cat_mod == 0 ) {
        $url = 'tienda';
      } else {
        $url = 'catalogo';
      }
    } else {
      $url = 'catalogo';
    }

  ?>

  {{-- CLIENTE --}}

  @if ( Auth::user()->rol_id == 2 )

    {{-- Dashboard Cliente --}}

    {{-- Logos marcas --}}

    @foreach ($marcas as $brand)

    <div class="card mb-3">

        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        
        <div class="card-body position-relative">

            <div class="row">
                <div class="col-lg-3">

                  <a style="margin: 0 auto;" href="{{ url( '/dashboard/'.$url.'?marca='.$brand->id.'&categoria=0') }}">
                    <img src="{{ url('storage/assets/img/logos/'.$brand->logo_src) }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="max-width: 180px; width: 100%; margin: 0 auto; display: block;"/>
                  </a>
                </div>

                <div class="col-lg-9">
                  <p class="text-justify mt-2 me-2" style="color: #000;">{{ $brand->descripcion }}</p>

                  <p style="color: #000;"><b>Categorías</b>:                          
                        @foreach ($categoriasAuto[$brand->id] as $cat)
                           <a href="/dashboard/{{ $url }}?marca={{ $brand->id }}&categoria={{ $cat->id }}">{{ $cat->nombre }}, </a>
                        @endforeach
                  </p>
                  
                </div>

            </div>
        </div>

      </div>

    @endforeach

    </div>

  @elseif ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

    {{-- Dashboard SuperAdmin y Admin --}}

    <div class="row g-3 mb-3">
      
      <div class="col-md-6">
        <div class="card h-md-100 ecommerce-card-min-width">
          
          <div class="card-header pb-0">

            <h6 class="mb-0 mt-2 d-flex align-items-center">Ventas Semanales<span class="ms-1 text-400" data-bs-toggle="tooltip" data-bs-placement="top" title="Calculado según las ventas de la semana pasada"><span class="far fa-question-circle" data-fa-transform="shrink-1"></span></span></h6>

          </div>

          <div class="card-body d-flex flex-column justify-content-end">
            <div class="row">
              <div class="col">
                <p class="font-sans-serif lh-1 mb-1 fs-4 total-ventas-semana">$0.00</p>
              </div>
            </div>
            <div class="mt-3" id="chart_ventas_semanales"></div>
          </div>

        </div>
      </div>

      <div class="col-md-6">
        <div class="card h-md-100">

          <div class="card-header pb-0">
            <h6 class="mb-0 mt-2">Total de Pedidos en el mes de <?php setlocale(LC_TIME, 'spanish'); echo strftime('%B'); ?></h6>
          </div>

          <div class="card-body d-flex flex-column justify-content-end">
            <div class="row justify-content-between">
              <div class="col-auto align-self-end">
                <div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1 total-ventas-mes">0</div>
              </div>
            </div>
          </div>
          <div class="mt-3" id="chart_total_pedidos"></div>

        </div>
      </div>

    </div>

    <div class="row g-3 mb-3">

      <div class="col-md-6 mb-3">
        <div class="card h-lg-100 overflow-hidden">
          <div class="card-body p-0">
            <div class="table-responsive scrollbar">
              <table class="table table-dashboard mb-0 table-borderless fs--1 border-200">
                <thead class="bg-light">
                  <tr class="text-900">
                    <th>Top 10 Productos Mejor Vendidos</th>
                    <th class="text-end">Ingresos totales recaudados por producto</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($topProductos as $producto)
                    <tr class="border-bottom border-200">
                        <td>
                            <div class="d-flex align-items-center position-relative">
                                <!-- Aquí puedes ajustar la ruta de la imagen según tus necesidades -->
                                <img class="rounded-1 border border-200" src="{{ url('storage/assets/img/products/'.$producto['imagen_1_src']) }}" width="60" alt="" />
                                <div class="flex-1 ms-3">
                                    <h6 class="mb-1 fw-semi-bold"><a class="text-dark stretched-link">{{ $producto['nombre'] }}</a></h6>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-end fw-semi-bold">$ {{ number_format($producto['total_ventas'], 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-3">
        <div class="card h-lg-100">
          <div class="card-header">
            <div class="row flex-between-center">
              <div class="col-auto">
                <h6 class="mb-0">Ventas Totales</h6>
                <span>Observa tus ventas realizadas por mes durante el año {{ date('Y') }}</span>
              </div>
            </div>
          </div>
          <div class="card-body h-100 pe-0">
            <div class="mt-3" id="chart_ventas_totales"></div>
          </div>
        </div>
      </div>

    </div>

  @else

    {{-- Dashboard Bodega --}}
    
    
    <div class="row g-3 mb-3">
      
      <div class="col-md-12">
        <div class="card h-md-100">

          <div class="card-header pb-0">
            <h6 class="mb-0 mt-2">Total de Pedidos en el mes de <?php setlocale(LC_TIME, 'spanish'); echo strftime('%B'); ?></h6>
          </div>

          <div class="card-body d-flex flex-column justify-content-end">
            <div class="row justify-content-between">
              <div class="col-auto align-self-end">
                <div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1 total-ventas-mes">0</div>
              </div>
            </div>
          </div>
          <div class="mt-3" id="chart_total_pedidos"></div>

        </div>
      </div>

    </div>

    <div class="row g-3 mb-3">

      <div class="col-md-12 mb-3">
        <div class="card h-lg-100 overflow-hidden">
          <div class="card-body p-0">
            <img src="{{ URL('assets/img/imgs/warehouse-img-0.png') }}" style="width: 100%;" alt="img-bg" />
          </div>
        </div>
      </div>
      
    </div>


  @endif


<!-- Glide JS -->           
<script src="{{ url('assets/js/glide.js') }}"></script>
<script>

    const config = {
        type: "carousel",
        perView: 4,
        focusAt: 'center',
        gap: 2,
        autoplay: 3000,
        duration: 3500,
        breakpoints: {
            800: {
              perView: 4
            },
            480: {
              perView: 4
            }
        }

    };

    new Glide(".glide", config).mount();
</script>

<script>
  function getWeeklySalesChart() {
  $.ajax({
    url: '/api/getWeeklySales', 
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      let result = JSON.parse(JSON.stringify(response));
      //console.log(result);
      am4core.ready(function () {
        am4core.useTheme(am4themes_animated);

        $('.total-ventas-semana').text(result.total_ventas_semana);
        var chart = am4core.create('chart_ventas_semanales', am4charts.XYChart); 
        chart.data = result.ventas_semanales; 

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = 'fecha'; 
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = 'total_ventas_dia'; 
        series.dataFields.categoryX = 'fecha'; 
        series.name = 'Ventas diarias semanales';
        series.columns.template.tooltipText = '{name}: [bold]{valueY}[/]';

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;

        // Animación
        series.columns.template.events.on('hit', function (ev) {
          var dataItem = ev.target.dataItem;
          dataItem.categoryX;
        });
      });
    },
  });
  }

  function getSalesByDayChart() {
  $.ajax({
    url: '/api/getSalesByDay', 
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      let result = JSON.parse(JSON.stringify(response));
      am4core.ready(function () {
        am4core.useTheme(am4themes_animated);

        $('.total-ventas-mes').text(result.total_ventas_mes);

        var chart = am4core.create('chart_total_pedidos', am4charts.PieChart);
        chart.data = result.ventas_por_dia;

        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = 'cantidad_ventas';
        pieSeries.dataFields.category = 'fecha';

        chart.innerRadius = am4core.percent(50);

        var label = chart.seriesContainer.createChild(am4core.Label);
        label.text = result.ventas_mes;
        label.horizontalCenter = 'middle';
        label.verticalCenter = 'middle';
        label.fontSize = 20;

        pieSeries.labels.template.disabled = true;

      });
    },
  });
  }

  function getYearlySalesChart() {
  $.ajax({
    url: '/api/getYearlySalesChart',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      let result = JSON.parse(JSON.stringify(response));
      am4core.ready(function () {
        am4core.useTheme(am4themes_animated);

        var chart = am4core.create('chart_ventas_totales', am4charts.XYChart);
        chart.data = result.yearly_sales;

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = 'month';
        categoryAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.categoryX = 'month';
        series.dataFields.valueY = 'total_sales';
        series.tooltipText = '{valueY.value}';
        series.strokeWidth = 2;
        // Agrega color debajo de la línea
        series.fillOpacity = 0.5;

        series.tensionX = 0.8; 

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = categoryAxis;

        var scrollbarX = new am4core.Scrollbar();
        chart.scrollbarX = scrollbarX;
      });
    },
  });
  }

  getWeeklySalesChart();
  getSalesByDayChart();
  getYearlySalesChart();
</script>