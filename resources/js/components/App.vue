<template>
  <main class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tarefas</h1>
    <TaskModal v-if="modalOpen" />
    <button @click="openNewTask" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded">Nova Tarefa</button>
    <TaskList />
  </main>
</template>

<script setup>
import TaskList from './TaskList.vue';
import TaskModal from './TaskModal.vue';
import { useTaskStore } from '../stores/taskStore';
import { storeToRefs } from 'pinia';

const store = useTaskStore();
const { modalOpen } = storeToRefs(store);

function openNewTask() {
  store.selectedTask = null;
  store.modalOpen = true;
}
</script>