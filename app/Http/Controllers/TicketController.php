<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


class TicketController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ticket = new Ticket();
        $ticket->id = (string)Str::uuid();
        $ticket->sometext = 'random text';
        $ticket->save();

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('http://82.196.2.197/claim/'.$ticket->id)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            //logoPath(__DIR__.'/assets/symfony.png')
            ->labelText($ticket->id)
            ->labelFont(new NotoSans(10))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();

        return new Response('
        <a href="/claim/'.$ticket->id.'">test link</a>
        <img src="'.$result->getDataUri().'">');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $ticket_id
     * @return void
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        if ($ticket->sometext == 'random text'){
            $ticket->sometext = 'done';
            $ticket->save();
            return new Response('ticket '.$ticket->id. 'is VALID');
        }
        else {
            return new Response('ticket '.$ticket->id. 'is INVALID');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
