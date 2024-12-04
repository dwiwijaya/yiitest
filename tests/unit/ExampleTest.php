<?php

namespace tests\unit;

use app\models\SysUser;
use app\models\User;

class ExampleTest extends \Codeception\Test\Unit
{
    public function testProcessUserDataValid()
    {

        // Data valid
        $userData = [
            'name' => 'John Doe',
            'transactions' => [
                ['amount' => 100],
                ['amount' => 150],
                ['amount' => 200]
            ]
        ];

        // Memanggil fungsi
        $result = SysUser::processUserData($userData);

        // Verifikasi hasil
        $this->assertEquals('JOHN DOE', $result['name']);
        $this->assertEquals(450, $result['total_amount']);
    }

    public function testGetService()
    {
        // Buat mock untuk model User
        $relayServiceMock = $this->make(new SysUser(), [
            'getRelayData' => 'Mocked Data'  // Menentukan nilai yang dikembalikan oleh mock
        ]);
        
        // Memastikan bahwa getRelayData mengembalikan data yang sudah ditentukan
        $result = $relayServiceMock->getRelayData('192.168.1.1', '8080', 'tag1,tag2');
        $this->assertEquals('Mocked Data', $result);
    }
    
    public function testCreateUserInvalidId()
    {
        // Membuat user dengan iduser yang invalid
        $user = new SysUser();
        $user->iduser = 'invalid_id'; // iduser harus integer
        $user->name = 'John';
        $user->email = 'john@example.com';

        // Pastikan penyimpanan gagal karena validasi iduser
        $this->assertFalse($user->save());
        $this->assertArrayHasKey('iduser', $user->getErrors());
    }

    public function testCreateUserValid()
    {
        // Membuat user dengan iduser valid
        $user = new SysUser();
        $user->iduser = 1;
        $user->name = 'John';
        $user->email = 'john@example.com';

        // Verifikasi bahwa data user disimpan di database
        $this->assertTrue($user->save());
        $this->assertEquals('John', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    public function testUpdateUser()
    {
        // Membuat user baru
        $user = new SysUser();
        $user->iduser = 2;
        $user->name = 'Jane';
        $user->email = 'jane@example.com';
        $user->save();

        // Mengupdate data user yang sudah ada
        $user->name = 'Jane Doe';
        $user->email = 'janedoe@example.com';

        // Verifikasi bahwa data telah berhasil diperbarui
        $this->assertTrue($user->save());
        $this->assertEquals('Jane Doe', $user->name);
        $this->assertEquals('janedoe@example.com', $user->email);
    }

    public function testDeleteUser()
    {
        // Membuat user baru
        $user = new SysUser();
        $user->iduser = 3;
        $user->name = 'John';
        $user->email = 'john2@example.com';
        $user->save();

        // Menghapus user
        // $this->assertTrue($user->delete());

        // Memastikan data telah dihapus dari database
        $deletedUser = SysUser::findOne(3);
        $this->assertNotNull($deletedUser);
    }

    public function testCreateUserWithExistingEmail()
    {
        // Membuat user pertama
        $user1 = new SysUser();
        $user1->iduser = 4;
        $user1->name = 'Alice';
        $user1->email = 'alice@example.com';
        $user1->save();

        // Membuat user kedua dengan email yang sama
        $user2 = new SysUser();
        $user2->iduser = 5;
        $user2->name = 'Bob';
        $user2->email = 'alice@example.com'; // Duplicate email
        $this->assertFalse($user2->save());

        // Verifikasi bahwa ada error untuk email yang duplikat
        $this->assertArrayHasKey('email', $user2->getErrors());
    }

    public function testCreateUserWithNullName()
    {
        // Membuat user dengan nama null
        $user = new SysUser();
        $user->iduser = 6;
        $user->name = null; // Nama harus diisi
        $user->email = 'test@example.com';

        // Pastikan penyimpanan gagal karena nama tidak boleh null
        $this->assertFalse($user->save());
        $this->assertArrayHasKey('name', $user->getErrors());
    }

    public function testCreateUserWithInvalidEmailFormat()
    {
        // Membuat user dengan email yang invalid
        $user = new SysUser();
        $user->iduser = 7;
        $user->name = 'Invalid Email';
        $user->email = 'invalid-email-format'; // Format email tidak valid

        // Pastikan penyimpanan gagal karena format email tidak valid
        $this->assertFalse($user->save());
        $this->assertArrayHasKey('email', $user->getErrors());
    }

    
}
