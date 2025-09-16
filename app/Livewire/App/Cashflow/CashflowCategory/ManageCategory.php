<?php

namespace App\Livewire\App\Cashflow\CashflowCategory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class ManageCategory extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Manage Cashflow Categories')]

    public $categoryList;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchCatList();
    }
    
    public function render()
    {
        return view('livewire.app.cashflow.cashflow-category.manage-category');
    }

    public function fetchCatList(){
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res3 = $client->get('/api/super-admin/manage/cashflow/category/get-all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->categoryList = json_decode($res3->getBody()->getContents(), true);

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
}
