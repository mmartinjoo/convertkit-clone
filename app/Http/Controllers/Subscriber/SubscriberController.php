<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\CreateSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Http\Request;

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
