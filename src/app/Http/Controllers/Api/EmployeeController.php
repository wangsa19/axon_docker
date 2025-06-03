<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Get sales representatives and their total number of customers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesRepresentativesWithCustomerCount()
    {
        $salesReps = DB::table('customers as c')
            ->select(
                'e.employeeNumber',
                DB::raw('CONCAT(e.firstName, " ", e.lastName) as representativename'),
                DB::raw('COUNT(c.customerNumber) as total_customers')
            )
            ->join('employees as e', 'c.salesRepEmployeeNumber', '=', 'e.employeeNumber')
            ->whereNotNull('c.salesRepEmployeeNumber') // Menggunakan whereNotNull sebagai pengganti 'is not null'
            ->groupBy('e.employeeNumber', 'representativename') // Group by both employeeNumber and representativename for correctness
            ->orderByDesc('total_customers')
            ->get();

        return response()->json([
            'message' => 'Sales representatives with customer count retrieved successfully',
            'data' => $salesReps
        ]);
    }
}
