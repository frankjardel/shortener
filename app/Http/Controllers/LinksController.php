<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ProcessAnalytics;
use App\Link;
use App\Analytic;
use Validator;
use Log;

class LinksController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        try {
            $link       = new Link;
            $link->from = $request->url;
            $link->to   = (string) Str::uuid();
            $link->save();
        } catch (\Exception $e) {
            Log::error($e);
        }

        return [
            'status' => true,
            'link'   => $link
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $link = Link::where('to', $id)->first();

        if (!$link) {
            return [
                'status'  => true,
                'message' => 'Oops! Algo errado, Link not found'
            ];
        }

        ProcessAnalytics::dispatch($link, $request->ip());

        return redirect()->away($link->from);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
