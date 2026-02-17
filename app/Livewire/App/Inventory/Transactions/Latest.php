<?php

namespace App\Livewire\App\Inventory\Transactions;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Latest extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Latest Transaction')]

    public $latestTransactions;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchData();
    }

    public function fetchData()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res4 = $client->get('/api/transactions/latest', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->latestTransactions = json_decode($res4->getBody()->getContents(), true)['data'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {
                    //Forbidden
                    session()->flash('error_message', 'Format Tidak Valid');
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
        return view('livewire.app.inventory.transactions.latest');
    }
}
