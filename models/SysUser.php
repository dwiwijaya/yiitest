<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sys_user".
 *
 * @property int|null $iduser
 * @property string|null $name
 * @property string|null $email
 */
class SysUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser'], 'integer'],
            [['name',], 'string', 'max' => 100],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }

    public function getRelayData($relayIp, $relayPort, $lmTags)
    {
        $command = "c:/lumut/fn_get_data.exe $relayIp $relayPort 1 $lmTags";
        $lmServiceData = exec(escapeshellcmd($command));
        
        return $lmServiceData;
    }

    public static function processUserData($userData)
    {
        // Validasi data
        if (!isset($userData['name']) || !isset($userData['transactions'])) {
            throw new \Exception('Invalid user data');
        }

        // Hitung total transaksi
        $total = 0;
        foreach ($userData['transactions'] as $transaction) {
            $total += $transaction['amount'];
        }

        // Format hasil
        return [
            'name' => strtoupper($userData['name']),
            'total_amount' => $total
        ];
    }
}
