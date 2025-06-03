<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Get the top 5 countries by total customers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopCustomerCountries()
    {
        $countries = DB::table('customers') // Memulai query builder pada tabel 'customers'
            ->select('country', DB::raw('COUNT(*) as total_customers')) // Memilih kolom 'country' dan menghitung jumlah pelanggan sebagai 'total_customers'
            ->groupBy('country') // Mengelompokkan hasil berdasarkan 'country'
            ->orderByDesc('total_customers') // Mengurutkan hasil berdasarkan 'total_customers' secara menurun
            ->limit(5) // Membatasi hasil hanya 5 baris teratas
            ->get(); // Mengeksekusi query dan mendapatkan hasilnya

        return response()->json([ // Mengembalikan respons JSON
            'message' => 'Top 5 customer countries retrieved successfully', // Pesan sukses
            'data' => $countries // Data negara pelanggan yang diambil
        ]);
    }

    /**
     * Get the top 5 customers by total orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopCustomersByOrders() //
    {
        $topCustomers = DB::table('customers as c') //
            ->select('c.customerName', DB::raw('COUNT(o.orderNumber) as total_orders')) //
            ->join('orders as o', 'c.customerNumber', '=', 'o.customerNumber') //
            ->groupBy('c.customerName') //
            ->orderByDesc('total_orders') //
            ->limit(5) //
            ->get(); //

        return response()->json([ //
            'message' => 'Top 5 customers by total orders retrieved successfully', //
            'data' => $topCustomers //
        ]);
    }

    /**
     * Get the customer with the longest shipping time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerWithLongestShippingTime()
    {
        $customer = DB::table('customers as c') //
            ->select(
                'c.customerName', //
                DB::raw('DATEDIFF(o.shippedDate, o.orderDate) as total_days') //
            )
            ->join('orders as o', 'c.customerNumber', '=', 'o.customerNumber') //
            ->whereNotNull('o.shippedDate') //
            ->orderByDesc('total_days') //
            ->limit(1) //
            ->first(); // Menggunakan first() karena kita hanya butuh 1 hasil

        return response()->json([ //
            'message' => 'Customer with longest shipping time retrieved successfully', //
            'data' => $customer //
        ]);
    }
}
