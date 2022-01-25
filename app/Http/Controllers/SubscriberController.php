<?php

namespace App\Http\Controllers;

use App\Actions\CreateSubscriberAction;
use App\DataTransferObjects\SubscriberData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriberController extends Controller
{
    public function index()
    {
        //
    }

    public function store(SubscriberData $data): SubscriberData
    {
        return SubscriberData::from(
            CreateSubscriberAction::execute($data)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
