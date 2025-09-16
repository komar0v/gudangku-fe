<?php

namespace App\Livewire\App\Cashflow;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Index extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Cashflow')]

    public $cashflowSummary, $periodeFormatted;
    public $recentCashflow;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchData();
    }

    public function fetchData(){
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/cashflow/cashflow-summary-7-day-ago', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $res2 = $client->get('/api/super-admin/manage/cashflow/recent-cashflow', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->cashflowSummary = json_decode($res1->getBody()->getContents(), true);

            $periode = $this->cashflowSummary['periode'];

            [$start, $end] = explode(' s/d ', $periode);

            $startFormatted = IndoDateFormat::formatTanggalIndo($start);
            $endFormatted   = IndoDateFormat::formatTanggalIndo($end);

            $this->periodeFormatted = $startFormatted . ' s/d ' . $endFormatted;

            $this->recentCashflow = json_decode($res2->getBody()->getContents(), true)['data'];

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

    public function render()
    {
        return view('livewire.app.cashflow.index');
    }
}
