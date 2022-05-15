<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class TodoController extends Controller
{
    public function index() {
        $data = [
            'records' => App\Todo::with('user')->get(),
        ];
        return view('todo.index', $data);
    }

    public function detail($id) {
        $data = [
            'records' => App\Todo::with('user')->find($id)
        ];
        return view('todo.detail', $data);
    }
}
