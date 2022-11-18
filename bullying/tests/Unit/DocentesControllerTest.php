<?php

namespace Tests\Unit;

/*use PHPUnit\Framework\TestCase;*/

use App\Http\Controllers\DocentesController;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Tests\TestCase;

class DocentesControllerTest extends TestCase
{

    /* Crear cuenta para directivo(registrarse) */
    /* TODO */

    /* Registrar docentes mediante una lista CSV */
    /*
     * Prueba pasando un archivo CSV
     */
    public function test_importar_un_csv_null()
    {
        $dc = new DocentesController();
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
        $dc = new DocentesController();
        $request = Request::create('/test', 'POST', [], [], [], [], []);
        $response = $dc->store($request);

        if (is_null($response))
        {
            print "es nulo";
        } else {
            print "NO es nulo";
        }

        $this->assertTrue(!is_null($response));
    }

}
