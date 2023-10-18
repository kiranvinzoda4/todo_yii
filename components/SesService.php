<?php

namespace app\components;

use Aws\Ses\SesClient;
use yii\base\Component;

class SesService extends Component
{
    public function getClient()
    {
        return new SesClient([
            'version' => 'latest',
            'region' => 'ap-south-1',
            'credentials' => [
                'key' => "AKIAQ7AKFCNM4IATGPLZ",
                'secret' => "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",
            ],
        ]);
    }
}
