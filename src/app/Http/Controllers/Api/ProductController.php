<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get the top 10 products by total orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopSellingProducts()
    {
        $products = DB::table('products as p') // Select from 'products' table, aliased as 'p'
            ->select('p.productName', DB::raw('SUM(od.quantityOrdered) as total_orders')) // Select productName and sum of quantityOrdered as total_orders
            ->join('orderdetails as od', 'p.productCode', '=', 'od.productCode') // Inner join with 'orderdetails' aliased as 'od'
            ->groupBy('p.productCode', 'p.productName') // Group by productCode and productName
            ->orderByDesc('total_orders') // Order by total_orders in descending order
            ->limit(10) // Limit to 10 results
            ->get(); // Execute the query and get the results

        return response()->json([ // Return a JSON response
            'message' => 'Top 10 selling products retrieved successfully', // Success message
            'data' => $products // The retrieved product data
        ]);
    }

    /**
     * Get products that have not been ordered.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnorderedProducts() //
    {
        $unorderedProductCodes = DB::table('orderdetails')->select('productCode')->distinct(); //
        $products = DB::table('products') //
            ->select('productName') //
            ->whereNotIn('productCode', $unorderedProductCodes) //
            ->get(); //

        return response()->json([ //
            'message' => 'Products that have not been ordered retrieved successfully', //
            'data' => $products //
        ]);
    }
}
