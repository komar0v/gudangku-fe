<?php

namespace App\Livewire\App\Inventory\Item;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class InOutItemNonPengrajin extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('In/Out Items')]

    public $listItems, $stokData;
    public $successMessage, $errorMessage;
    public $item_id, $quantity, $keterangan;
    public $type;

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

    public function rules()
    {
        return [
            'type' => 'required|in:in,out',
            'item_id' => 'required',
            'quantity' => 'required|numeric|min:1',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'item_id' => $this->item_id,
            'quantity' => $this->quantity,
            'keterangan' => $this->keterangan,
        ];

        if ($this->type === 'in') {
            try {
                $client = new Client(['base_uri' => env('API_URL')]);

                $res = $client->post('/api/super-admin/manage/inventory/item/item-in', [
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

        if ($this->type === 'out') {
            try {
                $client = new Client(['base_uri' => env('API_URL')]);

                $res = $client->post('/api/super-admin/manage/inventory/item/item-out', [
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
    }

    public function clearAlert()
    {
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function render()
    {
        return view('livewire.app.inventory.item.in-out-item-non-pengrajin');
    }
}
