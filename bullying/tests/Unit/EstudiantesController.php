<?php

namespace Tests\Unit;

/*use PHPUnit\Framework\TestCase;*/

use App\Http\Controllers\DocentesController;
use Illuminate\Http\Request;
use Tests\TestCase;

class EstudiantesController extends TestCase
{
    /* Registrar alumnos mediante una lista CSV */
    public function test_importar_un_csv_null()
    {
        $dc = new EstudiantesController();
        $request = Request::create('/test', 'POST', [], [], [], [], []);
        $response = $dc->store($request);
        /*
        if (is_null($response))
        {
            print "es nulo";
        } else {
            print "NO es nulo";
        }
        */
        $this->assertTrue(is_null($response));
    }

    public function test_importar_un_csv_ok()
    {
        $dc = new EstudiantesController();
        $request = Request::create('/test', 'POST', [], [], [], [], []);
        $response = $dc->store($request);
/*
        if (is_null($response))
        {
            print "es nulo";
        } else {
            print "NO es nulo";
        }
*/
        $this->assertTrue(!is_null($response));
    }

}
