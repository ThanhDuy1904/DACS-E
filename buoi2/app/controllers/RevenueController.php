<?php
require_once 'app/config/database.php';
require_once 'app/models/RevenueModel.php';

class RevenueController {
    private $conn;
    private $revenueModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->revenueModel = new RevenueModel($this->conn);
    }

    // Main revenue dashboard
    public function index() {
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Get revenue data
        $year = $_GET['year'] ?? date('Y');
        $monthlyRevenue = $this->revenueModel->getMonthlyRevenue($year);
        $yearlyRevenue = $this->revenueModel->getYearlyRevenue();
        $topProducts = $this->revenueModel->getTopSellingProducts($year);
        $dailyStats = $this->revenueModel->getDailyRevenueStats($year, date('m'));

        // Calculate totals
        $totalRevenue = array_sum(array_column($monthlyRevenue, 'total_revenue'));
        $totalOrders = array_sum(array_column($monthlyRevenue, 'total_orders'));

        require 'app/views/revenue/index.php';
    }

    // API endpoint for chart data
    public function getRevenueData() {
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $year = $_GET['year'] ?? date('Y');
        $data = [
            'monthly' => $this->revenueModel->getMonthlyRevenue($year),
            'daily' => $this->revenueModel->getDailyRevenueStats($year, $_GET['month'] ?? date('m')),
            'yearly' => $this->revenueModel->getYearlyRevenue()
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Export revenue data
    public function export() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $year = $_GET['year'] ?? date('Y');
        $format = $_GET['format'] ?? 'csv';
        $data = $this->revenueModel->getMonthlyRevenue($year);

        if ($format === 'csv') {
            $this->exportToCSV($data, $year);
        } elseif ($format === 'excel') {
            $this->exportToExcel($data, $year);
        }
    }

    private function exportToCSV($data, $year) {
        $filename = "doanh_thu_{$year}.csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['Tháng', 'Doanh thu', 'Số đơn hàng', 'Giá trị trung bình/đơn']);
        
        foreach ($data as $row) {
            fputcsv($output, [
                "Tháng {$row['month']}",
                number_format($row['total_revenue'], 0, ',', '.') . ' đ',
                $row['total_orders'],
                number_format($row['avg_order_value'], 0, ',', '.') . ' đ'
            ]);
        }
        
        fclose($output);
        exit;
    }

    private function exportToExcel($data, $year) {
        // Simple HTML table export for Excel
        $filename = "doanh_thu_{$year}.xls";
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<table border="1">';
        echo '<tr><th>Tháng</th><th>Doanh thu</th><th>Số đơn hàng</th><th>Giá trị trung bình/đơn</th></tr>';
        
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>Tháng ' . $row['month'] . '</td>';
            echo '<td>' . number_format($row['total_revenue'], 0, ',', '.') . ' đ</td>';
            echo '<td>' . $row['total_orders'] . '</td>';
            echo '<td>' . number_format($row['avg_order_value'], 0, ',', '.') . ' đ</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        exit;
    }
}
?>
