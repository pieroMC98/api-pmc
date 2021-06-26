<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->showAll(User::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//no hace falta, ya esta creado
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required',
			'email' => ['required', 'email', 'unique:user'],
			'password' => ['required', 'min:6', 'confirmed'],
		];

		$this->validate($request, $rules);
		$value = $request->all();
		$value['password'] = bcrypt($request->password);
		$value['verified'] = User::USER_NOT_VERIFIED;
		$value['admin'] = User::REGULAR;
		$value['verication_token'] = User::generateToken();
		//       return response()->json(['data'=>User::create($value)],201);
		return $this->showOne(User::create($value));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		/* return response()->json(['show'=>User::findOrFail($id)]); */
		// inyecciones implicitas
		//return $this->showOne(User::findOrFail($id));
		return $this->showOne($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		// no hace falta
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		//$user = User::findOrFail($id);
		$rules = [
			'email' => ['email', 'unique:user,email,' . $user->id],
			'password' => ['min:6', 'confirmed'],
			'admin' => 'in:' . User::REGULAR . ',' . User::ADMIN,
		];
		$this->validate($request, $rules);

		if ($request->has('name')) {
			$user->name = $request->name;
		}

		if ($request->has('email') && $user->email != $request->email) {
			$user->verified = User::USER_NOT_VERIFIED;
			$user->verification_token = User::generateToken();
			$user->email = $request->email;
		}

		if ($request->has('password')) {
			$user->password = bcrypt($request->password);
		}

		if ($request->has('admin')) {
			if ($user->isVerified()) {
				return $this->errorResponse(
					[
						'error' =>
							'only verified user can update his administratior value',
						'code' => 409,
					],
					409
				);
			}
			$user->admin = $request->admin;
		}

		if (!$user->isDirty()) {
			return $this->errorResponse(
				[
					'error' => 'you must update one value at least',
					'code' => 422,
				],
				422
			);
		}

		$user->save();
		/* return response()->json(['data'=>$user],200); */
		return $this->showOne($user);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		//$user = User::findOrFail($id);
		$user->delete();
	}

	function verify($token)
	{
		$user = User::where('verification_token', $token)->firstOrFail();
		$user->verified = User::USER_VERIFIED;
		$user->verification_token = null;
		$user->save();
		return $this->showMsg('La cuenta ha sido verificada');
	}
}
