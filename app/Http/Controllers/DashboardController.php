<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function cliente()
    {
        return view('dashboard.cliente', [
            'user' => auth()->user(),
        ]);
    }

    public function empleado()
    {
        return view('dashboard.empleado', [
            'user' => auth()->user(),
        ]);
    }

    public function gerente()
    {
        return view('dashboard.gerente', [
            'user'       => auth()->user(),
            'totalUsers' => \App\Models\User::count(),
        ]);
    }
}
