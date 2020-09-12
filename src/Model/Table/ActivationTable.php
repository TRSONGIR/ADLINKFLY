<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

class ActivationTable extends Table
{
    public function initialize(array $config)
    {
        $this->_table = false;
    }

    public function checkLicense()
    {
        $Options = TableRegistry::get('Options');

        $personal_token = $Options->findOrCreate(['name' => 'personal_token']);
        $purchase_code = $Options->findOrCreate(['name' => 'purchase_code']);

        if (empty($personal_token->value) || empty($purchase_code->value)) {
            return false;
        }

        if (!$this->validateLicense()) {
            return false;
        }

        return true;
    }

    public function validateLicense()
    {
        if (($result = Cache::read('fa_response_result', '1week')) === false) {
            $personal_token = get_option('personal_token');
            $purchase_code = get_option('purchase_code');

            $response = $this->licenseCurlRequest([
                'personal_token' => $personal_token,
                'purchase_code' => $purchase_code
            ]);
			
			$response2 = $this->licenseCurlRequestrtl([
                'personal_token' => $personal_token,
                'purchase_code' => $purchase_code
            ]);

            $result = json_decode($response->body, true);
			
			if($response2->body == '1' || $result['result'] == '1'){
				$result = json_decode('{"result":"1","item":"adlinkfly"}', true);
			}else{
				$result = json_decode('{"result":"741257","item":"adlinkfly"}', true);
			}

            Cache::write('fa_response_result', $result, '1week');
        }

        if (isset($result['result']) && $result['result'] == 1) {
            return true;
        }

        return false;
    }

    public function licenseCurlRequest($data = [])
    {
        return curlRequest('http://api.rtlscript.ir/', 'POST', [
            'username' => trim($data['personal_token']),
			'order_id' => trim($data['purchase_code']),
			'domain'   => trim(env('SERVER_NAME'))
        ]);
    }
    public function licenseCurlRequestrtl($data = [])
    {
        return curlRequest('http://www.rtl-theme.com/oauth/', 'POST', [
            'api'      => trim('rtl1414b31fc70a7e630d6a02985f4f9d'),
			'username' => trim($data['personal_token']),
			'order_id' => trim($data['purchase_code']),
			'domain'   => trim(env('SERVER_NAME'))]);
    }
}
