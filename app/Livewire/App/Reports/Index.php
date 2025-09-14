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

    public $dateBulanan, $dateHarian;
    public $inventoryReportData, $pengrajinLists;
    public $subject;
    public $startDatePeng, $endDatePeng, $pengrajinId;

    public function mount()
    {
        $this->dispatch('init-slim-select2');
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $resPengrajin = $client->get('/api/pengrajin-all-lite', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinLists = json_decode($resPengrajin->getBody()->getContents(), true);
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
    }

    public function cetakLaporanInvBulanan()
    {
        $this->validate([
            'dateBulanan' => 'required'
        ]);

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/reports/inventory/monthly/' . $this->dateBulanan, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->inventoryReportData = json_decode($res1->getBody()->getContents(), true);
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

        $periode = IndoDateFormat::formatIndo($this->dateBulanan);
        $parts = explode(' ', $periode);
        $substrPeriode = $parts[1] . ' ' . $parts[2];

        $data = [
            'periode' => $substrPeriode,
            'subject' => 'Laporan Inventory Bulanan',
            'namaAdmin' => session('auth_data.accountdata.fullname'),
            'printedOn' => now('Asia/Jakarta')->toDateTimeString(),
            'inventoryReportData' => $this->inventoryReportData
        ];

        // dd($data);

        $stream_PDF = PDF::loadView('livewire/app/reports/laporanInventory', $data)->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($stream_PDF) {
            echo $stream_PDF->stream();
        }, 'laporanArusBarang_' . $this->dateBulanan . '.pdf');
    }

    public function showInvGraphMonthly()
    {
        $this->validate();
        $this->redirectRoute('appGraphReportPage', ['date' => $this->date]);
    }

    public function render()
    {
        return view('livewire.app.reports.index');
    }

    public function cetakLaporanInvHarian()
    {
        $this->validate([
            'dateHarian' => 'required'
        ]);

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/reports/inventory/daily/' . $this->dateHarian, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->inventoryReportData = json_decode($res1->getBody()->getContents(), true);
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

        $periode = explode(' ', IndoDateFormat::formatIndo($this->dateHarian));
        $periode = $periode[0] . ' ' . $periode[1] . ' ' . $periode[2];

        $data = [
            'periode' => $periode,
            'subject' => 'Laporan Inventory Harian',
            'namaAdmin' => session('auth_data.accountdata.fullname'),
            'printedOn' => now('Asia/Jakarta')->toDateTimeString(),
            'inventoryReportData' => $this->inventoryReportData
        ];

        $stream_PDF = PDF::loadView('livewire/app/reports/laporanInventory', $data)->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($stream_PDF) {
            echo $stream_PDF->stream();
        }, 'laporanArusBarang_' . $this->dateHarian . '.pdf');
    }

    public function cetakLaporanInvPengrajin()
    {
        $this->validate([
            'startDatePeng' => 'required',
            'endDatePeng' => 'required',
            'pengrajinId' => 'required'
        ]);

        $data = [
            'start_date' => $this->startDatePeng,
            'end_date' => $this->endDatePeng,
            'pengrajinId' => $this->pengrajinId,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/reports/inventory-pengrajin/' . $data['pengrajinId'] . '/range?start_date=' . $data['start_date'] . '&end_date=' . $data['end_date'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->inventoryReportData = json_decode($res1->getBody()->getContents(), true);
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

        $periodeApi = $this->inventoryReportData['data']['periode'];
        [$start, $end] = explode(' s/d ', $periodeApi);

        $startFormatted = IndoDateFormat::formatIndo($start); // 01 September 2025
        $endFormatted   = IndoDateFormat::formatIndo($end);   // 14 September 2025

        $periode = $startFormatted . ' s/d ' . $endFormatted;

        $data = [
            'periode' => $periode,
            'subject' => 'Laporan Transaksi Pengrajin',
            'namaPengrajin'=>$this->inventoryReportData['data']['nama_pengrajin'],
            'namaAdmin' => session('auth_data.accountdata.fullname'),
            'printedOn' => now('Asia/Jakarta')->toDateTimeString(),
            'inventoryReportData' => $this->inventoryReportData
        ];

        $stream_PDF = PDF::loadView('livewire/app/reports/laporanInventoryPerPengrajin', $data)->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($stream_PDF) {
            echo $stream_PDF->stream();
        }, 'laporanTransaksiPengrajin_' . $data['namaPengrajin'] .'_'.$startFormatted.'-'.$endFormatted.'.pdf');
    }
}
