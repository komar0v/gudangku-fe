<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class SearchWithBarcode extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Scan Supplier Barcode')]

    public $qrResult = "default";
    public $supplierData;
    public $logo_img;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function fetchResult()
    {
        $this->qrResult;

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/supplier-barcode-search/' . $this->qrResult, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->supplierData = json_decode($res1->getBody()->getContents(), true);

            if ($this->supplierData['is_found']) {

                $this->logo_img = env('API_URL') . '/' . $this->supplierData['logo_file_path'];;
            }
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
        return view('livewire.app.supplier.search-with-barcode');
    }
}
