<?php

namespace App\Http\Controllers;

use Validator, Redirect, Response;

use App\User;
use App\Quarter;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\DDOCode;
use App\District;


class DashboardController extends Controller
{
    protected    $qurt_list = [
        1 => ['quarter_type' => 'A', 'area' => 'B-Colony Asarva, Meghani Nagar', 'total_quarter' => 64, 'vacant_quarter' => 0],
        2 => ['quarter_type' => 'B', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 0],
        3 => ['quarter_type' => 'B', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 3],
        4 => ['quarter_type' => 'B', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 1],
        5 => ['quarter_type' => 'B', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 0],
        6 => ['quarter_type' => 'B', 'area' => 'Sola Sarkari Vasahat', 'total_quarter' => 280, 'vacant_quarter' => 0],
        7 => ['quarter_type' => 'B', 'area' => 'G Colony, Sukhramnagar', 'total_quarter' => 357, 'vacant_quarter' => 18],
        8 => ['quarter_type' => 'B', 'area' => 'F Colony, Shah Alam', 'total_quarter' => 299, 'vacant_quarter' => 26],
        9 => ['quarter_type' => 'B', 'area' => 'Shahibaug Sarkari Vasahat, Dafnal', 'total_quarter' => 30, 'vacant_quarter' => 0],
        10 => ['quarter_type' => 'B1', 'area' => 'Dash Bangla, Gulbai Tekra', 'total_quarter' => 0, 'vacant_quarter' => 0],
        11 => ['quarter_type' => 'B1', 'area' => 'K Colony, Mithakhali', 'total_quarter' => 0, 'vacant_quarter' => 0],
        12 => ['quarter_type' => 'C', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 40, 'vacant_quarter' => 0],
        13 => ['quarter_type' => 'C', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 40, 'vacant_quarter' => 0],
        14 => ['quarter_type' => 'C', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 0],
        15 => ['quarter_type' => 'C', 'area' => 'Mamnagar Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 1],
        16 => ['quarter_type' => 'C', 'area' => 'Bodakdev Sarkari Vasahat, Bodakdev', 'total_quarter' => 52, 'vacant_quarter' => 0],
        17 => ['quarter_type' => 'C', 'area' => 'Shahibaug Sarkari Vasahat, Dafnal', 'total_quarter' => 80, 'vacant_quarter' => 4],
        18 => ['quarter_type' => 'C', 'area' => 'Vishram Nagar Sarkari Vasahat, Memnagar', 'total_quarter' => 52, 'vacant_quarter' => 0],
        19 => ['quarter_type' => 'C', 'area' => 'Dash Bangla, Gulbai Tekra', 'total_quarter' => 52, 'vacant_quarter' => 1],
        20 => ['quarter_type' => 'D', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 0],
        21 => ['quarter_type' => 'D', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 0],
        22 => ['quarter_type' => 'D', 'area' => 'Shahibaug Sarkari Vasahat', 'total_quarter' => 60, 'vacant_quarter' => 21],
        23 => ['quarter_type' => 'D1', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 3],
        24 => ['quarter_type' => 'D1', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 5],
        25 => ['quarter_type' => 'D1', 'area' => 'Shahibaug Sarkari Vasahat, Gayatri Mandir', 'total_quarter' => 12, 'vacant_quarter' => 0],
        26 => ['quarter_type' => 'E', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 40, 'vacant_quarter' => 0],
        27 => ['quarter_type' => 'E', 'area' => 'Shahibaug (24 Unit) Dafnal', 'total_quarter' => 24, 'vacant_quarter' => 5],
        28 => ['quarter_type' => 'E1', 'area' => 'Sampurn Flats, Gulbai Tekra', 'total_quarter' => 40, 'vacant_quarter' => 1],
        29 => ['quarter_type' => 'E1', 'area' => 'Sujalam Flats, Police Stadium Road, Shahibaug', 'total_quarter' => 14, 'vacant_quarter' => 1],
        30 => ['quarter_type' => 'Er', 'area' => 'Sampurn Flats, Gulbai Tekra', 'total_quarter' => 40, 'vacant_quarter' => 1],
        31 => ['quarter_type' => 'Er', 'area' => 'Sufalam Flats, Dafnal, Shahibaug', 'total_quarter' => 8, 'vacant_quarter' => 4],
        32 => ['quarter_type' => 'Er', 'area' => 'Bungalows (Shahibaug Dafnal)', 'total_quarter' => 13, 'vacant_quarter' => 0],
        33 => ['quarter_type' => 'K', 'area' => 'Sector-9', 'total_quarter' => 13, 'vacant_quarter' => 2],
        34 => ['quarter_type' => 'K', 'area' => 'Sector-19', 'total_quarter' => 28, 'vacant_quarter' => 2],
        35 => ['quarter_type' => 'K', 'area' => 'Sector-20', 'total_quarter' => 23, 'vacant_quarter' => 4],
        36 => ['quarter_type' => 'KH', 'area' => 'Sector-9', 'total_quarter' => 8, 'vacant_quarter' => 0],
        37 => ['quarter_type' => 'KH', 'area' => 'Sector-19', 'total_quarter' => 47, 'vacant_quarter' => 1],
        38 => ['quarter_type' => 'G', 'area' => 'Sector-9', 'total_quarter' => 69, 'vacant_quarter' => 19],
        39 => ['quarter_type' => 'G', 'area' => 'Sector-19', 'total_quarter' => 30, 'vacant_quarter' => 2],
        40 => ['quarter_type' => 'G', 'area' => 'Sector-20', 'total_quarter' => 24, 'vacant_quarter' => 0],
        41 => ['quarter_type' => 'G1', 'area' => 'Sector-8', 'total_quarter' => 32, 'vacant_quarter' => 0],
        42 => ['quarter_type' => 'G1', 'area' => 'Sector-9', 'total_quarter' => 36, 'vacant_quarter' => 0],
        43 => ['quarter_type' => 'G1', 'area' => 'Sector-19', 'total_quarter' => 40, 'vacant_quarter' => 0],
        44 => ['quarter_type' => 'G1', 'area' => 'Sector-20', 'total_quarter' => 40, 'vacant_quarter' => 0],
        45 => ['quarter_type' => 'G1', 'area' => 'Sector-23', 'total_quarter' => 31, 'vacant_quarter' => 0],
        46 => ['quarter_type' => 'G1', 'area' => 'Sector-30', 'total_quarter' => 31, 'vacant_quarter' => 0],
        47 => ['quarter_type' => 'GH', 'area' => 'Sector-8', 'total_quarter' => 36, 'vacant_quarter' => 0],
        48 => ['quarter_type' => 'GH', 'area' => 'Sector-17', 'total_quarter' => 44, 'vacant_quarter' => 0],
        49 => ['quarter_type' => 'GH', 'area' => 'Sector-19', 'total_quarter' => 84, 'vacant_quarter' => 0],
        50 => ['quarter_type' => 'GH', 'area' => 'Sector-20', 'total_quarter' => 68, 'vacant_quarter' => 0],
        51 => ['quarter_type' => 'GH', 'area' => 'Sector-21', 'total_quarter' => 32, 'vacant_quarter' => 0],
        52 => ['quarter_type' => 'GH', 'area' => 'Sector-22', 'total_quarter' => 48, 'vacant_quarter' => 0],
        53 => ['quarter_type' => 'GH', 'area' => 'Sector-23', 'total_quarter' => 36, 'vacant_quarter' => 0],
        54 => ['quarter_type' => 'GH', 'area' => 'Sector-28', 'total_quarter' => 20, 'vacant_quarter' => 0],
        55 => ['quarter_type' => 'GH', 'area' => 'Sector-29', 'total_quarter' => 8, 'vacant_quarter' => 0],
        56 => ['quarter_type' => 'GH', 'area' => 'Sector-30', 'total_quarter' => 0, 'vacant_quarter' => 0],
        57 => ['quarter_type' => 'GH1', 'area' => 'Sector-8', 'total_quarter' => 102, 'vacant_quarter' => 12],
        58 => ['quarter_type' => 'GH1', 'area' => 'Sector-13', 'total_quarter' => 27, 'vacant_quarter' => 0],
        59 => ['quarter_type' => 'GH1', 'area' => 'Sector-17', 'total_quarter' => 0, 'vacant_quarter' => 0],
        60 => ['quarter_type' => 'CH', 'area' => 'Sector-6 (Chandrashekhar Azad Nagar)', 'total_quarter' => 280, 'vacant_quarter' => 0],
        61 => ['quarter_type' => 'CH', 'area' => 'Sector-7', 'total_quarter' => 44, 'vacant_quarter' => 0],
        62 => ['quarter_type' => 'CH', 'area' => 'Sector-16', 'total_quarter' => 88, 'vacant_quarter' => 0],
        63 => ['quarter_type' => 'CH', 'area' => 'Sector-17', 'total_quarter' => 128, 'vacant_quarter' => 0],
        64 => ['quarter_type' => 'CH', 'area' => 'Sector-20', 'total_quarter' => 66, 'vacant_quarter' => 0],
        65 => ['quarter_type' => 'CH', 'area' => 'Sector-21', 'total_quarter' => 70, 'vacant_quarter' => 0],
        66 => ['quarter_type' => 'CH', 'area' => 'Sector-22', 'total_quarter' => 4, 'vacant_quarter' => 0],
        67 => ['quarter_type' => 'CH', 'area' => 'Sector-28', 'total_quarter' => 64, 'vacant_quarter' => 0],
        68 => ['quarter_type' => 'CH', 'area' => 'Sector-29', 'total_quarter' => 102, 'vacant_quarter' => 0],
        69 => ['quarter_type' => 'CH', 'area' => 'Sector-30 (Main)', 'total_quarter' => 130, 'vacant_quarter' => 0],
        70 => ['quarter_type' => 'CH', 'area' => 'Sector-30 (Category)', 'total_quarter' => 72, 'vacant_quarter' => 0],
        71 => ['quarter_type' => 'CH1', 'area' => 'Sector-6 (Veer Bhagat Singh Nagar)', 'total_quarter' => 672, 'vacant_quarter' => 0],
        72 => ['quarter_type' => 'CH1', 'area' => 'Sector-7', 'total_quarter' => 36, 'vacant_quarter' => 0],
        73 => ['quarter_type' => 'CH1', 'area' => 'Sector-7 (Shyamji Krishna Verma Park)', 'total_quarter' => 336, 'vacant_quarter' => 0],
        74 => ['quarter_type' => 'CH1', 'area' => 'Sector-8', 'total_quarter' => 90, 'vacant_quarter' => 19],
        75 => ['quarter_type' => 'CH1', 'area' => 'Sector-13', 'total_quarter' => 85, 'vacant_quarter' => 0],
        76 => ['quarter_type' => 'CH1', 'area' => 'Sector-12', 'total_quarter' => 0, 'vacant_quarter' => 0],
        77 => ['quarter_type' => 'CH1', 'area' => 'Sector-16', 'total_quarter' => 113, 'vacant_quarter' => 0],
        78 => ['quarter_type' => 'CH1', 'area' => 'Sector-17', 'total_quarter' => 164, 'vacant_quarter' => 0],
        79 => ['quarter_type' => 'CH1', 'area' => 'Sector-20', 'total_quarter' => 28, 'vacant_quarter' => 0],
        80 => ['quarter_type' => 'CH1', 'area' => 'Sector-21', 'total_quarter' => 329, 'vacant_quarter' => 0],
        81 => ['quarter_type' => 'CH1', 'area' => 'Sector-22', 'total_quarter' => 0, 'vacant_quarter' => 0],
        82 => ['quarter_type' => 'CH1', 'area' => 'Sector-23', 'total_quarter' => 252, 'vacant_quarter' => 0],
        83 => ['quarter_type' => 'CH1', 'area' => 'Sector-24', 'total_quarter' => 84, 'vacant_quarter' => 0],
        84 => ['quarter_type' => 'CH1', 'area' => 'Sector-28', 'total_quarter' => 46, 'vacant_quarter' => 0],
        85 => ['quarter_type' => 'CH1', 'area' => 'Sector-29', 'total_quarter' => 0, 'vacant_quarter' => 0],
        86 => ['quarter_type' => 'CH1', 'area' => 'Sector-29 Vande Mataram Park-3', 'total_quarter' => 280, 'vacant_quarter' => 0],
        87 => ['quarter_type' => 'CH1', 'area' => 'Sector-29 Vande Mataram Park-4', 'total_quarter' => 280, 'vacant_quarter' => 0],
        88 => ['quarter_type' => 'CH1', 'area' => 'Sector-30 (Main)', 'total_quarter' => 44, 'vacant_quarter' => 0],
        89 => ['quarter_type' => 'CH1', 'area' => 'Sector-30 (Category)', 'total_quarter' => 120, 'vacant_quarter' => 0],

        90 => ['quarter_type' => 'J-1', 'area' => 'Sector-6', 'total_quarter' => 0, 'vacant_quarter' => 0],
        91 => ['quarter_type' => 'J-1', 'area' => 'Sector-20', 'total_quarter' => 0, 'vacant_quarter' => 0],
        92 => ['quarter_type' => 'J-1', 'area' => 'Sector-23', 'total_quarter' => 24, 'vacant_quarter' => 0],
        93 => ['quarter_type' => 'J-1', 'area' => 'Sector-24', 'total_quarter' => 36, 'vacant_quarter' => 0],
        94 => ['quarter_type' => 'J-1', 'area' => 'Sector-29', 'total_quarter' => 0, 'vacant_quarter' => 0],
        95 => ['quarter_type' => 'J-2', 'area' => 'Sector-7', 'total_quarter' => 140, 'vacant_quarter' => 0],
        96 => ['quarter_type' => 'J-2', 'area' => 'Sector-12', 'total_quarter' => 60, 'vacant_quarter' => 0],
        97 => ['quarter_type' => 'J-2', 'area' => 'Sector-16', 'total_quarter' => 0, 'vacant_quarter' => 0],
        98 => ['quarter_type' => 'J-2', 'area' => 'Sector-23', 'total_quarter' => 132, 'vacant_quarter' => 0],
        99 => ['quarter_type' => 'J-2', 'area' => 'Sector-28', 'total_quarter' => 0, 'vacant_quarter' => 0],
        100 => ['quarter_type' => 'J-2', 'area' => 'Sector-30 (Category)', 'total_quarter' => 120, 'vacant_quarter' => 0],
        101 => ['quarter_type' => 'J', 'area' => 'Sector-6 (Veer Bhagat Singh Nagar)', 'total_quarter' => 280, 'vacant_quarter' => 0],
        102 => ['quarter_type' => 'J', 'area' => 'Sector-7', 'total_quarter' => 96, 'vacant_quarter' => 0],
        103 => ['quarter_type' => 'J', 'area' => 'Sector-13', 'total_quarter' => 78, 'vacant_quarter' => 0],
        104 => ['quarter_type' => 'J', 'area' => 'Sector-17', 'total_quarter' => 70, 'vacant_quarter' => 0],
        105 => ['quarter_type' => 'J', 'area' => 'Sector-20', 'total_quarter' => 0, 'vacant_quarter' => 0],
        106 => ['quarter_type' => 'J', 'area' => 'Sector-21', 'total_quarter' => 100, 'vacant_quarter' => 0],
        107 => ['quarter_type' => 'J', 'area' => 'Sector-22', 'total_quarter' => 150, 'vacant_quarter' => 0],
        108 => ['quarter_type' => 'J', 'area' => 'Sector-28', 'total_quarter' => 50, 'vacant_quarter' => 0],
        109 => ['quarter_type' => 'J', 'area' => 'Sector-29', 'total_quarter' => 142, 'vacant_quarter' => 0],
        110 => ['quarter_type' => 'J', 'area' => 'Sector-29 (Vande Mataram Park-1)', 'total_quarter' => 280, 'vacant_quarter' => 0],
        111 => ['quarter_type' => 'J', 'area' => 'Sector-29 (Vande Mataram Park-2)', 'total_quarter' => 168, 'vacant_quarter' => 0],
        112 => ['quarter_type' => 'J', 'area' => 'Sector-30 (Main)', 'total_quarter' => 92, 'vacant_quarter' => 0],
        113 => ['quarter_type' => 'J', 'area' => 'Sector-30 (Veer Savarkar Nagar)', 'total_quarter' => 336, 'vacant_quarter' => 0],
        114 => ['quarter_type' => 'CH-1', 'area' => 'Sector-6 (Veer Bhagat Singh Nagar)', 'total_quarter' => 672, 'vacant_quarter' => 0],
        115 => ['quarter_type' => 'CH-1', 'area' => 'Sector-7', 'total_quarter' => 36, 'vacant_quarter' => 0],
        116 => ['quarter_type' => 'CH-1', 'area' => 'Sector-7 (Shyamji Krishna Verma Park)', 'total_quarter' => 336, 'vacant_quarter' => 0],
        117 => ['quarter_type' => 'CH-1', 'area' => 'Sector-8', 'total_quarter' => 90, 'vacant_quarter' => 19],
        118 => ['quarter_type' => 'CH-1', 'area' => 'Sector-13', 'total_quarter' => 85, 'vacant_quarter' => 0],
        119 => ['quarter_type' => 'CHH', 'area' => 'Sector-12', 'total_quarter' => 0, 'vacant_quarter' => 0],
        120 => ['quarter_type' => 'CHH', 'area' => 'Sector-16', 'total_quarter' => 113, 'vacant_quarter' => 0],
        121 => ['quarter_type' => 'CHH', 'area' => 'Sector-17', 'total_quarter' => 164, 'vacant_quarter' => 0],
        122 => ['quarter_type' => 'CHH', 'area' => 'Sector-20', 'total_quarter' => 28, 'vacant_quarter' => 0],
        123 => ['quarter_type' => 'CHH', 'area' => 'Sector-21', 'total_quarter' => 329, 'vacant_quarter' => 0],
        124 => ['quarter_type' => 'CHH', 'area' => 'Sector-22', 'total_quarter' => 0, 'vacant_quarter' => 0],
        125 => ['quarter_type' => 'CHH', 'area' => 'Sector-23', 'total_quarter' => 252, 'vacant_quarter' => 0],
        126 => ['quarter_type' => 'CHH', 'area' => 'Sector-24', 'total_quarter' => 84, 'vacant_quarter' => 0],
        127 => ['quarter_type' => 'CHH', 'area' => 'Sector-28', 'total_quarter' => 46, 'vacant_quarter' => 0],
        128 => ['quarter_type' => 'CHH', 'area' => 'Sector-29', 'total_quarter' => 0, 'vacant_quarter' => 0],
        129 => ['quarter_type' => 'CHH', 'area' => 'Sector-29 Vande Mataram Park-3', 'total_quarter' => 280, 'vacant_quarter' => 0],
        130 => ['quarter_type' => 'CHH', 'area' => 'Sector-29 Vande Mataram Park-4', 'total_quarter' => 280, 'vacant_quarter' => 0],
        131 => ['quarter_type' => 'CHH', 'area' => 'Sector-30 (Main)', 'total_quarter' => 44, 'vacant_quarter' => 0],
        132 => ['quarter_type' => 'G-1', 'area' => 'Sector-8', 'total_quarter' => 32, 'vacant_quarter' => 0],
        133 => ['quarter_type' => 'G-1', 'area' => 'Sector-9', 'total_quarter' => 36, 'vacant_quarter' => 0],
        134 => ['quarter_type' => 'G-1', 'area' => 'Sector-19', 'total_quarter' => 40, 'vacant_quarter' => 0],
        135 => ['quarter_type' => 'G-1', 'area' => 'Sector-20', 'total_quarter' => 40, 'vacant_quarter' => 0],
        136 => ['quarter_type' => 'G-1', 'area' => 'Sector-23', 'total_quarter' => 31, 'vacant_quarter' => 0],
        137 => ['quarter_type' => 'G-1', 'area' => 'Sector-30', 'total_quarter' => 31, 'vacant_quarter' => 0],
        138 => ['quarter_type' => 'GH-1', 'area' => 'Sector-8', 'total_quarter' => 102, 'vacant_quarter' => 12],
139 => ['quarter_type' => 'GH-1', 'area' => 'Sector-13', 'total_quarter' => 27, 'vacant_quarter' => 0],
140 => ['quarter_type' => 'GH-1', 'area' => 'Sector-17', 'total_quarter' => 0, 'vacant_quarter' => 0],
141 => ['quarter_type' => 'E-1', 'area' => 'Samarpan Flat, Gulbai Tekra', 'total_quarter' => 40, 'vacant_quarter' => 1],
142 => ['quarter_type' => 'E-1', 'area' => 'Sujalam Flat, Police Stadium Paase, Shahibaug', 'total_quarter' => 14, 'vacant_quarter' => 1],
143 => ['quarter_type' => 'E-2', 'area' => 'Samarpan Flat, Gulbai Tekra', 'total_quarter' => 40, 'vacant_quarter' => 1],
144 => ['quarter_type' => 'E-2', 'area' => 'Suflam Flat, Dafnala, Shahibaug', 'total_quarter' => 8, 'vacant_quarter' => 4],
145 => ['quarter_type' => 'E-2', 'area' => 'Bungalow (Shahibaug Dafnala)', 'total_quarter' => 13, 'vacant_quarter' => 0],
146 => ['quarter_type' => 'D-1', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 3],
147 => ['quarter_type' => 'D-1', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 52, 'vacant_quarter' => 5],
148 => ['quarter_type' => 'D-1', 'area' => 'Vastrapur Sarkari Vasahat', 'total_quarter' => 40, 'vacant_quarter' => 0],
149 => ['quarter_type' => 'D-1', 'area' => 'Shahibaug Sarkari Vasahat, Gayatri Mandir Paase', 'total_quarter' => 12, 'vacant_quarter' => 0],
150 => ['quarter_type' => 'B-1', 'area' => 'Dash Bangla, Gulbai Tekra', 'total_quarter' => 0, 'vacant_quarter' => 0],
151 => ['quarter_type' => 'B-1', 'area' => 'K-Colony, Mithakhali', 'total_quarter' => 0, 'vacant_quarter' => 0],









    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $this->_viewContent['page_title'] = "Dashboard";
        return view('admin/dashboard', $this->_viewContent);
    }
    public function userdashboard()
    {

        $uid = Auth::user()->id;

        //to get ddo info
        $officecode = null;
        $usermaster = User::find($uid);
        //dd($usermaster);
        // Assuming the user has a 'cardex_no' attribute
        if ($usermaster) {
            // dd("hello");
             // Access the related ddocode*/
             Session::put('Name', $usermaster->name);
             Session::put('Uid', $uid);
            if($usermaster->from_old_awasallot_app === 1  && $usermaster->updated_to_new_awasallot_app === 0)
            {
            //     $basic_pay=$usermaster->basic_pay;
            //    $quartertype = Quarter::select('quartertype')->where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->first();
            //    dd($quartertype);
                return redirect('updateoldprofile');
            }
            Session::put('dcode',$usermaster->dcode);
            if($usermaster->from_old_awasallot_app === 1  && $usermaster->updated_to_new_awasallot_app === 2)
            {
            //     $basic_pay=$usermaster->basic_pay;
            //    $quartertype = Quarter::select('quartertype')->where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->first();
            //    dd($quartertype);
                $this->_viewContent['users'] = User::find($uid); //
                $this->_viewContent['imageData'] = generateImage($uid);
                $this->_viewContent['page_title']= "Old Profile Verfiy and  Update";
                return view('user/useroldprofile',$this->_viewContent);
            }
            if($usermaster->dcode != 6){
                Session::put('q_officecode', 28084);
            }
            else{
                Session::put('q_officecode', 28083);
            }
            if($usermaster->cardex_no !=0 )
            {
                Session::put('cardex_no',$usermaster->cardex_no);

            }
            if($usermaster->ddo_code != 0)
            {
                Session::put('ddo_code',$usermaster->ddo_code);
            }
            if($usermaster->cardex_no !=0 && $usermaster->ddo_code !=0)
            {
                $officecode = DDOCode::where('cardex_no', $usermaster->cardex_no)
                ->where('ddo_code', $usermaster->ddo_code)
                ->pluck('officecode')
                ->first();
                Session::put('officecode', $officecode);
            }
            /*if ($officecode) {
                Session::put('officecode', $officecode);
                if ($officecode != 28083) {
                    // q_officecode=28084 will be set for quarter type category if district is other than gandhinagar (that is for all districts other than gandhinagar)
                    Session::put('q_officecode', 28084);
                } else {
                    Session::put('q_officecode', $officecode);
                }
            }*/
        }


       
        Session::put('dcode',$usermaster->dcode);
        if ($usermaster->basic_pay == '') {
            return redirect('profile');
        } else {  //echo $usermaster->basic_pay;
            Session::put('basic_pay', $usermaster->basic_pay);
            //dd($usermaster->basic_pay);
            $q_officecode = Session::get('q_officecode', $officecode);
            //            dd($q_officecode);
            //  $this->_viewContent['quarterlist'] = Quarter::all();
            // $this->_viewContent['quarterlist'] = Quarter::all()->where('officecode',$q_officecode);
            $this->_viewContent['quarterlist'] = Quarter::where('officecode', $q_officecode)->get();
            //dd($this->_viewContent['quarterlist']);

            $this->_viewContent['notification'] = Notification::where('uid', '=',  $uid)->get();
            $basic_pay = Session::get('basic_pay');
            //dd($basic_pay);
            $this->_viewContent['quarterselect'] = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->first();
            //dd($this->_viewContent['quarterselect']);
            $this->_viewContent['page_title'] = "Dashboard";
            return view('user/dashboard', $this->_viewContent);
        }
    }
    // statc dashboard data showing functions-16/12/2024
    public function getQuarterType(Request $request)
    {
        $officecode = $request->input('officecode');
        //dd($officecode);
        $quartertype = [];
        if ($officecode != '28083') {
            $quartertype = [
                1 => 'A',
                2 => 'B',
                3 => 'C',
                4 => 'D',
                5 => 'E',
                6 => 'E-1',
                7 => 'E-2',
                20 => 'B-1',
                21 => 'D-1',
            ];
            return $quartertype;
        } else {
            $quartertype = [
                8 => 'J-1',
                9 => 'J-2',
                10 => 'CH',
                11 => 'CH-1',
                12 => 'CHH',
                13 => 'K',
                14 => 'KH',
                15 => 'G',
                16 => 'G-1',
                17 => 'GH',
                18 => 'GH-1',
                19 => 'J',
            ];
            //return $quartertype;
            // Return the quarter types as a JSON response
            return response()->json($quartertype);
        }
    }
    public function getAreaWiseQurtCnt(Request $request)
    {
        $quarter_type = $request->input('quarter_type');
        // Filter the array based on the quarter_type (either 'A' or 'B')
        $filtered_quarters = array_filter($this->qurt_list, function ($item) use ($quarter_type) {
            return $item['quarter_type'] == $quarter_type;
        });

        // Prepare the output where key is 'id' and value is 'area'
        $result = [];
        foreach ($filtered_quarters as $id => $item) {
            $result[$id] = $item['area']; // Set the key as id and value as area
        }

        // Return the result as a JSON response
        return response()->json($result);
    }
    public function getQuarterTotalList(Request $request)
    {
        $areaid = $request->input('area');
        $filtered_quarters = array_filter($this->qurt_list, function ($item) use ($areaid) {
            return $item['area'] == $areaid;
        });

        // Prepare the output where key is 'id' and value is 'area'
        $result = [];
        foreach ($filtered_quarters as $id => $item) {
            $result = [
                'total_quarters' => $item['total_quarter'],
                'vacant_quarters' => $item['vacant_quarter'],
            ];
        }

        // Return the result as a JSON response
        return response()->json($result);
    }
}
