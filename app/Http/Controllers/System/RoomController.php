<?php

namespace App\Http\Controllers\System;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomChangePricePerAdditionalHourRequest;

class RoomController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rooms = Room::orderBy('number', 'ASC');

        $q = trim($request->input('q'));

        if (!empty($q)) {
            $rooms->where('number', 'like', '%' . $q . '%');
        }

        $rooms = $rooms->paginate();

        return view('system.rooms.index')->with([
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.rooms.create')->with([
            'room' => new Room,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        try {
            Room::create($request->validated());
            return redirect()->route('system.rooms.index')
                ->with('success', 'Quarto adicionado com sucesso');
        } catch (\Exception $e) {
            $message = 'Erro ao adicionar quarto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.rooms.index')
                ->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return view('system.rooms.show', [
            'room' => $room,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('system.rooms.edit')->with([
            'room' => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        try {
            $room->update($request->validated());
            return redirect()->route('system.rooms.index')
                ->with('success', 'Quarto editado com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao editar quarto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.rooms.index')
                ->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return redirect()->route('system.rooms.index')
                ->with('success', 'Quarto excluído com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao excluir quarto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.rooms.index')
                ->with('error', $message);
        }
    }

    public function editPricePerAdditionalHour()
    {
        $this->authorize('edit-price rooms', Room::class);
        return view('system.rooms.edit-price-per-additional-hour');
    }

    public function updatePricePerAdditionalHour(RoomChangePricePerAdditionalHourRequest $request)
    {
        $this->authorize('update-price rooms', Room::class);
        try {
            Room::updateAllPricePerAdditionalHour($request->validated()['price_per_additional_hour']);
            return redirect()->route('system.rooms.edit-price-per-additional-hour')
                ->with('success', 'Preço de hora adicional atualizados com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao atualizar preço de hora adicional';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.rooms.edit-price-per-additional-hour')
                ->with('error', $message);
        }
    }
}
