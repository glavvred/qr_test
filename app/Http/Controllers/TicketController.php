<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Database\Eloquent\Model;
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
use Illuminate\View\View;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('construct-a-ticket');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return View
     */
    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->id = (string)Str::uuid();
        $ticket->quantity = (int)$request->get('quantity');
        $ticket->action_name = $request->get('action_name');
        $ticket->save();

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('http://82.196.2.197/claim/' . $ticket->id)
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

        return view('issue-a-ticket', [
            'image' => $result->getDataUri(),
            'ticket' => $ticket
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $ticket_id
     * @return View
     */
    public function claimForm($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        return view('claim-a-ticket', ['ticket' => $ticket]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return View
     */
    public function claimABit(Request $request): View
    {
        $ticket_id = $request->get('ticket_id');
        $request->request->remove('ticket_id');
        $ticket = Ticket::findOrFail($ticket_id);
        if ($ticket->quantity > 0) {
            $ticket->quantity = $ticket->quantity - 1;
            $ticket->save();
        }
        return view('claimed-successfully', ['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Ticket $ticket
     * @return Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
