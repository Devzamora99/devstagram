<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //Proteger la ruta
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('perfil/index');
    }

    public function store(Request $request)
    {
        //Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Laravel recomienda utilizar un arreglo cuando se validara con mas de cuatro reglas un dato del formulario
        $this->validate($request, [
            'username' => ["required","unique:users,username,".auth()->user()->id,"min:3","max:20", 'not_in:twitter,editar-perfil'],
            'email' => ["required","unique:users,email,".auth()->user()->id,"email","max:60"],
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);

        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
