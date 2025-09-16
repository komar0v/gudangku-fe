<?php

namespace App\Livewire\App\Cashflow;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class CatatBaru extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Create Cashflow')]

    public $kategoriCashflow;
    public $type, $category_id, $amount, $description, $transaction_date;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchCatList();
    }

    public function fetchCatList()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res3 = $client->get('/api/super-admin/manage/cashflow/category/get-all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->kategoriCashflow = json_decode($res3->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 404) {

                    session()->flash('error_message', 'Kategori tidak ditemukan.');
                    $this->redirectRoute('appInventoryIndexPage', navigate: true);
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
            'type'             => 'required|in:in,out',
            'category_id'      => 'required',
            'amount'           => 'required|numeric|min:1',
            'description'      => 'nullable|string',
            'transaction_date' => 'required|date',
        ];
    }

    public function saveData()
    {
        $this->validate();

        $data = [
            'type'             => $this->type,
            'category_id'      => $this->category_id,
            'amount'           => $this->amount,
            'description'      => $this->description,
            'transaction_date' => $this->transaction_date,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/cashflow/create', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appCashflowIndexPage', navigate: true);
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

    public function render()
    {
        return view('livewire.app.cashflow.catat-baru');
    }
}
