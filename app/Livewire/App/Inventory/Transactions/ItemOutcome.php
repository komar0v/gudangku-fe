<?php

namespace App\Livewire\App\Inventory\Transactions;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class ItemOutcome extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Item Income Stock')]

    public $listItems;
    public $item_id, $jumlah, $berat_total, $keterangan;
    public $stokData;

    public $successMessage;
    public $errorMessage;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res2 = $client->get('/api/super-admin/manage/inventory/item/get-all-lite', [
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

    public function rules()
    {
        return [
            'item_id' => 'required',
            'jumlah' => 'required|integer',
            'berat_total' => 'required|numeric',
            'keterangan' => 'nullable',
        ];
    }

    public function saveBarangKeluar()
    {
        $this->validate();

        $data = [
            'item_id' => $this->item_id,
            'jumlah' => $this->jumlah,
            'berat_total' => $this->berat_total,
            'keterangan' => $this->keterangan,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/transactions/inventory/outcoming-item', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $resbody = json_decode($res->getBody()->getContents(), true);

            $this->successMessage = $resbody['message'];

            // Kirim event ke browser
            $this->dispatch('success-message');
            $this->cekStok($this->item_id);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents(), true);

                if ($response->getStatusCode() == 400) {

                    $this->errorMessage = $body['message'];
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

            $res = $client->get('/api/super-admin/manage/inventory/item/cek-stok/' . $itemId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->stokData = json_decode($res->getBody()->getContents(), true)['data'];
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

    public function render()
    {
        return view('livewire.app.inventory.transactions.item-outcome');
    }
}
