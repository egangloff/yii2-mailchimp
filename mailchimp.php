<?php
namespace egangloff\mailchimp;

use Yii;
use yii\base\Component;
use linslin\yii2\curl;

class Mailchimp extends component
{
    public $apikey;
    public $apiurl;
    public $statuscode;
    public $statustext;

    public function init($listid = '', $firstname = '', $lastname = '', $email= '', $phone = '')
    {
        $this->apikey = Yii::$app->getComponents()['mailchimp']['apikey'];
        $this->apiurl = 'https://' . explode('-', $this->apikey, 2)[1] . '.api.mailchimp.com/';
        parent::init();
    }

    public function getLists($listid = '')
    {
        $this->statuscode = '';
        $this->statustext = '';

        $curl = new curl\Curl();
        $response = $curl
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'apikey '.$this->apikey,
            ])
            ->get($this->apiurl . '3.0/lists/'.$listid, true);

        if ($curl->errorCode === null) {
            return json_decode($response);
        } else {
            $this->statuscode = $curl->errorCode;
            $this->statustext = $curl->errorText;
            return false;
        }
        return $curl->errorCode;
    }

    public function getMembers($listid = '', $memberid = '')
    {
        $this->statuscode = '';
        $this->statustext = '';

        $curl = new curl\Curl();
        $response = $curl
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'apikey '.$this->apikey,
            ])
            ->get($this->apiurl . '3.0/lists/'.$listid.'/members/' . $memberid, true);

        if ($curl->errorCode === null) {
            return json_decode($response);
        } else {
            $this->statuscode = $curl->errorCode;
            $this->statustext = $curl->errorText;
            return false;
        }
        return $curl->errorCode;
    }

    public function addMember($listid = '', $firstname = '', $lastname = '', $email = '', $phone = '')
    {
        $this->statuscode = '';
        $this->statustext = '';

        $curl = new curl\Curl();
        $response = $curl
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'apikey '.$this->apikey,
            ])
            ->setRawPostData(
                json_encode([
                    'email_address' => $email,
                    'status' => 'subscribed',
                    'merge_fields' => [
                        'FNAME' => $firstname,
                        'LNAME' => $lastname,
                        'PHONE' => $phone,
                    ]
                ]))
            ->post($this->apiurl . '3.0/lists/'.$listid.'/members/', true);

        if ($curl->errorCode === null) {
            $response = json_decode($response);
            if($response->status == 'subscribed')
            {
                $this->statuscode = 200;
                $this->statustext = 'subscribed';
                return true;
            }
            else
                {
                    $this->statuscode = $response->status;
                    $this->statustext = $response->title;
                    return false;
                }
        } else {
            $this->statuscode = $curl->errorCode;
            $this->statustext = $curl->errorText;
            return false;
        }
    }

    public function deleteMember($listid = '', $memberid = '')
    {
        $this->statuscode = '';
        $this->statustext = '';

        $curl = new curl\Curl();
        $response = $curl
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'apikey '.$this->apikey,
            ])
            ->delete($this->apiurl . '3.0/lists/'.$listid.'/members/' . $memberid, true);

        if ($curl->errorCode === null) {
            return json_decode($response);
        } else {
            $this->statuscode = $curl->errorCode;
            $this->statustext = $curl->errorText;
            return false;
        }
        return $curl->errorCode;
    }
}