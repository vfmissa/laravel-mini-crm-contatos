<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Models\Contact;
use App\Jobs\ContactScoreJob;
use Illuminate\Support\Facades\Log;

class CrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_criar_um_novo_contato_via_api_post(): void
    {
        Queue::fake();

        $payload = [
            'name'  => 'Victor Silva',
            'email' => 'contato@minhaempresa.com.br',
            'phone' => '11988887777'
        ];

        $response = $this->postJson('/api/contacts', $payload);

        $response->assertSuccessful();
        $this->assertDatabaseHas('contacts', ['email' => 'contato@minhaempresa.com.br']);
        
    }

    public function test_deve_acionar_o_processamento_de_score_via_api_post(): void
    {
        Queue::fake();


        $contact = \App\Models\Contact::create([
            'name'  => 'Lucas Medeiros',
            'email' => 'lucas@teste.com',
            'phone' => '11955554444',
            'status' => 'pending'
        ]);

        $response = $this->postJson("/api/contacts/{$contact->id}/process-score");

        $response->assertStatus(202); 
        $response->assertJsonFragment(['message' => 'Score em processamento']);
        
        Queue::assertPushed(ContactScoreJob::class);
    }

    public function test_deve_listar_contatos_via_api_get(): void
    {

        Contact::create([
            'name'  => 'Maria Oliveira',
            'email' => 'maria@teste.com',
            'phone' => '11999999999',
            'status' => 'pending'
        ]);

        $response = $this->getJson('/api/contacts');

        $response->assertSuccessful();
        $response->assertJsonFragment(['name' => 'Maria Oliveira']);
    }

    public function test_deve_mostrar_um_contato_especifico_via_api_get_id(): void
    {
        $contact = Contact::create([
            'name'  => 'João Pedro',
            'email' => 'joao@teste.com',
            'phone' => '11888888888',
            'status' => 'pending'
        ]);


        $response = $this->getJson("/api/contacts/{$contact->id}");

        $response->assertSuccessful();
        $response->assertJsonFragment(['email' => 'joao@teste.com']);
    }

    public function test_deve_atualizar_um_contato_via_api_put(): void
    {
        $contact = Contact::create([
            'name'  => 'Nome Antigo',
            'email' => 'antigo@teste.com',
            'phone' => '11777777777',
            'status' => 'pending'
        ]);

        $payloadAtualizado = [
            'name'  => 'Nome Atualizado',
            'email' => 'novoemail@teste.com',
            'phone' => '11777777777'
        ];

        $response = $this->putJson("/api/contacts/{$contact->id}", $payloadAtualizado);

        $response->assertSuccessful();
        

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Nome Atualizado',
            'email' => 'novoemail@teste.com'
        ]);
    }

    public function test_deve_deletar_um_contato_via_api_delete(): void
    {
        $contact = Contact::create([
            'name'  => 'Contato Para Apagar',
            'email' => 'apagar@teste.com',
            'phone' => '11666666666',
            'status' => 'pending'
        ]);

        $response = $this->deleteJson("/api/contacts/{$contact->id}");

        $response->assertSuccessful();

        $this->assertSoftDeleted('contacts', [
            'id' => $contact->id,
            'email' => 'apagar@teste.com'
        ]);
    }
}