<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function index()
    {
        // 1. String functions on real product data
        $products = DB::select("
            SELECT
                product_id,
                name,
                CONCAT(name, ' - ₱', price) AS product_with_price,
                LENGTH(description) AS description_length,
                LOWER(name) AS name_lowercase,
                UPPER(name) AS name_uppercase,
                SUBSTR(description, 1, 20) AS short_description,
                LEFT(name, 5) AS name_prefix,
                RIGHT(name, 5) AS name_suffix,
                FORMAT(price, 2) AS formatted_price,
                TRIM(description) AS cleaned_description
            FROM products
            LIMIT 5
        ");

        // 2. CASE expression based on quantity
        $quantities = DB::select("
            SELECT
                sale_item_id,
                quantity,
                CASE
                    WHEN quantity = 1 THEN 'Single Item'
                    WHEN quantity BETWEEN 2 AND 4 THEN 'Few Items'
                    ELSE 'Bulk Order'
                END AS quantity_type
            FROM sales_items
            LIMIT 5
        ");

        // 3. IF expression from real sales
        $sales = DB::select("
            SELECT
                sale_id,
                payment_method,
                IF(payment_method = 'CASH', 'Cash Payment', 'Other Payment') AS payment_type
            FROM sales
            LIMIT 5
        ");

        // 4. LIKE examples from real customer names
        $customers = DB::select("
            SELECT
                customer_id,
                first_name,
                last_name,
                CONCAT(first_name, ' ', last_name) AS full_name,
                CONCAT(first_name, ' ', last_name) LIKE '%Maria%' AS contains_maria,
                CONCAT(first_name, ' ', last_name) LIKE 'Maria%' AS starts_with_maria,
                CONCAT(first_name, ' ', last_name) LIKE '%Reyes' AS ends_with_reyes
            FROM customers
            LIMIT 5
        ");

        // 5. Aggregate and summary queries
        $summary = DB::select("
            SELECT
                (SELECT COUNT(*) FROM customers) AS total_customers,
                (SELECT COUNT(*) FROM sales) AS total_sales,
                (SELECT COUNT(*) FROM products) AS total_products,
                (SELECT SUM(total_amount) FROM sales) AS total_revenue,
                (SELECT AVG(price) FROM products) AS average_product_price,
                (SELECT MAX(price) FROM products) AS max_price,
                (SELECT MIN(price) FROM products) AS min_price
        ");

        return response()->json([
            'products' => $products,
            'sales_items' => $quantities,
            'sales' => $sales,
            'customers' => $customers,
            'summary' => $summary
        ]);
    }
}
