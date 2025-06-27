<template>
  <div class="p-4 border rounded mb-2 flex justify-between items-center" :class="{ 'bg-green-100': task.finalizado }">
    <div>
      <h2 class="text-lg font-semibold">{{ task.nome }}</h2>
      <p v-if="task.descricao">{{ task.descricao }}</p>
      <p v-if="task.data_limite">Limite: {{ new Date(task.data_limite).toLocaleString() }}</p>
    </div>
    <div class="space-x-2">
      <button @click="store.toggleTask(task.id)" class="text-sm px-2 py-1 border rounded">
        {{ task.finalizado ? 'Desfazer' : 'Finalizar' }}
      </button>
      <button @click="editar" class="text-sm px-2 py-1 border rounded">Editar</button>
      <button @click="store.deleteTask(task.id)" class="text-sm px-2 py-1 border rounded text-red-600">Excluir</button>
    </div>
  </div>
</template>

<script setup>
import { useTaskStore } from '../stores/taskStore';
const store = useTaskStore();
const props = defineProps({ task: Object });

function editar() {
  store.selectedTask = props.task;
  store.modalOpen = true;
}
</script>