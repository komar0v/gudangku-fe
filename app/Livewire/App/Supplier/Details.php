<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Details extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Supplier Master Data')]

    public $supplierData;
    public $logo_img, $created_at, $QRbarcode;
    public $supplierVisitLog, $count_visit_log, $last_visit;

    public function mount($supplierId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/supplier/details/' . $supplierId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $res2 = $client->get('/api/super-admin/manage/supplier/' . $supplierId . '/get-supplier-visit-log', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->supplierData = json_decode($res1->getBody()->getContents(), true);
            $this->logo_img = env('API_URL') . '/' . $this->supplierData['logo_file_path'];
            $this->QRbarcode = $this->supplierData['barcode']['barcode'];
            $this->created_at = IndoDateFormat::formatIndo($this->supplierData['created_at']);

            $this->supplierVisitLog = json_decode($res2->getBody()->getContents(), true);

            $this->last_visit = isset($this->supplierVisitLog['last_visit']) && $this->supplierVisitLog['last_visit']
                ? IndoDateFormat::formatIndo($this->supplierVisitLog['last_visit'])
                : null;

            $this->count_visit_log = $this->supplierVisitLog['visit_count_on_this_month'] ?? 0;
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
                    //Forbidden
                    session()->flash('error_message', $body->message);
                    $this->redirectRoute('appSupplierIndexPage', navigate: true);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function downloadBarcode()
    {
        $filename = 'qr' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $this->supplierData['nama_supplier']) . '.png';

        $imageData = base64_decode($this->QRbarcode);
        $tempPath = storage_path('app/temp_barcode_' . uniqid() . '.png');
        file_put_contents($tempPath, $imageData);

        return response()->streamDownload(function () use ($tempPath) {
            readfile($tempPath);
            unlink($tempPath);
        }, $filename);
    }

    public function render()
    {
        return view('livewire.app.supplier.details');
    }
}
