<?php

namespace App\Livewire\App\Inventory\Stocks;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class UpdateStock extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Update Stock')]

    public $stockData, $itemData, $stockLogsData;
    public $stock_quantity, $stock_operation = 'set', $bulanIni;
    public $itemId;
    public $successMessage;

    public function mount($itemId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->itemId = $itemId;

        $this->bulanIni = Carbon::parse(now())->translatedFormat('F Y');

        $this->fetchStock();
    }

    public function fetchStock()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/stocks/' . $this->itemId . '/details', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->stockData = json_decode($res1->getBody()->getContents(), true);

            $res2 = $client->get('/api/super-admin/manage/inventory/item/' . $this->itemId . '/detail', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->itemData = json_decode($res2->getBody()->getContents(), true);

            $this->fetchStokLogs();
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
            'stock_quantity' => 'required|numeric',
        ];
    }

    public function updateStock()
    {
        $this->validate();

        $data = [
            'item_id' => $this->itemData['id'],
            'quantity' => $this->stock_quantity,
            'operation' => $this->stock_operation,
        ];


        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/stocks/update-stock', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            $this->successMessage = $responseData['message'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function fetchStokLogs()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $date = now()->format('m-Y');
            $res3 = $client->get('/api/super-admin/manage/stocks/'.$this->itemId.'/full-logs?month='.$date, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->stockLogsData = json_decode($res3->getBody()->getContents(), true);
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
        return view('livewire.app.inventory.stocks.update-stock');
    }
}
