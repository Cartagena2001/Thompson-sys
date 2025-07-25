<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\CMS;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();

        $marcasAuto = $user->marcas;
        $marcasAutorizadas = str_split($marcasAuto);
        $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

        //$categoriasAuto = [];

        foreach ($marcas as $brandA) {

            $marcaID = $brandA->id;

            $categoriasAuto[$marcaID] = Categoria::whereIn('id', function($query) use ( $marcaID){
                $query->select('categoria_id')->from('marca_cat')->whereIn('marca_id', [$marcaID]); 
            })->where('estado', '=', 'Activo')->get();

        }

        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        $topProductos = OrdenDetalle::select(
            'orden_detalle.producto_id',
            DB::raw('SUM(orden_detalle.cantidad * orden_detalle.precio) as total_ventas')
        )
            ->groupBy('orden_detalle.producto_id')
            ->join('producto', 'producto.id', '=', 'orden_detalle.producto_id')
            ->orderByDesc('total_ventas')
            ->take(10)
            ->get();

        $productos = Producto::whereIn('id', $topProductos->pluck('producto_id'))
            ->pluck('nombre', 'id');

        $topProductos = $topProductos->map(function ($producto) use ($productos) {
            return [
                'producto_id' => $producto->producto_id,
                'imagen_1_src' => Producto::find($producto->producto_id)->imagen_1_src,
                'nombre' => $productos[$producto->producto_id],
                'total_ventas' => $producto->total_ventas,
                'slug' => $producto->slug
            ];
        });


        if ($user->estatus == "aspirante" || $user->estatus == "rechazado") {

            return view('aspirantes.form-inscripcion', compact('user'));
        } else {
            //estatus = aprobado
            //dd($topProductos);
            return view('home',  compact('marcas', 'cat_mod', 'mant_mod', 'topProductos', 'categoriasAuto'));
        }
    }

    public function getWeeklySales(Request $request)
    {
        if ($request->ajax()) {
            $startOfWeek = Carbon::now()->startOfWeek()->subWeek()->toDateString();
            $endOfWeek = Carbon::now()->startOfWeek()->subDay()->toDateString();

            $ventasSemanales = Orden::select(
                DB::raw('DATE_FORMAT(fecha_registro, "%Y-%m-%d") as fecha'),
                DB::raw('SUM(total) as total_ventas_dia')
            )
                ->whereNotNull('fecha_registro')
                ->whereBetween('fecha_registro', [$startOfWeek, $endOfWeek])
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();

            $totalVentasSemana = Orden::whereNotNull('fecha_registro')
                ->whereBetween('fecha_registro', [$startOfWeek, $endOfWeek])
                ->sum('total');
            $totalVentasSemanaFormat = '$' . number_format($totalVentasSemana, 2);

            $data = [
                "ventas_semanales" => $ventasSemanales,
                "total_ventas_semana" => $totalVentasSemanaFormat
            ];

            return response()->json($data);
        }
    }

    public function getSalesByDay(Request $request)
    {
        if ($request->ajax()) {
            // Obtén la fecha de inicio y fin del mes actual
            $startOfMonth = now()->startOfMonth()->toDateString();
            $endOfMonth = now()->endOfMonth()->toDateString();

            // Obtén el total de pedidos y los días en que se realizaron durante el mes actual
            $ventasPorDia = Orden::select(
                DB::raw('DATE_FORMAT(fecha_registro, "%Y-%m-%d") as fecha'),
                DB::raw('COUNT(*) as cantidad_ventas')
            )
                ->whereNotNull('fecha_registro')
                ->whereBetween('fecha_registro', [$startOfMonth, $endOfMonth])
                ->groupBy('fecha')
                ->get();

            $totalVentasMes = Orden::whereNotNull('fecha_registro')
                ->whereBetween('fecha_registro', [$startOfMonth, $endOfMonth])
                ->count();

            $data = [
                "ventas_por_dia" => $ventasPorDia,
                "total_ventas_mes" => $totalVentasMes
            ];

            return response()->json($data);
        }
    }

    public function getYearlySalesChart(Request $request)
    {
        if ($request->ajax()) {
            // Obtén las ventas totales por mes para el año actual
            $yearlySales = Orden::select(
                DB::raw('MONTH(fecha_registro) as month'),
                DB::raw('SUM(total) as total_sales')
            )
                ->whereYear('fecha_registro', now()->year)
                ->groupBy(DB::raw('MONTH(fecha_registro)'))
                ->orderBy('month')
                ->get();

            // Construye un array con los datos necesarios para el gráfico
            $chartData = [];
            foreach ($yearlySales as $sale) {
                $chartData[] = [
                    'month' => date('F', mktime(0, 0, 0, $sale->month, 1)), // Obtener el nombre del mes
                    'total_sales' => $sale->total_sales,
                ];
            }

            return response()->json(['yearly_sales' => $chartData]);
        }
    }
}
