<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get the total number of orders per year.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrdersPerYear()
    {
        $ordersPerYear = DB::table('orders') // Memulai query builder pada tabel 'orders'
            ->select(
                DB::raw('YEAR(orderDate) as year'), // Ekstrak tahun dari orderDate sebagai 'year'
                DB::raw('COUNT(orderDate) as total_orders') // Hitung jumlah orderDate sebagai 'total_orders'
            )
            ->groupBy(DB::raw('YEAR(orderDate)')) // Kelompokkan berdasarkan tahun dari orderDate
            ->get(); // Eksekusi query

        return response()->json([
            'message' => 'Total orders per year retrieved successfully',
            'data' => $ordersPerYear
        ]);
    }

    /**
     * Get details of orders that are currently "On Hold".
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnHoldOrderDetails()
    {
        $onHoldOrders = DB::table('orders as o') // Mulai dari tabel 'orders' dengan alias 'o'
            ->select(
                'o.customerNumber',
                'c.customerName', // Menggunakan alias 'c' untuk customerName
                'od.orderNumber',
                DB::raw('COUNT(od.productCode) as Total_products'), // Menghitung total productCode
                DB::raw('SUM(od.quantityOrdered * od.priceEach) as Total_Price'), // Menghitung total harga
                'o.status'
            )
            ->join('payments as p', 'o.customerNumber', '=', 'p.customerNumber') // Join dengan tabel 'payments'
            ->join('orderdetails as od', 'o.orderNumber', '=', 'od.orderNumber') // Join dengan tabel 'orderdetails'
            ->join('customers as c', 'p.customerNumber', '=', 'c.customerNumber') // Join dengan tabel 'customers'
            ->where('o.status', '=', 'On Hold') // Filter status "On Hold"
            ->groupBy(
                'o.customerNumber',
                'c.customerName',
                'od.orderNumber',
                'o.status'
            ) // Kelompokkan berdasarkan kolom yang dipilih
            ->get(); // Eksekusi query

        return response()->json([
            'message' => 'On-hold order details retrieved successfully',
            'data' => $onHoldOrders
        ]);
    }
}
