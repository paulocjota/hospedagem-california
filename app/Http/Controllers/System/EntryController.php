<?php

namespace App\Http\Controllers\System;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EntryRequest;
use App\Http\Controllers\Controller;
use Exception;

class EntryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Entry::class, 'entry');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::orderBy('number', 'ASC')->get();

        return view('system.entries.index')->with([
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Room $room)
    {
        return view('system.entries.create')->with([
            'entry' => new Entry,
            'room' => $room,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryRequest $request)
    {
        try {
            $data = $request->validated();

            $room = Room::find($request->room_id)->first();
            if ($room->occupied) {
                throw new Exception('O quarto ' . $room->number . ' está ocupado. Finalize a entrada atual para liberar o quarto para novas entradas');
            }

            $data['finished'] = false;
            DB::beginTransaction();
            Entry::create($data);
            DB::commit();
            return redirect()->route('system.dashboard')
                ->with('success', 'Entrada adicionada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            $message = 'Erro ao adicionar entrada';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.entries.create', $room)
                ->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        return view('system.entries.edit')->with([
            'entry' => $entry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, Entry $entry)
    {
        try {
            $entry->update($request->validated());
            return redirect()->route('system.dashboard')
                ->with('success', 'Entrada editada com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao editar entrada';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.dashboard')
                ->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        //
    }
}
