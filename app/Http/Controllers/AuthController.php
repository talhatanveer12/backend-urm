<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Academia;
use App\Models\Recruiter;
use App\Models\DelOfficer;
use Illuminate\Http\Request;
use App\Models\UrmCandidates;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;
use App\Http\Requests\ResigterRequest;
use App\Http\Controllers\AuthController;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login','forgotPassword', 'resetPassword', 'resigter']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resigter(ResigterRequest $request)
    {
        //return response()->json(['status' => false, 'message' => "test"], 200);
        try {

            //dd($request->all());

            $data = $request->all();

            //$inputs['password'] = Hash::make($inputs['password']);

            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'dob' => $data['dob'],
                'address' => $data["address"],
                'role_id' => $data['role']
            ]);

            if ($data['role'] === '2') {

                UrmCandidates::create([
                    'user_id' => $user->id,
                    'frist_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'nationality' => $data['nationality'],
                    'ethnicity' => $data['ethnicity'],
                    'eduction' => $data['education'],
                    'research_experience' => $data['researchExperience'],
                    'phone_number' => $data['phoneNo'],
                ]);
            } elseif ($data['role'] === '3') {

                Academia::create([
                    'user_id' => $user->id,
                    'institution_name' => $data['institutionName'],
                    'institution_address' => $data['institutionAddress'],
                    'phone_number' => $data['phoneNo'],
                ]);
            } elseif ($data['role'] === '4') {

                Recruiter::create([
                    'user_id' => $user->id,
                    'company_name' => $data['companyName'],
                    'company_address' => $data['companyAddress'],
                    'phone_number' => $data['phoneNo'],
                ]);
            } elseif ($data['role'] === '5') {

                DelOfficer::create([
                    'user_id' => $user->id,
                    'organization_name' => $data['organizationName'],
                    'organization_address' => $data['organizationAddress'],
                    'phone_number' => $data['phoneNo'],
                ]);
            }


            //dd($inputs);



            $credentials = array(
                'email' => $request->email,
                'password' => $request->password,
            );

           // return response()->json(['status' => false, 'message' => "test"], 200);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['status' => false, 'message' => "Please Provide Valid Credentials"], 401);

                // return response()->error('Invalid Credentials!', 'Please Provide Valid Credentials', 401);

            } else {

                $user = auth('api')->user();

                $data = new AdminResource($user);

                return response()->json(['status' => true, 'data' => $data, 'token' => $token, 'message' => 'Successfully login'], 200);
            }

        } catch (Throwable $e) {
            // something went wrong
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        //return response()->json(['status' => false, 'message' => "test"], 200);
        try {

            $credentials = array(
                'email' => $request->email,
                'password' => $request->password,
            );

           // return response()->json(['status' => false, 'message' => "test"], 200);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['status' => false, 'message' => "Please Provide Valid Credentials"], 401);

                // return response()->error('Invalid Credentials!', 'Please Provide Valid Credentials', 401);

            } else {

                $user = auth('api')->user();

                $data = new AdminResource($user);

                return response()->json(['status' => true, 'data' => $data, 'token' => $token, 'message' => 'Successfully login'], 200);
            }

        } catch (Throwable $e) {
            // something went wrong
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'errors' => $e->getMessage()], 500);
        }
    }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //return response()->json(['status' => false, 'message' => "test"], 200);
        try {
            $data = new AdminResource(auth()->user());
            return response()->json(['status' => true, 'data' => $data, 'message' => 'User Found Successfully!'], 200);
            //return response()->success(new UserResource(auth()->user()), 'User Found Successfully!', 200);
        } catch (Throwable $e) {
            // something went wrong
            return response()->error($e->getMessage(), $e->getMessage(), 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {

            auth()->logout();

            return response()->json(['status' => true,'message' => 'User successfully signed out!'], 200);

        } catch (Throwable $e) {
            // something went wrong
            return response()->error($e->getMessage(), $e->getMessage(), 500);
        }
    }
}