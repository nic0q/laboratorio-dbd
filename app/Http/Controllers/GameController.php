<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
        if ($games->isEmpty()) {
          return response()->json([
            'respuesta' => 'No se encuentran juegos'
          ]);
        }
        return response($games, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:2|max:50',
                'description' => 'required|min:2|max:1000',
                'price' => 'required',
                'storage' => 'required',
                'age_restriction_id' => 'required|exists:age_restrictions,id',
                'url_id' => 'required|exists:urls,id',
                'demo_id' => 'required|exists:demos,id'

            ],
            [
                'name.required' => 'Debes ingresar un nombre',
                'name.min' => 'El nombre debe tener un largo minimo de 2 caracteres',
                'name.max' => 'El nombre excede el numero de caracteres',
                'description.required' => 'Debes ingresar una descripcion',
                'description.min' => 'La descripcion debe tener un largo minimo de 2 caracteres',
                'description.max' => 'La descripcion excede el maximo de caracteres',
                'price.required' => 'Debes ingresar un precio',
                'storage.required' => 'Debes ingresar un almacenamiento requerido',
                'age_restriction_id.required' => 'El ID de la restriccion de edad no existe',
                'url_id.required' => 'El ID del URL no es valido',
                'demo_id.required' => 'El ID de la demo no es valido',
            ]
        );
        
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $newGame = new Game();
        $newGame->name = $request->name;
        $newGame->description = $request->description;
        $newGame->price = $request->price;
        $newGame->storage= $request->storage;
        $newGame->age_restriction_id = $request->age_restriction_id;
        $newGame->url_id = $request->url_id;
        $newGame->demo_id = $request->demo_id;
        $newGame->save();
        return response()->json([
            'respuesta' => 'Se ha creado un nuevo juego',
            'id' => $newGame->id
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
        $game = Game::find($id);
        if (empty($game) or $game->delete == true) {
          return response("404 Not Found", 404);
        }
        return response($game, 200);
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:2|max:50',
                'description' => 'required|min:2|max:1000',
                'price' => 'required',
                'storage' => 'required',
                'age_restriction_id' => 'required|exists:age_restrictions,id',
                'url_id' => 'required|exists:urls,id',
                'demo_id' => 'required|exists:demos,id'

            ],
            [
                'name.required' => 'Debes ingresar un nombre',
                'name.min' => 'El nombre debe tener un largo minimo de 2 caracteres',
                'name.max' => 'El nombre excede el numero de caracteres',
                'description.required' => 'Debes ingresar una descripcion',
                'description.min' => 'La descripcion debe tener un largo minimo de 2 caracteres',
                'description.max' => 'La descripcion excede el maximo de caracteres',
                'price.required' => 'Debes ingresar un precio',
                'storage.required' => 'Debes ingresar un almacenamiento requerido',
                'age_restriction_id.required' => 'El ID de la restriccion de edad no existe',
                'url_id.required' => 'El ID del URL no es valido',
                'demo_id.required' => 'El ID de la demo no es valido',
            ]
            );
            if ($validator->fails()) {
                return response($validator->errors());
            }
        $game = Game::find($id);
        if (empty($game) or $game->delete == true) {
            return response("404 Not Found", 404);
        }
        $game->name = $request->name;
        $game->description = $request->description;
        $game->price = $request->price;
        $game->storage = $request->storage;
        $game->age_restriction_id = $request->age_restriction_id;
        $game->url_id = $request->url_id;
        $game->demo_id = $request->demo_id;
        $game->save();
        return response()->json(
            [
              'respuesta' => 'Se ha modificado el juego',
              'id' => $game->id
            ],
            200
          );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game= Game::find($id);
        if (empty($game) or $game->delete == true) {
          return response("404 Not Found", 404);
        }
        $game->delete = true;
        $game->save();
        return response()->json(
          [
            'respuesta' => 'Se borrado el juego',
            'id' => $game->id
          ],
          200
        );
    }
}
