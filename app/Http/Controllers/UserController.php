<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departmant;
use App\Models\UserInformation;

class UserController extends Controller
{
    /**
     * 初期画面表示
     * @return view
     */
    public function index()
    {
        // $userInformations = UserInformation::all();

        $userInformations = DB::table('userInformations')
        ->join('departments', 'userInformations.department_id', '=', 'departments.id')
        ->select('userInformations.*', 'departments.department')
        ->orderBy('userInformations.id', 'ASC')
        // ->orderByRaw('CAST(departments.id as SIGNED) ASC')
        ->get();
        // dd($userInformations);
        return view('index', compact('userInformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        DB::beginTransaction();
        try {
            UserInformation::create([
                'name' => $data['name'],
                'department_id' => $data['department'],
                'mail' => $data['email'],
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            abort(500);
            DB::rollBack();
        }

        $userInformations = DB::table('userInformations')
        ->join('departments', 'userInformations.department_id', '=', 'departments.id')
        ->select('userInformations.*', 'departments.department')
        ->orderBy('userInformations.id', 'ASC')
        // ->orderByRaw('CAST(departments.id as SIGNED) ASC')
        ->get();

        $datas = $userInformations[count($userInformations)-1];


        return ['datas' => $datas];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->all();
    }
}
