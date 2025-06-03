<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorReportController extends Controller
{
    /**
     * Get aggregated sales data per product vendor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVendorSalesSummary()
    {
        $vendorSales = DB::table('products as p') // Mulai dari tabel 'products' dengan alias 'p'
            ->select(
                'p.productVendor', // Pilih nama vendor
                DB::raw('COUNT(DISTINCT p.productCode) as total_products'), // Hitung produk unik
                DB::raw('SUM(od.quantityOrdered) as total_quantity'), // Hitung total kuantitas dipesan
                DB::raw('SUM(od.quantityOrdered * od.priceEach) as total_price') // Hitung total harga penjualan
            )
            ->join('orderdetails as od', 'p.productCode', '=', 'od.productCode') // Gabungkan dengan 'orderdetails'
            ->groupBy('p.productVendor') // Kelompokkan berdasarkan nama vendor
            ->orderByDesc('total_products') // Urutkan berdasarkan total_products secara menurun
            ->get(); // Eksekusi query

        return response()->json([
            'message' => 'Vendor sales summary retrieved successfully',
            'data' => $vendorSales
        ]);
    }

    /**
     * Get vendor names and their total orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVendorTotalOrders() //
    {
        $vendorOrders = DB::table('products as p') //
            ->select(
                'p.productVendor as vendername', //
                DB::raw('COUNT(od.orderNumber) as total_orders') //
            )
            ->join('orderdetails as od', 'od.productCode', '=', 'p.productCode') //
            ->groupBy('p.productVendor') //
            ->orderByDesc('total_orders') //
            ->get(); //

        return response()->json([ //
            'message' => 'Vendor total orders retrieved successfully', //
            'data' => $vendorOrders //
        ]);
    }
}
