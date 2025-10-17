<?php
require_once '../app/helpers/helper.php'; // Include the helper file

class Tenant extends Controller
{
    private $userModel;

    public function __construct()
    {
        // Check if user is logged in and is a tenant
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'tenant') {
            redirect('users/login');
        }
    }

    // Main dashboard page
    public function index()
    {
        $data = [
            'title' => 'Tenant Dashboard - TenantHub',
            'page' => 'dashboard',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_dashboard', $data);
    }

    // Search properties page
    public function search_properties()
    {
        $data = [
            'title' => 'Search Properties - TenantHub',
            'page' => 'search_properties',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_search_properties', $data);
    }

    // My bookings page
    public function bookings()
    {
        $data = [
            'title' => 'My Bookings - TenantHub',
            'page' => 'bookings',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_bookings', $data);
    }

    // Pay rent page
    public function pay_rent()
    {
        $data = [
            'title' => 'Pay Rent - TenantHub',
            'page' => 'pay_rent',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_pay_rent', $data);
    }

    // Lease agreements page
    public function agreements()
    {
        $data = [
            'title' => 'Lease Agreements - TenantHub',
            'page' => 'agreements',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_agreements', $data);
    }

    // Report issue page
    public function report_issue()
    {
        $data = [
            'title' => 'Report Issues - TenantHub',
            'page' => 'report_issue',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_report_issue', $data);
    }

    // Track issues page
    public function track_issues()
    {
        $data = [
            'title' => 'Track Issues - TenantHub',
            'page' => 'track_issues',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_track_issues', $data);
    }

    // My reviews page
    public function my_reviews()
    {
        $data = [
            'title' => 'My Reviews - TenantHub',
            'page' => 'my_reviews',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_my_reviews', $data);
    }

    // Notifications page
    public function notifications()
    {
        $data = [
            'title' => 'Notifications - TenantHub',
            'page' => 'notifications',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_notifications', $data);
    }

    // Feedback page
    public function feedback()
    {
        $data = [
            'title' => 'Feedback - TenantHub',
            'page' => 'feedback',
            'user_name' => $_SESSION['user_name']
        ];

        $this->view('tenant/v_feedback', $data);
    }
}
