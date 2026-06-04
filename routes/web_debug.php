<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/debug-html', function () {
    Auth::loginUsingId(1); // Login as admin or whatever
    $projects = \App\Models\Project::with(['client', 'documents'])->latest()->get();
    return view('modul.properti.karyawan.dokumen', compact('projects'));
});
