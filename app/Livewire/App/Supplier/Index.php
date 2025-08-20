<?php

namespace App\Livewire\App\Supplier;

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
    #[Title('Pengrajin Master Data')]

    public $recentlyAddSuppliers;
    public $countSupplier;
    public $searchQuery;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/count/pengrajin/count-all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->countSupplier = json_decode($res1->getBody()->getContents(), true)['total_pengrajin'];

            $res2 = $client->get('/api/super-admin/manage/get-all-recently-added-pengrajin', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->recentlyAddSuppliers = collect(json_decode($res2->getBody()->getContents(), true))->map(function ($item) {
                return [
                    'id'=>$item['id'],
                    'nama_pengrajin' => $item['nama_pengrajin'],
                    'created_at' => IndoDateFormat::formatIndo($item['created_at'])
                ];
            })->toArray();
            
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

    public function searchSupplier(){
        $this->redirectRoute('appSupplierSearchResultPage', ['query' => $this->searchQuery], navigate: true);
    }

    public function render()
    {
        return view('livewire.app.supplier.index');
    }
}
