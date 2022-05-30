<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    public function update(Request $request)
    {

        $header = $request->header("Authorization");
        if ($header == "") {
            $message = "Authentication is required";
            return response()->json(['message' => $message]);
        } else {
            if ($header == "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImJhbmdsYSBwdXp6bGUiLCJpYXQiOjE1MTYyMzkwMjJ9.BqUL6qa_rYqaeaMgA4t5LBoQBIck4qaOpW7hBnKA2B0") {
                if ($request->isMethod("post")) {
                    $data = $request->all();
                    $image = $request->file('image');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(300, 300)->save("frontend/media/" . $name_gen);
                    $save_url = "frontend/media/" . $name_gen;
                    $user = new User();
                    $user->name = $data['name'];
                    $user->name = bcrypt($data['password']);
                    $user->image = $save_url;

                    $user->save();

                    $message = "profile image successfully uploaded";
                    return response()->json(['message' => $message]);
                }
            } else {
                $message = "Authentication doesnot match";
                return response()->json(['message' => $message]);
            }
        }
    }
}