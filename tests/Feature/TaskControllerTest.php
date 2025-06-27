<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\DeleteCompletedTask;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function pode_criar_uma_tarefa()
    {
        $data = [
            'nome' => 'Nova tarefa',
            'descricao' => 'Descrição da tarefa',
            'data_limite' => now()->addDay()->toDateTimeString()
        ];

        $res = $this->postJson('/api/tasks', $data);

        $res->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Nova tarefa']);

        $this->assertDatabaseHas('tasks', ['nome' => 'Nova tarefa']);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function pode_listar_tarefas()
    {
        Task::factory()->count(2)->create();

        $res = $this->getJson('/api/tasks');

        $res->assertStatus(200)
            ->assertJsonCount(2);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function pode_visualizar_uma_tarefa()
    {
        $task = Task::factory()->create();

        $res = $this->getJson("/api/tasks/{$task->id}");

        $res->assertStatus(200)
            ->assertJsonFragment(['nome' => $task->nome]);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function pode_atualizar_uma_tarefa()
    {
        $task = Task::factory()->create();

        $res = $this->putJson("/api/tasks/{$task->id}", [
            'nome' => 'Atualizada',
            'descricao' => 'Alterado',
            'finalizado' => false,
            'data_limite' => now()->addDays(2)->toDateTimeString()
        ]);

        $res->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Atualizada']);

        $this->assertDatabaseHas('tasks', ['nome' => 'Atualizada']);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function pode_excluir_com_soft_delete()
    {
        $task = Task::factory()->create();

        $res = $this->deleteJson("/api/tasks/{$task->id}");

        $res->assertStatus(204);
        $this->assertSoftDeleted($task);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function pode_alternar_status_finalizado_e_despachar_job()
    {
        Queue::fake(); // evita executar o job real

        $task = Task::factory()->create(['finalizado' => false]);

        $res = $this->patchJson("/api/tasks/{$task->id}/toggle");

        $res->assertStatus(200)
            ->assertJson(['finalizado' => true]);

        Queue::assertPushed(DeleteCompletedTask::class);
    }
}
