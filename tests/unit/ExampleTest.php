<?php

namespace tests\unit;

use app\models\SysUser;

class ExampleTest extends \Codeception\Test\Unit
{
    public function testCreateUser()
    {
        $user = new SysUser();
        $user->iduser = 'abc';
        $user->name = 'John';
        $user->email = 'john@example.com';
        $user->save();

        // Verifikasi bahwa data user disimpan di database
        $this->assertEquals('John', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
    public function testCreateUser2()
    {
        $user = new SysUser();
        $user->iduser = 1;
        $user->name = 'John';
        $user->email = 'john@example.com';

        // Verifikasi bahwa data user disimpan di database
        $this->assertTrue($user->save());
        $this->assertEquals('John', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
}
