<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class TicketController extends Controller
{
    //
    public function formulir()
    {
        return view('ticket');
    }

    public function hasil(Request $request)
    {
        Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
        $this->validate($request, [
            'nama' => 'required|min:8|max:50',
            'jeniskelamin' => 'required|max:1',
            'noktp' => 'required|numeric',
            'alamat' => 'required|min:8|max:50',
            'notelp' => 'required|numeric',
            'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        $foto_link = $this->saveFoto($request, 1);
        $request->fotoktp = $foto_link;
        return view('hasil', ['data' => $request]);
    }
    public function saveFoto(Request $request, $id)
    {
        $fotoktp = $request->ktm; // typedata : file
        $foto_name = ''; // typedata : string
        if ($fotoktp !== NULL) {
            $foto_name = 'foto' . '-' . $id . "." . $fotoktp->extension(); // typedata : string
            $foto_name = str_replace(' ', '-', strtolower($foto_name)); // typedata : string
            $fotoktp->storeAs(null, $foto_name, ['disk' => 'public']); // memanggil function untuk menaruh file di storage
        }
        return asset('storage') . '/' . $foto_name; // me return path/to/file.ext
    }
}
