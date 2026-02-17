<?php

namespace App\Livewire\App\HutangPiutang;

use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Statistics extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Debts')]

    public $dataHutangs;

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

            $res = $client->get('/api/hutang/show-all-active', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->dataHutangs = json_decode($res->getBody()->getContents(), true)['data'];
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
        return view('livewire.app.hutang-piutang.statistics');
    }
}
