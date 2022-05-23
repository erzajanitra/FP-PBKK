<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;


class TicketController extends Controller
{
    //
    public function index()
    {
        // get all data from Ticket table
        $data= Ticket::all();
        return view('ticket', [
            'data' => $data
        ]);
        // $ticket = Ticket::all();
        // return view('ticket');
    }
    public function create(){
        return view('ticket');
    }
 
    public function store(Request $request)
    {
        Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
        $validatedData = $request->validate( [
            'nama' => 'required|min:8|max:50',
            'jeniskelamin' => 'required|max:1',
            'noktp' => 'required|numeric',
            'alamat' => 'required|min:8|max:100',
            'notelp' => 'required|numeric',
            'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        // $imageName = time() . '.' . $request->fotoktp->extension();
        // $request->fotoktp->move(public_path('images'), $imageName);
        // $request->fotoktp = $imageName;
        
        Ticket::create($validatedData);
        return redirect()->route('ticket.show')->with('tambah_data', 'Penambahan Pengguna berhasil');
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
    public function show()
    {
        //
        $data = Ticket::all();
        // return view('hasil');
        // $data = Ticket::where('id', $id);
        return view('hasil', [
            'data' => $data,
            // 'id' => $id,
        ]);
    }
}
