<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollDataTableController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Poll::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })->rawColumns(['action'])->make(true);
            }
            return view('pollDataTable');
    }
}
