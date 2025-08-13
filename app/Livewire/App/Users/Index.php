<?php

namespace App\Livewire\App\Users;

use GuzzleHttp\Client;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Index extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('User Management')]
    public $accountList, $currentUser;
    public $countSupplier, $countAdmin, $countTotalUser;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->currentUser = session('auth_data.accountdata');

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/super-admin/manage/get-all-users', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->accountList = json_decode($res->getBody()->getContents(), true);

            $res2 = $client->get('/api/super-admin/manage/user/count/all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $response2 = json_decode($res2->getBody()->getContents(), true);
            $this->countSupplier = $response2['supplier'];
            $this->countAdmin = $response2['admin'];
            $this->countTotalUser = $response2['total'];

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
        return view('livewire.app.users.index');
    }
}
