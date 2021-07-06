<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        foreach ($employee as $e){
            $e->foto = url('storage/'.$e->foto);
        }
        return response([
            'status' => true,
            'message' => "List Data Karyawan",
            'data' => $employee
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'umur' => 'required|numeric',
            'alamat' => 'required|string',
            'jabatan' => 'required|string',
            'foto' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }

        if(request()->file('foto')){
            $thumbnailUrl = request()->file('foto')->store('images/employees');
        } else {
            $thumbnailUrl = null;
        }

        $attr = $request->all();
        $attr['foto'] = $thumbnailUrl;
        $employee = Employee::create($attr);
        return response([
            'status' => true,
            'message' => "Data Karyawan Berhasil Ditambahkan",
            'data' => $employee
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'umur' => 'required|numeric',
            'alamat' => 'required|string',
            'jabatan' => 'required|string',
            'foto' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }

        if(request()->file('foto')){
            \Storage::delete($employee->foto);
            $thumbnailUrl = request()->file('foto')->store('images/employees');
        } else {
            $thumbnailUrl = request()->file('foto')->store('images/employees');
        }

        $employee->nama = $request->nama;
        $employee->umur = $request->umur;
        $employee->alamat = $request->alamat;
        $employee->jabatan = $request->jabatan;
        $employee->foto = $thumbnailUrl;
        $employee->save();
        return response([
            'status' => true,
            'message' => "Data Karyawan Berhasil Diubah",
            'data' => $employee
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        \Storage::delete($employee->foto);
        $employee->delete();
        return response([
            'status' => true,
            'message' => "Data Biodata Berhasil Dihapus"
        ], 200);
    }
}
