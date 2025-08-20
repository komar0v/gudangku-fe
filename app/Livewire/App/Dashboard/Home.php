<?php

namespace App\Livewire\App\Dashboard;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Home extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Dashboard')]
    public $accountData, $chartData;
    public $countSupplier;

    public $chart_cat, $chart_k, $chart_a;

    public $reportRange;
    public $ambilKembaliToday;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/statistics/report-7-day-ago', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $startDate = now('Asia/Jakarta')->subDays(7)->format('j F Y');
            $endDate = now('Asia/Jakarta')->format('j F Y');

            $this->reportRange = "{$startDate} - {$endDate}";

            $this->chartData = json_decode($res1->getBody()->getContents(), true);

            $this->chart_cat = json_encode(collect($this->chartData)->pluck('tanggal'), true);
            $this->chart_k = json_encode(collect($this->chartData)->pluck('kembali'), true);
            $this->chart_a = json_encode(collect($this->chartData)->pluck('ambil'), true);

            $res2 = $client->get('/api/count/pengrajin/count-all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->countSupplier = json_decode($res2->getBody()->getContents(), true)['total_pengrajin'];

            $today = now('Asia/Jakarta')->format('Y-m-d');
            $res3 = $client->get('/api/count/transactions/on-a-day/'.$today, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->ambilKembaliToday = json_decode($res3->getBody()->getContents(), true);
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
        return view('livewire.app.dashboard.home');
    }
}
