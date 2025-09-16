<?php

namespace App\Livewire\App\Cashflow;

use GuzzleHttp\Client;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class FullHistory extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Cashflow History')]

    public $cashflowHistory;
    public $kategoriCashflow;
    public $startDate, $endDate, $checkBxUpah = false, $category_id;

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
            'checkBxUpah' => $this->checkBxUpah,
            'category_id' => $this->category_id,
        ];

        if ($this->endDate < $this->startDate) {
            session()->flash('error_message', 'Cek kembali tanggalnya');
            return; // hentikan proses lanjut
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res4 = $client->get('/api/super-admin/manage/cashflow/filter?start_date=' . $data['startDate'] . '&end_date=' . $data['endDate'] . '&category_id=' . $data['category_id'] . '&include_wages=' . $data['checkBxUpah'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->cashflowHistory = json_decode($res4->getBody()->getContents(), true);
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

    public function cetakPDF()
    {
        $this->validate();

        $data = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'checkBxUpah' => $this->checkBxUpah,
            'category_id' => $this->category_id,
        ];

        if ($this->endDate < $this->startDate) {
            session()->flash('error_message', 'Cek kembali tanggalnya');
            return; // hentikan proses lanjut
        }
        
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res4 = $client->get('/api/super-admin/manage/cashflow/filter?start_date=' . $data['startDate'] . '&end_date=' . $data['endDate'] . '&category_id=' . $data['category_id'] . '&include_wages=' . $data['checkBxUpah'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->cashflowHistory = json_decode($res4->getBody()->getContents(), true);
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
                    session()->flash('error_message', $body->message);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }

        $data = [
            'periode' => $this->cashflowHistory['periode'],
            'subject' => 'Laporan Cashflow/Keuangan',
            'namaAdmin' => session('auth_data.accountdata.fullname'),
            'printedOn' => now('Asia/Jakarta')->toDateTimeString(),
            'cashflowHistory' => $this->cashflowHistory
        ];

        // dd($data);

        $stream_PDF = PDF::loadView('livewire/app/reports/cashflowReports', $data)->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($stream_PDF) {
            echo $stream_PDF->stream();
        }, 'laporanCashflow_' . str_replace('/', '', $data['periode']) . '.pdf');
    }

    public function render()
    {
        return view('livewire.app.cashflow.full-history');
    }
}
