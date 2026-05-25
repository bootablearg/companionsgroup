<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->string('slug', 50)->primary();
            $table->string('title', 255);
            $table->longText('content');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('legal_pages')->insert([
            [
                'slug'    => 'terms',
                'title'   => 'Términos y Condiciones',
                'content' => '<section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">1. Aceptacion de los Terminos</h2>
            <p>Al acceder y utilizar la plataforma (en adelante, "la Plataforma"), usted confirma tener al menos 18 años de edad y acepta quedar vinculado por los presentes Terminos y Condiciones, la Politica de Privacidad y todas las demas politicas aplicables. Si no acepta estos terminos en su totalidad, debe abandonar la Plataforma de inmediato.</p>
            <p class="mt-3">La Plataforma se reserva el derecho de modificar estos terminos en cualquier momento. Las modificaciones entraran en vigencia desde su publicacion en el sitio. El uso continuado de la Plataforma implica la aceptacion de los terminos modificados.</p>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">2. Naturaleza del Servicio</h2>
            <p>Esta plataforma es de publicacion de avisos clasificados para mayores de edad. Funciona exclusivamente como intermediario entre personas que desean publicar avisos de compañia y personas que buscan dicho servicio. No participa, organiza, ni facilita ningun encuentro entre usuarios, y no es responsable por el contenido, veracidad o legalidad de los servicios ofrecidos por los anunciantes.</p>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">3. Requisitos de Elegibilidad</h2>
            <ul class="list-disc list-inside space-y-1.5 mt-3 ml-4 text-gray-600">
                <li>Ser mayor de 18 años de edad.</li>
                <li>Proporcionar informacion veridica durante el proceso de registro.</li>
                <li>Completar el proceso de verificacion de identidad (KYC) si desea publicar un aviso como modelo.</li>
                <li>No estar inhabilitado legalmente para celebrar contratos.</li>
                <li>Cumplir con la legislacion vigente en su jurisdiccion.</li>
            </ul>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">4. Suspension y Cancelacion</h2>
            <p>La Plataforma se reserva el derecho de suspender o cancelar cuentas de forma temporal o permanente ante violaciones de estos terminos. Los usuarios pueden solicitar la cancelacion de su cuenta en cualquier momento a traves del panel de configuracion.</p>
        </section>',
                'updated_at' => now(),
            ],
            [
                'slug'    => 'privacy',
                'title'   => 'Política de Privacidad',
                'content' => '<section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">1. Informacion que Recopilamos</h2>
            <p>Recopilamos la informacion que usted nos proporciona directamente al registrarse, completar su perfil o contactarnos. Esto incluye nombre, correo electronico, datos de identidad para KYC, fotografia de perfil y datos de pago (procesados por terceros).</p>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">2. Uso de la Informacion</h2>
            <p>Utilizamos su informacion para: proveer y mejorar nuestros servicios, verificar identidades (KYC), procesar pagos, enviar comunicaciones relacionadas con el servicio y cumplir obligaciones legales.</p>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">3. Proteccion de Datos</h2>
            <p>Implementamos medidas de seguridad tecnicas y organizativas para proteger su informacion personal. Los documentos de identidad se almacenan en forma encriptada y son accesibles solo por administradores autorizados.</p>
        </section>
        <section>
            <h2 class="text-base ec-section-title mb-3" style="display:inline-block;">4. Sus Derechos</h2>
            <p>Usted tiene derecho a acceder, rectificar y suprimir sus datos personales. Para ejercer estos derechos, contactenos a traves del correo legal de la plataforma.</p>
        </section>',
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_pages');
    }
};
