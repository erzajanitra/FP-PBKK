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
            'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        $imageName = time().'.'.$request->fotoktp->extension();
        $request->fotoktp->move(public_path('images'),$imageName);
        $request->fotoktp = $imageName;

 		// echo $request->bukti;
        return view('hasil',['data' => $request]);
        // $foto_link = $this->saveFoto($request, 1);
        // $request->fotoktp = $foto_link;
        // return view('hasil', ['data' => $request]);
    }
    // public function saveFoto(Request $request, $id)
    // {
    //     $foto = $request->ktm; // typedata : file
    //     $foto_name = ''; // typedata : string
    //     if ($foto !== NULL) {
    //         $foto_name = 'foto' . '-' . $id . "." . $foto->extension(); // typedata : string
    //         $foto_name = str_replace(' ', '-', strtolower($foto_name)); // typedata : string
    //         $foto->storeAs(null, $foto_name, ['disk' => 'public']); // memanggil function untuk menaruh file di storage
    //     }
    //     return asset('storage') . '/' . $foto_name; // me return path/to/file.ext
    // }
}
