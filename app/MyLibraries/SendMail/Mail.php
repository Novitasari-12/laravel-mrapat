<?php
namespace App\MyLibraries\SendMail;

use \Mailjet\Resources;

class Mail {
    
    private $url = "https://app-compact.000webhostapp.com/api/mail/" ;
    private $dataMail ;

    public function __construct($dataMail){
        $this->dataMail = (Object) $dataMail ;
        $this->dataMail->key = "edsendmail" ;
        $this->dataMail->from = env('MAIL_FROM_ADDRESS', 'edyamishiro@gmail.com') ;
    }

    public function send($view, $data=null){
        $view = view($view, compact('data'));

        $data = [
            'key' => $this->dataMail->key,
            'mail_from' => $this->dataMail->from,
            'mail_to' => $this->dataMail->to,
            'mail_subject' => $this->dataMail->subject,
            'mail_body' => $view->render(),
            'mail_from_title' => $this->dataMail->title
        ];

        // return $this->request_mail_server($data);
        // or 
        return $this->request_guzzle($data);
        // or
        // return $this->request_mailjet($data);
    }

    public function request_guzzle($data){
        return (new \GuzzleHttp\Client())->post($this->url, [
            'form_params' => $data
        ])->getBody();
    }

    public function request_mailjet($data){
        $mj = new \Mailjet\Client('7b31f82a823b1c51225e70ceb82adda1','f43e9ea5dabd3821170b8943b1a0edf1',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "afdallx@gmail.com",
                        'Name' => "ed"
                    ],
                    'To' => [
                        [
                            'Email' => "afdallx@gmail.com", //$data["mail_to"],
                            'Name' => "ed"
                        ]
                    ],
                    'Subject' => $data["mail_subject"],
                    'TextPart' => $data["mail_from_title"],
                    'HTMLPart' => $data["mail_body"],
                    'CustomID' => "AppMrapat"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        return $response->success() && var_dump($response->getData());
    }

    public function request_mail_server($data){
        $send = "";
        foreach ($data as $key => $value) {
            $send .=  ($send != '' ? '&' : '') . "{$key}={$value}";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $send,
            CURLOPT_HTTPHEADER => array(
                ": ",
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: caaac66f-0334-4c23-9747-c45e91012feb",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $err ? $err : $response ;
    }

}


// $mail = (new SendMail([
//     'title' => 'test wai mas ',
//     'to' => 'afdalmtk@gmail.com',
//     'subject' => 'test email',
// ]))->send('welcome', ['data test']);

// echo $mail->getBody();