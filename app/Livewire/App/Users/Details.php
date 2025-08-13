<?php

namespace App\Livewire\App\Users;

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
    #[Title('Account Details')]

    public $fullname, $email, $nomer_wa, $role_code, $created_at, $updated_at;
    public $roleList, $accountData;

    public function mount($accountId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/roles/get-avail-roles', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $res2 = $client->get('/api/super-admin/manage/user/details/'.$accountId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            
            $this->roleList = json_decode($res1->getBody()->getContents(), true);
            $this->accountData = json_decode($res2->getBody()->getContents(), true);
            
            $this->fullname = $this->accountData['data']['fullname'];
            $this->email = $this->accountData['data']['email'];
            $this->nomer_wa = $this->accountData['data']['nomer_wa'];
            $this->role_code = $this->accountData['data']['role']['role_code'];
            $this->created_at = IndoDateFormat::formatIndo($this->accountData['data']['created_at']);
            $this->updated_at = IndoDateFormat::formatIndo($this->accountData['data']['updated_at']);

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

                    session()->flash('error_message', 'User tidak ditemukan.');
                    $this->redirectRoute('appManageUserPage', navigate:true);
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
            'fullname' => 'required',
            'nomer_wa' => 'required|numeric',
            'email' => 'required|email',
            'role_code'=> 'required',
        ];
    }

    public function render()
    {
        return view('livewire.app.users.details');
    }

    public function saveChanges(){
        $this->validate();

        $data = [
            'fullname' => $this->fullname,
            'nomer_wa' => $this->nomer_wa,
            'email' => $this->email,
            'role_code'=> $this->role_code,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->put('/api/super-admin/manage/user/update/'.$this->accountData['data']['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Perubahan akun '. $responseData['data']['fullname'].' berhasil disimpan');
            $this->redirectRoute('appManageUserPage', navigate:true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function resetPassword(){
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $client->put('/api/super-admin/manage/user/reset-password/'.$this->accountData['data']['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            session()->flash('success_message', 'Password akun '. $this->accountData['data']['fullname'].' sudah direset');
            $this->redirectRoute('appManageUserPage', navigate:true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }
}
