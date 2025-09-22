<?php

namespace App\Livewire\App\Inventory\Transactions;

use App\Helpers\IndoDateFormat;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Details extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Transaction Details')]

    public $pengrjnId;
    public $transactionData;
    public $kategoriDataAmbil, $kategoriDataKembali, $satuanData, $pengrajinData;
    public $waktuPengambilan, $waktuPengembalian;

    public function mount($transactionId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/transactions/' . $transactionId . '/details', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->transactionData = json_decode($res1->getBody()->getContents(), true);
            $this->pengrjnId = $this->transactionData['pengrajin_id'];

            $res2 = $client->get('/api/category/get-details-lite/' . $this->transactionData['item']['kategori_id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->kategoriDataAmbil = json_decode($res2->getBody()->getContents(), true);

            if (!empty($this->transactionData['timestamp_pengambilan'])) {

                $this->waktuPengambilan = IndoDateFormat::formatIndoNonUTC($this->transactionData['timestamp_pengambilan']);
            }

            if (!empty($this->transactionData['timestamp_pengembalian'])) {
                $this->waktuPengembalian = IndoDateFormat::formatIndoNonUTC($this->transactionData['timestamp_pengembalian']);

                $res5 = $client->get('/api/category/get-details-lite/' . $this->transactionData['item_pengembalian']['kategori_id'], [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . session('auth_data.token')
                    ],
                ]);
                $this->kategoriDataKembali = json_decode($res5->getBody()->getContents(), true);
            }

            $res3 = $client->get('/api/satuan-barang/get-details-lite/' . $this->transactionData['item']['satuan_id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->satuanData = json_decode($res3->getBody()->getContents(), true);

            $res4 = $client->get('/api/pengrajin-details-lite/' . $this->transactionData['pengrajin_id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);
            $this->pengrajinData = json_decode($res4->getBody()->getContents(), true);
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

                    session()->flash('error_message', 'Transaksi tidak ditemukan.');
                    $this->redirectRoute('appSupplierIndexPage', navigate: true);
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
        return view('livewire.app.inventory.transactions.details');
    }
}
