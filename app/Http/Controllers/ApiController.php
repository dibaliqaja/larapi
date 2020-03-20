<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Provinces;
use App\Cities;
use App\Areas;
use \Validator;

class ApiController extends Controller
{
    // public $loginAfterSignUp = true;

    // public function register(RegisterAuthRequest $request)
    // {
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);
    //     $user->save();

    //     if ($this->loginAfterSignUp) {
    //         return $this->login($request);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $user
    //     ], Response::HTTP_OK);
    // }

    // public function login(Request $request)
    // {
    //     $input = $request->only('email', 'password');
    //     $jwt_token = null;

    //     if (!$jwt_token = JWTAuth::attempt($input)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid Email or Password',
    //         ], Response::HTTP_UNAUTHORIZED);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'token' => $jwt_token,
    //     ]);
    // }

    // public function logout(Request $request)
    // {
    //     $this->validate($request, [
    //         'token' => 'required'
    //     ]);

    //     try {
    //         JWTAuth::invalidate($request->token);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User logged out successfully'
    //         ]);
    //     } catch (JWTException $exception) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Sorry, the user cannot be logged out'
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // public function getAuthUser(Request $request)
    // {
    //     $this->validate($request, [
    //         'token' => 'required'
    //     ]);

    //     $user = JWTAuth::authenticate($request->token);

    //     return response()->json(['user' => $user]);
    // }

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
        //validate data
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
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Area Gagal Dihapus!',
            ], 500);
        }
    }
    // END Area

}
