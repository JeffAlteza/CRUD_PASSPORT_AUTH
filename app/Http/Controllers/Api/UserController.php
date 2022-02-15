<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }


        $data=[
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password),
        ];
        $user= User::create($data);
        $token=$user->createToken('codesolution')->accessToken;
        $user->token=$token;
        return response()->json([
            'status' => true,
            'message' => 'User Created Succesfully',
            'data' => $user,

        ],
        200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $user = User::all();
        return response()->json([
            'data' => $user,
        ],
        200);
    }
    public function show_specific(Request $request,$id)
    {
        //
        $user = User::find($id);
        return response()->json([
            'data' => $user,
        ],
        200);
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
  



    public function update(Request $request, $id) {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        $user->update($request->all());
        return response($user, 200);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        //
        $user= User::find($id);
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Succesfully Deleted',
            'data' => $user,

        ],200);

    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        $user = User::where('email', $request->email)->first();
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('codesolution')->accessToken;
            //$user = User::all();
            return response()->json([
            'status' => true,
            'message' => 'Succesfully Logged in',
            'token' => $token,
            'data' => $user,
        ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    
}
