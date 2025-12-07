<?php

namespace App\Livewire\App\Reports;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Ranking extends Component
{
    use RequireLogin;

    public $startDate, $endDate;
    public $rankData;
    public $isData = false, $isGraph = false;

    #[Layout('components.layouts.applayout')]
    #[Title('Reports')]

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function rules()
    {
        return [
            'startDate' => 'required',
            'endDate' => 'required'
        ];
    }

    public function showData()
    {
        $this->validate();

        $data = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        if ($this->endDate < $this->startDate) {
            session()->flash('error_message', 'Cek kembali tanggalnya');
            return; // hentikan proses lanjut
        }

        try {
            $this->isData = true;
            $this->isGraph = false;
            $client = new Client(['base_uri' => env('API_URL')]);

            $res4 = $client->get('/api/super-admin/statistics/graph/ranking-pengrajin?start=' . $data['startDate'] . '&end=' . $data['endDate'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->rankData = json_decode($res4->getBody()->getContents(), true);
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

    public function showGraph()
    {
        $this->validate();

        $data = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        if ($this->endDate < $this->startDate) {
            session()->flash('error_message', 'Cek kembali tanggalnya');
            return; // hentikan proses lanjut
        }

        try {
            $this->isGraph = true;
            $this->isData = false;
            $client = new Client(['base_uri' => env('API_URL')]);

            $res4 = $client->get('/api/super-admin/statistics/graph/ranking-pengrajin?start=' . $data['startDate'] . '&end=' . $data['endDate'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->rankData = json_decode($res4->getBody()->getContents(), true);
            
            $this->dispatch("init-apex-graph", ranking: $this->rankData['ranking']);
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
        return view('livewire.app.reports.ranking');
    }
}
