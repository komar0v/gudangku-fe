<?php

namespace App\Livewire\App\Inventory\Transactions;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Pengambilan extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Pengambilan')]

    public $successMessage, $errorMessage;
    public $stokData, $pengrajinData;
    public $pengrajin_id, $berat_pengambilan, $item_id;
    public $qrResult = "default";
    public $listItems;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res2 = $client->get('/api/inventory/item/get-all-lite', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->listItems = json_decode($res2->getBody()->getContents(), true)['data'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function fetchResult()
    {
        $this->qrResult;

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/pengrajin-barcode-search/' . $this->qrResult, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinData = json_decode($res1->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function rules()
    {
        return [
            'item_id' => 'required',
            'berat_pengambilan' => 'required|numeric',
        ];
    }

    public function cekStok($itemId)
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/inventory/stocks/' . $itemId . '/get-stock', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->stokData = json_decode($res->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function savePengambilan()
    {
        $this->validate();

        $this->pengrajin_id = $this->qrResult;

        $data = [
            'item_id' => $this->item_id,
            'pengrajin_id' => $this->pengrajin_id,
            'berat_pengambilan' => $this->berat_pengambilan,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/transactions/inventory/pengambilan', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            $this->successMessage = $responseData['message'];

            $this->cekStok($this->item_id);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 400) {

                    session()->flash('error_message', $body->message);
                    $this->errorMessage = $body->message;
                    return;
                } else if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    $this->errorMessage = $body->message;
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function clearAlert()
    {
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function render()
    {
        return view('livewire.app.inventory.transactions.pengambilan');
    }
}
