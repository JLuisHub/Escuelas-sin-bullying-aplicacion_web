<?php

namespace Tests\Unit;

/*use PHPUnit\Framework\TestCase;*/
use Tests\TestCase;

class LoginDirectivoTest extends TestCase
{
    /* Login de directivo */
    /*
    * Prueba para ver el login de directivo
    */
    public function test_ver_login_directivo()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
