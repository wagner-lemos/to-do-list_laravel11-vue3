<template>
  <form @submit.prevent="salvar">
    <div class="mb-2">
      <label class="block">Nome</label>
      <input v-model="form.nome" class="w-full border p-2 rounded" required />
    </div>
    <div class="mb-2">
      <label class="block">Descrição</label>
      <textarea v-model="form.descricao" class="w-full border p-2 rounded"></textarea>
    </div>
    <div class="mb-2">
      <label class="block">Data Limite</label>
      <input type="datetime-local" v-model="form.data_limite" class="w-full border p-2 rounded" />
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
      {{ props.task ? 'Atualizar' : 'Criar' }}
    </button>
  </form>
</template>

<script setup>
import { reactive, watchEffect } from 'vue';
import { useTaskStore } from '../stores/taskStore';

const props = defineProps({ task: Object });
const store = useTaskStore();

const form = reactive({
  nome: '',
  descricao: '',
  data_limite: ''
});

watchEffect(() => {
  if (props.task) {
    form.nome = props.task.nome;
    form.descricao = props.task.descricao;
    form.data_limite = props.task.data_limite?.slice(0, 16) || '';
  } else {
    // Limpa o formulário ao abrir para nova task
    form.nome = '';
    form.descricao = '';
    form.data_limite = '';
  }
});

async function salvar() {
  if (props.task) {
    await store.updateTask(props.task.id, form);
  } else {
    await store.createTask(form);
  }
  store.modalOpen = false;
}
</script>