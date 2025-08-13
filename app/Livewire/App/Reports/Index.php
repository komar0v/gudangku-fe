<?php

namespace App\Livewire\App\Reports;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use GuzzleHttp\Exception\RequestException;

class Index extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Reports')]

    public $date;
    public $inventoryReportData;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function rules()
    {
        return [
            'date' => 'required'
        ];
    }

    public function cetakLaporan()
    {
        $this->validate();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/statistics/inventory/reports/' . $this->date, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->inventoryReportData = json_decode($res1->getBody()->getContents(), true)['data'];
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

        $periode = IndoDateFormat::formatIndo($this->date);
        $parts = explode(' ', $periode);
        $substrPeriode = $parts[1] . ' ' . $parts[2];

        $data = [
            'periode' => $substrPeriode,
            'namaAdmin' => session('auth_data.accountdata.fullname'),
            'printedOn' => now('Asia/Jakarta')->toDateTimeString(),
            'inventoryReportData' => $this->inventoryReportData
        ];

        // dd($data);

        $stream_PDF = PDF::loadView('livewire/app/reports/laporanInventory', $data)->setPaper('A4', 'portrait');
        return response()->streamDownload(function () use ($stream_PDF) {
            echo $stream_PDF->stream();
        }, 'laporanInventory_' . $this->date . '.pdf');
    }

    public function showGraph()
    {
        $this->validate();
        $this->redirectRoute('appGraphReportPage', ['date' => $this->date]);
    }

    public function render()
    {
        return view('livewire.app.reports.index');
    }
}
