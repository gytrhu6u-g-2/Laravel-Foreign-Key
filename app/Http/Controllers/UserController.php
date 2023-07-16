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
            ->get();
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
            ->get();

        $datas = $userInformations[count($userInformations) - 1];


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
     * 削除機能
     * @param request
     * @return array
     */
    public function destroy(Request $request)
    {
        $id = $request->all();

        $findId = UserInformation::where('id', $id)->get();

        if ($findId->isEmpty()) {
            return redirect(route('index'));
        }

        try {
            UserInformation::destroy($findId);
        } catch (\Throwable $th) {
            abort(500);
            DB::rollBack();
        }

        return ['id' => $findId];
    }

    /**
     * 検索結果
     * @param request
     * @return array
     */
    public function search(Request $request)
    {
        $request_id = $request->all();
        $id = (int) $request_id['id'];

        try {
            $results = DB::table('userInformations')
                ->join('departments', 'userInformations.department_id', '=', 'departments.id')
                ->select('userInformations.*', 'departments.department')
                ->where('userInformations.id', 'like', "%$id%")
                ->orderBy('userInformations.id', 'ASC')
                ->get();
        } catch (\Throwable $th) {
            abort(500);
        }


        return ['results' => $results];
    }
}
