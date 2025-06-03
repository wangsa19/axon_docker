<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductLineController extends Controller
{
    /**
     * Get the top 2 product lines by total quantity ordered.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopSellingProductLines()
    {
        $productLines = DB::table('productlines as pl') // Mulai dari tabel productlines dengan alias 'pl'
            ->select(
                'pl.productLine', // Pilih productLine dari tabel productlines
                DB::raw('SUM(od.quantityOrdered) as total_orders') // Hitung total quantityOrdered sebagai total_orders
            )
            ->join('products as p', 'pl.productLine', '=', 'p.productLine') // Join dengan tabel products
            ->join('orderdetails as od', 'p.productCode', '=', 'od.productCode') // Join dengan tabel orderdetails
            ->groupBy('pl.productLine') // Kelompokkan berdasarkan productLine
            ->orderByDesc('total_orders') // Urutkan berdasarkan total_orders secara menurun
            ->limit(2) // Batasi hingga 2 hasil teratas
            ->get(); // Eksekusi query

        return response()->json([
            'message' => 'Top 2 selling product lines retrieved successfully',
            'data' => $productLines
        ]);
    }
}
