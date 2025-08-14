<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class VisitHistory extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Supplier Visit Log')]

    public $suppId;
    public $visitLogs;

    public function mount($supplierId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->suppId = $supplierId;

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/supplier/'.$supplierId.'/get-supplier-full-visit-log', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->visitLogs = json_decode($res1->getBody()->getContents(), true);
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
        return view('livewire.app.supplier.visit-history');
    }
}
