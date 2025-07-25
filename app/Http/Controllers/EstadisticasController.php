<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Orden;
use App\Models\User;
use App\Models\Producto;

class EstadisticasController extends Controller
{
    public function index()
    {
        return view('estadisticas.index');
    }

    public function getMonthlySalesChart(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date', now()->startOfYear());
            $endDate = $request->input('end_date', now()->endOfYear());


            $yearlySales = Orden::select(
                DB::raw('DATE(fecha_registro) as date'),
                DB::raw('SUM(total) as total_sales')
            )
                ->whereBetween('fecha_registro', [$startDate, $endDate])
                ->groupBy('date')
                ->get();

            $chartData = [];
            foreach ($yearlySales as $sale) {
                $chartData[] = [
                    'date' => Carbon::parse($sale->date)->format('Y-m-d'),
                    'total_sales' => $sale->total_sales,
                ];
            }

            return response()->json(['yearly_sales' => $chartData]);
        }
    }

    public function getOrderStatusCount(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date', now()->startOfMonth());
            $endDate = $request->input('end_date', now()->endOfMonth());

            $orderStatusCount = Orden::select(
                'estado',
                DB::raw('COUNT(*) as count')
            )
                ->whereBetween('fecha_registro', [$startDate, $endDate])
                ->groupBy('estado')
                ->get();

            $chartData = [];
            foreach ($orderStatusCount as $status) {
                $chartData[] = [
                    'estado' => $status->estado,
                    'count' => $status->count,
                ];
            }

            return response()->json(['order_status_count' => $chartData]);
        }
    }

    public function getNewCustomersChart(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date', now()->startOfMonth()); // Fecha de inicio predeterminada al comienzo del mes actual
            $endDate = $request->input('end_date', now()->endOfMonth()); // Fecha de fin predeterminada al final del mes actual

            // Obtén la cantidad de nuevos clientes registrados por día
            $newCustomersCount = User::select(
                DB::raw('DATE_FORMAT(fecha_registro, "%Y-%m-%d") as date'),
                DB::raw('COUNT(*) as count')
            )
                ->whereBetween('fecha_registro', [$startDate, $endDate])
                ->groupBy('date')
                ->get();


            $chartData = [];
            foreach ($newCustomersCount as $customer) {
                $chartData[] = [
                    'date' => Carbon::parse($customer->date)->format('Y-m-d'),
                    'count' => $customer->count,
                ];
            }

            return response()->json(['new_customers_count' => $chartData]);
        }
    }

    public function getLowStockProductsChart()
    {
        $lowStockProducts = Producto::orderBy(DB::raw('unidad_por_caja * existencia'))->limit(30)->get();

        $chartData = [];
        foreach ($lowStockProducts as $product) {
            $chartData[] = [
                'nombre' => $product->nombre,
                'unidad_por_caja' => $product->unidad_por_caja,
            ];
        }

        return response()->json(['low_stock_products' => $chartData]);
    }

    public function getTopStockProductsChart()
    {
        $topStockProducts = Producto::orderByDesc(DB::raw('unidad_por_caja * existencia'))->limit(10)->get();

        $chartData = [];
        foreach ($topStockProducts as $product) {
            $chartData[] = [
                'nombre' => $product->nombre,
                'unidad_por_caja' => $product->unidad_por_caja,
            ];
        }

        return response()->json(['top_stock_products' => $chartData]);
    }
}
