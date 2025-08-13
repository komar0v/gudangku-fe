<?php

namespace App\Livewire\App\Users;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Register extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Register User')]

    public $fullname, $email, $nomer_wa, $password, $role_code;
    public $roleList;
    public $excel_file;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/super-admin/roles/get-avail-roles', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->roleList = json_decode($res->getBody()->getContents(), true);
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

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'fullname' => 'required',
            'nomer_wa' => 'required|numeric',
            'role_code' => 'required'
        ];
    }

    public function render()
    {
        return view('livewire.app.users.register');
    }

    public function downloadTemplate()
    {
        $path = public_path('assets/template_files/templateRegisterUser.xlsx');

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, 'templateRegisterUser.xlsx');
    }

    public function createNewUser()
    {
        $this->validate();

        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'fullname' => $this->fullname,
            'nomer_wa' => $this->nomer_wa,
            'role_code' => $this->role_code,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/user/register-new', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['data']['fullname'] . ' berhasil ditambahkan');

            $this->redirectRoute('appManageUserPage', navigate: true);
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

    public function uploadFile()
    {

        $file = $this->excel_file;

        $this->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);


        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/bulk-register-new', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => [
                    [
                        'name'     => 'excel_file',
                        'filename' => $fileName,
                        'Mime-Type' => $file->getMimeType(),
                        'contents' => fopen($filePath, 'r'),
                    ]
                ]
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appManageUserPage', navigate: true);
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
