<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Ticket;
use Illuminate\Support\Str;


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
            // 'pricelist_id' => 'required|numeric',
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
        // dd($request);

        $price = Pricelist::where('name', '=', Str::lower($request->namawisata))->first();
        // dd($price);

        $ticket = new Ticket();
        $ticket->pricelist_id = $price->id;
        $ticket->nama = $request->nama;
        $ticket->jeniskelamin = $request->jeniskelamin;
        $ticket->alamat = $request->alamat;
        $ticket->noktp = $request->noktp;
        $ticket->notelp = $request->notelp;
        $ticket->fotoktp = $validatedData['fotoktp'];
        $ticket->save();

        // Increment Counter Cache
        if (Cache::has($price->id)) {
			Cache::increment($price->id);
		}
        else Cache::put($price->id, 1, now()->addHours(6));

        // Ticket::create($validatedData);
        return redirect()->route('ticket.show', $ticket->id )->with('tambah_data', 'Penambahan Pengguna berhasil');
        // return view('hasil', ['data' => $request]);
    }

    public function show($id)
    {
        // Problem
        // $data = Ticket::all();
        $data = Ticket::where('id', $id)->first();
        // $price = Pricelist::all();
        // dd($data);
        return view('hasil', [
            'data' => $data,
            // 'price'=> $price,
        ]);
    }
}
