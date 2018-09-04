<?php

namespace App\Http\Controllers\Sdm;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
// use models below here
use App\Models\M_Religion;

class ReligionController extends Controller
{
    protected $model_name = 'App\Models\M_Religion';

    public function list(Request $request){
        // $religions = M_Religion::all();
        // $religions = DB::table('religion')->get();
        // $religions = DB::table('religion')
                // ->select('religion_name as agama', 'religion_id as nomor_agama')
                // ->where('religion_id','<=',6)
                // ->orderBy('religion_id', asc)
                // ->get();
        // source above just experimental code =====================
        $data = DB::table('religion')->get();
        $totalData = M_Religion::count();
        
            $data = array(
                'status     '=> 'Ok',
                'code       '=> 200,
                'message    '=> 'List semua data berhasil ditampilkan',
                'total row  '=> $totalData,
                'data       '=> $data
            );
        

        return response()->json($data,200);
    }
    
    public function detail($id){
        // $religion = M_Religion::findOrFail($id);
        $data = DB::table('religion')
                    // ->select('religion_name as agama','religion_id as nomor_agama')
                    ->where('religion_id','=',$id)
                    ->get();
        $data = array(
            'status     '=> 'Ok',
            'code       '=> 200,
            'message    '=> 'Detail data berhasil ditampilkan',
            'data       '=> $data
        );
        return response()->json($data,200);
    }

    public function insert(Request $request){//fungsi insert data religion

        $date = date('Y-m-d');
		$dateInt = str_replace('-', '', $date);
		$time = date('H:i:s');
        $timeInt = str_replace(':', '', $time);

        DB::beginTransaction();
        try{
            $model = app($this->model_name);
            $request->request->add(
                [
                    'religion_name'     => $request->get('religion_name'),
                    'religion_crdate'   => date('Y-m-d H:i:s'),
                    'religion_update'   => date('Y-m-d H:i:s'),
                    'religion_dldate'   => date('Y-m-d H:i:s'),
                ]
            );

            $check = $model::where('religion_name', 'ilike',  $request->get('religion_name'))->first();

            if(!$check){// if there's no redundant data in table
                $request_religion = array(
                    'religion_name' => $request->get('religion_name'),
                    'religion_crdate'   => date('Y-m-d H:i:s'),
                    'religion_update'   => date('Y-m-d H:i:s'),
                    'religion_dldate'   => date('Y-m-d H:i:s')
                );
                $response = $model::insert($request_religion);
                DB::commit();
                $religion = DB::table('religion')
                    ->where('religion_name','=',$request->get('religion_name'))
                    ->get();
                
                $data = array(
                            'status     '=> 'Created',
                            'code       '=> 201,
                            'message    '=> 'nama agama berhasil disimpan',
                            'nama agama '=> $request->get('religion_name'),
                            'data       '=> $religion
                );
                return response()->json($data, 200);
            }else{
                $religion = DB::table('religion')
                    ->where('religion_name','=',$request->get('religion_name'))
                    ->get();
                $data = array(
                            'status       '=> 'Not Implemented',
                            'code         '=> 501,
                            'message      '=> 'nama agama sudah ada',
                            'nama agama   '=> $request->get('religion_name'),
                            'related data '=> $religion
                );
                return response()->json($data,200);
            }
        }catch (\Illuminate\Database\QueryException $ex){
            DB::rollBack();
            $message = $this->getErrorMessage($ex->getCode());
            $data = array(
                        'status'    => 0,
                        'code'      => 500,
                        'message'   => $ex->getMessage(),
            );
            return response()->json($data, 200);
        }
        return response()->json($data, 200);
    }

}
