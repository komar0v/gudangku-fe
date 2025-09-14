<?php

namespace App\Livewire\App\Inventory\Transactions;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Pengembalian extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Pengembalian')]

    public $successMessage, $errorMessage;
    public $qrResult = "default", $bulanIni, $transactionId = "", $berat_pengembalian;
    public $pengrajinData;
    public $transactionList, $transactionListLite;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->bulanIni = Carbon::parse(now())->translatedFormat('F Y');
    }

    public function fetchResultPool()
    {
        if (empty($this->pengrajinData) || !$this->pengrajinData['is_found']) {
            $this->fetchResult();
        }
    }

    public function fetchResult()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/pengrajin-barcode-search/' . $this->qrResult, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinData = json_decode($res1->getBody()->getContents(), true);

            if ($this->pengrajinData['is_found']) {

                $this->fetchTransactionListLite();
                $this->fetchTransactionList();
                $this->dispatch('init-slim-select');
            }
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

    public function fetchTransactionList()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $date = now()->format('m-Y');
            $res2 = $client->get('/api/transactions/pengrajin/' . $this->qrResult . '?month=' . $date, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->transactionList = json_decode($res2->getBody()->getContents(), true)['transactions'];
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
            'transactionId' => 'required',
            'berat_pengembalian' => 'required|numeric',
        ];
    }

    public function fetchTransactionListLite()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $date = now()->format('m-Y');

            $res3 = $client->get('/api/transactions/pengrajin/incomplete-lite/' . $this->qrResult . '?month=' . $date, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->transactionListLite = json_decode($res3->getBody()->getContents(), true);
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

    public function savePengembalian()
    {
        $this->validate();

        $trx_id = $this->transactionId;

        $data = [
            'berat_pengembalian' => $this->berat_pengembalian,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/transactions/inventory/pengembalian/' . $trx_id, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            $this->successMessage = $responseData['message'];

            $this->berat_pengembalian = null;
            $this->transactionId = null;

            $this->fetchTransactionList();
            $this->fetchTransactionListLite();
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
        return view('livewire.app.inventory.transactions.pengembalian');
    }
}
