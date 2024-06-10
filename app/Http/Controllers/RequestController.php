<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pathum4u\ApiRequest\ApiRequest;
use GuzzleHttp\Psr7\Utils;

class RequestController extends Controller
{
    //load data
    public function load_request_data(Request $request){

        $client = new ApiRequest();
        $quotations = $client->service('api_gateway')
            ->get('/api/portal/requisition/' . $request->slug);
        return $quotations;
    }

    //update data
    public function upload(Request $request, $quotation_request){

        $request_data = (array) json_decode($request->data);
        $data = [];

        foreach ($request_data as $quotation_data) {
            $client = new ApiRequest();
            $response_data = $client->service('procurement')
                ->attach('quotation', Utils::tryFopen($request->file($quotation_data->quotation), 'r'))
                ->attach('specification', Utils::tryFopen($request->file($quotation_data->specification), 'r'))
                ->post('/api/quotation/' . $quotation_request, [
                    'price' => $quotation_data->price,
                    'total_price' => $quotation_data->total_price,
                    'remark' => $quotation_data->remark,
                    'exclusive_price' => $quotation_data->exclusive_price,
                    'currency_type' => ($quotation_data->currency_type != '' && isset($quotation_data->currency_type->id))?$quotation_data->currency_type->id:1,
                    'lead_time' => $quotation_data->lead_time,
                ]);
            array_push($data, json_decode($response_data, true));
        }

        $client = new ApiRequest();
        $quotations = $client->service('api_gateway')
            ->post('/api/portal/quotation/acnkow', ['data' => $data]);

        return response()->json(['status' => 'success', 'Quotations' => $data], 201);
    }
}
