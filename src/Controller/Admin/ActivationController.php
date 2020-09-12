<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

class ActivationController extends AppAdminController
{
    public function index()
    {
        if ($this->request->is('post')) {
            $response = $this->Activation->licenseCurlRequest($this->request->data);
			$response2 = $this->Activation->licenseCurlRequestrtl($this->request->data);

            $result = json_decode($response->body, true);
			
			if($response2->body == '1' || $result['result'] == '1'){
				$result = json_decode('{"result":"1","item":"adlinkfly"}', true);
			}else{
				$result = json_decode('{"result":"741257","item":"adlinkfly"}', true);
			}

            if (isset($result['result']) && $result['result'] == 1) {
                Cache::write('fa_response_result', $result, '1week');

                $Options = TableRegistry::get('Options');

                $personal_token = $Options->find()->where(['name' => 'personal_token'])->first();
                $personal_token->value = trim($this->request->data['personal_token']);
                $Options->save($personal_token);

                $purchase_code = $Options->find()->where(['name' => 'purchase_code'])->first();
                $purchase_code->value = trim($this->request->data['purchase_code']);
                $Options->save($purchase_code);

                $this->Flash->success(__('Your license has been verified.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
            } else {
                    $this->Flash->error('اطلاعات وارد شده تایید نشد. لطفا با پشتیبانی راستچین در تماس باشید. اگر بابت استفاده از این اسکریپت هزینه ای به ما پرداخت نکرده اید از لحاظ شرعی حرام  میباشد.');
                    return null;
            }
        }
    }
}
