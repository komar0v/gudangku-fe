<?php

namespace App\Livewire\App\Account;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Password extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Account Password')]
    
    public $current_password, $new_password;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function rules()
    {
        return [
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ];
    }
    
    public function render()
    {
        return view('livewire.app.account.password');
    }

    public function updatePassword(){
        $this->validate();
        
        $data=[
            'current_password'=>$this->current_password,
            'new_password'=>$this->new_password
        ];
        
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/account/change-password', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }
}
