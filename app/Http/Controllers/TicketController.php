<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pricelist;
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
        $data = Pricelist::all();
        return view('ticket', [
            'data' => $data
        ]);
        // $ticket = Ticket::all();
        // return view('ticket');
    }
    public function create()
    {
        $data = Ticket::All();
        // $price = Pricelist::find($data->pricelists_id);
        return view('ticket', [
            'data' => $data,
            // 'price' => $price,
        ]);
    }
    // return view('ticket');


    public function store(Request $request)
    {
        Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
        $validatedData = $request->validate([
            // 'namawisata' => 'required|min:8|max:50',
            // 'harga' => 'required|numeric',
            'nama' => 'required|min:8|max:50',
            'jeniskelamin' => 'required|max:1',
            'noktp' => 'required|numeric',
            'alamat' => 'required|min:8|max:100',
            'notelp' => 'required|numeric',
            'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        
        if ($request->hasFile('fotoktp')) {
            $validatedData['fotoktp'] = $request->file('fotoktp')->store('public/images');

            
        }

        Ticket::create($validatedData);
        return redirect()->route('ticket.show')->with('tambah_data', 'Penambahan Pengguna berhasil');
        // return view('hasil', ['data' => $request]);
    }

    public function show()
    {
        // Problem
        //$data = Ticket::where('id', $id)->first();
        $data = Ticket::all();
        $price = Pricelist::all();
        return view('hasil', [
            'data' => $data,
            'price'=> $price,
        ]);
    }
}
