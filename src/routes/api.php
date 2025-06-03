<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Get the top 10 products by total orders.
Route::get('/products/top-selling', [Api\ProductController::class, 'getTopSellingProducts']);
// 6. Get products that have not been ordered.
Route::get('/products/unordered', [Api\ProductController::class, 'getUnorderedProducts']);

// 2. Get the top 5 countries by total customers.
Route::get('/customers/top-countries', [Api\CustomerController::class, 'getTopCustomerCountries']);
// 4. Get the top 5 customers by total orders.
Route::get('/customers/top-by-orders', [Api\CustomerController::class, 'getTopCustomersByOrders']);
// 10. Get the customer with the longest shipping time.
Route::get('/customers/longest-shipping', [Api\CustomerController::class, 'getCustomerWithLongestShippingTime']);

// 3. Get the top 2 product lines by total quantity ordered.
Route::get('/product-lines/top-selling', [Api\ProductLineController::class, 'getTopSellingProductLines']);

// 5. Get the total number of orders per year.
Route::get('/orders/per-year', [Api\OrderController::class, 'getOrdersPerYear']);

// 7. Get sales representatives and their total number of customers.
Route::get('/employees/sales-rep-customer-count', [Api\EmployeeController::class, 'getSalesRepresentativesWithCustomerCount']);

// 8. Get aggregated sales data per product vendor.
Route::get('/reports/vendor-sales', [Api\VendorReportController::class, 'getVendorSalesSummary']);
// 11. Get vendor names and their total orders.
Route::get('/vendors/total-orders', [Api\VendorReportController::class, 'getVendorTotalOrders']);

// 9. Get details of orders that are currently "On Hold".
Route::get('/orders/on-hold-details', [Api\OrderController::class, 'getOnHoldOrderDetails']);
