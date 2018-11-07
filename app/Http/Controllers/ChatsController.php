<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Chat, Mensaje };

class ChatsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'msg' => 'required|string',
            'chat' => 'required|numeric'
        ]);
        Mensaje::create([
            'usuario_id' => \Auth::user()->id,
            'chat_id' => $request->chat,
            'mensaje' => $request->msg,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat = Chat::where('empresa_id', \Auth::user()->id)
        ->orWhere('persona_id', \Auth::user()->id)
        ->findOrFail($id);
        return $chat->mensaje->where('id', '>', request()->last)->each(function ($m) {
            $m->date = [
                $m->created_at->format('Y'),
                $m->created_at->format('m') - 1,
                $m->created_at->format('d'),
                $m->created_at->format('H'),
                $m->created_at->format('i'),
                $m->created_at->format('s'),
            ];
            $usuario = $m->usuario->fullName();
            $m->logo = $m->usuario->getLogoPath();
            unset($m->usuario, $m->chat_id);
            $m->usuario = $usuario;
        });
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dataForRegister()
    {
        $chat = Chat::orderBy('id', 'DESC')->where('empresa_id', \Auth::user()->id)
        ->orWhere('persona_id', \Auth::user()->id)
        ->get(['id', 'persona_id', 'empresa_id', 'created_at']);
        $chat->each(function ($c) {
            if ($c->persona_id == \Auth::user()->id) {
                $c->usuario_id = $c->empresa->fullName();
                $c->logo = $c->empresa->getLogoPath();
            } else {
                $c->usuario_id = $c->persona->fullName();
                $c->logo = $c->persona->getLogoPath();
            }
            $c->last_msg = '';
            $c->msg_no_view = 0;
            $c->date = $c->created_at->diffForHumans();
            unset($c->empresa);
        });
        return response()->json([
            'user' => [
                'id' => \Auth::user()->id,
                'name' => \Auth::user()->fullName(),
                'image' => \Auth::user()->getLogoPath()
            ],
            'chats' => $chat
        ]);
    }
}
