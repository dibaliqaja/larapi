<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Provinces;
use App\Cities;
use App\Areas;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Validator;

class ApiController extends Controller
{
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
            LogActivity::addToLog('User logged out');
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        LogActivity::addToLog('User login');
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        LogActivity::addToLog('Registered New User');
        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function tesAuth() {
        $data = "Welcome " . Auth::user()->name;
        return response()->json($data, 200);
    }

    // START PROVINCES
    public function getIndexProvinces()
    {
        $provinces = Provinces::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Provinsi',
            'data'    => $provinces
        ], 200);
    }

    public function storeProvinces(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code'     => 'required',
            'province_name'     => 'required|min:3|max:100'
        ],
            [
                'province_code.required' => 'Masukkan Kode Provinsi !',
                'province_name.required' => 'Masukkan Nama Provinsi !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $province = Provinces::create([
                'province_code'   => $request->input('province_code'),
                'province_name'   => $request->input('province_name')
            ]);
            if ($province) {
                return response()->json([
                    'success' => true,
                    'message' => 'Provinsi Berhasil Disimpan!',
                ], 200);
                LogActivity::addToLog('Province Created');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Provinsi Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function showProvinces($id)
    {
        $province = Provinces::whereId($id)->first();
        if ($province) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Provinsi!',
                'data'    => $province
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Provinsi Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function updateProvinces(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code'     => 'required',
            'province_name'     => 'required|min:3|max:100'
        ],
            [
                'province_code.required' => 'Masukkan Kode Provinsi !',
                'province_name.required' => 'Masukkan Nama Provinsi !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $province = Provinces::whereId($request->input('id'))->update([
                'province_code'     => $request->input('province_code'),
                'province_name'     => $request->input('province_name'),
            ]);
            if ($province) {
                return response()->json([
                    'success' => true,
                    'message' => 'Provinsi Berhasil Diupdate!',
                ], 200);
                LogActivity::addToLog('Province Updated');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Provinsi Gagal Diupdate!',
                ], 500);
            }
        }
    }

    public function destroyProvinces($id)
    {
        $province = Provinces::findOrFail($id);
        $province->delete();

        if ($province) {
            return response()->json([
                'success' => true,
                'message' => 'Provinsi Berhasil Dihapus!',
            ], 200);
            LogActivity::addToLog('Province Deleted');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Provinsi Gagal Dihapus!',
            ], 500);
        }
    }
    // END PROVINCES

    // START CITY
    public function getIndexCity()
    {
        $city = Cities::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Kota',
            'data'    => $city
        ], 200);
    }

    public function storeCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code'   => 'required',
            'city_code'     => 'required',
            'city_name'     => 'required|min:3|max:100'
        ],
            [
                'city_code.required' => 'Masukkan Kode Kota !',
                'city_name.required' => 'Masukkan Nama Kota !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $city = Cities::create([
                'province_code'     => $request->input('province_code'),
                'city_code'         => $request->input('city_code'),
                'city_name'         => $request->input('city_name')
            ]);
            if ($city) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kota Berhasil Disimpan!',
                ], 200);
                LogActivity::addToLog('City Created');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kota Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function showCity($id)
    {
        $city = Cities::whereId($id)->first();

        if ($city) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Kota!',
                'data'    => $city
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kota Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function updateCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code' => 'required',
            'city_code'     => 'required',
            'city_name'     => 'required|min:3|max:100'
        ],
            [
                'city_name.required' => 'Masukkan Kode Kota !',
                'city_name.required' => 'Masukkan Nama Kota !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $city = Cities::whereId($request->input('id'))->update([
                'province_code'     => $request->input('province_code'),
                'city_code'         => $request->input('city_code'),
                'province_name'     => $request->input('province_name'),
            ]);

            if ($city) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kota Berhasil Diupdate!',
                ], 200);
                LogActivity::addToLog('City Updated');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kota Gagal Diupdate!',
                ], 500);
            }
        }
    }

    public function destroyCity($id)
    {
        $city = Cities::findOrFail($id);
        $city->delete();

        if ($city) {
            return response()->json([
                'success' => true,
                'message' => 'Kota Berhasil Dihapus!',
            ], 200);
            LogActivity::addToLog('City Deleted');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kota Gagal Dihapus!',
            ], 500);
        }

    }
    // END CITY

    // START AREA
    public function getIndexArea()
    {
        $area = Areas::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Area',
            'data'    => $area
        ], 200);
    }

    public function storeArea(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'province_code'   => 'required',
            'city_code'       => 'required',
            'area_code'     => 'required',
            'area_name'     => 'required|min:3|max:100'
        ],
            [
                'area_code.required' => 'Masukkan Kode Area !',
                'area_name.required' => 'Masukkan Nama Area !',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $area = Areas::create([
                'province_code'     => $request->input('province_code'),
                'city_code'         => $request->input('city_code'),
                'area_code'         => $request->input('area_code'),
                'province_name'     => $request->input('area_name'),
            ]);

            if ($area) {
                return response()->json([
                    'success' => true,
                    'message' => 'Area Berhasil Disimpan!',
                ], 200);
                LogActivity::addToLog('Area Created');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Area Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function showArea($id)
    {
        $area = Areas::whereId($id)->first();

        if ($area) {
            return response()->json([
                'success' => true,
                'message' => 'Area Ditemukan!',
                'data'    => $area
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Area Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function updateArea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code'   => 'required',
            'city_code'       => 'required',
            'area_code'     => 'required',
            'area_name'     => 'required|min:3|max:100'
        ],
            [
                'area_code.required' => 'Masukkan Kode Area !',
                'area_name.required' => 'Masukkan Nama Area !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $area = Areas::whereId($request->input('id'))->update([
                'province_code'     => $request->input('province_code'),
                'city_code'         => $request->input('city_code'),
                'area_code'         => $request->input('area_code'),
                'province_name'     => $request->input('area_name'),
            ]);

            if ($area) {
                return response()->json([
                    'success' => true,
                    'message' => 'Area Berhasil Diupdate!',
                ], 200);
                LogActivity::addToLog('Area Updated');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Area Gagal Diupdate!',
                ], 500);
            }
        }
    }

    public function destroyArea($id)
    {
        $area = Areas::findOrFail($id);
        $area->delete();

        if ($area) {
            return response()->json([
                'success' => true,
                'message' => 'Area Berhasil Dihapus!',
            ], 200);
            LogActivity::addToLog('Area Deleted');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Area Gagal Dihapus!',
            ], 500);
        }
    }
    // END Area

}
